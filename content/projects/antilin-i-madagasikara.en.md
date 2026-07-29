---
title: "Antilin'i Madagasikara"
slug: "antilin-i-madagasikara"
excerpt: "Member management application for the Antilin'i Madagasikara scout association (Scouts of Madagascar). Web and mobile responsive platform with Filament admin and Vue.js public site."
cover_image: "/images/projects/antilin-i-madagasikara/cover.jpg"
gallery:
  - "/images/projects/antilin-i-madagasikara/screenshot-1.jpg"
  - "/images/projects/antilin-i-madagasikara/screenshot-2.jpg"
  - "/images/projects/antilin-i-madagasikara/screenshot-3.jpg"
category: "web"
technologies: ["Laravel", "Filament", "Vue.js", "Tailwind CSS", "MySQL", "Chart.js", "Laravel Octane", "Laravel Reverb"]
site_url: null
github_url: "https://github.com/FinJoseph/aim-app-v2"
completed_at: "2025-06"
status: "in_progress"
is_featured: true
order: 1
meta_title: "Antilin'i Madagasikara - Scout Management Application"
meta_description: "Complete member management application for Scouts of Madagascar. Filament admin panel, Vue.js SPA, hierarchical RBAC, blog, payments and events."
---
## Overview

**Antilin'i Madagasikara** is a comprehensive member management web application for the **Antilin'i Madagasikara (Scouts of Madagascar)** association. It combines a powerful Filament admin panel with a modern Vue.js SPA public website.

## Features

### Administration (Filament)
- **Hierarchical management**: Diocese → District → Group → Branch → Unit → Member
- **Advanced RBAC**: 5 hierarchical roles (super_admin, admin_national, admin_diocese, chef_district, chef_groupe) with filtered visibility
- **Editorial blog**: publication workflow (draft → submitted → published/rejected)
- **Member management**: full profiles with health, badges, training, camps, positions
- **Subscriptions & Payments**: one-time or periodic, chef/member rates
- **Event management**: creation and registration
- **Excel exports**: via Maatwebsite
- **Dashboards**: 6 widgets with Chart.js
- **25 resources** across 3 navigation clusters

### Public Site (Vue.js SPA)
- Pages: Home, About, History, Contact, Join Us, News/Blog
- Interactive map of scout groups
- Online membership application with diocese → district → group selection
- Dark/light mode
- Custom scout-themed design

### Technical
- **Dual architecture**: Filament Admin (`/admin`) + Vue SPA (client-side routes)
- **Real-time WebSocket** via Laravel Reverb
- **High performance** with Laravel Octane (Swoole)
- **Responsive**: mobile, tablet and desktop
- **Database**: SQLite (dev), MySQL (production) — 26 models, 35 migrations

## Tech Stack

| Technology | Usage |
|-------------|-------------|
| Laravel 12 | Backend framework |
| PHP 8.4 | Server language |
| Filament 5 | Admin panel |
| Vue.js 3 (Composition API) | SPA frontend |
| Tailwind CSS 4 | Utility-first CSS |
| Pinia | State management |
| Vue Router | Client routing |
| Chart.js | Dashboard charts |
| MySQL | Production database |
| Laravel Octane | High-performance server (Swoole) |
| Laravel Reverb | Real-time WebSocket |
| Spatie MediaLibrary | Media management |
| Maatwebsite Excel | Excel exports |
| Vite 7 | Frontend bundler |

## Status

Project in finalization phase (~90%), already deployed in test environment.
