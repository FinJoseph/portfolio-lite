<p align="center">
  <picture>
    <source media="(prefers-color-scheme: dark)" srcset="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="300">
    <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="300">
  </picture>
</p>

# Portfolio Lite — Laravel 13 + Inertia + Vue 3

Portfolio professionnel **sans base de données**, 100% fichier, hébergeable gratuitement.

**Auteur :** FIN FANILONANTENAINA Joseph — Développeur Full-Stack (Laravel · Next.js) & Designer (Madagascar)
**Site en ligne :** [finjoseph.onrender.com](https://finjoseph.onrender.com/)
**Plan de travail :** [PLAN_AMELIORATIONS.md](PLAN_AMELIORATIONS.md) — feuille de route fonctionnelle, design, perf et SEO (lots 0 → 7)

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

## Contenu mis en avant

**9 projets** (FR / EN / MG) avec images de couverture, galerie, technologies, statut et liens (site live + dépôt GitHub) :

| # | Projet | Stack principale | Statut | En ligne |
|---|---|---|---|---|
| 1 | **iKAALY** — marketplace de commande locale à Manakara | Next.js, React, TypeScript, Tailwind CSS, Supabase, PostgreSQL | Terminé | [ikaaly.vercel.app](https://ikaaly.vercel.app) |
| 2 | **AIM App (Next.js)** — plateforme de gestion AIM (Scouts de Madagascar) | Next.js, React, TypeScript, Tailwind CSS, Drizzle ORM, PostgreSQL, shadcn/ui | En cours | [antilinimadagascar.vercel.app](https://antilinimadagascar.vercel.app) |
| 3 | **Autocollant Mada** — e-commerce de stickers PC sur mesure | Next.js, React, TypeScript, Tailwind CSS, Prisma | Terminé | [autocollantmada.vercel.app](https://autocollantmada.vercel.app) |
| 4 | Antilin'i Madagasikara — gestion des membres (scouts) | Laravel, Filament, Vue.js | En cours | — |
| 5 | Portfolio professionnel (ce site) | Laravel, Filament, Vue.js, Inertia.js | Terminé | — |
| 6 | Ikomandy — plateforme de services | Laravel, Filament, Vue.js | Terminé | — |
| 7 | Horloge Mada | Laravel, Filament, Vue.js | Terminé | — |
| 8 | ROI University | Laravel, Filament, Vue.js | Terminé | — |
| 9 | Art Malagasy | Laravel, Filament, Vue.js | Terminé | — |

**32 compétences** réparties en 7 catégories : Front-end, Back-end, Base de données, DevOps & Outils, Design & UI, Autres, Soft skills.
Le niveau de chaque compétence est affiché et les compétences associées sont liées entre elles.

> 💡 Les liens internes entre projets utilisent des URL **sans préfixe de locale** (`/projects/{slug}`) : la locale est résolue côté serveur via le cookie `locale` et l'en-tête `X-Locale`, pas via le chemin.

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

68 tests Pest — repositories, routes, commandes.

## Déploiement

Hébergement gratuit possible sur :
- **[Render.com](https://render.com)** (free web service, HTTPS auto)
- **[Fly.io](https://fly.io)** (VM légère, Dockerfile requis)
- **Serverless** via Bref (AWS Lambda)

Aucune base de données ➔ déploiement simplifié.

## Licence

MIT
