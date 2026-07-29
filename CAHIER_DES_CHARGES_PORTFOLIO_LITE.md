# 📄 CAHIER DES CHARGES — PORTFOLIO LARAVEL (VERSION LITE / FILE-BASED)

**Version 1.1 — 2026-07-02** (ajout section 7 : fonctionnalités avancées additionnelles)
**Projet :** Portfolio professionnel — développeur web full-stack, Madagascar
**Type :** SPA Laravel + Vue/Inertia, **sans base de données**, 100% hébergeable gratuitement

---

## 1. Objectif du projet

Version allégée du portfolio initial, pensée pour être **déployée gratuitement** (pas de service BDD payant/persistant requis) tout en démontrant une maîtrise avancée de Laravel : Repository pattern, injection de dépendances, cache, commandes Artisan, i18n, SEO.

Le contenu (projets, articles, skills, expériences) est stocké dans des **fichiers versionnés** (Markdown + JSON), pas en BDD. La mise à jour du contenu se fait via Git, pas via un dashboard admin.

---

## 2. Stack technique

| Composant | Techno | Version |
|---|---|---|
| Backend | Laravel | 13.8 |
| Frontend SPA | Vue.js (Composition API) | 3.5.38 |
| SPA Bridge | Inertia.js | 3.4.0 |
| CSS | Tailwind CSS | 4.3.1 |
| Build | Vite | 8.0.0 |
| Parsing contenu | `spatie/yaml-front-matter` | dernière stable |
| Sitemap | `spatie/laravel-sitemap` | 8.1 |
| i18n frontend | vue-i18n | fichiers `resources/js/i18n/*.js` |
| PHP requis | 8.3+ | — |
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

### 4.1 Pages Vue.js (SPA)
Identique à la v1 : `/`, `/about`, `/skills`, `/skills/{skill}`, `/projects`, `/projects/{project}`, `/blog`, `/blog/{slug}`, `/testimonials`, `/contact`.

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

| # | Fonctionnalité | Détail | Démontre |
|---|---|---|---|
| B1 | **API REST versionnée** | `/api/v1/projects`, `/api/v1/skills`, etc., en plus des routes Inertia | API Resources, versioning |
| B2 | **Cache tags + invalidation** | Cache taggé par type de contenu, invalidé à la commande `content:build` | Maîtrise fine du cache |
| B3 | **Queue `sync`** pour l'email de contact | Job `SendContactEmail` dispatché en asynchrone (driver sync ou database) | Jobs, Queues, Listeners |
| B4 | **Policies/Gates** pour un mode "preview" | Accès aux articles/projets en brouillon via token signé, sans Auth complète | Autorisation Laravel |
| B5 | **Webhook sortant** (Discord/Slack) | Notification à chaque soumission de contact/témoignage | HTTP Client, intégrations tierces |
| B6 | **Recherche full-text** (Laravel Scout, driver `collection`) | Recherche sur projets/articles/skills | Scout, indexation sans DB |
| B7 | **Feature flags** | Activer/désactiver des sections via `settings.json` | Config-driven design |

### 7.2 Frontend / UX

| # | Fonctionnalité | Détail | Démontre |
|---|---|---|---|
| F1 | **CV en PDF à la volée** | Génération via `barryvdh/laravel-dompdf` depuis les données `experiences.json`/`skills.json` | Génération de documents dynamiques |
| F2 | **Flux RSS du blog** | `/feed.xml` généré depuis `content/articles/` | Génération XML, standards web |
| F3 | **PWA basique** | Manifest + service worker simple (cache des assets statiques) | Frontend avancé, offline-first |
| F4 | **Recherche instantanée côté client** | Fuse.js sur un index JSON pré-généré par une commande Artisan | Perf, UX |

### 7.3 Observabilité / Qualité

| # | Fonctionnalité | Détail | Démontre |
|---|---|---|---|
| O1 | **Tests Pest + couverture** | Tests sur repositories, routes, commandes ; badge de couverture dans le README | Rigueur, TDD |
| O2 | **CI/CD GitHub Actions** | Pipeline : lint → tests → build assets → déploiement auto (Render/Fly.io) | DevOps, intégration continue |
| O3 | **Logging structuré** | Canal de log custom en JSON pour les événements clés (contact, erreurs) | Observabilité |
| O4 | **Health check endpoint** | `/up` étendu : vérifie cache, mail, lecture des fichiers `content/` | Monitoring |

### 7.4 Ordre de mise en œuvre recommandé

Séquencé pour livrer de la valeur rapidement puis monter en complexité :

```
Étape 1 (fondations, rapide)   : O1 (tests de base) → O2 (CI) → B2 (cache tags)
Étape 2 (backend avancé)       : B1 (API REST) → B3 (queue email) → B7 (feature flags)
Étape 3 (frontend enrichi)     : F1 (CV PDF) → F2 (RSS) → F4 (recherche client)
Étape 4 (fonctionnalités fines): B4 (policies preview) → B5 (webhook) → B6 (Scout)
Étape 5 (finitions)            : F3 (PWA) → O3 (logging) → O4 (health check)
```

> Chaque étape est livrable et déployable indépendamment — pas besoin de tout finir avant de mettre en prod.

---

## 8. Ce qui est explicitement hors périmètre (vs v1)

- ❌ Dashboard Filament / CRUD admin
- ❌ Base de données relationnelle
- ❌ Authentification admin
- ❌ Modération live des témoignages
- ❌ Stockage des messages de contact

---

*Cahier des charges LITE — v1.1 (2026-07-02). Complète, ne remplace pas les fichiers PROGRESS.md / SKILLS_AGENTS.md existants, à adapter en conséquence.*
