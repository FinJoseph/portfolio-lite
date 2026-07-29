---
title: "Structure d'un projet Laravel"
slug: "structure-projet-laravel"
excerpt: "Comprendre l'organisation des dossiers et fichiers d'un projet Laravel pour mieux s'y retrouver."
cover_image: null
category: "backend"
tags: ["Laravel", "PHP", "Architecture", "Structure"]
status: "published"
published_at: "2026-07-05"
reading_time: 7
order: 5
meta_title: "Structure projet Laravel - Guide complet"
meta_description: "Comprenez l'architecture d'un projet Laravel : app, config, database, resources, routes et plus."
---
## Architecture MVC

Laravel suit l'architecture **Modèle-Vue-Contrôleur (MVC)** :

- **Modèle** : Gère les données et la logique métier
- **Vue** : Affiche les données à l'utilisateur
- **Contrôleur** : Traite les requêtes et fait le lien entre Modèle et Vue

## Arborescence principale

```
mon-projet/
├── app/
│   ├── Http/
│   │   ├── Controllers/    # Contrôleurs
│   │   └── Middleware/      # Filtres de requêtes
│   ├── Models/              # Modèles Eloquent
│   └── Providers/           # Providers de services
│
├── config/                  # Configuration (app, database, mail...)
├── database/
│   ├── migrations/          # Structure de la base de données
│   └── seeders/             # Données de test
│
├── resources/
│   ├── views/               # Templates Blade
│   └── lang/                # Fichiers de traduction
│
├── routes/
│   ├── web.php              # Routes web
│   ├── api.php              # Routes API
│   └── console.php          # Commandes Artisan
│
├── public/                  # Point d'entrée (index.php)
├── storage/                 # Logs, cache, fichiers uploadés
├── tests/                   # Tests automatisés
└── .env                     # Configuration environnement
```

## Dossier app/ en détail

Le dossier `app/` contient le cœur de votre application :

- **Http/Controllers** : Vos contrôleurs qui traitent les requêtes
- **Http/Middleware** : Filtres pour les requêtes HTTP (auth, CORS, etc.)
- **Models** : Vos modèles Eloquent
- **Providers** : Enregistrement des services
- **Http/Requests** : Validation des formulaires
- **Exceptions** : Gestion des erreurs personnalisées

## Dossier routes/

- **web.php** : Routes avec session, CSRF (pour les pages web)
- **api.php** : Routes API (sans état, authentification par token)
- **console.php** : Commandes Artisan personnalisées

## Dossier resources/

- **views/** : Templates Blade (`.blade.php`)
- **lang/** : Fichiers de traduction (fr/, en/, mg/)
- **css/** : Fichiers CSS
- **js/** : Fichiers JavaScript

## Le fichier .env

Contient les variables d'environnement : base de données, mail, debug, etc. **Ne jamais partager ce fichier** (il est dans `.gitignore`).

## Conclusion

Comprendre la structure de Laravel est essentiel pour naviguer efficacement dans votre projet. Chaque dossier a un rôle précis et bien défini.
