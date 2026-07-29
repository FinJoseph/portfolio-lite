---
title: "Installing Laravel"
slug: "installation-laravel"
excerpt: "Step-by-step guide to installing Laravel with Composer, Laravel Installer and Laravel Sail."
cover_image: null
category: "backend"
tags: ["Laravel", "PHP", "Installation", "Composer"]
status: "published"
published_at: "2026-07-04"
reading_time: 6
order: 4
meta_title: "Laravel Installation - Complete Guide"
meta_description: "Learn how to install Laravel step by step with Composer, Laravel Installer and Docker Sail."
---
## Creating a New Laravel Project

There are several methods to install Laravel:

### Method 1: Composer (Recommended)
```bash
composer create-project laravel/laravel my-project
cd my-project
php artisan serve
```
Your application will be accessible at `http://localhost:8000`.

### Method 2: Laravel Installer
```bash
composer global require laravel/installer
laravel new my-project
cd my-project
php artisan serve
```

### Method 3: Laravel Sail (Docker)
```bash
curl -s https://laravel.build/my-project | bash
cd my-project
./vendor/bin/sail up
```

## Structure After Installation

```
my-project/
├── app/           # Core code (Models, Controllers)
├── bootstrap/     # Framework configuration
├── config/        # Configuration files
├── database/      # Migrations and seeders
├── public/        # Web entry point
├── resources/     # Views, assets, languages
├── routes/        # Route definitions
├── storage/       # Logs, cache, uploads
├── tests/         # Automated tests
├── vendor/        # Composer dependencies
└── .env           # Environment configuration
```

## Environment Configuration

The `.env` file contains the configuration:
```env
APP_NAME=MyProject
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=my_project
DB_USERNAME=root
DB_PASSWORD=
```

## Start the Development Server

```bash
php artisan serve
```

By default, Laravel uses port 8000. To change the port:
```bash
php artisan serve --port=8080
```

## Verify Installation

Open your browser at `http://localhost:8000`. You should see the default Laravel welcome page. Congratulations, Laravel is installed!
