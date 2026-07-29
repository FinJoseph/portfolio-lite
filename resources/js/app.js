import "./bootstrap";
// ↑ importe la config JS de base de Laravel (axios pré-configuré avec le token CSRF, etc.)
// généré automatiquement par Laravel, ne pas supprimer
import { createApp, h } from "vue";
// ↑ createApp : fonction Vue qui initialise une application Vue 3
// h : "hyperscript", fonction bas-niveau qui crée un élément virtuel (VNode) — nécessaire pour le render manuel ci-dessous
import { createInertiaApp } from "@inertiajs/vue3";
// ↑ fonction fournie par Inertia qui fait le pont entre Laravel (backend) et Vue (frontend) :
// elle intercepte la navigation, appelle Laravel en arrière-plan, et affiche le bon composant Vue sans recharger la page
import { i18n } from "./i18n";
// ↑ AJOUT : notre instance vue-i18n configurée dans resources/js/i18n/index.js

createInertiaApp({
    // resolve : dit à Inertia COMMENT retrouver un composant Vue à partir d'un nom de page
    // (le nom de page vient du contrôleur Laravel, ex: Inertia::render('Home'))
    resolve: (name) => {
        // import.meta.glob charge TOUS les fichiers .vue du dossier Pages/ d'un coup (eager: true = chargés immédiatement, pas en lazy loading)
        const pages = import.meta.glob("./Pages/**/*.vue", {
            eager: true,
        });
        // on va chercher dans cet objet le fichier correspondant au nom demandé
        const path = "./Pages/" + name + ".vue";
        return pages[path];
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
