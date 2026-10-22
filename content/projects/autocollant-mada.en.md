---
title: "Autocollant Mada"
slug: "autocollant-mada"
excerpt: "E-commerce platform for custom PC case stickers in Madagascar: premium vinyl design catalogue, live configurator, Mobile Money payments, multilingual chatbot and a full back-office."
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
meta_title: "Autocollant Mada - E-commerce for custom PC case stickers"
meta_description: "Autocollant Mada: premium PC design catalogue, real-time configurator, Mobile Money payments, trilingual chatbot and complete administration."
---
## Overview

**Autocollant Mada** is an e-commerce platform for **custom PC case stickers** in Madagascar: premium vinyl designs, an interactive configurator, a full ordering flow and a conversational assistant.

The site is **fully dynamic**: every text, price and delivery zone is editable from the admin panel, with automatic revalidation and no redeployment needed.

## Features

### 🛍️ Public site
- 🎨 **Design catalogue** sorted by category, image galleries and detail sheets
- 🛠️ **Configurator**: image, engraving, font, colour and real-time positioning
- 🛒 **Checkout flow**: design → finish → delivery (zoned pricing) → payment → recap
- 💳 **Mobile Money payments**: MVola, Orange Money, Airtel Money, bank transfer and cash, with proof-of-payment upload
- 💬 **"Mady" chatbot**: multilingual assistant (FR/EN/MG) with dynamic FAQ and direct action buttons
- ⭐ **Customer reviews** rated and approved from the admin
- 📖 **Heritage page**: timeline, key figures and craftsmanship
- 🌍 **Trilingual** (FR / EN / MG) with a persistent dark/light theme

### 🔐 Administration
- **Dashboard**: orders, messages, revenue
- **Orders**: status tracking (new → deposit paid → in progress → delivered), priorities, internal notes, tracking
- **Messages**: inbox and customer replies
- **Designs**: full CRUD, Cloudinary images and galleries
- **Plans & pricing**: prices, promotions (struck-through price + end date)
- **Delivery zones** and **payment methods** configuration
- **Contents**: every site text editable in the 3 languages
- **Settings**: name, logo, favicon, SEO, contacts, social links, colours, maintenance mode

### 🔔 Free notifications
Every key event (new order, message, custom design) triggers an **ntfy.sh** push notification and a **CallMeBot** WhatsApp message. Sends are non-blocking (Next.js `after()`): a notification outage never slows the site down.

## Tech Stack

| Technology | Usage |
|-------------|-------------|
| Next.js 16 (App Router, Turbopack) | Full-stack framework |
| React 19 | UI components |
| Strict TypeScript | Full typing |
| Tailwind CSS 4 | Styles |
| Prisma 7 | ORM with dual adapter (local SQLite / Turso in production) |
| Cloudinary | Image hosting (designs, payment proofs) |
| Zod | Input validation |
| Vercel | Hosting + Vercel Analytics |

## Data models

`Setting`, `Design`, `CustomDesign`, `PortfolioItem`, `Sticker`, `PricingPlan`, `Testimonial`, `Order`, `Message`, `HeritageTimeline`, `HeritageStat`, `HeritageCraft`, `PageContent`, `DeliveryZone`, `PaymentMethod`, `ChatFaq`.

## Status

**Deployed on Vercel** — [autocollantmada.vercel.app](https://autocollantmada.vercel.app) — complete, fully operational platform.
