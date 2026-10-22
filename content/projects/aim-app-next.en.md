---
title: "AIM App (Next.js)"
slug: "aim-app-next"
excerpt: "Next.js version of the AIM — Antilin'I Madagascar (Scouts de Madagascar) management platform. Trilingual public site, member area, hierarchical back-office and database-level RBAC."
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
meta_title: "AIM App (Next.js) - Member management for the Scouts of Madagascar"
meta_description: "Next.js rewrite of the AIM platform: trilingual public site, member area, hierarchical back-office and PostgreSQL RBAC powered by Drizzle ORM."
---
## Overview

**AIM App (Next.js)** is the **Next.js version** of the management platform for **AIM — Antilin'I Madagascar (Scouts of Madagascar)**. It keeps the business foundations of the first Laravel/Filament release and rewrites them on a modern stack: App Router, Server Components, Server Actions and Drizzle ORM.

> This page covers the **Next.js rewrite**. The original **Laravel + Filament + Vue.js** version is documented separately under "Antilin'i Madagasikara".

## Features

### 🌍 Public site (FR / EN / MG)
- Home, **news** (categories, tags), **association life**, **events**, **scouts quiz** and about page
- Detail sheets opened in a modal, **Contact ⇄ Join** toggle with a 4-step membership assistant
- **SEO**: canonical, `hreflang`, Open Graph, JSON-LD, multilingual sitemap, `robots.txt`
- Dark mode, **PWA**, animations honouring `prefers-reduced-motion`

### 🧑‍🤝‍🧑 Member area
- Login with **member number + 6-digit code**, with a session distinct from the admin
- Profile (changes submitted for approval), **dues**, payment declaration with proof, printable invoice, quiz

### 🗂️ Back-office
- **Members**: mobile-first directory, instant search, filters, CSV/XLSX import & export
- **Dues & payments**: one-off or periodic, per scope, member/leader amounts
- **Events**: camps, meetings, training, attendance, hierarchical validation
- **Organisation**: one page per level (national → diocese → district → group → unit), multi-step assistant and interactive map
- **Real-time messaging** (SSE): conversations, announcements, polls, reactions

### 🛡️ Superadmin
- Site content, users, editable **roles and permissions**, sensitive fields and validation by the direct parent

## Tech Stack

| Technology | Usage |
|-------------|-------------|
| Next.js 16 (App Router) | Full-stack framework, Server Components & Actions |
| React 19 | UI components, Server Components |
| Strict TypeScript | Full domain typing |
| Tailwind CSS 4 + shadcn/ui | Accessible design system |
| Drizzle ORM | Typed SQL access to PostgreSQL (Neon) |
| PostgreSQL (Neon) | Managed relational database |
| Auth.js (NextAuth v5) | Separate member and admin sessions |
| Recharts | Back-office charts |
| Zod | Server Action validation |
| ExcelJS | XLSX import / export |
| Vercel | Hosting + Vercel Analytics |

## Architecture

Layered architecture with a one-way flow and a single **trust boundary**: the Server Actions.

```text
Browser (PWA) → Presentation (RSC) → Server Actions (session → permission → Zod)
                                     → Domain (scope applied) → RBAC → PostgreSQL
```

- **Database-level RBAC**: hierarchical roles (national → diocese → district → group → unit) and functional roles are editable, and every query is filtered by a domain-level `scopeWhere`.
- **Hierarchical scope** applied systematically: a district leader only sees their own district.

## Status

**Deployed on Vercel** — [antilinimadagascar.vercel.app](https://antilinimadagascar.vercel.app) — working MVP, v1.0 in progress.
