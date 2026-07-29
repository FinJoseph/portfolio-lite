---
title: "Fepetra sy tontolo fampandrosoana Laravel"
slug: "prerequis-environnement-laravel"
excerpt: "Ny zavatra rehetra tokony ho fantatra alohan'ny fametrahana Laravel: PHP, Composer, mpizara web ary fitaovana ilaina."
cover_image: null
category: "backend"
tags: ["Laravel", "PHP", "Fametrahana", "Tontolo"]
status: "published"
published_at: "2026-07-03"
reading_time: 5
order: 3
meta_title: "Fepetra Laravel - Tontolo fampandrosoana"
meta_description: "Tari-dalana feno momba ny fepetra ilaina amin'ny fametrahana Laravel: PHP, Composer, MySQL sy configuration."
---
## Fepetra Teknika

Alohan'ny fametrahana Laravel, ataovy azo antoka fa manana ireto manaraka ireto ianao:

### PHP
Laravel 13 dia mitaky **PHP 8.3 na ambony**. Jereo ny version-nao:
```bash
php -v
```

Extension PHP ilaina:
- `BCMath`, `Ctype`, `Fileinfo`, `JSON`, `Mbstring`
- `OpenSSL`, `PDO`, `Tokenizer`, `XML`, `cURL`

### Composer
**Composer** no mpitantana dépendance PHP. Ampidiro avy amin'ny [getcomposer.org](https://getcomposer.org).
```bash
composer --version
```

### Mpizara Web
Safidy 1: **PHP Built-in Server** (ho an'ny fampandrosoana)
```bash
php artisan serve
```

Safidy 2: **Laravel Herd** (tsara ho an'ny vao manomboka)
- Interface graphique, PHP sy MySQL efa voaomana
- Ampidiro ao amin'ny [herd.laravel.com](https://herd.laravel.com)

Safidy 3: **Laravel Sail** (Docker)
- Tontolo feno miaraka amin'ny Docker
- PHP, MySQL, Redis, Mailpit tafiditra

### Database
- **MySQL** 5.7+ na **MariaDB** 10.3+
- **PostgreSQL** (tsy voatery)
- **SQLite** (tsara ho an'ny fampandrosoana, tsy mila mpizara)

### Node.js sy NPM
Ilaina ho an'ny frontend (Vite, Mix):
```bash
node -v
npm -v
```

## Fametrahana Composer

Amin'ny Linux:
```bash
php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
php composer-setup.php
php -r "unlink('composer-setup.php');"
sudo mv composer.phar /usr/local/bin/composer
```

Amin'ny Windows: Ampidiro ny installer avy amin'ny [getcomposer.org](https://getcomposer.org).

## Fanamarinana farany

```bash
php -v
composer --version
node -v
npm -v
```

Raha tsara ny rehetra, vonona ny hametraka Laravel ianao!
