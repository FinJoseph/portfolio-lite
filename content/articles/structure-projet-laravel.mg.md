---
title: "Rafitry ny tetikasa Laravel"
slug: "structure-projet-laravel"
excerpt: "Alaharo ny fandrindrana ny lahatahiry sy rakitra ao amin'ny tetikasa Laravel mba ho mora fitetezana."
cover_image: null
category: "backend"
tags: ["Laravel", "PHP", "Arsitektira", "Rafitra"]
status: "published"
published_at: "2026-07-05"
reading_time: 7
order: 5
meta_title: "Rafitry ny tetikasa Laravel - Tari-dalana feno"
meta_description: "Alaharo ny arsitektiran'ny tetikasa Laravel: app, config, database, resources, routes sy maro hafa."
---
## Arsitektira MVC

Laravel dia manaraka ny arsitektira **Model-View-Controller (MVC)**:

- **Modely**: Mitantana ny data sy ny logika
- **Vue**: Mampiseho ny data amin'ny mpampiasa
- **Controller**: Mandray ny fangatahana ary mampifandray ny Modely sy Vue

## Rafitra lahatahiry lehibe

```
ny-tetikasa/
├── app/
│   ├── Http/
│   │   ├── Controllers/    # Controllers
│   │   └── Middleware/     # Sivan'ny fangatahana
│   ├── Models/             # Modely Eloquent
│   └── Providers/          # Providers
│
├── config/                 # Configuration (app, database, mail...)
├── database/
│   ├── migrations/         # Rafitra database
│   └── seeders/            # Data andrana
│
├── resources/
│   ├── views/              # Templates Blade
│   └── lang/               # Fichier fandikan-teny
│
├── routes/
│   ├── web.php             # Routes web
│   ├── api.php             # Routes API
│   └── console.php         # Baiko Artisan
│
├── public/                 # Fidirana (index.php)
├── storage/                # Logs, cache, rakitra voafafa
├── tests/                  # Tests automatisés
└── .env                    # Configuration tontolo
