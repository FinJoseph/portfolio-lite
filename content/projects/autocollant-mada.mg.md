---
title: "Autocollant Mada"
slug: "autocollant-mada"
excerpt: "Sehatra e-commerce amin'ny fan personalization ny boaty PC eto Madagasikara : katalaogy design premium vinyle, configurateur an'araka ny fotoana, fandoavana Mobile Money, chatbot trifiteny ary bokin'ny fitantanana feno."
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
meta_title: "Autocollant Mada - E-commerce ho an'ny boaty PC voa customizing"
meta_description: "Autocollant Mada: katalaogy design PC premium, configurateur an'araka ny fotoana, fandoavana Mobile Money, chatbot trifiteny ary fitantanana feno."
---
## Fampidirana

Ny **Autocollant Mada** dia sehatra e-commerce amin'ny **fan personalization ny boaty PC** eto Madagasikara : design premium amin'ny vinyle, configurateur mifandray amin'ny mpampiasa, fitsapana baiko feno ary mpanampy resaka.

Ny tranon-kasa dia **tanteraka mivantana** : ny teny tsirairay, ny vidiny ary ny zone fandefasana dia azo ovaina avy amin'ny admin, miaraka amin'ny fanavaozana automatique tsy mila redeploy.

## Endri-javatra

### 🛍️ Tranon-kasa mivantana
- 🎨 **Katalaogy design** voasokajy araka ny sokajy, sary galeria sy antontan-taratasy
- 🛠️ **Configurateur** : sary, engraving, taratasy, loko ary toerana amin'ny fotoana tena izy
- 🛒 **Fitsapana baiko** : design → faritra → fandefasana (zone misy vidiny) → fandoavana → famintinana
- 💳 **Fandoavana Mobile Money** : MVola, Orange Money, Airtel Money, virement sy vola, misy porofo
- 💬 **Chatbot « Mady »** : mpanampy trifiteny (FR/EN/MG) misy FAQ miova-ditra sy boky hetsika
- ⭐ **Hevitry ny mpanjifa** misy naoty ary ekena avy amin'ny admin
- 📖 **Pejy Héritage** : vanian-tantara, isa lehibe ary fahaizana
- 🌍 **Trifiteny** (FR / EN / MG) sy maizina/mazava voatahiry

### 🔐 Fitantanana
- **Dashboard** : baiko, hafatra, vola
- **Baiko** : fanaraha-maso ny toe-java (vaovao → acompte voaloa → miaina → voatarika), lahatra, fanamarihana anatiny, suivi
- **Hafatra** : boaty fandraisana sy valiny ho an'ny mpanjifa
- **Design** : CRUD feno, sary sy galeria ao amin'ny Cloudinary
- **Formules & vidiny** : prix, fihenam-bidy (prix barré + daty fiafarana)
- **Zone fandefasana** sy **mijalatra fandoavana** azo amboarina
- **Votoaty** : ny teny tsirairay amin'ny tranon-kasa azo ovaina amin'ny fiteny 3
- **Fandrindrana** : anarana, logo, favicon, SEO, fifandraisana, tambajotra, loko, fomba fanokafana

### 🔔 Notifications maimaim-poana
Ny fanevarana rehetra (baiko vaovao, hafatra, design voaforona) dia mametraka notification **ntfy.sh** (push) sy hafatra WhatsApp amin'ny **CallMeBot**. Ny fandefasana dia tsy mihitsa fitandrezana (`after()` amin'ny Next.js) : ny faharesena amin'ny notification dia tsy mampahadisoana ny tranon-kasa.

## Stack Teknika

| Teknolojia | Fampiasana |
|-------------|-------------|
| Next.js 16 (App Router, Turbopack) | Framework full-stack |
| React 19 | Composants UI |
| TypeScript strict | Typage feno |
| Tailwind CSS 4 | Styles |
| Prisma 7 | ORM misy adaptateur roa (SQLite local / Turso amin'ny production) |
| Cloudinary | Fitoerana ny sary (designs, porofo fandoavana) |
| Zod | Fanamarinana ny fidirana |
| Vercel | Fanolorana + Vercel Analytics |

## Modely ny angona

`Setting`, `Design`, `CustomDesign`, `PortfolioItem`, `Sticker`, `PricingPlan`, `Testimonial`, `Order`, `Message`, `HeritageTimeline`, `HeritageStat`, `HeritageCraft`, `PageContent`, `DeliveryZone`, `PaymentMethod`, `ChatFaq`.

## Sata

**Navoaka ao amin'ny Vercel** — [autocollantmada.vercel.app](https://autocollantmada.vercel.app) — sehatra feno sy miasa tsara.
