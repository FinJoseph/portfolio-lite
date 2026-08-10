---
title: "Horloge Mada"
slug: "horloge-mada"
excerpt: "Horloge intelligente du call center avec heure officielle de Madagascar, progression de journée, pause déjeuner, compte à rebours de paie, chat en direct et mascotte chat en 3D."
cover_image: "/images/projects/horloge-mada/cover.png"
gallery:
  - "/images/projects/horloge-mada/cover.png"
category: "web"
technologies: ["Laravel", "Livewire", "Alpine.js", "Tailwind CSS", "FrankenPHP", "Docker", "Vite"]
site_url: "https://horloge-mada.onrender.com"
github_url: "https://github.com/FinJoseph/horloge-mada"
completed_at: "2026-08"
status: "completed"
is_featured: true
order: 6
meta_title: "Horloge Mada - Horloge intelligente call center"
meta_description: "Horloge du call center avec heure officielle de Madagascar, progression de journée, pause, paie et chat en direct."
---
## Présentation

**Horloge Mada** est une horloge intelligente pensée pour les agents du call center, affichant l'**heure officielle de Madagascar** (Indian/Antananarivo) en temps réel. Elle rythme la journée de travail et rassemble les informations essentielles en un coup d'œil.

## Fonctionnalités

- 🕒 Heure officielle de Madagascar en temps réel, **5 langues** (FR/MG/EN/HI/ZH)
- 📈 **Progression de la journée** de travail (07:00 → 19:00) avec barre animée
- 🍽️ **Pause déjeuner** à 12:00 (1h) avec compte à rebours vers chaque étape
- 💰 **Compte à rebours de la paie** (le 15 du mois)
- 🌅 **Ciel dynamique** : aube, jour, crépuscule, nuit — soleil et lune réalistes en 3D
- 🐱 **Chat mascotte 3D** qui se promène aléatoirement sur toute la page avec messages de motivation
- 💬 **Chat en direct** multi-utilisateurs avec emojis, stickers et GIFs animés (Google Noto, sans clé API)
- 🔔 **Alarmes sonores** (début, pause, reprise, fin de journée)
- ✨ **Effets 3D** : tilt des cartes au survol, reflets, écran de chargement animé

## Stack Technique

| Technologie | Utilisation |
|-------------|-------------|
| Laravel 12 | Framework backend |
| PHP 8.4 | Langage serveur |
| Livewire 4 | Composants SFC côté serveur |
| Alpine.js | Interactivité côté client |
| Tailwind CSS 4 | Styles |
| FrankenPHP | Serveur PHP + Caddy |
| Docker | Conteneurisation |
| Vite 8 | Bundler frontend |

## Statut

Déployé sur **Render** (Docker), prêt pour **Fly.io** (région Johannesburg) via un fichier `fly.toml` fourni.
