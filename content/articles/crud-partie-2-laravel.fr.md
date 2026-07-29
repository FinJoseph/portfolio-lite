---
title: "CRUD Partie 2 : Modification et Suppression"
slug: "crud-partie-2-laravel"
excerpt: "Ajoutez les fonctionnalités de modification et suppression à votre application CRUD Laravel."
cover_image: null
category: "backend"
tags: ["Laravel", "CRUD", "Débutant", "Projet pratique"]
status: "published"
published_at: "2026-07-11"
reading_time: 7
order: 11
meta_title: "CRUD Laravel Partie 2 - Modification et Suppression"
meta_description: "Complétez votre CRUD Laravel avec la modification et la suppression d'articles."
---
## Rappel

Dans la partie 1, nous avons créé les opérations **Create** et **Read**. Ajoutons maintenant **Update** et **Delete**.

## Méthodes Update dans le contrôleur

```php
<?php
namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    // ... index, create, store, show ...

    // Affiche le formulaire d'édition
    public function edit(Article $article)
    {
        return view('articles.edit', compact('article'));
    }

    // Met à jour l'article
    public function update(Request $request, Article $article)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
            'category' => 'nullable|max:100',
        ]);

        $article->update($validated);

        return redirect()->route('articles.index')
            ->with('success', 'Article modifié avec succès !');
    }

    // Supprime l'article
    public function destroy(Article $article)
    {
        $article->delete();

        return redirect()->route('articles.index')
            ->with('success', 'Article supprimé avec succès !');
    }
}
```

## Vue Edit

```blade
{{-- resources/views/articles/edit.blade.php --}}
@extends('layouts.app')

@section('content')
    <h1>Modifier l'article</h1>

    <form action="{{ route('articles.update', $article) }}" method="POST">
        @csrf
        @method('PUT')

        <div>
            <label for="title">Titre</label>
            <input type="text" name="title" id="title"
                   value="{{ old('title', $article->title) }}" required>
            @error('title') <p class="error">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="content">Contenu</label>
            <textarea name="content" id="content" rows="10"
                      required>{{ old('content', $article->content) }}</textarea>
            @error('content') <p class="error">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="category">Catégorie</label>
            <input type="text" name="category" id="category"
                   value="{{ old('category', $article->category) }}">
        </div>

        <button type="submit">Enregistrer</button>
    </form>

    <a href="{{ route('articles.index') }}">Annuler</a>
@endsection
```

## Ajout des boutons d'action dans la vue Index

```blade
{{-- Dans la boucle @foreach de index.blade.php --}}
@foreach($articles as $article)
    <article>
        <h2>
            <a href="{{ route('articles.show', $article) }}">
                {{ $article->title }}
            </a>
        </h2>
        <p>{{ Str::limit($article->content, 150) }}</p>

        <div class="actions">
            <a href="{{ route('articles.edit', $article) }}">Modifier</a>

            <form action="{{ route('articles.destroy', $article) }}"
                  method="POST"
                  onsubmit="return confirm('Supprimer cet article ?')">
                @csrf
                @method('DELETE')
                <button type="submit">Supprimer</button>
            </form>
        </div>
    </article>
@endforeach
```

## Liaison de modèle implicite

Laravel utilise la **liaison de modèle implicite** : quand vous type-hintez `Article $article`, Laravel récupère automatiquement l'article correspondant à l'ID dans l'URL.

```php
// URL: /articles/5
public function show(Article $article)
{
    // $article est déjà l'article avec ID 5
}
```

## Validation des données

```php
$validated = $request->validate([
    'title' => 'required|max:255',
    'content' => 'required|min:10',
    'category' => 'nullable|max:100',
    'email' => 'nullable|email',
    'published' => 'boolean',
]);
```

## Résumé du CRUD complet

| Opération | Verbe | Route | Méthode |
|-----------|-------|-------|---------|
| Liste | GET | /articles | index |
| Créer (form) | GET | /articles/create | create |
| Créer (action) | POST | /articles | store |
| Voir | GET | /articles/{id} | show |
| Modifier (form) | GET | /articles/{id}/edit | edit |
| Modifier (action) | PUT | /articles/{id} | update |
| Supprimer | DELETE | /articles/{id} | destroy |

## Conclusion

Vous avez maintenant une application CRUD complète avec Laravel ! C'est la base de la plupart des applications web : créer, lire, modifier et supprimer des données.
