---
title: "Laravel Prerequisites and Development Environment"
slug: "prerequis-environnement-laravel"
excerpt: "Everything you need to know before installing Laravel: PHP, Composer, web server and recommended tools."
cover_image: null
category: "backend"
tags: ["Laravel", "PHP", "Installation", "Environment"]
status: "published"
published_at: "2026-07-03"
reading_time: 5
order: 3
meta_title: "Laravel Prerequisites - Development Environment"
meta_description: "Complete guide to prerequisites for installing Laravel: PHP, Composer, MySQL and configuration."
---
## Technical Prerequisites

Before installing Laravel, make sure you have the following:

### PHP
Laravel 13 requires **PHP 8.3 or higher**. Check your version:
```bash
php -v
```

Required PHP extensions:
- `BCMath`, `Ctype`, `Fileinfo`, `JSON`, `Mbstring`
- `OpenSSL`, `PDO`, `Tokenizer`, `XML`, `cURL`

### Composer
**Composer** is the PHP dependency manager. Install it from [getcomposer.org](https://getcomposer.org).
```bash
composer --version
```

### Web Server
Option 1: **PHP Built-in Server** (for development)
```bash
php artisan serve
```

Option 2: **Laravel Herd** (recommended for beginners)
- GUI, pre-configured PHP and MySQL
- Download at [herd.laravel.com](https://herd.laravel.com)

Option 3: **Laravel Sail** (Docker)
- Complete environment with Docker
- Includes PHP, MySQL, Redis, Mailpit

### Database
- **MySQL** 5.7+ or **MariaDB** 10.3+
- **PostgreSQL** (optional)
- **SQLite** (perfect for development, no server required)

### Node.js and NPM
Required for frontend (Vite, Mix):
```bash
node -v
npm -v
```

## Installing Composer

On Linux:
```bash
php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
php composer-setup.php
php -r "unlink('composer-setup.php');"
sudo mv composer.phar /usr/local/bin/composer
```

On Windows: Download the installer from [getcomposer.org](https://getcomposer.org).

## Final Check

```bash
php -v
composer --version
node -v
npm -v
```

If everything is OK, you are ready for Laravel installation!
