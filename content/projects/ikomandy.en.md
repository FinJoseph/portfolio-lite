---
title: "iKomandy B2B"
slug: "ikomandy"
excerpt: "B2B e-commerce platform connecting wholesalers and buyers. Filament administration, Vue.js frontend, multi-role RBAC with per-tenant data isolation."
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
meta_title: "iKomandy B2B - Wholesale e-commerce platform"
meta_description: "Complete B2B wholesale e-commerce platform with Filament administration and Vue.js SPA."
---
## Overview

**iKomandy B2B** is a comprehensive **Business-to-Business** e-commerce platform connecting wholesalers and buyers. It features advanced logistics administration via Filament and a reactive Vue.js purchasing frontend.

## Multi-Role Architecture (RBAC)

Four distinct access levels with data isolation:

| Role | Access | Interface |
|------|--------|-----------|
| **Super Admin** | Global revenue view, audit, wholesaler certification | Filament |
| **Wholesaler** | Isolated data (Eloquent scopes), stats, employees, orders | Filament |
| **Delivery** | Logistics management of shipments | Filament |
| **B2B Client** | Shopping cart, purchase history, wholesaler ratings | Vue.js SPA |

## Features

- **Advanced RBAC** with Spatie Permission + Filament Shield
- **Data isolation** by wholesaler (Eloquent scopes)
- **Product catalog** with per-wholesaler management
- **Shopping cart** and order tracking
- **Rating system** for wholesalers (1-5 stars)
- **Rate limiting** on API calls
- **Account suspension** with immediate block (HTTP 403)
- **Access policies** (Laravel Policies) preventing order falsification

## Tech Stack

| Technology | Usage |
|-------------|-------------|
| Laravel 11 | Backend framework |
| PHP 8.2 | Server language |
| Filament 3 | Admin panel |
| Vue.js 3 (Composition API) | SPA frontend |
| Inertia.js | Laravel ↔ Vue.js bridge |
| Tailwind CSS 3 | Styles |
| MySQL / PostgreSQL | Database |
| Spatie Permission | Role management |
| Filament Shield | Permission UI |
