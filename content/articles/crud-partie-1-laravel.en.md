---
title: "CRUD Part 1: Create and Read"
slug: "crud-partie-1-laravel"
excerpt: "Build a complete CRUD application with Laravel: creating and displaying articles."
cover_image: null
category: "backend"
tags: ["Laravel", "CRUD", "Beginner", "Practical Project"]
status: "published"
published_at: "2026-07-10"
reading_time: 8
order: 10
meta_title: "Laravel CRUD Part 1 - Create and Read"
meta_description: "Learn how to create a CRUD application with Laravel: creating and displaying articles."
---
## Goal

Create a simple article management application with **C**reate and **R**ead operations.

## Step 1: Create the model with migration and controller

```bash
php artisan make:model Article -mc
```

## Step 2: Migration

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

## Step 3: Route

```php
// routes/web.php
use App\Http\Controllers\ArticleController;

Route::resource('articles', ArticleController::class);
```

## Step 4: Controller

```php
<?php
namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function index()
    {
        $articles = Article::where('published', true)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('articles.index', compact('articles'));
    }

    public function create()
    {
        return view('articles.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
            'category' => 'nullable|max:100',
        ]);

        Article::create($validated);

        return redirect()->route('articles.index')
            ->with('success', 'Article created successfully!');
    }

    public function show(Article $article)
    {
        return view('articles.show', compact('article'));
    }
}
```

## Step 5: Index View

```blade
@extends('layouts.app')

@section('content')
    <h1>My Articles</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('articles.create') }}">Create article</a>

    @foreach($articles as $article)
        <article>
            <h2>
                <a href="{{ route('articles.show', $article) }}">
                    {{ $article->title }}
                </a>
            </h2>
            <p>{{ Str::limit($article->content, 150) }}</p>
        </article>
    @endforeach
@endsection
```
