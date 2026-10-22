---
title: "iKAALY"
slug: "ikaaly"
excerpt: "Marketplace fanontana amin'ny toerana Manakara : trano fandraisan'ny sakafo, mpanjifa ary fitantanana amin'ny ekosistema iray. PWA azo apetraka, fandoavana mobile money ary fanaraha-maso ny baiko."
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
meta_title: "iKAALY - Marketplace fanontana amin'ny Manakara"
meta_description: "Ny iKAALY dia mampifandray trano fandraisan'ny sakafo, mpanjifa ary fitantanana: baiko eo an-toerana, fandoavana mobile money, fanaraha-maso ary PWA trifiteny."
---
## Fampidirana

Ny **iKAALY** dia sehatra fanontana an-tapitrisany amin'ny toerana **Manakara** izay manambatra fampiasana telo amin'ny ekosistema iray: ny pejy hita eto an-tany, ny toeran'ny trano fandraisan'ny sakafo ary ny bokin'ny fitantanana.

> « Safidio, kaomandio, iKAALY » · « Choisis, commande, c'est iKAALY »

Ny fomba fametrahana dia **mobile-first** : kaody fohy, dia lavitra sy mazava, ho an'ny mpikaroka matetika manana ora vitsy sy fifaovana tsy maharitra.

## Endri-javatra

- 🍽️ **Katalaogy mivantana** : fikarohana trano fandraisan'ny sakafo, antontan-taratasy sy menu isaky trano
- 🛒 **Sarety iray ihany** isaky trano, voatahiry mandrakizay (Zustand + middleware)
- 🧾 **Baiko tsy mitady kaonty** ny mpanjifa, azo alaina na alefa any an-tapitrisany
- 💳 **Fandoavana mobile money** (MVola, Orange Money, Airtel Money) misy porofo fandoavana
- 📍 **Fanaraha-maso ny baiko** amin'ny kaony manokana, tsy mila fidirana
- 🏪 **Toeran'ny trano** : fitantanana baiko amin'ny fotoana tena izy, menu ary ny misy
- 🛡️ **Toeran'ny fitantanana** : fametrahamana trano, fitantanana faritra, antontan-taratasy sy ady
- 🌍 **Tri fiteny** FR / MG / EN (next-intl) misy lalana mifototra amin'ny fiteny
- 📲 **PWA azo apetraka** (Serwist) : notifications push ary fitaovana mitovy ny naty

## Stack Teknika

| Teknolojia | Fampiasana |
|-------------|-------------|
| Next.js 16 (App Router) | Framework full-stack, RSC, Server Actions |
| React 19 | Composants UI, Suspense, Server Components |
| TypeScript | Typage strict manontolo |
| Tailwind CSS 4 | Design system utility-first |
| Supabase | Postgres, Auth, Storage, Realtime, RLS |
| PostgreSQL | Base de données relacionaly fitantanin'ny Supabase |
| Zustand | État global sy sarety voatahiry |
| Leaflet / React-Leaflet | Sary an-tany amin'ny trano sy faritra |
| Zod | Fanamarinana sy lojikan'ny toe-danja |
| Serwist | Service worker sy fampidirana PWA |
| Vercel | Fanolorana sy previews isaky branch |

## Rafitra

- **Fetitra fiantokiana iray ihany** : ny Server Actions rehetra ao amin'ny Next.js dia manamarina session → andraikitra → schéma Zod.
- **Row Level Security** ao amin'ny Supabase : ny fanontaniana tsirairay dia voasivana ao amin'ny base, tsy ao amin'ny interface fotsiny.
- Ny i18n dia tantana amin'ny middleware miaraka amin'ny rakitra hafatra voa-maritra.

## Sata

**Navoaka ao amin'ny Vercel** — [ikaaly.vercel.app](https://ikaaly.vercel.app) — sehatra feno sy miasa.
