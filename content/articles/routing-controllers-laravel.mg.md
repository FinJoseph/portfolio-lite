---
title: "Routing sy Controllers ao amin'ny Laravel"
slug: "routing-controllers-laravel"
excerpt: "Ianaro ny famaritana routes sy ny famoronana controllers ao amin'ny Laravel hitantanana ny fangatahana HTTP."
cover_image: null
category: "backend"
tags: ["Laravel", "PHP", "Routing", "Controllers"]
status: "published"
published_at: "2026-07-06"
reading_time: 7
order: 6
meta_title: "Routing Laravel - Routes sy Controllers"
meta_description: "Tari-dalana feno momba ny routing sy controllers ao amin'ny Laravel: famaritana routes, famoronana controllers sy paramètres."
---
## Routes ao amin'ny Laravel

Ny routes dia voafaritra ao amin'ny lahatahiry `routes/`:

- **web.php**: Routes ho an'ny pejy web (miaraka amin'ny session, CSRF)
- **api.php**: Routes ho an'ny API (tsy misy fanjakana)
- **console.php**: Baiko Artisan

### Syntaxe fototra

```php
// routes/web.php
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/about', function () {
    return 'Pejy Momba';
});
```

### Karazana routes HTTP

```php
Route::get('/articles', [ArticleController::class, 'index']);
Route::post('/articles', [ArticleController::class, 'store']);
Route::put('/articles/{id}', [ArticleController::class, 'update']);
Route::delete('/articles/{id}', [ArticleController::class, 'destroy']);
```

## Mamorona Controller

Mampiasà Artisan hamoronana controller:

```bash
php artisan make:controller ArticleController

# Miaraka amin'ny ressource
php artisan make:controller ArticleController --resource
```

### Controller fototra

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

## Routes miaraka amin'ny paramètres

```php
Route::get('/articles/{id}', [ArticleController::class, 'show']);
Route::get('/sokajy/{sokajy}/article/{id}', [ArticleController::class, 'find']);
```

## Route::resource

Andalana iray ho an'ny routes CRUD rehetra:

```php
Route::resource('articles', ArticleController::class);
```

Mandefa ho azy:
| Hetsika | URL | Méthode | Anarana |
|-------|-----|---------|-----|
| GET | /articles | index | articles.index |
| GET | /articles/create | create | articles.create |
| POST | /articles | store | articles.store |
| GET | /articles/{id} | show | articles.show |
| GET | /articles/{id}/edit | edit | articles.edit |
| PUT | /articles/{id} | update | articles.update |
| DELETE | /articles/{id} | destroy | articles.destroy |
