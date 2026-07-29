---
title: "Modely sy Eloquent ORM"
slug: "modeles-eloquent-laravel"
excerpt: "Fantaro ny Eloquent, ORM Laravel, mba hifandraisana amin'ny database amin'ny fomba kanto."
cover_image: null
category: "backend"
tags: ["Laravel", "Eloquent", "ORM", "Database"]
status: "published"
published_at: "2026-07-08"
reading_time: 8
order: 8
meta_title: "Eloquent ORM Laravel - Modely sy queries"
meta_description: "Tari-dalana feno momba ny Eloquent ORM: famoronana modely, fifandraisana, queries sy fomba tsara."
---
## Inona ny Eloquent?

**Eloquent** dia ORM (Object-Relational Mapping) Laravel. Mamela anao hifandray amin'ny database amin'ny alalan'ny zavatra PHP fa tsy SQL queries.

## Mamorona Modely

```bash
php artisan make:model Article
php artisan make:model Article -m   # Miaraka amin'ny migration
php artisan make:model Article -mc  # Miaraka amin'ny migration sy controller
```

### Modely fototra

```php
<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $fillable = ['title', 'content', 'category_id'];
}
```

## Queries fototra

### Famoronana
```php
Article::create([
    'title' => 'Ny lahatsoratro',
    'content' => 'Votoatiny...',
]);
```

### Famakiana
```php
$articles = Article::all();
$article = Article::find(1);
$articles = Article::where('published', true)
    ->orderBy('created_at', 'desc')
    ->get();
```

### Fanavaozana
```php
$article = Article::find(1);
$article->title = 'Lohateny vaovao';
$article->save();
```

### Famafana
```php
$article = Article::find(1);
$article->delete();
```

## Fifandraisana

### One To Many
```php
class Article extends Model {
    public function category() {
        return $this->belongsTo(Category::class);
    }
}

class Category extends Model {
    public function articles() {
        return $this->hasMany(Article::class);
    }
}
```
