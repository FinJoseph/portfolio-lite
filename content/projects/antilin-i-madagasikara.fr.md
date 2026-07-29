---
title: "Antilin'i Madagasikara"
slug: "antilin-i-madagasikara"
excerpt: "Application de gestion des membres pour l'association scout Antilin'i Madagasikara (Scouts de Madagascar). Plateforme web et mobile responsive avec administration Filament et site public Vue.js."
cover_image: "/images/projects/antilin-i-madagasikara/cover.jpg"
gallery:
  - "/images/projects/antilin-i-madagasikara/screenshot-1.jpg"
  - "/images/projects/antilin-i-madagasikara/screenshot-2.jpg"
  - "/images/projects/antilin-i-madagasikara/screenshot-3.jpg"
category: "web"
technologies: ["Laravel", "Filament", "Vue.js", "Tailwind CSS", "MySQL", "Chart.js", "Laravel Octane", "Laravel Reverb"]
site_url: null
github_url: "https://github.com/FinJoseph/aim-app-v2"
completed_at: "2025-06"
status: "in_progress"
is_featured: true
order: 1
meta_title: "Antilin'i Madagasikara - Application de gestion des scouts"
meta_description: "Application complète de gestion des membres pour les Scouts de Madagascar. Administration Filament, site public Vue.js SPA, RBAC hiérarchique, blog, paiements et événements."
---
## Présentation

**Antilin'i Madagasikara** est une application web complète de gestion des membres pour l'association scout **Antilin'i Madagasikara (Scouts de Madagascar)**. Elle combine un puissant panneau d'administration Filament et un site public moderne en Vue.js SPA.

## Fonctionnalités

### Administration (Filament)
- **Gestion hiérarchique** : Diocese → District → Groupe → Branche → Unité → Membre
- **RBAC avancé** : 5 rôles hiérarchiques (super_admin, admin_national, admin_diocese, chef_district, chef_groupe) avec visibilité filtrée
- **Blog éditorial** : workflow publication (brouillon → soumis → publié/rejeté)
- **Gestion des membres** : fiches complètes avec santé, brevets, formations, camps, postes
- **Abonnements & Paiements** : paiement unique ou périodique, tarifs chef/membre
- **Gestion d'événements** : création et inscription aux événements
- **Export Excel** : exportation des données via Maatwebsite
- **Tableaux de bord** : 6 widgets avec graphiques Chart.js
- **25 ressources** réparties en 3 clusters de navigation

### Site Public (Vue.js SPA)
- Pages : Accueil, À propos, Histoire, Contact, Nous rejoindre, Actualités
- Carte interactive des groupes
- Formulaire d'adhésion en ligne avec sélection diocèse → district → groupe
- Mode sombre/clair
- Thème personnalisé aux couleurs des scouts

### Technique
- **Architecture duale** : Filament Admin (`/admin`) + Vue SPA (routes client-side)
- **WebSocket temps réel** via Laravel Reverb
- **Haute performance** avec Laravel Octane (Swoole)
- **Responsive** : adapté mobile, tablette et desktop
- **Base de données** : SQLite en développement, MySQL en production (26 modèles, 35 migrations)

## Stack Technique

| Technologie | Utilisation |
|-------------|-------------|
| Laravel 12 | Framework backend |
| PHP 8.4 | Langage serveur |
| Filament 5 | Panneau d'administration |
| Vue.js 3 (Composition API) | Frontend SPA |
| Tailwind CSS 4 | Styles utilitaires |
| Pinia | Gestion d'état |
| Vue Router | Routage client |
| Chart.js | Graphiques et tableaux de bord |
| MySQL | Base de données production |
| Laravel Octane | Serveur haute performance (Swoole) |
| Laravel Reverb | WebSocket temps réel |
| Spatie MediaLibrary | Gestion des médias |
| Maatwebsite Excel | Exportations Excel |
| Vite 7 | Bundler frontend |

## Statut

Projet en cours de finalisation (environ 90%), déjà déployé en environnement de test.
