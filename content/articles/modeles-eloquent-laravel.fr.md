---
title: "Modèles et Eloquent ORM"
slug: "modeles-eloquent-laravel"
excerpt: "Découvrez Eloquent, l'ORM de Laravel, pour interagir avec votre base de données de façon élégante."
cover_image: null
category: "backend"
tags: ["Laravel", "Eloquent", "ORM", "Base de données"]
status: "published"
published_at: "2026-07-08"
reading_time: 8
order: 8
meta_title: "Eloquent ORM Laravel - Modèles et requêtes"
meta_description: "Guide complet sur Eloquent ORM : création de modèles, relations, requêtes et bonnes pratiques."
---
## Qu'est-ce qu'Eloquent ?

**Eloquent** est l'ORM (Object-Relational Mapping) de Laravel. Il permet d'interagir avec votre base de données en utilisant des objets PHP plutôt que des requêtes SQL.

## Créer un modèle

```bash
php artisan make:model Article
php artisan make:model Article -m   # Avec migration
php artisan make:model Article -mc  # Avec migration et contrôleur
```

### Modèle de base

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

## Requêtes de base

### Création
```php
Article::create([
    'title' => 'Mon article',
    'content' => 'Contenu...',
]);
```

### Lecture
```php
$articles = Article::all();                    // Tous
$article = Article::find(1);                   // Par ID
$articles = Article::where('published', true)
    ->orderBy('created_at', 'desc')
    ->get();
```

### Mise à jour
```php
$article = Article::find(1);
$article->title = 'Nouveau titre';
$article->save();

// Ou
Article::where('id', 1)->update(['title' => 'Nouveau']);
```

### Suppression
```php
$article = Article::find(1);
$article->delete();

Article::destroy(1);
```

## Relations

### One To Many (Un à plusieurs)
```php
// Article (plusieurs) appartient à Categorie (un)
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

### Many To Many (Plusieurs à plusieurs)
```php
class Article extends Model {
    public function tags() {
        return $this->belongsToMany(Tag::class);
    }
}
```

## Scope (Filtres personnalisés)

```php
class Article extends Model {
    public function scopePublished($query) {
        return $query->where('published', true);
    }

    public function scopeRecent($query) {
        return $query->orderBy('created_at', 'desc');
    }
}

// Utilisation
$articles = Article::published()->recent()->get();
```

## Accesseurs et Mutateurs

```php
class Article extends Model {
    // Accesseur
    public function getExcerptAttribute($value) {
        return substr($this->content, 0, 100) . '...';
    }

    // Mutateur
    public function setTitleAttribute($value) {
        $this->attributes['title'] = ucfirst($value);
    }
}
```

## Conclusion

Eloquent rend les interactions avec la base de données intuitives et agréables. Ses relations, scopes et accesseurs permettent d'écrire du code propre et expressif.
