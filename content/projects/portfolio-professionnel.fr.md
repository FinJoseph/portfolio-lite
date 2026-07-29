---
title: "Portfolio Professionnel"
slug: "portfolio-professionnel"
excerpt: "Portfolio interactif multilingue (FR/EN/MG) avec panneau d'administration Filament et interface SPA Inertia.js. Gestion complète des projets, articles, compétences et témoignages."
cover_image: "/images/projects/portfolio-professionnel/cover.jpg"
gallery:
  - "/images/projects/portfolio-professionnel/screenshot-1.jpg"
  - "/images/projects/portfolio-professionnel/screenshot-2.jpg"
category: "web"
technologies: ["Laravel", "Filament", "Vue.js", "Inertia.js", "Tailwind CSS", "MySQL", "Spatie MediaLibrary", "Spatie Translatable"]
site_url: null
github_url: null
completed_at: "2026-07"
status: "completed"
is_featured: true
order: 2
meta_title: "Portfolio Professionnel - CMS avec administration Filament"
meta_description: "Portfolio CMS complet avec administration Filament, SPA Inertia.js, support multilingue et SEO intégré."
---
## Présentation

**Portfolio Professionnel** est un CMS de portfolio complet construit avec Laravel, Filament et Inertia.js. Il permet de gérer l'ensemble du contenu d'un portfolio personnel via une interface d'administration puissante.

## Fonctionnalités

### Administration (Filament)
- **10 modèles** gérés : Projets, Articles, Compétences, Expériences, Témoignages, Messages, Catégories, Tags, Utilisateurs, Paramètres
- **Gestion des médias** via Spatie MediaLibrary
- **Tableau de bord** avec statistiques
- **Notifications** base de données
- **Pages personnalisées** : Profil, Paramètres du site

### Site Public (Inertia.js SPA)
- **Multilingue** : Français, Anglais, Malgache (`fr`/`en`/`mg`)
- **Pages** : Accueil, Compétences (détail), Projets (liste + détail), Blog (liste + détail), Témoignages, Contact
- **Formulaire de contact** avec rate limiting
- **SEO** : JSON-LD structured data, meta tags, sitemap.xml
- **Mode sombre/clair**
- **Navigation responsive**

### Technique
- **Architecture SPA** avec Inertia.js (pas d'API REST)
- **20 migrations** et **9 seeders**
- **Routes localisées** (`fr|en|mg`)
- **Modèles traduisibles** via Spatie Translatable

## Stack Technique

| Technologie | Utilisation |
|-------------|-------------|
| Laravel 13.8 | Framework backend |
| PHP 8.3 | Langage serveur |
| Filament 5.6 | Panneau d'administration |
| Vue.js 3.5 | Frontend SPA |
| Inertia.js 3 | Pont Laravel ↔ Vue.js |
| Tailwind CSS 4.3 | Styles |
| MySQL | Base de données |
| Spatie MediaLibrary | Gestion des médias |
| Spatie Translatable | Traductions base de données |
| Spatie Sitemap | Génération sitemap |
| Vite 8 | Bundler frontend |

## Statut

Projet terminé et déployé.
