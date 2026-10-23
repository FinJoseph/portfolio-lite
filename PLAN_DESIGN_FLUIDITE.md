# ✨ PLAN DESIGN & FLUIDITÉ — PORTFOLIO LITE

**Version 1.0 — 2026-10-22**
**Complément à** `PLAN_AMELIORATIONS.md` (lots fonctionnels / SEO / CI) — ici : **look, modernité, sensation de fluidité**
**Site :** [finjoseph.onrender.com](https://finjoseph.onrender.com/)

---

## 📊 DIAGNOSTIC DE L'ÉTAT ACTUEL

Mesuré dans le code, pas supposé.

### Design system

| Constat | Preuve | Impact |
|---|---|---|
| Palette quasi monochrome : 1 seule couleur d'accent | `resources/css/app.css:21-32` — `--color-primary` + 2 variantes, `paper`/`ink`/`muted`/`border` | Rien ne hiérarchise l'attention ; pas de couleur sémantique (succès, alerte, info) |
| Aucune tokens d'espacement / rayon / ombre / z-index | `@theme` ne contient que `--font-sans` + 9 couleurs | Impossible de faire évoluer la charte sans passer par 60 composants |
| Typographie non fluide | `text-3xl sm:text-4xl lg:text-6xl` en dur partout | Pas d'adaptation au viewport → sauts de taille entre breakpoints |
| 2 rayons seulement | `rounded-full` (boutons/nav) + `rounded-xl` (cartes) | Manque de hiérarchie de surface (carte vs panneau vs modale) |
| Ombres colorées ad hoc | `shadow-md shadow-primary/20`, `shadow-2xl shadow-black/40` | 9 `backdrop-blur` différents → rendu non homogène + coûteux en GPU |
| Code fence dans les articles sans coloration ni copie | `resources/js/Pages/Blog/Show.vue` | Articles techniques tristement bruts |
| Zéro `@container` | `grep @container` → 0 | Les cartes ne s'adaptent pas à leur conteneur, seulement au viewport |
| Composant et composable morts | `AboutPreviewSection.vue` non importé par `Home.vue` · `useScrollToTop.js` non utilisé · `useSearch.js` non utilisé | Code fantôme = dette confuse |

### Motion / fluidité

| Constat | Preuve | Impact |
|---|---|---|
| **Aucune transition entre les pages** | `resources/js/app.js` — pas de hook Inertia | Chaque navigation = coupe sèche, sensation « site cheap » |
| **Pas de code splitting** | `import.meta.glob("./Pages/**/*.vue", { eager: true })` → **toutes** les pages dans le chunk initial | 476 Ko de JS, navigation perçue lente |
| **Pas de système de reveal au scroll** | Seuls le hero (transitions de montage) et les compteurs de l'About utilisent l'IO | Les sections arrivent « d'un bloc », pas en vagues |
| **Pas de scroll fluide** | `scroll-behavior` absent | Défilement sec, accroche sur mobile |
| 4 animations infinies sur le hero | `animate-ping`, `animate-[spin_20s]`, `animate-[float_4s]`, `animate-pulse` | Travail GPU continu sur le chemin critique du LCP |
| Halos en `blur-[100px]` animés en continu | `CyberGrid.vue` — `filter: blur(100px)` + `will-change` permanent | ~1,5 Mo de couche GPU en mémoire sur mobile, ce qui vide la batterie |
| `will-change` permanent | `CyberGrid.vue:106` | Le navigateur garde la couche promote en mémoire même à l'arrêt |
| Aucun retour d'interaction | Copier l'email ne confirme rien, aucun toast, aucun ripple | L'utilisateur ne sait pas si l'action a marché |
| Pas de barre de progression de lecture | Article long sans repère | Abandonnement sur les articles longs |
| Pas de feedback de scroll | Navbar sans réaction au scroll, pas de bouton « retour en haut » | Perte de repère |

### Ce qui est déjà bien (à garder)

- La grille SVG du `CyberGrid` : légère, sans JS, bel effet « circuit ».
- Le modèle de tokens déjà amorcé dans `@theme` (structure prête à être densifiée).
- Le mode sombre piloté par classe `.dark` (choix sain : contrôle utilisateur > préférence système).
- Les compteurs animés de l'About + l'IntersectionObserver existant (à généraliser).

---

## 🎯 PRINCIPES DIRECTEURS

1. **Le mouvement explique, il ne décore.** Une animation doit signaler un changement d'état, guider l'œil ou établir une hiérarchie. Jamais de mouvement décoratif permanent.
2. **Budget de performance = contrat.** Une animation qui coûte > 4 ms de CPU par frame ne passe pas. `transform` et `opacity` uniquement.
3. **Mobile d'abord.** 60 % du trafic cible est mobile : le scroll et le tactile passent avant l'effet.
4. **Calme premium.** Contraste fort, espace généreux, typographie maîtrisée, 1 accent — pas de néon partout.
5. **Accessible par défaut.** Tout mouvement respecte `prefers-reduced-motion` ; tout contraste ≥ AA ; navigation clavier complète.

---

# LOT A — DESIGN

## A1. Tokens de design (socle de tout le reste)

**Objectif :** une seule source de vérité, et une charte qui se change en 10 minutes.

**Étapes**
1. Compléter `@theme` dans `resources/css/app.css` :
   ```css
   @theme {
     /* Couleurs */
     --color-primary: #10B981;  --color-primary-dark: #059669;  --color-primary-light: #34D399;
     --color-accent: #6366F1;   /* indigo : couleur secondaire pour les accents/liens */
     --color-success: #10B981;  --color-warning: #F59E0B;  --color-danger: #EF4444;  --color-info: #3B82F6;
     /* Surfaces (au lieu d'utiliser paper/ink partout) */
     --color-surface: #FFFFFF;  --color-surface-2: #F3F4F6;  --color-surface-3: #E5E7EB;
     --color-surface-dark: #0B0F14; --color-surface-dark-2: #111827; --color-surface-dark-3: #1F2937;
     /* Rayons */
     --radius-xs: 0.375rem; --radius-sm: 0.5rem; --radius-md: 0.75rem;
     --radius-lg: 1rem; --radius-xl: 1.5rem; --radius-2xl: 2rem;
     /* Élévation (échelle cohérente, pas de shadow colorée ad hoc) */
     --shadow-xs: 0 1px 2px rgb(0 0 0 / .06);
     --shadow-sm: 0 1px 3px rgb(0 0 0 / .08), 0 1px 2px rgb(0 0 0 / .04);
     --shadow-md: 0 4px 12px rgb(0 0 0 / .08);
     --shadow-lg: 0 12px 32px rgb(0 0 0 / .10);
     --shadow-xl: 0 24px 64px rgb(0 0 0 / .14);
     /* Mouvement */
     --ease-out-quart: cubic-bezier(.25, 1, .5, 1);
     --ease-spring: cubic-bezier(.34, 1.56, .64, 1);
     --dur-fast: 120ms; --dur-base: 220ms; --dur-slow: 420ms; --dur-slower: 720ms;
   }
   ```
2. Ajouter une **couche sémantique** (tokens qui basculent avec `.dark`) dans `resources/css/app.css` via `:root` / `.dark` → `bg-surface`, `text-ink`, `border-border`.
3. Migration progressive : remplacer d'abord `BaseButton`, `BaseCard`, `SectionHeading`, `Navbar`, `Footer`, puis les pages.
4. Nettoyer : plus aucune couleur hexadécimale ni `shadow-*/shadow-primary/*` en dur dans les `.vue`.

**Validation :** changer `--color-primary` repeint tout le site ; `grep -rn "#[0-9A-Fa-f]\{6\}" resources/js` → 0 résultat.

**Charge :** 4 h.

---

## A2. Typographie premium

**Objectif :** le point de vue n°1 sur la perception « pro ».

**Étapes**
1. **Ajouter une police d'affichage** (serif) pour les titres et les accents : **Instrument Serif** (compatible avec Instrument Sans, déjà via Bunny Fonts, RGPD-friendly). Un seul ajout de famille donne un saut de niveau perçu immédiat.
2. **Typo fluide** : passer les titres en `clamp()` via des tokens :
   ```css
   --text-display: clamp(2.5rem, 1.6rem + 4vw, 4.5rem);
   --text-h1: clamp(2rem, 1.5rem + 2.2vw, 3rem);
   --text-h2: clamp(1.5rem, 1.2rem + 1.4vw, 2.25rem);
   --text-lead: clamp(1.05rem, 1rem + .35vw, 1.3rem);
   ```
3. **Variable font** : charger Instrument Sans en un seul fichier variable (400→700) au lieu de 3 graisses × 2 formats = 12 fichiers (voir `PLAN_AMELIORATIONS.md` T4.5). Gagne ~8 requêtes.
4. **Détails qui font pro** :
   - `text-wrap: balance` sur les titres, `text-wrap: pretty` sur les paragraphes.
   - `font-variant-numeric: tabular-nums` sur les stats et les compteurs (les chiffres ne sautent plus en animant).
   - `letter-spacing` négatif progressif sur les grands titres (`tracking-tight` → `-0.03em` à `-0.04em`).
   - `font-feature-settings: "ss01", "cv01"` si la police expose des variantes.
5. **Échelle de lecture** : `max-width: 68ch` sur les corps de texte d'articles ; interligne 1,7 sur le lead.
6. Code : passer à une mono cohérente (`ui-monospace` + `JetBrains Mono` en Variable via Bunny) au lieu de la mono par défaut.

**Validation :** aucune coupure de mot dans les titres à 360 px ; le blog se lit confortablement à 100 % de zoom.

**Charge :** 3 h.

---

## A3. Surfaces, élévation et profondeur

**Objectif :** que l'interface ait du relief sans effet « glassmorphism 2021 ».

**Étapes**
1. **3 niveaux de surface** cohérents : `surface` (page) → `surface-2` (cartes) → `surface-3` (panneaux, modales, popovers). Supprimer les `bg-white/40 dark:bg-ink-light/20` ad hoc.
2. **Bordures vivantes** : remplacer les bordures plates par une bordure à gradient (`border-image` ou `mask-composite`) sur les cartes « vedette » — effet « verre dépoli » moderne (1 px de lumière sur le bord supérieur).
3. **Grain (noise)** : overlay SVG `feTurbulence` en `opacity-[0.035]` sur toute la page (`position: fixed`, `pointer-events:none`, `z-index: 40`). Apporte une profondeur « premium » pour ~0 Ko (inline SVG).
4. **Ombres en 2 couches** : `shadow-[0_1px_2px_rgb(0_0_0/.06),0_8px_24px_rgb(0_0_0/.08)]` — cohérent clair/sombre.
5. **Halo d'accent** : conserver le `CyberGrid` mais remplacer les `blur-[100px]` animés par **un seul** halo statique (pas d'animation continue) → gain GPU immédiat, rendu plus net.
6. Verre : `backdrop-blur` limité à **2 éléments maximum** (navbar + palette de recherche) — 9 occurrences actuelles à rationaliser.

**Validation :** les cartes se distinguent du fond par la **luminosité**, pas seulement par l'ombre ; le grain est imperceptible mais supprime l'aplat.

**Charge :** 4 h.

---

## A4. Refonte de la home en bento + storytelling

**Objectif :** la page d'accueil doit être le meilleur argument commercial du portfolio.

**Étapes**
1. **Grille bento** (`grid-cols-4` + `col-span-*`) au lieu de la pile verticale uniforme :
   - grande tuile « Projet phare » (iKAALY, 2×2),
   - tuile « Compétences clés »,
   - tuile « Disponibilité » (pastule pulsed),
   - tuile « Dernier article »,
   - tuile « Statistique » (ex. 3+ ans, 6 000 membres gérés, 9 projets).
2. **Hero modernisé** :
   - titre en `text-display` avec **révélation par mots** (clip-path + translateY, déclenché une fois, 60 ms de décalage entre les mots) ;
   - **badge de disponibilité** cliquable (pastule + « Disponible pour une mission — réponse < 24 h ») ;
   - 2 CTA : « Voir les projets » (primaire) + « Discutons » (secondaire, bordé).
3. **Bandeau de stack** : marquee horizontal en défilement continu (CSS `translateX` + `@keyframes`, pause au survol, masqué si `prefers-reduced-motion`) avec les technos réellement pratiquées.
4. **Bandeau « preuves »** (3 chiffres) : chiffres réels, `tabular-nums`, compteur animé à l'entrée (réutiliser le composant de l'About → l'extraire dans `resources/js/Components/UI/StatCounter.vue`).
5. **Section services** : 3 cartes (Laravel/Filament · Next.js/React · UI Design) avec livrable et tarif d'entrée indicatif — rare et fortement convertissant.
6. **CTA final** : formulaire express (email + message) directement dans la home, pas seulement un bouton.

**Validation :** en 5 s sur mobile, on voit : qui je suis, ce que je fais, un projet, une action.

**Charge :** 1,5 j (design + intégration).

---

## A5. Cartes projet et fiche projet « vitrines »

**Étapes**
1. **Carte projet** : couverture avec zoom `scale(105%)` au survol, gradient sombre en pied de carte (lisibilité du texte), badge de statut, **rôle tenu**, 3 pastilles de technos + « +N », icônes site/GitHub au survol, bordure qui s'allume au survol.
2. **Fiche projet** :
   - **hero** en 2 colonnes (texte + capture qui déborde du cadre) ;
   - **barre de méta** sticky (statut, date, rôle, stack, liens) ;
   - **timeline de réalisation** (4-6 jalons) ;
   - bloc **Impact** (3 chiffres) ;
   - galerie avec lightbox (cf. `PLAN_AMELIORATIONS.md` T1.3) ;
   - « Projets similaires » en carrousel horizontal avec scroll-snap.
3. **Section « stack »** en pied de fiche : les technos cliquables vers `/stack/{tech}`.

**Charge :** 1 j.

---

## A6. Page compétences : matrice lisible + visualisation

**Étapes**
1. Navigation **sticky par catégorie** + indicateur de catégorie active (scrollspy).
2. **Matrice** : catégorie × compétence × niveau × projets qui l'utilisent (le triomphe des listes à 32 entrées).
3. Visualisation : barres groupées par famille + anneau de progression global (« 32 compétences, dont 28 à ≥ 70 % »).
4. Conserver la page détail `/skills/{slug}` et y ajouter les projets liés.

**Charge :** 1 j.

---

## A7. About : timeline horizontale + « hors du code »

**Étapes**
1. Timeline horizontale 2023 → aujourd'hui, scroll-snap sur mobile, chaque jalon avec impact chiffré.
2. Section « Ce que je fais / comment je travaille » (4 principes) → rassure sur la méthode.
3. Section « En dehors du code » (design, photo, illust) → humanise.
4. Photo de travail + citation courte.

**Charge :** 1 j (+ rédaction).

---

## A8. Blog : couverture, code coloré, TOC, lecture fluide

**Étapes**
1. Champ `cover_image` optionnel + **illustration par catégorie** (SVG généré, 6 visuels) pour les 13 articles existants.
2. **Coloration syntaxique** : Shiki au build (via `content:build`) ou, plus simple, `highlight.js` chargé à la demande sur `Blog/Show` — recommandation : **Shiki au build** (résultat parfait, 0 Ko côté client).
3. **Bouton « copier »** sur chaque bloc de code + toast de confirmation.
4. **Table des matières** sticky (auto-générée depuis les `h2/h3`) + scroll-spy.
5. **Barre de progression de lecture** en haut de l'article.
6. Prélude de « temps de lecture + date + catégorie + partage » + articles liés en fin d'article.
7. Pagination propre (au lieu de tout lister) + page par catégorie.

**Charge :** 1,5 j.

---

## A9. Contact : 2 étapes, disponibilité, réponse immédiate

**Étapes**
1. Formulaire en 2 étapes avec barre de progression (cf. `PLAN_AMELIORATIONS.md` T1.7) + ergonomie soignée.
2. Bloc **disponibilité** : statut, délai de réponse, créneaux, bouton WhatsApp (`wa.me`), copie email, QR vCard.
3. **Feedback instantané** : validation au blur, envoi avec état « envoi en cours → envoyé », toast de confirmation.
4. Accordéon FAQ (6 questions : budget, délai, Langues, paiement, maintenance, confidentiality).

**Charge :** 1 j.

---

## A10. Icônes, favicons et identité

- Favicons : SVG animé (icône qui change au survol de l'onglet), `manifest.webmanifest` avec masque, icônes 192/512, `apple-touch-icon`, `safari-pinned-tab`.
- Favicon **par page** via `<link rel="icon">` dynamique ? (optionnel, effet pro rare).
- Illustrations : empty states dessinés (SVG, cohérents avec la charte) pour : aucun projet trouvé, aucun témoignage, aucun résultat de recherche.
- Logo : version horizontale + monochrome + favicon ; `LogoAvatar.vue` à nettoyer (actuellement un avatar, pas un logo).

**Charge :** 5 h.

---

# LOT B — FLUIDITÉ

> C'est ce qui fait qu'un site «iftonne » plutôt que « rame ».

## B1. Code splitting par route 🔥 Le gain n°1

**Constat :** `resources/js/app.js` charge **toutes** les pages en eager → 476 Ko dans le chunk initial.

**Correction :**
```js
// resources/js/app.js
const pages = import.meta.glob("./Pages/**/*.vue"); // sans eager

resolve: (name) => {
    const path = "./Pages/" + name + ".vue";
    const loader = pages[path];
    if (!loader) throw new Error("Page introuvable : " + name);
    return defineAsyncComponent(loader);   // import dynamique → chunk séparé par page
},
```
**Étapes**
1. Appliquer la correction ci-dessus (attention : `defineAsyncComponent` à importer depuis `vue`).
2. Ajouter `<Suspense>` avec un **squelette** autour de `<App>` pour éviter le flash blanc.
3. Vérifier le découpage : `npm run build` doit produire un chunk par page (`Home-xxx.js`, `Projects-xxx.js`…).
4. **Préchargement intelligent** : précharger le chunk de la page suivante probable (hover sur un lien → `router.prefetch`).
5. `vite.config.js` → `build.rollupOptions.output.manualChunks` pour séparer `vendor-vue` / `vendor-inertia`.

**Validation :** chunk initial < **90 Ko gzip** ; la home ne télécharge pas le code de `/blog` ; la navigation vers `/projects` est instantanée après le premier clic.

**Charge :** 2 h.

---

## B2. Transitions de page (View Transitions API)

**Constat :** aucune transition entre les pages → coupe sèche.

**Étapes**
1. CSS natif (sans lib) :
   ```css
   @view-transition { navigation: auto; }              /* navigations Same-Origin (y compris Inertia) */
   ::view-transition-old(root) { animation: fade-out .18s ease both; }
   ::view-transition-new(root) { animation: fade-in .26s var(--ease-out-quart) both; }
   ```
2. Hook Inertia pour les transitions plus ====
   ```js
   router.on('start', () => document.documentElement.dataset.transition = 'out');
   ```
   et, si besoin d'un contrôle fin, `document.startViewTransition(() => router.visit(url))` avec fallback.
3. **Variantes** : fondu simple (défaut), glissement latéral (projets ↔ fiche projet), zoom (fiche projet), inversion pour la navigation arrière (`popstate`).
4. Repli progressif : sans support → rien ne casse.

**Validation :** la navigation `/projects` → `/projects/ikaaly` a un mouvement fluide et le focus revient au bon endroit.

**Charge :** 3 h.

---

## B3. Moteur de scroll fluide (Lenis)

**Étapes**
1. `npm i lenis` (~3 Ko gzip), un seul point d'initialisation dans `resources/js/app.js`.
2. Lenis **désactivé** si `prefers-reduced-motion: reduce`.
3. `lenis.on('scroll', ...)` → alimente les effets liés au scroll (barre de progression, scrollspy, parallax léger, header shrink).
4. `html { scroll-behavior: smooth }` retiré (Lenis prend le relais) pour éviter le double lissage.
5. Ne jamais Lenis sur les zones à scroll interne (lightbox, palette).

**Charge :** 2 h.

---

## B4. Système de révélation au scroll (directive `v-reveal`)

**Constat :** aucun reveal générique ; chaque page réinvente son animation.

**Étapes**
1. Nouvelle directive `resources/js/directives/reveal.js` :
   ```js
   // v-reveal : ajoute .is-revealed quand l'élément entre dans le viewport
   // options : v-reveal="{ delay: 120, y: 24, once: true }"
   ```
   → IntersectionObserver + classes `opacity-0 translate-y-6` → `opacity-100 translate-y-0` avec `transition` de 600 ms.
2. **Stagger** : chaque enfant direct d'une grille reçoit un délai indexé (60 ms × index) → vagues.
3. Enregistrer la directive globalement dans `resources/js/app.js`.
4. **Respect de `prefers-reduced-motion`** : les éléments sont visibles immédiatement, sans animation.
5. Nettoyer : remplacer les animations manuelles de `About.vue` et `HeroSection.vue` par la directive.

**Validation :** toutes les pages « respirent » de la même façon ; plus une seule animation écrite à la main.

**Charge :** 3 h.

---

## B5. Micro-interactions qui confirment l'action

| Interaction | Retour attendu | Fichier |
|---|---|---|
| Copier l'email / le téléphone | Toast « Copié ✓ » + le bouton devient « Copié ! » 1,5 s | `new Toast` (`Components/UI/Toast.vue`) |
| Bouton « Envoyer » | État loader (spinner) → coche → message de succès | `Contact.vue` |
| Changement de thème | Icône soleil/lune qui tourne et se fond (transition 300 ms) | `DarkModeToggle.vue` |
| Hover sur une carte projet | Élévation + bordure qui s'allume + zoom image | `Projects/Index.vue` |
| Hover sur un bouton | Effet magnétique (le bouton suit le curseur sur ~6 px) + onde au clic | `BaseButton.vue` |
| Lien externe | Petit badge ↗ + `title` explicite | global |
| Ajout au favori / favori | Étoile qui se remplit avec un rebond | `BaseButton.vue` |
| Recherche | Résultats en fondu + surlignage du terme + état « aucun résultat » soigné | `SearchPalette.vue` |
| Toggle de filtre | Pastille qui se remplit avec `scale` + `spring` | `Projects/Index.vue` |

**Étapes**
1. Créer `resources/js/Components/UI/Toast.vue` + `useToast()` (file d'attente, auto-dismiss 2,5 s, position bottom-right / top en mobile).
2. Créer `resources/js/Components/UI/MagneticButton.vue` (wrapper de `BaseButton`, transform uniquement, désactivé sur `pointer: coarse`).
3. Créer `resources/js/composables/useSpring.js` (spring amorti pour les micro-interactions : ressort `stiffness/damping`).
4. Appliquer aux 5 interactions les plus visibles d'abord.

**Charge :** 1 j.

---

## B6. Feedback de scroll et navigation

- **Navbar qui réagit** : se contracte (hauteur + opacité) après 40 px de scroll, ombre qui apparaît, fond qui passe de translucide à opaque.
- **Scrollspy** : le lien de nav actif est mis en surbrillance selon la section visible.
- **Bouton « retour en haut »** : apparaît après 600 px, devient fixe en bas à droite sur mobile (avec le CTA WhatsApp, voir A9).
- **Barre de progression** : fine barre verte en haut de page (2 px) qui suit le scroll.
- **Indicateur de section** : petit point/ligne sur le bord droit pour les pages longues (modern, discret).
- **Header shrink + morph** : le logo se réduit légèrement au scroll.
- Le `useScrollToTop.js` existant est enfin branché.

**Charge :** 1 j.

---

## B7. Sprites d'animation sur les logos / skills

- Les logos de technos (SkillIcon) sont des SVG monochromes → les remplacer par les **marques officielles** en couleur (Simple Icons / logos npm) pour les 32 skills : reconnaissance immédiate, effet « pro ».
- Animation optionnelle au survol (rotation de la marque sur `Next.js`, pulse sur `Supabase`) — 1 seule animation, courte (300 ms).
- Cache : un seul composant `<BrandIcon tech="next.js" />` qui switch sur une collection SVG locale (pas de CDN → pas de dépendance externe, pas de RGPD).

**Charge :** 4 h.

---

## B8. Budget GPU & discipline d'animation

**Constat :** 4 animations infinies au hero + halos `blur(100px)` animés + `will-change` permanent = consommation permanente même sur l'onglet inactif.

**Étapes**
1. Supprimer les animations infinies non essentielles ; si on les garde, les piloter par `IntersectionObserver` (**pause hors écran**) et par `document.visibilityState`.
2. `will-change` **uniquement pendant** l'animation (ajouter/retirer la classe), jamais en statique.
3. `filter: blur()` : 1 seul halo, statique, `blur(60px)` max.
4. `transform: translateZ(0)` / `backface-visibility: hidden` sur les éléments animés.
5. Respect de `prefers-reduced-motion` pour **toutes** les animations (y compris le `CyberGrid`).
6. `content-visibility: auto` + `contain-intrinsic-size` sur les sections longues hors écran → rendu plus rapide au scroll.

**Validation :** onglet inactif → 0 % CPU ; scroll à 60 fps sur un mobile d'entrée de gamme (test via DevTools CPU throttling 4×).

**Charge :** 4 h.

---

# LOT C — FONCTIONNALITÉS MODERNES

## C1. Palette de commandes (Ctrl+K) — version moderne du site
*(cf. `PLAN_AMELIORATIONS.md` T1.1)* — à enrichir : actions (« aller à la home », « basculer le thème », « copier l'email », « ouvrir le CV ») + résultats groupés + navigation clavier.

## C2. Aperçu au survol des projets
Survol d'une carte projet → petite carte flottante avec la capture, l'impact et la stack. Sans JS lourd (CSS `:hover` + transition). Effort : 3 h.

## C3. Spotlight « projet en cours »
Sur la home, une section « En ce moment je construis » avec le projet actif, sa progression, la dernière mise à jour. Donne l'impression d'une activité réelle. Effort : 3 h.

## C4. Comparateur de projets
Vue tableau comparant 2-3 projets (stack, statut, impact, technos) — très utile en entretien, et très « pro ». Effort : 1 j.

## C5. Bloc de code avec surlignage + copie + onglets de fichiers
Sur la fiche projet : onglets `schema.ts` / `actions.ts` / `middleware.ts` avec le vrai code extrait du dépôt, copier-coller, et numéro de ligne. Ça prouve le niveau technique plus sûrement qu'une description. Effort : 1 j.

## C6. Accordéon FAQ +estimation de devis
FAQ sur `/contact` + mini-formulaire « 3 questions → fourchette de délai » (sans engagement). Effort : 5 h.

## C7. Installation PWA + « ajouter à l'écran d'accueil »
Manifest déjà présent (item F3 partiel) → terminer le service worker + prompt d'installation + bannière discrete. Effort : 1 j.

## C8. Partage et preuve sociale
Boutons de partage (LinkedIn, X, WhatsApp, copier le lien) sur chaque fiche projet + compteur de vues local (pas de tracker). Effort : 3 h.

## C9. Statut / page « Stack »
`/stack` listant toutes les technos avec le nombre de projets, l'expérience moyenne et les projets associés ; sert de page interne rentable en SEO. Effort : 3 h.

## C10. Journal de bord (« build log »)
Une page `/journal` : 5-10 entrées datées sur ce que tu construis/apprends (Laravel, Next.js, design). Différenciant, alimenté en 10 min/semaine. Effort : 5 h + entretien.

---

# 📐 BUDGET DE PERFORMANCE (à contractualiser)

| Métrique | Aujourd'hui | Cible | Comment |
|---|---|---|---|
| JS initial (gzip) | 148 Ko | **< 90 Ko** | B1 (code splitting) + B5 (lazy) |
| CSS (gzip) | 47 Ko | **< 30 Ko** | A1 (purge des tokens non utilisés) |
| LCP (home) | 6,5 s | **< 2,0 s** | T0.4 + A3 + B1 |
| TTFB | 4,0 s | **< 800 ms** | T4.3 (instance active) |
| INP | non mesuré | **< 200 ms** | B1 + B7 + limiter les `blur` |
| CLS | non mesuré | **< 0,1** | `width`/`height` sur toutes les images |
| Images `/projects` | 3,9 Mo | **< 600 Ko** | T0.4 (WebP + dimensions) |
| CPU onglet inactif | ~8 % | **0 %** | B8 |
| FPS scroll mobile 4× throttle | ~28 fps | **60 fps** | B8 + A3 |

Mesure : `npx lighthouse https://finjoseph.onrender.com --preset=desktop --view` et en mode mobile (`--form-factor=mobile`).

---

# 📈 ÉTAT D'AVANCÉE

## ✅ Sprint 1 — Fondations (livré le 2026-10-23)

| Chantier | Livré | Preuve mesurée |
|---|---|---|
| **A1 — Tokens** | `@theme` complet (couleurs sémantiques + `amber`, rayons `card/panel/pill`, ombres `xs→float`, easings `quart/out-expo/spring`, durées) ; couche `:root`/`.dark` (`--surface/2/3`, `--border-soft`) alignée sur `paper`/`paper-dark` ; `html` peint selon le thème | `--surface` = `#F9FAFB` clair / `#000` sombre, bascule instantanée via `.dark` |
| **A2 — Typo** | Échelle fluide `clamp()` : `text-display` / `h1` / `h2` / `h3` / `lead` ; Instrument Serif (italique) via Bunny ; `text-wrap: balance/pretty` | H1 = **80 px** à 1440 px, **41,6 px** à 360 px ; tagline en Instrument Serif italic |
| **B1 — Code splitting** | `import.meta.glob` sans `eager` + `defineAsyncComponent` + `PageSkeleton` (shimmer) ; `advancedChunks` `vendor-vue` / `vendor-inertia` | JS initial **≈ 113 Ko gzip** (contre ≈ 148 Ko) **−24 %** ; chunk par page `Home` 6,1 Ko gzip |
| **B2 — View Transitions** | `@view-transition` + keyframes `vt-out`/`vt-in` ; `router.visit` force `viewTransition: true` sur les navigations **GET** uniquement (les `<Link>` Inertia envoient `false` par défaut) | `document.startViewTransition` détecté ; repli natif si non supporté |
| **B8 — GPU** | Halos et orbes convertis de `filter: blur()` → `radial-gradient` ; animations infinies réduites (`animate-ping` supprimé, `pulse` retiré des gros blobs) ; plus aucun `will-change` permanent | `blur` restants sur `/` : 2 (avatar + navbar `backdrop-blur`), contre une dizaine avant |
| **Prefetch** | Écoute déléguée `mouseover` (debounce 150 ms, skip externe/_blank/`data-no-prefetch`) | 1 requête XHR par lien survolé |
| **A11y** | Skip link `#main-content` + `:focus-visible` + `scroll-padding-top: 6rem` ; **une seule H1 par page** (`as="h1"` sur `SectionHeading`) | 7 routes testées : 1 H1 chacune, 0 erreur console |
| **Divers** | axios retiré (`bootstrap.js`, −17 Ko gzip) ; `bg-amber` du footer réparé (classe inexistante) ; `text-wrap` + `::selection` ; reset global `prefers-reduced-motion` | Animations à `1e-06 s` avec `reducedMotion: reduce` |

**Reste à faire en S1 (bloqué par l'environnement)** : mesure Lighthouse réelle (PHP local cassé → validation via harnais statique Playwright), et arbitrage sur le budget « < 90 Ko gzip » (les 113 Ko actuels sont dominés par Vue + Inertia, non compressibles sans changer de framework).

**Décisions prises**
- `--font-mono` déclaré « JetBrains Mono » mais **non chargé** : soit on l'ajoute à Bunny, soit on assume `ui-monospace`. À trancher en S1.5.
- Transitions limitées aux **GET** : les POST de formulaire (contact) gardent le comportement Inertia standard.

# 🗓️ PLAN D'EXÉCUTION

| Sprint | Contenu | Charge | Sortie |
|---|---|---|---|
| **S1 — Fondations** ✅ | A1 tokens · A2 typo · B1 code splitting · B2 view transitions · B8 GPU | 1,5 j | Charte pilotable, bundle −24 %, 60 fps |
| **S2 — Mouvement** | B2 transitions · B4 reveal · B3 scroll Lenis · B6 feedback scroll | 1,5 j | Navigation perçue instantanée, pages qui respirent |
| **S3 — Home & projets** | A4 bento home · A5 cartes/fiche · A2 + B7 (icônes de marque) | 1,5 j | La home devient une vitrine |
| **S4 — Contenu** | A8 blog (Shiki, TOC, covers) · A6 compétences · A7 about | 1,5 j | Les 3 pages secondaires au niveau |
| **S5 — Contact & conversions** | A9 contact 2 étapes · C5 blocs de code · C6 FAQ/devis · C8 partage | 1 j | Le site transforme |
| **S6 — Bonus** | C2 aperçu · C3 spotlight · C4 comparateur · C7 PWA · C10 journal | 1 j | Différenciateurs rares |

**Ordre imposé :** S1 avant tout le reste (sans tokens ni code splitting, chaque retouche ultérieurement sera faite deux fois).

---

# ✅ CHECKLIST DE VALIDATION DESIGN & FLUIDITÉ

- [x] `grep -rn "eager: true" resources/js/app.js` → plus de chargement eager des pages
- [ ] Chunk initial < 90 Ko gzip (vérifier dans `public/build/manifest.json`)
- [ ] LCP < 2,0 s, INP < 200 ms, CLS < 0,1 sur `/` et `/projects` (Lighthouse mobile)
- [ ] Aucune animation infinie hors écran ; CPU 0 % onglet inactif
- [x] `prefers-reduced-motion` → aucun mouvement, contenu intégralement visible
- [ ] Aucune couleur hexadécimale en dur dans les `.vue` ; les tokens pilotent tout
- [ ] Tous les titres utilisent l'échelle fluide `clamp()` ; `text-wrap: balance`
- [x] Grain + halos : rendu net, pas de flou laiteux sur le texte
- [x] Navigation clavier : skip link + focus visible (palette Ctrl+K → S6)
- [x] Transitions de page actives entre toutes les routes (avec repli si non supporté)
- [ ] Au moins 2 retours visuels sur chaque action (toast, état, animation) → S2/S5
- [x] Mobile 360 px : aucun débordement, CTA principal au pouce
- [ ] Contraste AA validé sur les 10 pages, en clair **et** en sombre
- [ ] Images : `width`/`height` partout, WebP, `loading`/`fetchpriority` corrects
- [ ] Animations : uniquement `transform`/`opacity` (vérifier via DevTools « Paint flashing »)

---

# 📌 BACKLOG DESIGN

- **Thème 3D / shader** en arrière-plan de la home (three.js lazy, chargé après le premier scroll, coupé sur mobile et `prefers-reduced-motion`) — spectaculaire mais à conditionner.
- **Mode « CV »** : une page alternative très épurée, imprimable, orientée recruteur.
- **Personnalisation** : accent color changé par section (vert en home, indigo en blog) → cohérent via tokens.
- **Illustrations vectorielles** de tes projets (au lieu de captures) pour un rendu « design system ».
- **Animation de chargement** sur la home : logo qui se dessine en SVG (`stroke-dashoffset`) pendant le chargement des données.
- **Musique d'ambiance** off par défaut — non, à éviter (accessibilité + autoplay).
- **Vue « timeline »** du parcours en sticky-scroll (une étape épinglée par écran).
