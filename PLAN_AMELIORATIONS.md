# 🚀 PLAN D'AMÉLIORATIONS — PORTFOLIO LITE

**Version 1.0 — 2026-10-22**
**Projet :** portfolio-lite (Laravel 13 + Inertia + Vue 3, sans BDD, file-based)
**Site en ligne :** [finjoseph.onrender.com](https://finjoseph.onrender.com/)
**Baseline mesurée avant plan :** LCP **6,5 s** · TTFB **4,0 s** · **3,9 Mo** d'images sur `/projects` · bundle JS **476 Ko** (148 Ko gzip) · 68 tests Pest dont 1 en échec

> Ce document est le plan d'exécution : chaque tâche a un emplacement de code, une charge et un critère de validation.
> Un lot = une session. Ne pas commencer un lot avant que le précédent soit validé et poussé.

---

## 📋 SOMMAIRE

| Lot | Thème | Charge | Priorité |
|---|---|---|---|
| [0](#lot-0--crédibilité--ce-quon-voit-dabord) | Crédibilité (ce qu'on voit d'abord) | 0,5 j | 🔴 P0 |
| [1](#lot-1--fonctionnalités-cœur) | Fonctionnalités cœur | 1 j | 🔴 P0 |
| [2](#lot-2--design--ux) | Design / UX | 1 j | 🟠 P1 |
| [3](#lot-3--accessibilité) | Accessibilité | 0,5 j | 🟠 P1 |
| [4](#lot-4--performance) | Performance | 1 j | 🟠 P1 |
| [5](#lot-5--seo--social--légal) | SEO / Social / Légal | 0,5 j | 🟡 P2 |
| [6](#lot-6--contenu--production) | Contenu (dépend de toi) | 0,5 j | 🟠 P1 |
| [7](#lot-7--qualité--ci-cd) | Qualité / CI-CD | 0,5 j | 🟡 P2 |
| [—](#backlog--idées-plus-loin) | Backlog (idées plus loin) | — | ⚪ P3 |

---

# LOT 0 — Crédibilité (ce qu'on voit d'abord)

> Objectif : qu'aucun visiteur ne tombe sur un lien mort, une page vide ou un « 0+ ANNÉES ».

### T0.1 — Rendre les repos GitHub accessibles ⚠️ Bloquant

Les repos `FinJoseph/ikaaly`, `FinJoseph/aim-app-next` et `FinJoseph/roi` sont **privés** : le bouton « Voir le code » du portfolio en ligne mène à un **404**. Ce sont les 3 projets les plus visibles de la home.

**Étapes**
1. Rendre les 3 repos publics (ou créer des repos mirrors `FinJoseph/<slug>` publics si le code doit rester privé).
2. Ajouter dans chaque repo :
   - `README.md` : titre, slogan, captures (réutiliser `public/images/projects/<slug>/cover.jpg`), stack, `npm install && npm run dev`, `.env.example` (clés listées **sans valeur**), variables Supabase/Vercel.
   - `LICENSE` (MIT).
   - `.gitignore` vérifié (`.env`, `.next`, `node_modules`).
   - Badges : build, deploy Vercel, licence.
3. Si un repo doit rester privé : **retirer le bouton « Voir le code »** dans `resources/js/Pages/Projects/Show.vue` (ne pas laisser un lien qui mène à une erreur d'authentification).

**Validation** : `curl -o /dev/null -w '%{http_code}' https://github.com/FinJoseph/ikaaly` → `200`.

**Charge :** 1 h (aide d'un agent possible pour les README).

---

### T0.2 — Corriger le compteur « 0+ ANNÉES » ⚠️ Bloquant

`resources/js/Pages/About.vue:47` lit `e.start_date` alors que le DTO expose `startDate` (`app/DTO/ExperienceDTO.php`). Le calcul retombe toujours à 0.

**Étapes**
1. `resources/js/Pages/About.vue:47` → utiliser `e.startDate`.
2. Vérifier les autres accès snake_case/camelCase dans les pages Vue (`grep -rn "_date\|_url\|_image" resources/js --include=*.vue`) et aligner sur le DTO.
3. La valeur doit devenir **3+** (2023 → 2026).

**Validation** : la page `/about` affiche « 3+ ANNÉES » (FR/EN/MG).

**Charge :** 15 min.

---

### T0.3 — Remplir la page Témoignages ⚠️ Bloquant

`content/testimonials.json` est vide (`[]`) → la page affiche « Aucun témoignage pour le moment. Revenez bientôt ! ».

**Étapes**
1. Récupérer 2-3 témoignages (association AIM, client iKAALY, RSIPRODIGY, La Vanille) : nom, rôle, entreprise, message (2-3 phrases), note, photo optionnelle.
2. Remplir `content/testimonials.json` (structure existante : `name`, `email`, `company`, `job_title`, `message`, `rating`, `photo`, `submitted_at`, `order`, `is_active`).
3. Un témoignage ne peut pas être publié sans l'accord de la personne (ajouter `is_active: true` seulement après accord).
4. Si aucun témoignage n'est disponible : **remplacer la section par une section « Ils m'ont fait confiance »** (logos d'organisations / projets livrés) — c'est un repli honnête et sans risque juridique.

**Validation** : `/testimonials` affiche au moins 2 cartes ; sinon la section est remplacée par le repli logos.

**Charge :** 30 min (hors rédaction) — **besoin de toi**.

---

### T0.4 — Alléger les images ⚠️ Bloquant (perf)

Mesuré : `avatar.jpg` **973 Ko** (chargé en `eager` sur la home → candidat LCP), `antilin…/cover.jpg` **1 Mo**, `roi-university/cover.jpg` **884 Ko**, total `public/images/` **7,2 Mo**.

**Étapes**
1. Générer des WebP (qualité 82) en plus des JPG, pour chaque image de `public/images/` :
   `magick in.jpg -resize 1200x630^ -gravity center -extent 1200x630 -quality 82 out.webp`
   - covers : **1200×630** (ratio Open Graph 1.91:1)
   - galerie : **1200×675** (16:9)
   - avatar : **400×400** carré (recadrage centré)
2. Remplacer les `.jpg` par les `.webp` dans les fichiers de contenu et `content/settings.json` (`avatar`).
3. Ajouter `width`/`height` sur les `<img>` (évite le CLS) — `resources/js/Pages/Projects/Index.vue:135`, `Show.vue:184`, `About.vue:168`, `Home/HeroSection.vue:207`.
4. `fetchpriority="high"` sur l'image LCP de la home, `loading="lazy"` + `decoding="async"` sur le reste.
5. Objectif : **3,9 Mo → < 600 Ko** sur `/projects`.

**Validation** : `du -sh public/images/` < 2 Mo ; LCP home < 2,5 s en local.

**Charge :** 1 h (script à écrire, une fois).

---

### T0.5 — Aligner le footer et les textes sur la vraie stack

Le footer affiche encore « Fait avec Laravel, Vue.js & Tailwind CSS » et le blog « Réflexions sur le développement web, Laravel, Vue.js et plus ». Or la home affiche Next.js/React.

**Étapes**
1. `resources/js/Components/Layout/Footer.vue:23-24` → pile → `Laravel, Next.js, React, TypeScript, Tailwind CSS, Supabase, Vercel`.
2. `resources/js/i18n/locales/{fr,en,mg}.json` → `footer.crafted_with`, `footer.tagline`, `blog.subtitle` mis à jour dans les 3 langues.
3. `content/settings.json` → `footer`/`social_links` cohérents.

**Validation** : aucune mention de "Vue.js et plus" sur le site ; les 3 locales sont à jour.

**Charge :** 30 min.

---

### T0.6 — Réseaux sociaux + identité

`content/settings.json` → `social_links.linkedin` et `twitter` sont à `null`.

**Étapes**
1. Renseigner LinkedIn (prioritaire), X/Twitter, Facebook, YouTube selon ce que tu utilises vraiment.
2. Ajouter une section « Disponibilité » : statut + délai de réponse (ex. « Réponse sous 24 h ») + fuseau horaire (EAT/UTC+3).
3. Créer une adresse pro `contact@` (domaine personnel recommandé : `finjoseph.dev` → credibility ×2 vs `finjoseph433@gmail.com`).

**Validation** : les icônes sociales s'affichent sur `/about` et `/contact` ; aucune entrée `null` affichée.

**Charge :** 30 min + création du compte LinkedIn (**besoin de toi**).

---

# LOT 1 — Fonctionnalités cœur

> Objectif : transformer une vitrine statique en portfolio qui **se visite** et **se recommande**.

### T1.1 — Recherche globale (le code existe mais n'est pas branché) 🔥

`resources/js/composables/useSearch.js` (Fuse.js) est écrit mais **utilisé nulle part**. L'index `public/search-index.json` est pourtant régénéré à chaque `content:build`. Le CDC annonce la recherche comme « FAIT ».

**Étapes**
1. Lire `resources/js/composables/useSearch.js` (index `public/search-index.json`, champs indexés).
2. Ajouter une **commande palette** (Ctrl/Cmd+K) :
   - `resources/js/Components/UI/SearchPalette.vue` — overlay, input, résultats groupés (Projets / Compétences / Articles), clavier (↑ ↓ Enter Échap), highlight du terme.
   - Raccourci global dans `resources/js/app.js` (listener `keydown`).
   - Bouton loupe dans `resources/js/Components/Layout/Navbar.vue`.
3. Créer la page `resources/js/Pages/Search.vue` + route `/search` pour la recherche à query string (`?q=`), indexable et partageable.
4. **Étendre l'index** aux compétences et aux articles si ce n'est pas déjà fait (`app/Console/Commands/ContentBuild.php`).

**Validation** : Ctrl+K ouvre la palette, « ikaaly » renvoie la fiche projet, onglet flèche + Entrée navigue.

**Charge :** 3 h.

---

### T1.2 — Filtres et tri sur `/projects` (le filtre statut manque)

Le CDC annonce « filtres catégorie/techno/statut » ; le code n'a que catégorie + techno (`resources/js/Pages/Projects/Index.vue:22-43`). Les statuts `completed` / `in-progress` / `draft` existent dans le frontmatter mais ne sont pas filtrables.

**Étapes**
1. Ajouter le filtre **statut** (badges colorés alignés sur `statusConfig`, ligne 45).
2. Ajouter un **tri** : par défaut `order`, puis `completed_at` (récent → ancien), puis alphabétique.
3. Persister les filtres dans l'URL (`?category=web&tech=Next.js&status=completed`) → pages partageables et indexables.
4. Afficher le **nombre de résultats** et un bouton « Réinitialiser » (la clé `projects.reset_filters` existe déjà).
5. Conserver la cohérence des clés i18n : ajouter `projects.filter.status.*`, `projects.sort.*` dans les 3 locales.

**Validation** : filtrer par « En cours » ne renvoie que AIM App (v1) et AIM App (Next.js) ; l'URL se met à jour.

**Charge :** 2 h.

---

### T1.3 — Lightbox sur les galeries

`resources/js/Pages/Projects/Show.vue` affiche les images de galerie en grille sans visionneuse (le modal existe pour d'autres usages).

**Étapes**
1. `resources/js/Components/UI/Lightbox.vue` : plein écran, flèches ←/→, clavier, numéro d'image, `Esc` pour fermer, focus trap, `aria-modal`.
2. Brancher sur la galerie de `Show.vue` et sur la home (aperçus projet).
3. Bouton « Voir la galerie » dans la section hero de la fiche.

**Validation** : clic sur une image → plein screen, navigation clavier fonctionnelle, `Esc` ferme.

**Charge :** 2 h.

---

### T1.4 — Pages « stack » (et/ou taxonomie)

Chaque compétence et chaque technologie pointe vers des projets. Manque une page qui regroupe le tout par technologie : `https://finjoseph.onrender.com/stack/next.js`.

**Étapes**
1. Nouvelle route `/stack/{tech}` → `app/Http/Controllers/StackController.php` + `resources/js/Pages/Stack/Show.vue`.
2. Contenu : nom + description de la techno, projets qui l'utilisent, compétences liées, articles du blog qui la citent.
3. Générer une page statique par techno détectée dans `content/projects/*.md` + `content/skills.json` → enrichit le maillage interne (SEO) et donne des URL partageables (« j'ai vu ton portfolio Next.js »).
4. Ajouter le lien dans les cartes projet (chaque techno devient un lien vers `/stack/{tech}`).

**Validation** : `/stack/next.js` liste 3 projets + les compétences Next.js ; aucun lien mort interne.

**Charge :** 3 h.

---

### T1.5 — Études de cas chiffrées (structure + preuve)

Les fiches listent des fonctionnalités mais **aucun impact mesuré**. L'`*expérience* AIM` mentionne déjà « adoption 100 %, −50 % de temps de saisie » : ce type de chiffre manque sur les projets.

**Étapes**
1. Nouvelle structure de fiche, appliquée aux 9 projets (FR/EN/MG) :
   ```
   ## Le problème        → contexte, contraintes, douleur réelle
   ## L'approche        → décisions techniques, arbitrages, ce qui a été écarté
   ## Le résultat       → 3 chiffres (utilisateurs, perf, adoption)
   ## Ce que j'ai appris→ 2 enseignements techniques
   ```
2. Bloc « Impact » dans le composant de fiche (`resources/js/Pages/Projects/Show.vue`) : 3 tuiles chiffrées, champ optionnel dans le frontmatter (`impact: [{value, label}]`).
3. Ajouter `impact` au `ProjectDTO` (`app/DTO/ProjectDTO.php`) + `FileProjectRepository` + test Pest.
4. Remplir les chiffres réels de iKAALY, AIM App Next, Autocollant Mada (nb de restaurants testés, utilisateurs, transactions, Lighthouse).

**Validation** : chaque fiche affiche 3 tuiles chiffrées ; aucun chiffre inventé (source vérifiable).

**Charge :** 1 j (dont rédaction — **besoin de toi** pour les chiffres).

---

### T1.6 — « Projet phare » sur la home

iKAALY (marketplace + mobile money + PWA) est le projet le plus fort commercialement, mais il n'a pas plus de poids visuel qu'iKomandy.

**Étapes**
1. `resources/js/Pages/Home.vue` → section dédiée entre les skills et la grille projets : grande capture, phrase d'accroche, 3 chiffres clés, CTA « Voir le projet » + « Ouvrir la démo ».
2. Source de vérité : un champ `featured_project` dans `content/settings.json` (slug) plutôt qu'un hard-code.
3. `app/Http/Controllers/HomeController.php` → charge la fiche complète de ce projet.

**Validation** : la home met en avant 1 projet avec capture grand format, visible sans scroll sur desktop 1440 px.

**Charge :** 2 h + rédaction de l'accroche (**besoin de toi**).

---

### T1.7 — Formulaire de contact v2

Le formulaire actuel ne qualifie pas le lead.

**Étapes**
1. `resources/js/Pages/Contact.vue` + `app/Http/Requests/` : ajouter `project_type` (site vitrine / e-commerce / app interne / API / autre), `budget_range`, `deadline`, `preferred_contact` (email/WhatsApp), consent RGPD.
2. `app/Mail/SendContactEmail.php` : nouveau template avec ces champs + mail d'accusé de réception automatique.
3. Anti-spam : honeypot existant + `throttle:5,1` existant ; ajouter un lien de désinscription si la newsletter est activée.
4. Affichage de la **disponibilité** et du délai de réponse au-dessus du formulaire (cf. T0.6).

**Validation** : envoi OK en dev, mail reçu avec les nouvelles champs, message d'erreur clair à la validation.

**Charge :** 3 h.

---

### T1.8 — Carte de visite numérique (vCard + QR)

Petit plus très utilisé par les recruteurs / clients.

**Étapes**
1. Route `/vcard` → `.vcf` (nom, poste, email, téléphone, site, LinkedIn, organisation).
2. Bouton « Enregistrer mes coordonnées » sur `/about` et `/contact`.
3. QR code du lien `vcard` affiché sur `/contact` (généré en SVG côté build ou via une lib légère `qrcode`).

**Validation** : le `.vcf` s'ouvre dans Contacts (iOS/Android/Outlook), le QR scanne vers la page contact.

**Charge :** 1 h.

---

### T1.9 — RSS visible + inscription

`/feed.xml` existe mais n'est lié que depuis la page blog → invisible pour 95 % des visiteurs.

**Étapes**
1. Ajouter l'icône RSS dans le footer (les 3 locales).
2. Formulaire d'inscription à la newsletter dans le footer : email → `app/Listeners/` → mail de confirmation + stockage dans `content/subscribers.json` (file-based, cohérent avec la doctrine) + envoi d'un mail récapitulatif à chaque nouvel article (commande `art:publish`).
3. Double opt-in (confirmation par email) obligatoire.

**Validation** : le flux est accessible en un clic depuis n'importe quelle page ; l'inscription déclenche un mail de confirmation.

**Charge :** 3 h.

---

# LOT 2 — Design / UX

> Objectif : le portfolio doit ressembler à un produit premium, pas à un thème.

### T2.1 — Design tokens centralisés

Les couleurs/rayons/ombres sont redéfinis dans chaque composant (classes Tailwind hardcodées). Toute évolution devient fastidieuse et incohérente.

**Étapes**
1. Dans `resources/css/app.css` (Tailwind v4, syntaxe `@theme`) : tokens `--color-primary`, `--color-accent`, `--color-surface`, rayons, ombres, échelles d'espacement, durées de transition.
2. Remplacer les classes hardcodées par les tokens (`bg-primary`, `text-ink-light`, …) dans `resources/js/Components/UI/*`.
3. Documenter les tokens dans le README.

**Validation** : changer `--color-primary` change toute la charte ; plus aucune couleur hexadécimale dans les `.vue`.

**Charge :** 3 h.

---

### T2.2 — Nouvelle hiérarchie de la home

Ordre actuel : Hero → Compétences (6) → Projets (3) → … Le visiteur ne comprend pas en 5 s **ce que tu fais**.

**Étapes**
1. Nouvelle structure : Hero (promesse + CTA + statut de disponibilité) → Bandeau « ce que je fais » (3 cartes de service : Laravel, Next.js, Design) → **Projet phare** (T1.6) → Compétences (groupées, 8-10 + lien « voir les 32 ») → Projets (grille 6) → Témoignages → CTA final avec formulaire express.
2. `resources/js/Pages/Home.vue` + `resources/js/Components/Home/*` (un composant par section, déjà amorcé).
3. Animer l'entrée des sections avec l'IntersectionObserver existant, en respectant `prefers-reduced-motion` (voir T3.2).

**Validation** : en 5 s, un visiteur comprend le profil, voit 3 projets récents et une action claire.

**Charge :** 1 j.

---

### T2.3 — Cartes projet enrichies

Les cartes ne montrent que couverture + titre + excerpt + 5 pastilles de techno.

**Étapes**
1. `resources/js/Pages/Projects/Index.vue` → carte enrichie : statut, date de livraison, **rôle tenu**, **impact chiffré**, pastilles de technos (max 4 + «+N »), lien site live et GitHub sur icônes.
2. Vue **grille / liste** commutable (persistance en localStorage) : la liste montre excerpt + technos + statut + impact sur une ligne — très pratique pour un recruteur qui scanne 9 projets.

**Validation** : une carte tient en 3 lignes denses et donne titre + rôle + impact + statut sans zoomer.

**Charge :** 3 h.

---

### T2.4 — Page compétences : matrice lisible

32 compétences sur une page = scroll long. Aujourd'hui : cartes par catégorie avec barres de niveau.

**Étapes**
1. Vue par **catégorie** avec navigation sticky + ancrage, et une **matrice** (catégorie × techno × niveau × projets associés).
2. Chaque compétence affiche : niveau, familles de projets où elle est utilisée, et un lien vers `/stack/{tech}`.
3. Graphique simple niveau par famille (barres groupées) — sans lib de charts lourd.
4. Conserver la page détail `/skills/{slug}` existante (elle est bonne) et y ajouter les « projets qui l'utilisent ».

**Validation** : on voit en un coup d'œil les 32 compétences et leur niveau réel, et on saute directement aux projets correspondants.

**Charge :** 1 j.

---

### T2.5 — Page À propos : timeline + services

**Étapes**
1. `resources/js/Pages/About.vue` → frise chronologique horizontale (2023 → aujourd'hui) au lieu d'une liste d'expériences ; chaque jalon : poste, période, mission, **impact chiffré**.
2. Ajouter une section « Services » (Laravel/Filament, Next.js/React, UI Design, Audit/performance) avec les 4 offres détaillées.
3. Photo de travail + « en dehors du code » (design, photo, etc.) — humanise.

**Validation** : le parcours se lit comme une histoire, pas comme une liste.

**Charge :** 1 j (rédaction : **besoin de toi**).

---

### T2.6 — Blog : cartes, pagination, couverture

Les articles n'ont pas d'image de couverture et la page blog est une longue liste.

**Étapes**
1. Champ `cover_image` optionnel dans les articles (13 articles existants → 13 captures à produire, ou illustrations génériques par catégorie).
2. Cartes blog avec : cover, catégorie colorée, temps de lecture, date, extrait, tags (max 3).
3. Pagination propre (la page existe déjà ?) + catégorie « Next.js », « React », « Architecture », « DevOps ».
4. Passer de 13 tutos Laravel-{#Débutant} à un mix : **garder** 4-5 tutos Laravel-*débutant* (ils montrent que tu forms), **ajouter** 4-5 articles sur ta stack réelle (voir T6.1).

**Validation** : la page blog est visuellement attrayante, laategorisée, et reflète la stack affichée.

**Charge :** 1 j + production des visuels.

---

### T2.7 — Page contact : 2 étapes + disponibilité

**Étapes**
1. Formulaire en 2 étapes : (1) type de projet + budget, (2) détails + coordonnées — moins d'abandon qu'un long formulaire.
2. Bloc « Disponibilité » (statut, délai de réponse, créneaux libres).
3. Bouton WhatsApp cliquable (wa.me) + copie email + QR vCard (T1.8).
4. Carte de localisation (Madagascar) statique et légère.

**Validation** : formulaire validé en < 1 min, 3 canaux de contact visibles.

**Charge :** 5 h.

---

### T2.8 — Audit dark mode & contrastes

**Étapes**
1. Passer sur chaque page en dark mode et corriger les contrastes (ratio AA minimum : 4,5:1 texte, 3:1 gros texte).
2. Vérifier les images (logo, illustrations) sur fond sombre, les bordures `border-border-dark`, les ombres.
3. Un seul point de vérité pour les couleurs de surface.

**Validation** : audit AA validé sur les 10 pages, aucune zone illisible.

**Charge :** 4 h.

---

### T2.9 — Mobile

**Étapes**
1. Barre d'action fixe en bas sur mobile (Appeler / WhatsApp / Email) — conversion directe.
2. Menu mobile : vérifier fermeture au clic outside, focus trap, retour au body scroll.
3. Tableaux → cartes empilées (à vérifier : compétences, expériences).
4. Tester à 360 px de large.

**Validation** : aucune débordement horizontal à 360 px, actions principales accessibles au pouce.

**Charge :** 4 h.

---

### T2.10 — Micro-interactions cohérentes

**Étapes**
1. Tokens de transition (durées/courbes) appliqués partout : hover de carte (élévation + bordure), boutons (scale 0.98), badges.
2. Curseurs et focus visibles cohérents.
3. Squelettes de chargement (si requêtes futures) + états vides soignés (page déjà vide → replaced per T0.3).

**Charge :** 3 h.

---

# LOT 3 — Accessibilité

### T3.1 — Navigation clavier & structure

- **Skip link** « Aller au contenu » (premier élément focusable, `resources/js/Layouts/AppLayout.vue`).
- **Landmarks** : `header`/`nav`/`main`/`footer` explicites, `aria-current="page"` sur l'onglet actif.
- **Focus visible** sur tous les éléments interactifs (`:focus-visible` global, pas de `outline: none`).
- **aria** sur les filtres projets (groupes de boutons `role="group"` + `aria-pressed`), sur la palette de recherche (combobox), sur la lightbox (`aria-modal`, `aria-label`).
- Le logo/lien « retour en haut » doit être accessible au clavier.

**Validation** : parcours complet au clavier sans piège, focus toujours visible.

**Charge :** 3 h.

---

### T3.2 — `prefers-reduced-motion`

Aucune gestion du mouvement réduit n'existe (`grep -rn "prefers-reduced-motion"` → 0 résultat) alors que le site anime beaucoup (entrées décalées, Ken Burns, halos animés, cybergrid).

**Étapes**
1. Dans `resources/css/app.css` : `@media (prefers-reduced-motion: reduce) { *, *::before, *::after { animation-duration: .01ms !important; animation-iteration-count: 1 !important; transition-duration: .01ms !important; scroll-behavior: auto !important; } }`
2. Désactiver en JS le Ken Burns et le cybergrid animé (`resources/js/Components/...`) quand la préférence est active.
3. Le `scroll-behavior: smooth` global doit tomber en auto.

**Validation** : avec l'option système « réduire les animations », le site reste lisible et sans mouvement.

**Charge :** 1 h.

---

### T3.3 — Tests d'accessibilité automatisés

- Ajouter `axe-core` + test Playwright sur les 10 pages (niveaux A/AA).
- Ajouter un test Pest vérifiant que chaque `<img>` a un `alt` (ou `alt=""` si décoratif).

**Charge :** 2 h.

---

# LOT 4 — Performance

Objectif : LCP < 2,5 s · TTFB < 800 ms · page d'accueil < 1 Mo.

### T4.1 — Images (voir aussi T0.4)

`srcset` + `sizes` pour les covers, `<picture>` WebP/JPEG, preload de l'image LCP, `width`/`height` sur toutes les images.

### T4.2 — Bundle & navigation

- **Bundle 476 Ko** (148 Ko gzip) : split vendor (Vue/Inertia d'un côté), lazy-load des composants lourds (lightbox, palette de recherche, carte).
- **Prefetch Inertia** : activer le prefetch au survol des liens (`router.prefetch` / `prefetch` sur les `<Link>`), aujourd'hui absent → navigation perçue instantanée.
- Analyser : `npm run build` + rapport de chunks ; viser **< 90 Ko gzip** sur le chunk initial.

### T4.3 — TTFB (4 s aujourd'hui) 🔥 Le plus gros frein

Cause principale : instance **free tier** Render qui s'éteint après inactivité + cold start Docker.

**Étapes (choisir une option)**
1. **Option A (recommandée)** : instance toujours active (Fly.io / Railway / Render paid 5 $/mois) → TTFB < 300 ms.
2. **Option B** : garder le free tier + **CDN cache** devant (Cloudflare) + page d'accueil statique pré-rendue → le HTML est servi depuis le cache, seul l'API reste dynamique.
3. **Option C** : `APP_ENV=production` avec `config:cache` + `route:cache` + `view:cache` déjà dans le Dockerfile ; vérifier `opcache.enable=1` et `opcache.jit` dans le `Dockerfile` (PHP CLI n'a pas d'OPcache par défaut).

### T4.4 — Cache applicatif

- `Cache::remember()` : TTL 3600 s → 600 s pour les pages qui changent (projets), longer pour le statique.
- Purge via `php artisan content:build` au lieu d'attendre l'expiration.

### T4.5 — Polices

Bunny Fonts sert 3 graisses (400/500/600) en woff **et** woff2 → 12 fichiers dans le build. Ne garder que woff2, `font-display: swap`, et **preload** de la graisse 400 (la LCP).

**Charge totale du lot :** 1 j (T4.3 option A = 30 min de config).

---

# LOT 5 — SEO / Social / Légal

### T5.1 — JSON-LD sur toutes les pages

Le JSON-LD n'existe que sur Blog et Contact. Manque sur la home et les projets.

**Étapes**
1. `Person` (nom, poste, `sameAs` → LinkedIn/GitHub/X, `worksFor`, `alumniOf`, `knowsAbout`) + `WebSite` (`SearchAction`) sur la home.
2. `CreativeWork`/`SoftwareSourceCode` par projet (nom, description, `codeRepository`, `url`, `programmingLanguage`, `dateCreated`, `image`).
3. `BreadcrumbList` sur les pages imbriquées.
4. Composant `resources/js/Components/UI/JsonLd.vue` déjà réutilisable.

**Validation** : validateur Google Rich Results sans erreur sur `/`, `/projects`, `/projects/ikaaly`.

### T5.2 — Open Graph dynamique

L'OG image est aujourd'hui la cover brute (ratio 1,91:1 non respecté pour certaines). Générer une **OG image 1200×630 par projet** (titre + logo + fond) → préviews LinkedIn/X/WhatsApp beaucoup plus cliquables.

### T5.3 — Multilingue indexable

Les URLs ne sont pas préfixées → pas d'`hreflang`, et Google ne voit qu'une seule version. Deux options :
- **A** (recommandé) : préfixe réel `/{locale}/...` (le middleware `SetLocale` sait déjà lire `segment(1)`) + `hreflang` réciproque + `x-default`.
- **B** : conserver les URLs propres et utiliser `?lang=` + `hreflang` sur query.

À traiter en même temps que la correction des liens internes `/projects/{slug}` (T0.x).

### T5.4 — Pages légales & RGPD

Le site a un formulaire de contact, un email et (bientôt) une newsletter, mais **aucune page légale**.

- `/legal/mentions-legales` (éditeur, hébergeur Render, responsable de traitement).
- `/legal/privacy` + `/legal/cookies` (cookies : analytics optionnel → bandeau de consentement si un outil non essentiel est ajouté).
- Bandeau de consentement **uniquement** si analytics/cookies non essentiels sont ajoutés.

### T5.5 — robots.txt + sitemap enrichi

- `robots.txt` : autoriser tout, pointer vers le sitemap, exclure `/preview/*` et `/api/*`.
- Sitemap : ajouter les images (`<image:image>`) et les pages `/stack/{tech}`.

**Charge totale du lot :** 1 j.

---

# LOT 6 — Contenu (production)

> Ce lot dépend de toi : c'est ce qui fait la différence entre « site bien fait » et « profil qui convertit ».

### T6.1 — 4-5 articles sur la stack réelle 🔥

Le blog actuel = 13 tutos Laravel **débutant** (tags `#Débutant`, dates juillet 2026) alors que le profil affiché est Next.js/React. Un recruteur lit « tuto pour débutants » et conclut « junior ». Un article de niveau expert prouve l'inverse.

**Candidats (un article = 1 sujet, 800-1500 mots, FR + EN + MG)**
1. **« Migrer une app Laravel de 6 000 membres vers Next.js 16 »** — le story-telling du projet AIM (le plus fort : cas réel + arbitrages techniques).
2. **« Server Actions + Drizzle ORM : un back-office typé de bout en bout »** — pattern réutilisable.
3. **« RLS Supabase vs validation applicative : où s'arrête la frontière de confiance ? »**
4. **« i18n App Router : FR/EN/MG sans îlot de traduction »** (pattern `next-intl` + segments).
5. **« PWA avec Serwist : notifications push et install sur Vercel »** (technique rare et crédible).

**Règle** : conserver 4-5 tutos Laravel-*débutant* (ils démontrent ta capacité à former), mais les classer dans une catégorie « Fondamentaux » et non comme le cœur du blog.

### T6.2 — Mettre à jour l'index du blog

`blog.subtitle` → « Architecture, Laravel, Next.js, React et retours d'expérience ».

### T6.3 — LinkedIn sérieux

Photo, bannière, titre aligné sur le portfolio, 3 projets mis en avant (iKAALY, AIM App Next, Autocollant Mada), lien vers le portfolio. C'est le canal n°1 de recherche passive de devs.

### T6.4 — Témoignages (cf. T0.3)

### T6.5 — Chiffres réels des projets (cf. T1.5)

---

# LOT 7 — Qualité / CI-CD

### T7.1 — Réparer le test en échec

`tests/Feature/FileProjectRepositoryTest.php:100` — échec **pré-existant** : le dépôt ne renvoie `coverImage` que si le fichier existe sur le disque, la fixture de test n'a pas d'image. Deux options :
1. Créer la fixture image (`tests/Fixtures/images/test/cover.jpg`) → le test passe tel quel.
2. Modifier le dépôt pour accepter un chemin en environnement de test.

→ **Option 1** recommandée (ne pas assouplir la logique de production pour un test).

### T7.2 — CI GitHub Actions (item O2 du CDC)

Workflow `.github/workflows/ci.yml` : PHP 8.3 + Node 22 → `composer install` → `php artisan test` → `npm ci && npm run build` → build Docker de `render.yaml` (ou au minimum vérification que le Dockerfile build).

### T7.3 — Sécurité

- **Rotation du PAT GitHub** exposé en clair dans le remote (`git remote -v`) → `https://<token>@github.com/...`. À révoquer puis à remplacer par un remote **sans token** + credential helper / SSH.
- CSP : remplacer `'unsafe-inline' 'unsafe-eval'` par des **nonces** (`app/Http/Middleware/ContentSecurityPolicy.php:17`).
- Vérifier `X-Frame-Options`, `Strict-Transport-Security` (absent aujourd'hui).

### T7.4 — Garde-fous de contenu

Script `php artisan content:validate` : vérifie que chaque projet a une cover qui **existe**, que les `order` sont uniques, que les `status` sont dans la liste blanche, que chaque `github_url` **existe** (HEAD 200), que les slugs sont cohérents entre les 3 langues. → à brancher dans la CI, ça évitera les 4 bugs de la session passée.

**Charge totale du lot :** 1 j.

---

# ✅ CHECKLIST DE VALIDATION GLOBALE

À passer avant de considérer le plan terminé :

- [ ] Aucun lien externe ne renvoie 404 (repos GitHub, liens des articles, sites live)
- [ ] Aucun `0+` ou valeur vide sur une page (`/about`, `/testimonials`, `/projects`)
- [ ] Les 3 locales (FR/EN/MG) sont synchronisées : aucune clé manquante, aucun texte en français résiduel en `en`
- [ ] LCP < 2,5 s et TTFB < 800 ms en 4G simulé, sur `/` et `/projects`
- [ ] Aucune image > 200 Ko sur la home et `/projects`
- [ ] Navigation clavier complète possible, focus visible partout
- [ ] `prefers-reduced-motion` respecté
- [ ] JSON-LD valide sur `/`, `/projects`, `/projects/{slug}`, `/blog`
- [ ] `/legal/mentions-legales` + `/legal/privacy` en ligne
- [ ] `php artisan test` → 68/68 vert
- [ ] `npm run build` sans avertissement
- [ ] `content:validate` passe en CI

---

# 📌 BACKLOG — idées plus loin

- **Page « générateur de devis »** : 3 questions → fourchette de prix et délai (différenciateur fort pour un freelance, à condition d'être honnête sur les fourchettes).
- **Stats GitHub / contributions** intégrées (via l'API GitHub, plan gratuit) — attention à ne pas sur-vendre.
- **Mode « CV interactif »** : le CV PDF devient une page web filtrable (filtres par compétence, expérience, type de projet) — utile en amont d'un entretien.
- **Multilingue MG complet** : aujourd'hui le malagache est une traduction ; viser du contenu natif (recrutement local).
- **Newsletter bimestrielle** « construire un produit Next.js à Madagascar » — 1 email/2 mois, liste d'abonnés = audience.
- **Post-mortem public** d'un projet (ce qui a échoué) — très différenciant, à faire quand la confiance est établie.
- **Pause / spacer** entre les sections pour respirer (le design est assez dense).
- **Easy mode** : cache-first sur le HTML avec revalidation à la publication → TTFB quasi nul sur le free tier.
