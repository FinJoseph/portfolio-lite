---
title: "Fametrahana Laravel"
slug: "installation-laravel"
excerpt: "Tari-dalana isaky ny dingana hametrahana Laravel miaraka amin'ny Composer, Laravel Installer ary Laravel Sail."
cover_image: null
category: "backend"
tags: ["Laravel", "PHP", "Fametrahana", "Composer"]
status: "published"
published_at: "2026-07-04"
reading_time: 6
order: 4
meta_title: "Fametrahana Laravel - Tari-dalana feno"
meta_description: "Ianaro ny fametrahana Laravel isaky ny dingana miaraka amin'ny Composer, Laravel Installer ary Docker Sail."
---
## Mamorona tetikasa Laravel vaovao

Misy fomba maro hametrahana Laravel:

### Fomba 1: Composer (soso-kevitra)
```bash
composer create-project laravel/laravel ny-tetikasa
cd ny-tetikasa
php artisan serve
```
Ny app-nao dia ho hita ao amin'ny `http://localhost:8000`.

### Fomba 2: Laravel Installer
```bash
composer global require laravel/installer
laravel new ny-tetikasa
cd ny-tetikasa
php artisan serve
```

### Fomba 3: Laravel Sail (Docker)
```bash
curl -s https://laravel.build/ny-tetikasa | bash
cd ny-tetikasa
./vendor/bin/sail up
```

## Rafitra aorian'ny fametrahana

```
ny-tetikasa/
├── app/           # Code fototra (Modely, Controllers)
├── bootstrap/     # Configuration framework
├── config/        # Fichier configuration
├── database/      # Migration sy seeder
├── public/        # Fidirana web
├── resources/     # Vues, assets, fiteny
├── routes/        # Famaritana routes
├── storage/       # Logs, cache, uploads
├── tests/         # Tests automatisés
├── vendor/        # Dépendance Composer
└── .env           # Configuration tontolo
```

## Configuration tontolo

Ny fichier `.env` dia misy ny configuration:
```env
APP_NAME=NyTetkasa
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=ny_tetikasa
DB_USERNAME=root
DB_PASSWORD=
```

## Alefaso ny mpizara fampandrosoana

```bash
php artisan serve
```

Amin'ny alàlan'ny default, Laravel mampiasa port 8000. Hanova port:
```bash
php artisan serve --port=8080
```

## Hamarino ny fametrahana

Sokafy ny navigateur-nao amin'ny `http://localhost:8000`. Tokony hahita ny pejy fandraisana Laravel ianao. Arahabaina, Laravel dia voapetraka!
