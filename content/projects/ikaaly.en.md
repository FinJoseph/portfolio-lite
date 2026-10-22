---
title: "iKAALY"
slug: "ikaaly"
excerpt: "Local food-ordering marketplace in Manakara: restaurants, customers and administration in one ecosystem. Installable PWA, mobile-money payments and live order tracking."
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
meta_title: "iKAALY - Local food-ordering marketplace in Manakara"
meta_description: "iKAALY connects restaurants, customers and administration: local ordering, mobile-money payments, order tracking and a trilingual PWA."
---
## Overview

**iKAALY** is a local food-ordering platform built for **Manakara** that brings three use cases into a single ecosystem: the public storefront, the restaurant workspace and the admin back-office.

> "Choose, order, it's iKAALY" · "Safidio, kaomandio, iKAALY"

The UX is **mobile-first**: short codes, a fast and frictionless journey, and strong readability for an audience that often has little time and an unstable connection.

## Features

- 🍽️ **Public catalog**: restaurant search, detailed listings and menus per venue
- 🛒 **Single-restaurant cart**, persisted across sessions (Zustand + persistence middleware)
- 🧾 **Guest checkout** — no mandatory customer account
- 💳 **Mobile-money payments** (MVola, Orange Money, Airtel Money) with proof-of-payment upload
- 📍 **Order tracking** via a public token, no authentication required
- 🏪 **Restaurant workspace**: real-time order handling, menu and availability management
- 🛡️ **Admin space**: restaurant approval, neighbourhood management, statistics and disputes
- 🌍 **Trilingual** FR / MG / EN (next-intl) with locale-based routing
- 📲 **Installable PWA** (Serwist): push notifications and a native-like experience

## Tech Stack

| Technology | Usage |
|-------------|-------------|
| Next.js 16 (App Router) | Full-stack framework, RSC, Server Actions |
| React 19 | UI components, Suspense, Server Components |
| TypeScript | Strict typing end to end |
| Tailwind CSS 4 | Utility-first design system |
| Supabase | Postgres, Auth, Storage, Realtime, RLS |
| PostgreSQL | Relational database managed by Supabase |
| Zustand | Global state and persistent cart |
| Leaflet / React-Leaflet | Restaurant and neighbourhood mapping |
| Zod | Validation and business rules |
| Serwist | Service worker and PWA installability |
| Vercel | Hosting and per-branch previews |

## Architecture

- A single **trust boundary**: every Next.js Server Action validates session → role → Zod schema.
- Supabase **Row Level Security** filters every query at the database level, not just in the UI.
- i18n handled by a locale-aware middleware with typed message dictionaries.

## Status

**Deployed on Vercel** — [ikaaly.vercel.app](https://ikaaly.vercel.app) — fully functional application.
