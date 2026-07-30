<p align="center">
  <picture>
    <source media="(prefers-color-scheme: dark)" srcset="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="300">
    <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="300">
  </picture>
</p>

# Portfolio Lite — Laravel 13 + Inertia + Vue 3

Portfolio professionnel **sans base de données**, 100% fichier, hébergeable gratuitement.

**Auteur :** FIN FANILONANTENAINA Joseph — Développeur Laravel & Designer (Madagascar)

---

## Stack technique

| Composant | Technologie |
|---|---|
| Backend | Laravel 13.18+ |
| Frontend SPA | Vue 3.5 (Composition API) |
| Bridge SPA | Inertia.js 3.6 |
| CSS | Tailwind CSS 4.3 |
| Build | Vite 8 |
| i18n | vue-i18n 11 (FR / EN / MG) |
| Recherche | Fuse.js 7 |
| PDF | barryvdh/laravel-dompdf |
| Parsing | spatie/yaml-front-matter |
| Sitemap | spatie/laravel-sitemap |
| Tests | Pest 4 |
| PHP | 8.3+ |
| BDD | Aucune |

## Fonctionnalités

- **SPA complète** — 10 pages (Accueil, À propos, Compétences, Projets, Blog, Témoignages, Contact)
- **Multilingue** — Français, English, Malagasy
- **Dark / Light mode** — Bascule en direct, persistance localStorage
- **Responsive** — Mobile + Desktop, Tailwind utility-first
- **CyberGrid** — Fond cyberpunk animé (SVG + halos verts)
- **Animations fluides** — Staggered entrances, Ken Burns, IntersectionObserver
- **SEO** — Meta dynamiques (<Head> Inertia), JSON-LD, sitemap XML, RSS, Open Graph
- **CV PDF** — Génération à la volée via dompdf
- **Recherche full-text** — Fuse.js côté client sur index JSON
- **API REST** — v1 (projets, compétences, expériences, éducation, témoignages)
- **File-based** — Contenu en fichiers JSON + Markdown, zéro dépendance BDD
- **Repository pattern** — 7 repositories avec interfaces + DTO + injection de dépendances
- **Cache** — Cache::remember() avec système de tags et invalidation
- **Health check** — Endpoint `/up`
- **Contact** — Formulaire avec honeypot + throttle (5/min)
- **Preview** — URLs signées pour brouillons projets/articles
- **CI/CD ready** — GitHub Actions, déploiement Render/Fly.io

## Structure du projet

```
content/
├── projects/          # Projets (Markdown, 1 fichier par langue)
├── articles/          # Articles de blog (Markdown)
├── skills.json        # Compétences
├── experiences.json   # Expériences professionnelles
├── education.json     # Formation
├── testimonials.json  # Témoignages
└── settings.json      # Configuration globale

app/
├── Http/
│   ├── Controllers/   # Contrôleurs Inertia + API REST
│   └── Requests/      # Form Requests (validation)
├── Repositories/      # Interfaces + Implémentations (File/JSON)
├── DTOs/              # Data Transfer Objects
└── Services/          # Logique métier

resources/js/
├── Pages/             # Pages Vue (Home, About, Skills, Projects, Blog, Contact...)
├── Components/        # Composants réutilisables (UI, Layout)
├── Layouts/           # AppLayout (Navbar + Footer)
├── Composables/       # useDarkMode, useScrollAnimation...
└── i18n/locales/      # Traductions FR/EN/MG
```

## Démarrage rapide

```bash
composer install
npm install
cp .env.example .env
php artisan key:generate
npm run build
php artisan serve
```

## Tests

```bash
php artisan test
```

46+ tests Pest — repositories, routes, commandes.

## Déploiement

Hébergement gratuit possible sur :
- **[Render.com](https://render.com)** (free web service, HTTPS auto)
- **[Fly.io](https://fly.io)** (VM légère, Dockerfile requis)
- **Serverless** via Bref (AWS Lambda)

Aucune base de données ➔ déploiement simplifié.

## Licence

MIT
