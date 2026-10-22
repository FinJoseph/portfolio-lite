---
title: "Autocollant Mada"
slug: "autocollant-mada"
excerpt: "Plateforme e-commerce de personnalisation de boîtiers PC à Madagascar : catalogue de designs premium en vinyle, configurateur de design, paiement Mobile Money, chatbot multilingue et back-office complet."
cover_image: "/images/projects/autocollant-mada/cover.jpg"
gallery:
  - "/images/projects/autocollant-mada/cover.jpg"
  - "/images/projects/autocollant-mada/01-designs.jpg"
  - "/images/projects/autocollant-mada/02-configurateur.jpg"
category: "web"
technologies: ["Next.js", "React", "TypeScript", "Tailwind CSS", "Prisma", "i18n"]
site_url: "https://autocollantmada.vercel.app"
github_url: "https://github.com/FinJoseph/roi"
completed_at: "2026-08"
status: "completed"
is_featured: true
order: 3
meta_title: "Autocollant Mada - E-commerce de personnalisation de boîtiers PC"
meta_description: "Autocollant Mada : catalogue de designs PC premium, configurateur en temps réel, paiement Mobile Money, chatbot trilingue et administration complète."
---
## Présentation

**Autocollant Mada** est une plateforme e-commerce de **personnalisation de boîtiers PC** à Madagascar : des designs premium en vinyle, un configurateur interactif, un tunnel de commande complet et un assistant conversationnel.

Le site est **entièrement dynamique** : chaque texte, chaque tarif et chaque zone de livraison se modifie depuis l'admin, avec revalidation automatique et sans redéploiement.

## Fonctionnalités

### 🛍️ Site public
- 🎨 **Catalogue de designs** classés par catégorie, galerie d'images et fiche détaillée
- 🛠️ **Configurateur** : image, gravure, police, couleur et positionnement en temps réel
- 🛒 **Tunnel de commande** : design → finition → livraison (zones tarifées) → paiement → récapitulatif
- 💳 **Paiement Mobile Money** : MVola, Orange Money, Airtel Money, virement et espèces, avec preuve de paiement
- 💬 **Chatbot « Mady »** : assistant multilingue (FR/EN/MG) avec FAQ dynamique et boutons d'action directs
- ⭐ **Avis clients** notés et approuvés depuis l'admin
- 📖 **Page Héritage** : timeline, chiffres clés et savoir-faire
- 🌍 **Trilingue** (FR / EN / MG) et thème sombre/clair persistant

### 🔐 Administration
- **Dashboard** : commandes, messages, revenus
- **Commandes** : suivi des statuts (nouvelle → acompte payé → en cours → livrée), priorités, notes internes, tracking
- **Messages** : boîte de réception et réponses aux clients
- **Designs** : CRUD complet, images et galeries Cloudinary
- **Formules & tarifs** : prix, promos (prix barré + date de fin)
- **Zones de livraison** et **moyens de paiement** configurables
- **Contenus** : chaque texte du site modifiable dans les 3 langues
- **Paramètres** : nom, logo, favicon, SEO, contacts, réseaux sociaux, couleurs, mode maintenance

### 🔔 Notifications gratuites
Chaque événement clé (nouvelle commande, message, design personnalisé) déclenche une notification **ntfy.sh** (push) et **CallMeBot** (WhatsApp). Les envois sont non bloquants (`after()` de Next.js) : une panne de notification ne ralentit jamais le site.

## Stack Technique

| Technologie | Utilisation |
|-------------|-------------|
| Next.js 16 (App Router, Turbopack) | Framework full-stack |
| React 19 | Composants UI |
| TypeScript strict | Typage complet |
| Tailwind CSS 4 | Styles |
| Prisma 7 | ORM avec adaptateur double (SQLite local / Turso en production) |
| Cloudinary | Hébergement des images (designs, preuves de paiement) |
| Zod | Validation des entrées |
| Vercel | Déploiement + Vercel Analytics |

## Modèles de données

`Setting`, `Design`, `CustomDesign`, `PortfolioItem`, `Sticker`, `PricingPlan`, `Testimonial`, `Order`, `Message`, `HeritageTimeline`, `HeritageStat`, `HeritageCraft`, `PageContent`, `DeliveryZone`, `PaymentMethod`, `ChatFaq`.

## Statut

**Déployé sur Vercel** — [autocollantmada.vercel.app](https://autocollantmada.vercel.app) — plateforme complète et opérationnelle.
