---
title: "Installation de Laravel"
slug: "installation-laravel"
excerpt: "Guide pas à pas pour installer Laravel avec Composer, Laravel Installer et Laravel Sail."
cover_image: null
category: "backend"
tags: ["Laravel", "PHP", "Installation", "Composer"]
status: "published"
published_at: "2026-07-04"
reading_time: 6
order: 4
meta_title: "Installation Laravel - Guide complet"
meta_description: "Apprenez à installer Laravel étape par étape avec Composer, Laravel Installer et Docker Sail."
---
## Créer un nouveau projet Laravel

Il existe plusieurs méthodes pour installer Laravel :

### Méthode 1 : Composer (recommandée)
```bash
composer create-project laravel/laravel mon-projet
cd mon-projet
php artisan serve
```
Votre application sera accessible sur `http://localhost:8000`.

### Méthode 2 : Laravel Installer
```bash
composer global require laravel/installer
laravel new mon-projet
cd mon-projet
php artisan serve
```

### Méthode 3 : Laravel Sail (Docker)
```bash
curl -s https://laravel.build/mon-projet | bash
cd mon-projet
./vendor/bin/sail up
```

## Structure après installation

```
mon-projet/
├── app/           # Code principal (Modèles, Contrôleurs)
├── bootstrap/     # Configuration du framework
├── config/        # Fichiers de configuration
├── database/      # Migrations et seeders
├── public/        # Point d'entrée web
├── resources/     # Vues, assets, langues
├── routes/        # Définition des routes
├── storage/       # Logs, cache, uploads
├── tests/         # Tests automatisés
├── vendor/        # Dépendances Composer
└── .env           # Configuration de l'environnement
```

## Configuration de l'environnement

Le fichier `.env` contient la configuration :
```env
APP_NAME=MonProjet
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=mon_projet
DB_USERNAME=root
DB_PASSWORD=
```

## Lancer le serveur de développement

```bash
php artisan serve
```

Par défaut, Laravel utilise le port 8000. Pour changer de port :
```bash
php artisan serve --port=8080
```

## Vérifier l'installation

Ouvrez votre navigateur sur `http://localhost:8000`. Vous devriez voir la page d'accueil par défaut de Laravel. Félicitations, Laravel est installé !
