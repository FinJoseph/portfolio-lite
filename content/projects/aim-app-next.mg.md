---
title: "AIM App (Next.js)"
slug: "aim-app-next"
excerpt: "Ny dikan'ny Next.js amin'ny sehatra fitantanana ny association AIM — Antilin'I Madagascar (Skoto eto Madagasikara). Trifiteny mivantana, toeran'ny mpikambana, back-office araka ny ambaratonga ary RBAC ao amin'ny base."
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
meta_title: "AIM App (Next.js) - Fitantanana ny mpikambana amin'ny Skoto eto Madagasikara"
meta_description: "Ny dikan'ny Next.js amin'ny sehatra AIM : tranon-kasa mivantana trifiteny, toeran'ny mpikambana, back-office araka ny ambaratonga ary RBAC PostgreSQL amin'ny Drizzle ORM."
---
## Fampidirana

Ny **AIM App (Next.js)** dia ny **dikan'ny Next.js** amin'ny sehatra fitantanana ny association **AIM — Antilin'I Madagascar (Skoto eto Madagasikara)**. Mitaky ny fototra ara-pitsarana ny dikan'ny voalohany (Laravel/Filament) ary manao azy indray amin'ny rafitra vaovao : App Router, Server Components, Server Actions ary Drizzle ORM.

> Ity pejy ity dia milaza ny **dikan'ny Next.js**. Ny dikan'ny taloha **Laravel + Filament + Vue.js** dia misy amin'ny pejy manokana « Antilin'i Madagasikara ».

## Endri-javatra

### 🌍 Tranon-kasa mivantana (FR / EN / MG)
- Fizarana an-tapitrisany, **actualités** (sokajy, tag), **fiainam-pikambana**, **dingana**, **quiz skoto** ary pejy momba ny association
- Takelaka misokatra amin'ny modale, fifindran'ny **Contact ⇄ HRejoindre** misy mpanampy fandraisana anaraha 4 dingana
- **SEO** : canonical, `hreflang`, Open Graph, JSON-LD, sitemap multilingue, `robots.txt`
- Modo maizina, **PWA**, animasyon manaraka ny `prefers-reduced-motion`

### 🧑‍🤝‍🧑 Toeran'ny mpikambana
- Fifidirana amin'ny **nomerao mpikambana + kaody 6 isa**, miaraka amin'ny session tsy mitovy amin'ny admin
- Mombamomba (ny fanovana dia mila alalana), **kotizasy**, fanambarana fandoavana misy porofo, faktiora azo atontay, quiz

### 🗂️ Back-office
- **Mpikambana** : lisitry ny mpikambana mora ampiasaina amin'ny finday, fikarohana avo haingana, sivana, fand-import/export CSV/XLSX
- **Kotizasy sy fandoavana** : tokana na matetika, araka ny sehatra, ny vola amin'ny mpikambana sy ny lehibe
- **Dingana** : camps, fivoriana, fiofanana, fanatrehana, fametrahamana araka ny ambaratonga
- **Fikambanana** : pejy isaky ny ambaratonga (national → diocèse → district → groupe → unité), mpanampy multi-étape ary sary an-tany mihetsika
- **Hafatra mivantana** (SSE) : resaka, filazana, fanontaniana, fihetsika

### 🛡️ Superadmin
- votoatin'ny tranon-kasa, mpampiasa, **andraikitra sy alalana** azo ovaina, saha miafina ary fametrahamana avy amin'ny ray aman-dreny

## Stack Teknika

| Teknolojia | Fampiasana |
|-------------|-------------|
| Next.js 16 (App Router) | Framework full-stack, Server Components & Actions |
| React 19 | Composants UI, Server Components |
| TypeScript strict | Typage feno ny sehatra |
| Tailwind CSS 4 + shadcn/ui | Design system azo iditana |
| Drizzle ORM | Fifandraisana SQL voa-types amin'ny PostgreSQL (Neon) |
| PostgreSQL (Neon) | Base de données relacionaly fitantanina |
| Auth.js (NextAuth v5) | Session mpikambana sy admin misaraka |
| Recharts | Grafika amin'ny back-office |
| Zod | Fanamarinana ny Server Actions |
| ExcelJS | Import / export XLSX |
| Vercel | Fanolorana + Vercel Analytics |

## Rafitra

Rafitra misokatra amin'ny ambaratonga, misy **fetitra fiantokiana iray ihany** : ny Server Actions.

```text
Navigateur (PWA) → Présentation (RSC) → Server Actions (session → permission → Zod)
                                     → Domaine (périmètre appliqué) → RBAC → PostgreSQL
```

- **RBAC ao amin'ny base** : ny andraikitra araka ny ambaratonga (national → diocèse → district → groupe → unité) sy ny andraikitra ara-dasa dia azo ovaina, ary ny fanontaniana tsirairay dia voasivana amin'ny `scopeWhere` ao amin'ny sehatra.
- Ny **périmètre hiérarchique** dia ampiharina mandrakariva : ny mpitarika district dia tsy mijery ny district hafa.

## Sata

**Navoaka ao amin'ny Vercel** — [antilinimadagascar.vercel.app](https://antilinimadagascar.vercel.app) — MVP miasa, ny v1.0 dia mbola tanteraka.
