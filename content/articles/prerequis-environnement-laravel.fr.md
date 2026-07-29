---
title: "Prérequis et environnement de développement Laravel"
slug: "prerequis-environnement-laravel"
excerpt: "Tout ce qu'il faut savoir avant d'installer Laravel : PHP, Composer, serveur web et outils recommandés."
cover_image: null
category: "backend"
tags: ["Laravel", "PHP", "Installation", "Environnement"]
status: "published"
published_at: "2026-07-03"
reading_time: 5
order: 3
meta_title: "Prérequis Laravel - Environnement de développement"
meta_description: "Guide complet des prérequis pour installer Laravel : PHP, Composer, MySQL et configuration."
---
## Prérequis techniques

Avant d'installer Laravel, assurez-vous d'avoir les éléments suivants :

### PHP
Laravel 13 nécessite **PHP 8.3 ou supérieur**. Vérifiez votre version :
```bash
php -v
```

Extensions PHP requises :
- `BCMath`, `Ctype`, `Fileinfo`, `JSON`, `Mbstring`
- `OpenSSL`, `PDO`, `Tokenizer`, `XML`, `cURL`

### Composer
**Composer** est le gestionnaire de dépendances PHP. Installez-le depuis [getcomposer.org](https://getcomposer.org).
```bash
composer --version
```

### Serveur web
Option 1 : **PHP Built-in Server** (pour le développement)
```bash
php artisan serve
```

Option 2 : **Laravel Herd** (recommandé pour débutants)
- Interface graphique, PHP et MySQL pré-configurés
- Téléchargez sur [herd.laravel.com](https://herd.laravel.com)

Option 3 : **Laravel Sail** (Docker)
- Environnement complet avec Docker
- PHP, MySQL, Redis, Mailpit inclus

### Base de données
- **MySQL** 5.7+ ou **MariaDB** 10.3+
- **PostgreSQL** (optionnel)
- **SQLite** (parfait pour le développement, aucun serveur requis)

### Node.js et NPM
Nécessaires pour le frontend (Vite, Mix) :
```bash
node -v
npm -v
```

## Installation de Composer

Sur Linux :
```bash
php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
php composer-setup.php
php -r "unlink('composer-setup.php');"
sudo mv composer.phar /usr/local/bin/composer
```

Sur Windows : Téléchargez l'installateur depuis [getcomposer.org](https://getcomposer.org).

## Vérification finale

```bash
php -v
composer --version
node -v
npm -v
```

Si tout est OK, vous êtes prêt pour l'installation de Laravel !
