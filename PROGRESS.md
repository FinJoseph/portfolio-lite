# 📊 PROGRESS.md — Statut vivant du projet

**Dernière mise à jour : 2026-07-03**
**Projet :** portfolio-lite (Laravel + Inertia + Vue 3, sans BDD, file-based)

> Ce fichier est LA mémoire principale de l'agent. Le lire en premier à chaque nouvelle session, avant de relire le cahier des charges.

---

## ✅ CE QUI EST FAIT

### Fondation technique (Étapes 1-3)
- ✅ Projet Laravel 13.18 initialisé avec `composer create-project laravel/laravel`
- ✅ Inertia.js + Vue 3 + Tailwind CSS 4 configurés (`vite.config.js`, `resources/js/app.js`, `resources/css/app.css`)
- ✅ `resources/js/bootstrap.js` créé (config Axios manquante du starter kit)
- ✅ `resources/views/app.blade.php` créé (template racine Inertia)
- ✅ Middleware `HandleInertiaRequests` généré et enregistré dans `bootstrap/app.php`
- ✅ Route `/` fonctionnelle avec `resources/js/Pages/Home.vue`
- ✅ Pest installé (`composer require pestphp/pest --dev`), init fait via `./vendor/bin/pest --init` (PAS `php artisan pest:install`, cette commande n'existe pas en Pest 4)

### Architecture Repository pattern (Étape 4 — 6/6 Repositories créés, TOUS enrichis) ✅ TERMINÉ

Tous suivent le même pattern : `Interface` + `DTO` + implémentation (`File*` pour Markdown, `Json*` pour JSON) + binding dans `app/Providers/AppServiceProvider.php` + test Pest dans `tests/Feature/`.

| Repository | Format | Fichier(s) contenu | Interface | Implémentation | Test | Statut |
|---|---|---|---|---|---|---|
| Project | Markdown (1 fichier/projet) | `content/projects/*.{locale}.md` | `ProjectRepositoryInterface` | `FileProjectRepository` | `FileProjectRepositoryTest` (6 tests) | ✅ Enrichi |
| Article (blog) | Markdown (1 fichier/article) | `content/articles/*.{locale}.md` | `ArticleRepositoryInterface` | `FileArticleRepository` | `FileArticleRepositoryTest` (7 tests) | ✅ Créé + enrichi d'origine |
| Skill | JSON (1 fichier, liste) | `content/skills.json` | `SkillRepositoryInterface` | `JsonSkillRepository` | `JsonSkillRepositoryTest` (7 tests) | ✅ Enrichi (description, related_skills) |
| Experience | JSON (1 fichier, liste, multilingue) | `content/experiences.json` | `ExperienceRepositoryInterface` | `JsonExperienceRepository` | `JsonExperienceRepositoryTest` (6 tests) | ✅ Enrichi (start_date, end_date, location, company_url, company_logo) |
| Education | JSON (1 fichier, liste, multilingue) | `content/education.json` | `EducationRepositoryInterface` | `JsonEducationRepository` | `JsonEducationRepositoryTest` (5 tests) | ✅ Créé complet dès le départ |
| Testimonial | JSON (1 fichier, liste) | `content/testimonials.json` | `TestimonialRepositoryInterface` | `JsonTestimonialRepository` | `JsonTestimonialRepositoryTest` (7 tests) | ✅ Enrichi (job_title, submitted_at) |
| Settings | JSON (1 fichier, objet unique) | `content/settings.json` | `SettingsRepositoryInterface` | `JsonSettingsRepository` | `JsonSettingsRepositoryTest` (6 tests) | ✅ Enrichi (bio, avatar, hero_tagline, meta SEO) |

**Total tests actuels : 46 tests, TOUS PASS** (validé le 2026-07-03 via `php artisan test`, 102 assertions, 3.08s).

### Champs finaux par Repository (état définitif de la phase d'enrichissement)

**ProjectDTO** : `title, slug, excerpt, content, coverImage, gallery, category, technologies, siteUrl, githubUrl, completedAt, status, isFeatured, order, metaTitle, metaDescription`

**ArticleDTO** : `title, slug, excerpt, content, coverImage, category, tags, status, publishedAt, readingTime, order, metaTitle, metaDescription` — inclut méthode `related()` (articles similaires par tag/catégorie partagés)

**SettingsDTO** : `siteName, jobTitle, heroTagline, bio, avatar, email, phone, socialLinks, defaultMetaTitle, defaultMetaDescription`

**SkillDTO** : `name, icon, level, category, description, relatedSkills (array), order, isActive`

**ExperienceDTO** : `title, company, description, duration, startDate, endDate, location, companyUrl, companyLogo, order, isActive`

**EducationDTO** (nouveau) : `degree, institution, description, duration, startDate, endDate, location, institutionUrl, institutionLogo, order, isActive`

**TestimonialDTO** : `name, email, company, jobTitle, message, rating, photo, submittedAt, order, isActive`

---

## ⏳ CE QUI RESTE À FAIRE

### Phase enrichissement des contenus : ✅ TERMINÉE (7/7 étapes)

```
1. ✅ Enrichir Project (FAIT)
2. ✅ Créer Article/Blog (FAIT)
3. ✅ Enrichir Settings (FAIT)
4. ✅ Enrichir Experience (FAIT — start_date, end_date, location, company_url, company_logo)
5. ✅ Créer Education (FAIT — nouveau Repository complet, pattern JSON simple comme Experience)
6. ✅ Enrichir Skill (FAIT — description, related_skills)
7. ✅ Enrichir Testimonial (FAIT — job_title, submitted_at)
```

### Architecture frontend (posée avant la construction des pages) — ✅ TERMINÉE

- ✅ Arborescence organisée : `Components/UI/` (réutilisable), `Components/Layout/` (navbar/footer), `Components/{Page}/` (sections propres à une page), `Layouts/AppLayout.vue`, `composables/`
- ✅ i18n frontend (vue-i18n@9) : `resources/js/i18n/index.js` + `locales/{fr,en,mg}.json`, branché dans `app.js`, synchronisé avec la locale serveur
- ✅ Mode clair/sombre : `composables/useDarkMode.js` (état partagé, `localStorage`, classe `dark` sur `<html>`) + `Components/Layout/DarkModeToggle.vue`
- ✅ Composants UI réutilisables : `BaseButton.vue` (variants primary/secondary/ghost, prop `as` polymorphe pour `<Link>` Inertia), `BaseCard.vue`, `SectionHeading.vue`
- ✅ Layout global : `AppLayout.vue` (Navbar + slot + Footer), `Navbar.vue` avec `NavDropdown.vue` (regroupe Compétences/Projets/Témoignages sous un menu "Réalisations" au survol, pattern Tailwind `group-hover`/`group-focus-within`, pas de JS), `LocaleSwitcher.vue`
- ✅ Design tokens définis : couleurs (`ink #151A21`, `paper #FAF8F4`, `amber #C97A2B` accent principal, `teal #1F6F63` secondaire, `slate #5B6472`), typo Inter (conforme CDC) + JetBrains Mono en utilitaire (labels, eyebrows, badges techniques)

### Pages Vue (SPA) — EN COURS

- ✅ `Home.vue` — sections : `HeroSection`, `SkillsPreviewSection`, `ProjectsPreviewSection` (filtré `isFeatured`, limite 3), `TestimonialsPreviewSection` (triés par rating, limite 3), `ContactCtaSection`. Alimentée par `HomeController::__invoke()` (single action controller) via `SkillRepositoryInterface`, `ProjectRepositoryInterface`, `TestimonialRepositoryInterface`. Pas de section "About preview" (redondant avec la page `/about` dédiée).
- ✅ `Footer.vue` — personnalisé : nom du site, tagline, liens sociaux (GitHub/LinkedIn/X), navigation complète, email/téléphone, copyright multilingue. Données partagées globalement via `HandleInertiaRequests::share()` et `SettingsDTO::toArray()`.
- ❌ `About.vue` (doit consommer Settings + Experience + **Education**)
- ❌ `Skills/Index.vue` (galerie groupée par catégorie via `groupedByCategory()`)
- ❌ `Skills/Show.vue` (détail d'un skill + `related_skills` résolus)
- ❌ `Projects/Index.vue` (avec filtres catégorie/techno/statut)
- ❌ `Projects/Show.vue`
- ❌ `Blog/Index.vue`
- ❌ `Blog/Show.vue` (+ section articles similaires via `related()`)
- ❌ `Testimonials.vue`
- ❌ `Contact.vue` + formulaire

### Après les pages Vue (non commencé)

- Formulaire de contact (envoi email direct, sans stockage BDD, Form Request + honeypot + throttle)
- i18n frontend (vue-i18n, fichiers `resources/js/i18n/*.js`)
- Mode clair/sombre (toggle navbar, localStorage, Tailwind `dark:`)
- SEO (meta dynamiques via `<Head>` Inertia, sitemap XML, Schema.org)
- CI/CD GitHub Actions (item O2 du plan de fonctionnalités avancées)
- Cache tags (item B2), API REST (B1), autres items du plan section 7 du CDC v1.1

---

## 🔑 Décisions techniques importantes (ne pas re-débattre)

1. **Cache toujours en array, jamais en objet DTO directement** — bug résolu une fois (`__PHP_Incomplete_Class`), cause : Laravel ne désérialise pas bien des objets PHP complexes depuis le cache. Pattern systématique : `Cache::remember` stocke un `->toArray()`, puis on reconstruit les DTO juste après à chaque appel.
2. **Clé de cache toujours suffixée par `md5($this->path)`** — évite les collisions entre le vrai dossier de contenu et les dossiers de test isolés.
3. **`Cache::flush()` en première ligne de CHAQUE `beforeEach()` de test** — évite qu'un test hérite du cache laissé par un test précédent ou par la navigation manuelle sur le site.
4. **Constructeur de chaque Repository accepte `?string $path = null`** — permet l'injection d'un chemin de test isolé (`new FileProjectRepository($this->testPath)`) sans toucher au vrai contenu `content/`.
5. **Tous les champs des DTO utilisent `??` avec valeur par défaut au moment de la reconstruction depuis le cache** — protège contre un vieux cache incomplet après ajout de nouveaux champs (bug rencontré et corrigé sur ProjectDTO, puis appliqué systématiquement à Experience/Education/Skill/Testimonial).
6. **Champs multilingues résolus DANS le Repository, jamais dans le DTO** — le DTO ne contient que la valeur déjà résolue dans la langue demandée, avec repli automatique sur `fr` si la traduction manque. S'applique à Project, Article, Settings, Experience, Education.
7. **Project/Article = 1 fichier Markdown par item** (texte long) vs **Skill/Experience/Education/Testimonial/Settings = 1 fichier JSON** (données courtes) — règle de choix de format, voir CAHIER_DES_CHARGES pour le détail.
8. **Pest 4** : l'installation se fait avec `./vendor/bin/pest --init`, PAS `php artisan pest:install` (n'existe pas dans cette version).
9. **Champs non-multilingues explicitement séparés des champs multilingues** — ex: dans Experience/Education, `location`, `company_url`/`institution_url`, `company_logo`/`institution_logo`, `start_date`/`end_date` ne sont PAS des objets `{fr, en, mg}` (une URL ou une date ne se traduit pas), contrairement à `title`/`company`/`description`.
10. **`related_skills` (Skill) stocké comme simple tableau de noms** (pas d'objets complets imbriqués) — reste simple en JSON ; la résolution en DTOs complets se fera côté page Vue `/skills/{skill}` en filtrant `all()` par nom, pas dans le Repository.

## ❌ Problèmes rencontrés et résolus (ne pas refaire les mêmes erreurs)

| Problème | Cause | Solution |
|---|---|---|
| `Return value must be of type Collection, __PHP_Incomplete_Class returned` | Cache d'objets DTO directement sérialisés | Cache en array, reconstruction DTO après lecture cache |
| Test lit les vraies données au lieu des données de test | Clé de cache identique entre vrai chemin et chemin de test | Suffixer la clé de cache avec `md5($this->path)` |
| Test échoue après modification manuelle du JSON de test | Cache non vidé entre les tests | `Cache::flush()` en début de chaque `beforeEach()` |
| `Undefined array key "coverImage"` après enrichissement de Project | Vieux cache de navigation avec ancienne structure de données | `??` avec valeur par défaut sur CHAQUE clé lors de la reconstruction DTO depuis le cache |
| `Failed to resolve import "./bootstrap"` | Starter kit Laravel récent ne génère plus ce fichier par défaut | Créer manuellement `resources/js/bootstrap.js` avec la config Axios standard |
| `php artisan pest:install` → erreur "no commands in pest namespace" | Pest 4 a changé sa commande d'installation | Utiliser `./vendor/bin/pest --init` à la place |

---

## 🔑 Décisions techniques frontend (ajout, ne pas re-débattre)

11. **Filtres/tri spécifiques à une page vivent dans le Contrôleur, jamais dans le Repository** — ex: `isFeatured` + `take(3)` pour la home sont appliqués dans `HomeController`, pas dans `FileProjectRepository::all()`. Le Repository reste une source neutre et réutilisable par toutes les pages.
12. **Single Action Controllers (`__invoke()`) pour les pages simples** — `HomeController` n'a qu'une action, donc pas de `index()`. Les contrôleurs avec plusieurs actions (Projects, Blog...) garderont le pattern classique `index()`/`show()`.
13. **`BaseButton.vue` : prop `as` typée `[String, Object, Function]`**, pas `String` seul — piège rencontré : passer `:as="Link"` (composant Inertia) avec `type: String` déclenche un warning Vue car `Link` est un objet, pas une chaîne.
14. **Dropdown de nav en CSS pur (`group-hover`/`group-focus-within` Tailwind), pas de JS/état** — plus simple, accessible au clavier nativement, pas de listener à gérer. Utilisé pour regrouper Compétences/Projets/Témoignages sous "Réalisations" et éviter une nav trop longue.
15. **`app.js` : ne jamais couper une chaîne de template literal sur plusieurs lignes** — bug rencontré : l'éditeur (auto-wrap) insérait un vrai saut de ligne dans `` `./Pages/${name}.vue` ``, cassant la résolution des composants Inertia (`module is undefined`). Remplacé par une concaténation `"./Pages/" + name + ".vue"` sur une seule ligne, plus robuste face à l'auto-wrap.
16. **`settings` partagé globalement via `HandleInertiaRequests::share()`** — les composants de layout (Footer, Navbar…) ne reçoivent pas de props de page. Pour y accéder, on injecte `SettingsRepositoryInterface` dans le middleware Inertia et on expose `settings` + `locale` dans `usePage().props`. `SettingsDTO` expose une méthode `toArray()` pour sérialiser proprement vers Inertia.

## 🎯 Prochaine étape recommandée

**Construction des pages Vue (SPA)** — continuer par `About.vue`, qui est la première page à consommer les 3 repositories liés au profil : `Settings` (bio, avatar, contact), `Experience` (parcours pro) et **`Education`** (nouveau, parcours scolaire). Ensuite enchaîner sur `Skills/Index.vue` (utilise `groupedByCategory()`), puis `Projects/Index.vue` avec ses filtres.

Pour chaque page : créer le contrôleur Inertia (`Http::render('About', ['settings' => ..., 'experiences' => ..., 'education' => ...])`), la route dans `routes/web.php`, puis le composant `.vue` correspondant, en réutilisant `AppLayout`, `BaseButton`, `BaseCard`, `SectionHeading` déjà en place.

Consulter `CAHIER_DES_CHARGES_PORTFOLIO_LITE.md` section 4.1 pour la liste complète des routes/pages attendues, et section 7 pour les fonctionnalités avancées à prévoir après.