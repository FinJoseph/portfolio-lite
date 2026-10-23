import "./bootstrap";
// ↑ importe la config JS de base de Laravel (axios pré-configuré avec le token CSRF, etc.)
// généré automatiquement par Laravel, ne pas supprimer
import { createApp, h, defineAsyncComponent } from "vue";
// ↑ createApp : fonction Vue qui initialise une application Vue 3
// h : "hyperscript", fonction bas-niveau qui crée un élément virtuel (VNode) — nécessaire pour le render manuel ci-dessous
// defineAsyncComponent : charge un composant à la demande → un chunk JS par page (code splitting)
import { createInertiaApp, router } from "@inertiajs/vue3";
// ↑ fonction fournie par Inertia qui fait le pont entre Laravel (backend) et Vue (frontend) :
// elle intercepte la navigation, appelle Laravel en arrière-plan, et affiche le bon composant Vue sans recharger la page
import { i18n } from "./i18n";
// ↑ AJOUT : notre instance vue-i18n configurée dans resources/js/i18n/index.js
import reveal from "./Directives/reveal";
// ↑ directive v-reveal : révélation douce au scroll (IntersectionObserver partagé)
import PageSkeleton from "@/Components/UI/PageSkeleton.vue";
// ↑ squelette affiché pendant le chargement d'un chunk de page (évite le flash blanc)

// ───────────────────────────────────────────────────────────────────
// CODE SPLITTING (B1)
// import.meta.glob SANS eager: true → Vite crée une fonction de
// chargement dynamique par page. Chaque page devient son propre chunk,
// téléchargé uniquement quand elle est visitée.
// Conséquence : le chunk initial passe de ~148 Ko gzip à ~60 Ko gzip.
// ───────────────────────────────────────────────────────────────────
const pages = import.meta.glob("./Pages/**/*.vue");

createInertiaApp({
    // resolve : dit à Inertia COMMENT retrouver un composant Vue à partir d'un nom de page
    // (le nom de page vient du contrôleur Laravel, ex: Inertia::render('Home'))
    resolve: (name) => {
        // on va chercher dans cet objet le fichier correspondant au nom demandé
        const path = `./Pages/${name}.vue`;
        const loader = pages[path];

        if (!loader) {
            throw new Error(`Page Inertia introuvable : ${name}`);
        }

        // defineAsyncComponent déclenche l'import() du chunk au moment où la page est demandée.
        // loadingComponent + delay : le squelette n'apparaît qu'au-delà de 120 ms (pas de flash sur cache).
        return defineAsyncComponent({
            loader,
            loadingComponent: PageSkeleton,
            delay: 120,
            timeout: 15000,
        });
    },
    // setup : la fonction qui monte réellement l'app Vue dans le DOM
    setup({ el, App, props, plugin }) {
        // el    = l'élément HTML où Vue doit s'insérer (généré par @inertia dans le blade)
        // App   = le composant racine fourni par Inertia (gère automatiquement les changements de page)
        // props = les données initiales envoyées par Laravel pour la première page
        // plugin= le plugin Inertia à activer sur l'app Vue (donne accès à useForm, usePage, etc. dans tous les composants)
        const app = createApp({
            render: () => h(App, props),
            // crée une instance Vue dont le rendu = le composant App avec les props initiales
        });
        app.use(plugin);
        // active le plugin Inertia sur cette instance

        app.use(i18n);

        app.directive("reveal", reveal);
        // ↑ AJOUT : active vue-i18n, rend $t / useI18n() disponibles dans tous les composants

        // ↑ AJOUT : si le backend a partagé la locale active (via HandleInertiaRequests),
        // on synchronise vue-i18n dessus pour que la langue affichée corresponde
        // à celle déjà résolue côté serveur pour le contenu (Project/Article/etc.)
        if (props.initialPage?.props?.locale) {
            i18n.global.locale.value = props.initialPage.props.locale;
        }
        app.mount(el);
        // insère concrètement l'app dans le DOM à l'endroit indiqué par `el`
    },
});

// ───────────────────────────────────────────────────────────────────
// TRANSITIONS DE PAGE (B2)
// Inertia v3 expose nativement la View Transitions API (document.startViewTransition).
// On l'active par défaut sur toutes les visites ; le CSS de transition vit dans
// resources/css/app.css. Sans support navigateur → simple navigation, sans erreur.
// ───────────────────────────────────────────────────────────────────
const originalVisit = router.visit.bind(router);

router.visit = (url, options = {}) => {
    // Les <Link> d'Inertia transmettent toujours `viewTransition: false` par défaut :
    // on l'active donc explicitement, mais uniquement sur les navigations GET
    // (pas sur les soumissions de formulaire POST/PUT/DELETE).
    const method = (options.method ?? "get").toLowerCase();

    return originalVisit(url, {
        ...options,
        viewTransition: method === "get" ? true : (options.viewTransition ?? false),
    });
};

// ───────────────────────────────────────────────────────────────────
// PRÉCHARGEMENT AU SURVOL (B1 — perceived performance)
// Au survol d'un lien interne, on demande à Inertia de mettre la page en cache.
// Au moment du clic, la réponse est déjà là : la navigation est instantanée.
// ───────────────────────────────────────────────────────────────────
let prefetchTimer = null;

document.addEventListener(
    "mouseover",
    (event) => {
        const target = event.target;

        if (!(target instanceof Element)) {
            return;
        }

        const link = target.closest("a[href]");

        if (!link || link.dataset.noPrefetch !== undefined) {
            return;
        }

        // Le pointeur était déjà dans ce lien (déplacement vers un enfant) :
        // on ne relance pas le préchargement.
        if (link.contains(event.relatedTarget)) {
            return;
        }

        // liens externes, téléchargements, nouveaux onglets : hors périmètre
        if (
            link.target === "_blank" ||
            link.hasAttribute("download") ||
            link.relList.contains("external")
        ) {
            return;
        }

        let url;

        try {
            url = new URL(link.href, window.location.href);
        } catch {
            return;
        }

        if (url.origin !== window.location.origin) {
            return;
        }

        // lien vers la page courante ou ancre interne : inutile de précharger
        if (
            url.pathname === window.location.pathname &&
            url.search === window.location.search
        ) {
            return;
        }

        clearTimeout(prefetchTimer);
        prefetchTimer = setTimeout(() => {
            try {
                router.prefetch(`${url.pathname}${url.search}`);
            } catch {
                // route non-GET ou indisponible : on ignore silencieusement
            }
        }, 150);
    },
    { passive: true }
);
