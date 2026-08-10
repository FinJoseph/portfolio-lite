---
title: "Horloge Mada"
slug: "horloge-mada"
excerpt: "Smart call-center clock with official Madagascar time, day progress, lunch break, payday countdown, live chat and a 3D cat mascot."
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
meta_title: "Horloge Mada - Smart call-center clock"
meta_description: "Call-center clock with official Madagascar time, day progress, lunch, payday countdown and live chat."
---
## Overview

**Horloge Mada** is a smart clock designed for call-center agents, displaying the **official Madagascar time** (Indian/Antananarivo) in real time. It paces the workday and gathers essential information at a glance.

## Features

- 🕒 Real-time official Madagascar time, **5 languages** (FR/MG/EN/HI/ZH)
- 📈 **Workday progress** (07:00 → 19:00) with animated bar
- 🍽️ **Lunch break** at 12:00 (1h) with countdown to every milestone
- 💰 **Payday countdown** (on the 15th of each month)
- 🌅 **Dynamic sky** : dawn, day, dusk, night — realistic 3D sun and moon
- 🐱 **3D cat mascot** roaming randomly across the page with motivational messages
- 💬 **Live chat** with emojis, stickers and animated GIFs (Google Noto, no API key)
- 🔔 **Sound alarms** (start, break, resume, end of day)
- ✨ **3D effects** : card tilt on hover, glows, animated loading screen

## Tech Stack

| Technology | Usage |
|-------------|-------------|
| Laravel 12 | Backend framework |
| PHP 8.4 | Server language |
| Livewire 4 | Server-side SFC components |
| Alpine.js | Client-side interactivity |
| Tailwind CSS 4 | Styles |
| FrankenPHP | PHP + Caddy server |
| Docker | Containerization |
| Vite 8 | Frontend bundler |

## Status

Deployed on **Render** (Docker), ready for **Fly.io** (Johannesburg region) via a provided `fly.toml`.
