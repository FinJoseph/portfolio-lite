---
title: "Routing et Controllers dans Laravel"
slug: "routing-controllers-laravel"
excerpt: "Apprenez à définir des routes et créer des contrôleurs dans Laravel pour gérer les requêtes HTTP."
cover_image: null
category: "backend"
tags: ["Laravel", "PHP", "Routing", "Controllers"]
status: "published"
published_at: "2026-07-06"
reading_time: 7
order: 6
meta_title: "Routing Laravel - Routes et Controllers"
meta_description: "Guide complet sur le routing et les contrôleurs dans Laravel : définir des routes, créer des contrôleurs et passer des paramètres."
---
## Les routes dans Laravel

Les routes sont définies dans le dossier `routes/` :

- **web.php** : Routes pour les pages web (avec session, CSRF)
- **api.php** : Routes pour les API (sans état)
- **console.php** : Commandes Artisan

### Syntaxe de base

```php
// routes/web.php
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/about', function () {
    return 'Page À propos';
});
```

### Types de routes HTTP

```php
Route::get('/articles', [ArticleController::class, 'index']);
Route::post('/articles', [ArticleController::class, 'store']);
Route::put('/articles/{id}', [ArticleController::class, 'update']);
Route::delete('/articles/{id}', [ArticleController::class, 'destroy']);
```

## Créer un contrôleur

Utilisez Artisan pour générer un contrôleur :

```bash
php artisan make:controller ArticleController

# Avec ressources
php artisan make:controller ArticleController --resource
```

### Contrôleur de base

```php
<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function index()
    {
        return view('articles.index');
    }

    public function show($id)
    {
        return view('articles.show', ['id' => $id]);
    }
}
```

## Routes avec paramètres

```php
Route::get('/articles/{id}', [ArticleController::class, 'show']);
Route::get('/categorie/{categorie}/article/{id}', [ArticleController::class, 'find']);
```

## Routes nommées

```php
Route::get('/articles', [ArticleController::class, 'index'])->name('articles.index');
// Utilisation : route('articles.index')
```

## Route::resource

Une seule ligne pour toutes les routes CRUD :

```php
Route::resource('articles', ArticleController::class);
```

Génère automatiquement :
| Verbe | URL | Méthode | Nom |
|-------|-----|---------|-----|
| GET | /articles | index | articles.index |
| GET | /articles/create | create | articles.create |
| POST | /articles | store | articles.store |
| GET | /articles/{id} | show | articles.show |
| GET | /articles/{id}/edit | edit | articles.edit |
| PUT | /articles/{id} | update | articles.update |
| DELETE | /articles/{id} | destroy | articles.destroy |

## Conclusion

Le routing dans Laravel est flexible et expressif. Avec `Route::resource`, vous pouvez mettre en place un CRUD complet en une seule ligne de code.
