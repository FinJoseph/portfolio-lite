---
title: "iKAALY"
slug: "ikaaly"
excerpt: "Marketplace de commande locale à Manakara : restaurants, clients et administration dans un même écosystème. PWA installable, paiement mobile money et suivi de commande."
cover_image: "/images/projects/ikaaly/cover.jpg"
gallery:
  - "/images/projects/ikaaly/cover.jpg"
  - "/images/projects/ikaaly/01-restaurants.jpg"
  - "/images/projects/ikaaly/02-menu.jpg"
category: "web"
technologies: ["Next.js", "React", "TypeScript", "Tailwind CSS", "Supabase", "PostgreSQL", "Zustand", "i18n"]
site_url: "https://ikaaly.vercel.app"
github_url: "https://github.com/FinJoseph/ikaaly"
completed_at: "2026-10"
status: "completed"
is_featured: true
order: 1
meta_title: "iKAALY - Marketplace de commande locale à Manakara"
meta_description: "iKAALY connecte restaurants, clients et administration : commande locale, paiement mobile money, suivi de commande et PWA trilingue."
---
## Présentation

**iKAALY** est une plateforme de commande locale à **Manakara** qui réunit trois usages dans un même écosystème : la vitrine publique, l'espace restaurant et le back-office administrateur.

> « Choisis, commande, c'est iKAALY » · « Safidio, kaomandio, iKAALY » · « Choose, order, it's iKAALY »

L'UX est pensée **mobile-first** : codes courts, parcours rapide et lisibilité parfaite, pour un public qui dispose souvent de peu de temps et d'une connexion instable.

## Fonctionnalités

- 🍽️ **Catalogue public** : recherche de restaurants, fiches détaillées et menu par établissement
- 🛒 **Panier mono-restaurant** persistant (Zustand + middleware de persistance)
- 🧾 **Commande sans compte client** obligatoire, avec choix du mode de retrait ou de livraison
- 💳 **Paiement mobile money** (MVola, Orange Money, Airtel Money) avec preuve de paiement
- 📍 **Suivi de commande** par token public, sans authentification
- 🏪 **Espace restaurant** : traitement des commandes en temps réel, gestion du menu et des disponibilités
- 🛡️ **Espace admin** : validation des restaurants, gestion des quartiers, statistiques et litiges
- 🌍 **Trilingue** FR / MG / EN (next-intl) avec routage localisé
- 📲 **PWA installable** (Serwist) : notifications push et expérience native

## Stack Technique

| Technologie | Utilisation |
|-------------|-------------|
| Next.js 16 (App Router) | Framework full-stack, RSC, Server Actions |
| React 19 | Composants UI, Suspense, Server Components |
| TypeScript | Typage strict de bout en bout |
| Tailwind CSS 4 | Design system utility-first |
| Supabase | Postgres, Auth, Storage, Realtime, RLS |
| PostgreSQL | Base relationnelle gérée par Supabase |
| Zustand | État global et panier persistant |
| Leaflet / React-Leaflet | Cartographie des restaurants et des quartiers |
| Zod | Validation et règles métier |
| Serwist | Service worker et installation PWA |
| Vercel | Déploiement et previews par branche |

## Architecture

- Une seule **frontière de confiance** : les Server Actions Next.js valident chaque mutation (session → rôle → schéma Zod).
- **Row Level Security** Supabase : chaque requête est filtrée côté base, pas seulement dans l'interface.
- i18n par middleware avec segments de locale et messages typés.

## Statut

**Déployé sur Vercel** — [ikaaly.vercel.app](https://ikaaly.vercel.app) — application complète et fonctionnelle.
