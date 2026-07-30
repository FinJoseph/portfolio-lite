# 📄 CAHIER DES CHARGES — PORTFOLIO LARAVEL (VERSION LITE / FILE-BASED)

**Version 1.2 — 2026-07-30** (mise à jour versions dépendances + statut réalisation)
**Projet :** Portfolio professionnel — développeur web full-stack, Madagascar
**Site en ligne :** [finjoseph.onrender.com](https://finjoseph.onrender.com/)
**Type :** SPA Laravel + Vue/Inertia, **sans base de données**, 100% hébergeable gratuitement

---

## 1. Objectif du projet

Version allégée du portfolio initial, pensée pour être **déployée gratuitement** (pas de service BDD payant/persistant requis) tout en démontrant une maîtrise avancée de Laravel : Repository pattern, injection de dépendances, cache, commandes Artisan, i18n, SEO.

Le contenu (projets, articles, skills, expériences) est stocké dans des **fichiers versionnés** (Markdown + JSON), pas en BDD. La mise à jour du contenu se fait via Git, pas via un dashboard admin.

---

## 2. Stack technique

| Composant | Techno | Version |
|---|---|---|---|
| Backend | Laravel | 13.18.1 |
| Frontend SPA | Vue.js (Composition API) | 3.5.39 |
| SPA Bridge | Inertia.js | 3.6.0 |
| CSS | Tailwind CSS | 4.3.2 |
| Build | Vite | 8.0.0 |
| Parsing contenu | `spatie/yaml-front-matter` | dernière stable |
| Sitemap | `spatie/laravel-sitemap` | 8.2 |
| Recherche | Fuse.js | 7.5.0 |
| PDF | barryvdh/laravel-dompdf | 3.1 |
| i18n frontend | vue-i18n | 11.4.6 |
| PHP requis | 8.3+ | — |
| Tests | Pest | 4 |
| Cache | driver `file` ou `array` | — |
| BDD | ❌ aucune | — |
| Auth / Admin | ❌ aucune | — |

Charte graphique (police Inter, couleurs, mode clair/sombre) : **identique à la v1**.

---

## 3. Architecture du contenu (remplace la BDD)

```
content/
├── projects/
│   ├── mon-projet-1.fr.md
│   ├── mon-projet-1.en.md
│   └── mon-projet-1.mg.md
├── articles/
│   └── mon-article.{locale}.md
├── skills.json
├── experiences.json
└── settings.json
```

- Chaque fichier `.md` de projet/article contient un **Front Matter YAML** (titre, slug, excerpt, cover_image, techs, statut, date) + le corps en Markdown.
- `skills.json`, `experiences.json`, `settings.json` : structures simples, une entrée par langue si besoin (`{"fr": "...", "en": "...", "mg": "..."}`).

### Pattern Repository (remplace Eloquent)

```php
interface ProjectRepositoryInterface {
    public function all(string $locale): Collection;
    public function findBySlug(string $slug, string $locale): ?ProjectDTO;
}

class FileProjectRepository implements ProjectRepositoryInterface {
    // lit content/projects/*.md, parse le Front Matter, cache le résultat
}
```

Binding dans un `ServiceProvider` → même logique métier que si c'était Eloquent, mais 100% fichiers. Ça montre l'injection de dépendances et le découplage.

---

## 4. Fonctionnalités conservées

### 4.1 Pages Vue.js (SPA) — ✅ TOUTES IMPLÉMENTÉES
`/` (Home), `/about`, `/skills`, `/skills/{skill}`, `/projects`, `/projects/{project}`, `/blog`, `/blog/{slug}`, `/testimonials`, `/contact` (GET + POST). 10 pages + routes API REST v1 + endpoint santé `/up` + CV PDF `/cv/{locale?}` + preview URLs signées + flux RSS `/feed.xml`.

### 4.2 Multilingue
FR / EN / MG, préfixe `/{locale}/`, middleware `SetLocale`. Contenu dynamique = fichiers par langue au lieu de colonnes JSON.

### 4.3 Mode clair/sombre
Identique (toggle navbar, `localStorage`, `dark:` Tailwind).

### 4.4 Filtres projets & animations
Identique à la v1 (filtres catégorie/techno/statut, hover, scroll animations).

### 4.5 SEO
Meta dynamiques via `<Head>` Inertia, sitemap XML généré par une commande Artisan (`php artisan sitemap:generate`) qui scanne `content/`, Schema.org JSON-LD.

### 4.6 Formulaire de contact
Pas de stockage BDD → envoi direct par email via `Mailable` + Form Request pour la validation. Honeypot anti-spam + `throttle:5,1`.

### 4.7 Témoignages
Fichiers JSON pré-approuvés (affichage uniquement). Une soumission via formulaire peut envoyer un email à l'admin pour ajout manuel au fichier — pas de modération live.

---

## 5. Fonctionnalités Laravel "avancées" mises en valeur

| Fonctionnalité | Où / comment |
|---|---|
| Repository pattern + interfaces | `app/Repositories/` |
| Injection de dépendances | Bindings dans `AppServiceProvider` |
| Cache | `Cache::remember()` sur le contenu parsé |
| Commandes Artisan custom | `content:build`, `sitemap:generate` |
| Form Requests | Validation contact/témoignage |
| Events/Listeners | Ex: `ContactMessageSubmitted` → `SendContactEmail` |
| Middleware custom | `SetLocale` |
| Tests Pest | Sur les repositories, routes, commandes |

---

## 6. Hébergement gratuit visé

| Option | Remarque |
|---|---|
| Render.com (free web service) | Simple, HTTPS auto, cold start ~30s |
| Fly.io | VM légère gratuite, Dockerfile requis |
| AWS Lambda + Bref | Serverless, 1M req/mois gratuit, plus technique |

Pas de dépendance à un service BDD → déploiement simplifié sur toutes ces options.

---

## 7. Fonctionnalités avancées additionnelles

Ajouts optionnels visant à renforcer le profil technique du portfolio (CV, apprentissage, complétude). Chaque fonctionnalité respecte le garde-fou : **sans BDD persistante, gratuit à héberger, sans alourdir le build**.

### 7.1 Backend / Architecture

| # | Fonctionnalité | Détail | Statut |
|---|---|---|---|
| B1 | **API REST versionnée** | `/api/v1/projects`, `/api/v1/skills`, `/api/v1/experiences`, `/api/v1/education`, `/api/v1/testimonials` | ✅ FAIT |
| B2 | **Cache tags + invalidation** | Cache taggé par type de contenu, invalidé à la commande `content:build` | 🔜 À faire |
| B3 | **Queue `sync`** pour l'email de contact | Événement + Listener + Mailable `SendContactEmail` | ✅ FAIT |
| B4 | **Policies/Gates** pour preview | URLs signées pour brouillons sans Auth | ✅ FAIT |
| B5 | **Webhook sortant** (Discord/Slack) | Notification à chaque soumission de contact | ✅ FAIT (Listener) |
| B6 | **Recherche full-text** (Fuse.js) | Recherche sur projets/articles/skills côté client | ✅ FAIT |
| B7 | **Feature flags** | Activer/désactiver des sections via `settings.json` | 🔜 À faire |

### 7.2 Frontend / UX

| # | Fonctionnalité | Détail | Statut |
|---|---|---|---|
| F1 | **CV en PDF à la volée** | Génération via `barryvdh/laravel-dompdf` | ✅ FAIT |
| F2 | **Flux RSS du blog** | `/feed.xml` généré depuis `content/articles/` | ✅ FAIT |
| F3 | **PWA basique** | Manifest + service worker simple | 🟡 Partiel (manifest OK) |
| F4 | **Recherche instantanée client** | Fuse.js sur index JSON | ✅ FAIT (composable créé, à brancher) |

### 7.3 Observabilité / Qualité

| # | Fonctionnalité | Détail | Statut |
|---|---|---|---|
| O1 | **Tests Pest** | Tests sur repositories + routes + commandes | ✅ FAIT (46+ tests) |
| O2 | **CI/CD GitHub Actions** | Pipeline lint → tests → build → déploiement | 🔜 À faire |
| O3 | **Logging structuré** | Canal JSON pour événements clés | 🔜 À faire |
| O4 | **Health check endpoint** | `/up` étendu avec vérifications | ✅ FAIT |

### 7.4 Ordre de mise en œuvre — État actuel

La majorité des fonctionnalités ont déjà été implémentées :

```
✅ Étape 1 (fondations)  : O1 (tests, 46+) → B4 (preview URLs signées) → B6 (recherche Fuse.js)
✅ Étape 2 (backend)     : B1 (API REST v1) → B3 (queue email avec Events/Listeners) → B5 (webhook notifications)
✅ Étape 3 (frontend)    : F1 (CV PDF) → F2 (RSS feed) → F4 (recherche instannée)
🔜 Étape 4 (finitions)  : B2 (cache tags) → B7 (feature flags) → F3 (PWA) → O2 (CI/CD) → O3 (logging)
```

> Ce qui reste : cache tags, feature flags, PWA service worker, CI/CD GitHub Actions, logging structuré.

---

## 8. Ce qui est explicitement hors périmètre (vs v1)

- ❌ Dashboard Filament / CRUD admin
- ❌ Base de données relationnelle
- ❌ Authentification admin
- ❌ Modération live des témoignages
- ❌ Stockage des messages de contact

---

*Cahier des charges LITE — v1.2 (2026-07-30). Complète, ne remplace pas les fichiers PROGRESS.md / SKILLS_AGENTS.md existants, à adapter en conséquence.*
