---
title: "iKomandy B2B"
slug: "ikomandy"
excerpt: "Plateforme e-commerce B2B connectant grossistes et acheteurs. Administration Filament, frontend Vue.js, RBAC multi-rôles avec isolation des données par tenant."
cover_image: "/images/projects/ikomandy/cover.jpg"
gallery:
  - "/images/projects/ikomandy/screenshot-1.jpg"
  - "/images/projects/ikomandy/screenshot-2.jpg"
category: "web"
technologies: ["Laravel", "Filament", "Vue.js", "Inertia.js", "Tailwind CSS", "MySQL", "Spatie Permission", "Filament Shield"]
site_url: null
github_url: null
completed_at: "2025-12"
status: "completed"
is_featured: true
order: 3
meta_title: "iKomandy B2B - Plateforme e-commerce en gros"
meta_description: "Plateforme B2B complète de vente en gros avec administration Filament et SPA Vue.js."
---
## Présentation

**iKomandy B2B** est une plateforme e-commerce complète orientée **Business-to-Business** qui connecte les grossistes et les acheteurs/détaillants. Elle propose une administration logistique avancée via Filament et un frontend d'achat réactif en Vue.js.

## Architecture Multi-Rôles (RBAC)

Quatre niveaux d'accès distincts avec isolation des données :

| Rôle | Accès | Interface |
|------|-------|-----------|
| **Super Admin** | Vision globale CA, audit, certification des grossistes | Filament |
| **Grossiste** | Données cloisonnées (scopes Eloquent), stats, employés, commandes | Filament |
| **Livreur** | Gestion logistique des expéditions | Filament |
| **Client B2B** | Paniers, historique achats, évaluation des grossistes | Vue.js SPA |

## Fonctionnalités

- **RBAC avancé** avec Spatie Permission + Filament Shield
- **Isolation des données** par grossiste (scopes Eloquent)
- **Catalogue produits** avec gestion par grossiste
- **Panier d'achat** et suivi des commandes
- **Système d'évaluation** des grossistes (1-5 étoiles)
- **Rate limiting** sur les appels API
- **Suspension de compte** avec blocage immédiat (HTTP 403)
- **Politiques d'accès** (Laravel Policies) interdisant la falsification des commandes

## Stack Technique

| Technologie | Utilisation |
|-------------|-------------|
| Laravel 11 | Framework backend |
| PHP 8.2 | Langage serveur |
| Filament 3 | Panneau d'administration |
| Vue.js 3 (Composition API) | Frontend SPA |
| Inertia.js | Pont Laravel ↔ Vue.js |
| Tailwind CSS 3 | Styles |
| MySQL / PostgreSQL | Base de données |
| Spatie Permission | Gestion des rôles |
| Filament Shield | UI des permissions |
