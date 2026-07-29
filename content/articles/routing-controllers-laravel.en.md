---
title: "Routing and Controllers in Laravel"
slug: "routing-controllers-laravel"
excerpt: "Learn how to define routes and create controllers in Laravel to handle HTTP requests."
cover_image: null
category: "backend"
tags: ["Laravel", "PHP", "Routing", "Controllers"]
status: "published"
published_at: "2026-07-06"
reading_time: 7
order: 6
meta_title: "Laravel Routing - Routes and Controllers"
meta_description: "Complete guide on routing and controllers in Laravel: defining routes, creating controllers and passing parameters."
---
## Routes in Laravel

Routes are defined in the `routes/` directory:

- **web.php**: Routes for web pages (with session, CSRF)
- **api.php**: Routes for APIs (stateless)
- **console.php**: Artisan commands

### Basic Syntax

```php
// routes/web.php
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/about', function () {
    return 'About Page';
});
```

### HTTP Route Types

```php
Route::get('/articles', [ArticleController::class, 'index']);
Route::post('/articles', [ArticleController::class, 'store']);
Route::put('/articles/{id}', [ArticleController::class, 'update']);
Route::delete('/articles/{id}', [ArticleController::class, 'destroy']);
```

## Creating a Controller

Use Artisan to generate a controller:

```bash
php artisan make:controller ArticleController

# With resources
php artisan make:controller ArticleController --resource
```

### Basic Controller

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

## Routes with Parameters

```php
Route::get('/articles/{id}', [ArticleController::class, 'show']);
Route::get('/category/{category}/article/{id}', [ArticleController::class, 'find']);
```

## Named Routes

```php
Route::get('/articles', [ArticleController::class, 'index'])->name('articles.index');
// Usage: route('articles.index')
```

## Route::resource

One line for all CRUD routes:

```php
Route::resource('articles', ArticleController::class);
```

Automatically generates:
| Verb | URL | Method | Name |
|-------|-----|---------|-----|
| GET | /articles | index | articles.index |
| GET | /articles/create | create | articles.create |
| POST | /articles | store | articles.store |
| GET | /articles/{id} | show | articles.show |
| GET | /articles/{id}/edit | edit | articles.edit |
| PUT | /articles/{id} | update | articles.update |
| DELETE | /articles/{id} | destroy | articles.destroy |

## Conclusion

Routing in Laravel is flexible and expressive. With `Route::resource`, you can set up a complete CRUD in just one line of code.
