---
title: "Models and Eloquent ORM"
slug: "modeles-eloquent-laravel"
excerpt: "Discover Eloquent, Laravel's ORM, to interact with your database in an elegant way."
cover_image: null
category: "backend"
tags: ["Laravel", "Eloquent", "ORM", "Database"]
status: "published"
published_at: "2026-07-08"
reading_time: 8
order: 8
meta_title: "Eloquent ORM Laravel - Models and Queries"
meta_description: "Complete guide on Eloquent ORM: creating models, relationships, queries and best practices."
---
## What is Eloquent?

**Eloquent** is Laravel's ORM (Object-Relational Mapping). It allows you to interact with your database using PHP objects instead of SQL queries.

## Creating a Model

```bash
php artisan make:model Article
php artisan make:model Article -m   # With migration
php artisan make:model Article -mc  # With migration and controller
```

### Basic Model

```php
<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $fillable = ['title', 'content', 'category_id'];
    protected $casts = [
        'published_at' => 'datetime',
    ];
}
```

## Basic Queries

### Create
```php
Article::create([
    'title' => 'My article',
    'content' => 'Content...',
]);
```

### Read
```php
$articles = Article::all();                    // All
$article = Article::find(1);                   // By ID
$articles = Article::where('published', true)
    ->orderBy('created_at', 'desc')
    ->get();
```

### Update
```php
$article = Article::find(1);
$article->title = 'New title';
$article->save();
```

### Delete
```php
$article = Article::find(1);
$article->delete();

Article::destroy(1);
```

## Relationships

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

### Many To Many
```php
class Article extends Model {
    public function tags() {
        return $this->belongsToMany(Tag::class);
    }
}
```

## Scopes

```php
class Article extends Model {
    public function scopePublished($query) {
        return $query->where('published', true);
    }

    public function scopeRecent($query) {
        return $query->orderBy('created_at', 'desc');
    }
}

// Usage
$articles = Article::published()->recent()->get();
```
