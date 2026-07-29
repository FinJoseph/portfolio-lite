---
title: "CRUD Partie 1 : Création et Lecture"
slug: "crud-partie-1-laravel"
excerpt: "Construisez une application CRUD complète avec Laravel : création et affichage des articles."
cover_image: null
category: "backend"
tags: ["Laravel", "CRUD", "Débutant", "Projet pratique"]
status: "published"
published_at: "2026-07-10"
reading_time: 8
order: 10
meta_title: "CRUD Laravel Partie 1 - Création et Lecture"
meta_description: "Apprenez à créer une application CRUD avec Laravel : création et affichage d'articles."
---
## Objectif

Créer une application simple de gestion d'articles avec les opérations **C**reate et **R**ead.

## Étape 1 : Créer le modèle avec migration et contrôleur

```bash
php artisan make:model Article -mc
```

## Étape 2 : Migration

```php
// database/migrations/xxxx_create_articles_table.php
Schema::create('articles', function (Blueprint $table) {
    $table->id();
    $table->string('title');
    $table->text('content');
    $table->string('category')->nullable();
    $table->boolean('published')->default(false);
    $table->timestamps();
});
```

```bash
php artisan migrate
```

## Étape 3 : Route

```php
// routes/web.php
use App\Http\Controllers\ArticleController;

Route::resource('articles', ArticleController::class);
```

## Étape 4 : Contrôleur

```php
<?php
namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    // Affiche la liste
    public function index()
    {
        $articles = Article::where('published', true)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('articles.index', compact('articles'));
    }

    // Affiche le formulaire de création
    public function create()
    {
        return view('articles.create');
    }

    // Enregistre un nouvel article
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
            'category' => 'nullable|max:100',
        ]);

        Article::create($validated);

        return redirect()->route('articles.index')
            ->with('success', 'Article créé avec succès !');
    }

    // Affiche un article
    public function show(Article $article)
    {
        return view('articles.show', compact('article'));
    }
}
```

## Étape 5 : Vue Index

```blade
{{-- resources/views/articles/index.blade.php --}}
@extends('layouts.app')

@section('content')
    <h1>Mes Articles</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('articles.create') }}">Créer un article</a>

    @foreach($articles as $article)
        <article>
            <h2>
                <a href="{{ route('articles.show', $article) }}">
                    {{ $article->title }}
                </a>
            </h2>
            <p>{{ Str::limit($article->content, 150) }}</p>
            <small>Catégorie : {{ $article->category ?? 'Non classé' }}</small>
        </article>
    @endforeach
@endsection
```

## Étape 6 : Vue Create

```blade
{{-- resources/views/articles/create.blade.php --}}
@extends('layouts.app')

@section('content')
    <h1>Nouvel Article</h1>

    <form action="{{ route('articles.store') }}" method="POST">
        @csrf

        <div>
            <label for="title">Titre</label>
            <input type="text" name="title" id="title"
                   value="{{ old('title') }}" required>
            @error('title') <p class="error">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="content">Contenu</label>
            <textarea name="content" id="content" rows="10"
                      required>{{ old('content') }}</textarea>
            @error('content') <p class="error">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="category">Catégorie</label>
            <input type="text" name="category" id="category"
                   value="{{ old('category') }}">
        </div>

        <button type="submit">Publier</button>
    </form>
@endsection
```

## Étape 7 : Vue Show

```blade
{{-- resources/views/articles/show.blade.php --}}
@extends('layouts.app')

@section('content')
    <article>
        <h1>{{ $article->title }}</h1>
        <p>{{ $article->content }}</p>
        <small>Publié le {{ $article->created_at->format('d/m/Y') }}</small>
        <small>Catégorie : {{ $article->category ?? 'Non classé' }}</small>
    </article>

    <a href="{{ route('articles.index') }}">Retour à la liste</a>
@endsection
```

## Résultat

Vous avez maintenant une application fonctionnelle qui permet de créer et afficher des articles. Dans la partie 2, nous ajouterons la modification et la suppression.
