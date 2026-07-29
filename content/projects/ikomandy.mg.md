---
title: "iKomandy B2B"
slug: "ikomandy"
excerpt: "Tranokala e-commerce B2B mampifandray ny mpivarotra ambongadiny sy ny mpividy. Administrasiona Filament, frontend Vue.js, RBAC miaraka amin'ny fanavahana data isaky ny mpampiasa."
cover_image: "/images/projects/ikomandy/cover.jpg"
gallery:
  - "/images/projects/ikomandy/screenshot-1.jpg"
  - "/images/projects/ikomandy/screenshot-2.jpg"
category: "web"
technologies: ["Laravel", "Filament", "Vue.js", "Inertia.js", "Tailwind CSS", "MySQL", "Spatie Permission", "Filament Shield"]
site_url: null
github_url: null
completed_at: "2025-12"
status: "completed"
is_featured: true
order: 3
meta_title: "iKomandy B2B - Tranokala e-commerce ambongadiny"
meta_description: "Tranokala e-commerce B2B feno ho an'ny varotra ambongadiny miaraka amin'ny administrasiona Filament sy Vue.js SPA."
---
## Fampidirana

**iKomandy B2B** dia tranokala e-commerce **Business-to-Business** feno mampifandray ny mpivarotra ambongadiny sy ny mpividy. Manana administrasiona logistika mandroso amin'ny alalan'ny Filament sy frontend fividianana Vue.js.

## Arsitektira Multi-Role (RBAC)

Ambaratonga fidirana 4 samy hafa miaraka amin'ny fanavahana data:

| Andraikitra | Fidirana | Interface |
|------|--------|-----------|
| **Super Admin** | Fahitana ny vola miditra, audit, certification mpivarotra | Filament |
| **Mpivarotra ambongadiny** | Data voatokana (Eloquent scopes), statistika, mpiasa, baiko | Filament |
| **Mpandefa** | Fitantanana logistika ny fandefasana | Filament |
| **Mpividy B2B** | Harona, tantaran'ny fividianana, naoty mpivarotra | Vue.js SPA |

## Endri-javatra

- **RBAC mandroso** miaraka amin'ny Spatie Permission + Filament Shield
- **Fanavahana data** isaky ny mpivarotra (Eloquent scopes)
- **Katalaogy vokatra** miaraka amin'ny fitantanana isaky ny mpivarotra
- **Harona** sy fanarahana baiko
- **Naoty mpivarotra** (1-5 kintana)
- **Rate limiting** amin'ny antso API
- **Fanafoanana kaonty** miaraka amin'ny fanakanana haingana (HTTP 403)
- **Politika fidirana** (Laravel Policies) misakana ny fanodikodinana baiko
