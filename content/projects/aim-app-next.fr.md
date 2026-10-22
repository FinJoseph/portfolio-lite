---
title: "AIM App (Next.js)"
slug: "aim-app-next"
excerpt: "Version Next.js de la plateforme de gestion de l'association AIM — Antilin'I Madagascar (Scouts de Madagascar). Site vitrine trilingue, espace membre, back-office hiérarchique et RBAC en base."
cover_image: "/images/projects/aim-app-next/cover.jpg"
gallery:
  - "/images/projects/aim-app-next/cover.jpg"
  - "/images/projects/aim-app-next/01-actualites.jpg"
  - "/images/projects/aim-app-next/02-evenements.jpg"
category: "web"
technologies: ["Next.js", "React", "TypeScript", "Tailwind CSS", "Drizzle ORM", "PostgreSQL", "shadcn/ui", "i18n"]
site_url: "https://antilinimadagascar.vercel.app"
github_url: "https://github.com/FinJoseph/aim-app-next"
completed_at: "2026-10"
status: "in-progress"
is_featured: true
order: 2
meta_title: "AIM App (Next.js) - Gestion des membres des Scouts de Madagascar"
meta_description: "Version Next.js de la plateforme AIM : site public trilingue, espace membre, back-office hiérarchique et RBAC PostgreSQL avec Drizzle ORM."
---
## Présentation

**AIM App (Next.js)** est la **version Next.js** de la plateforme de gestion de l'association **AIM — Antilin'I Madagascar (Scouts de Madagascar)**. Elle reprend les fondations métier de la première version Laravel/Filament et les réécrit sur une architecture moderne : App Router, Server Components, Server Actions et Drizzle ORM.

> Cette fiche décrit la **réécriture Next.js**. La version historique **Laravel + Filament + Vue.js** est présentée séparément dans la fiche « Antilin'i Madagasikara ».

## Fonctionnalités

### 🌍 Site public (FR / EN / MG)
- Accueil, **actualités** (catégories, tags), **vie associative**, **événements**, **quiz scouts** et page à propos
- Fiches ouvertes en modale, bascule **Contact ⇄ Rejoindre** avec assistant d'adhésion en 4 étapes
- **SEO** : canonical, `hreflang`, Open Graph, JSON-LD, sitemap multilingue, `robots.txt`
- Mode sombre, **PWA**, animations respectant `prefers-reduced-motion`

### 🧑‍🤝‍🧑 Espace membre
- Connexion par **n° de membre + code à 6 chiffres**, session distincte de l'admin
- Profil (modifications soumises à validation), **cotisations**, déclaration de paiement avec preuve, facture imprimable, quiz

### 🗂️ Back-office
- **Membres** : annuaire mobile-first, recherche instantanée, filtres, import/export CSV/XLSX
- **Cotisations & paiements** : ponctuelles ou périodiques, par périmètre, montants membre/chef
- **Événements** : camps, réunions, formations, présence, validation hiérarchique
- **Organisation** : une page par niveau (national → diocèse → district → groupe → unité), assistant multi-étapes et carte interactive
- **Messagerie temps réel** (SSE) : conversations, annonces, sondages, réactions

### 🛡️ Superadmin
- Contenu du site, utilisateurs, **rôles et permissions** éditables, champs sensibles et validation par le parent direct

## Stack Technique

| Technologie | Utilisation |
|-------------|-------------|
| Next.js 16 (App Router) | Framework full-stack, Server Components & Actions |
| React 19 | Composants UI, Server Components |
| TypeScript strict | Typage complet du domaine |
| Tailwind CSS 4 + shadcn/ui | Design system accessible |
| Drizzle ORM | Accès SQL typé à PostgreSQL (Neon) |
| PostgreSQL (Neon) | Base relationnelle managée |
| Auth.js (NextAuth v5) | Sessions membre et admin séparées |
| Recharts | Graphiques de back-office |
| Zod | Validation des Server Actions |
| ExcelJS | Import / export XLSX |
| Vercel | Déploiement + Vercel Analytics |

## Architecture

Architecture en couches à sens unique, avec **une seule frontière de confiance** : les Server Actions.

```text
Navigateur (PWA) → Présentation (RSC) → Server Actions (session → permission → Zod)
                                     → Domaine (périmètre appliqué) → RBAC → PostgreSQL
```

- **RBAC en base** : les rôles hiérarchiques (national → diocèse → district → groupe → unité) et fonctionnels sont éditables, et chaque requête est filtrée par un `scopeWhere` côté domaine.
- **Périmètre hiérarchique** appliqué systématiquement : un responsable de district ne voit que son district.

## Statut

**Déployé sur Vercel** — [antilinimadagascar.vercel.app](https://antilinimadagascar.vercel.app) — MVP fonctionnel, la v1.0 est en cours.
