---
title: "CRUD Ampahany 1: Famoronana sy Famakiana"
slug: "crud-partie-1-laravel"
excerpt: "Manamboatra application CRUD feno miaraka amin'ny Laravel: famoronana sy fampisehoana lahatsoratra."
cover_image: null
category: "backend"
tags: ["Laravel", "CRUD", "Vao manomboka", "Tetikasa azo ampiharina"]
status: "published"
published_at: "2026-07-10"
reading_time: 8
order: 10
meta_title: "CRUD Laravel Ampahany 1 - Famoronana sy Famakiana"
meta_description: "Ianaro ny famoronana application CRUD miaraka amin'ny Laravel: famoronana sy fampisehoana lahatsoratra."
---
## Tanjona

Mamorona application tsotra fitantanana lahatsoratra miaraka amin'ny **C**reate sy **R**ead.

## Dingana 1: Mamorona modely miaraka amin'ny migration sy controller

```bash
php artisan make:model Article -mc
```

## Dingana 2: Migration

```php
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

## Dingana 3: Route

```php
Route::resource('articles', ArticleController::class);
```

## Dingana 4: Controller

```php
class ArticleController extends Controller
{
    public function index()
    {
        $articles = Article::where('published', true)
            ->orderBy('created_at', 'desc')->get();
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
        ]);
        Article::create($validated);
        return redirect()->route('articles.index')
            ->with('success', 'Vita ny lahatsoratra!');
    }

    public function show(Article $article)
    {
        return view('articles.show', compact('article'));
    }
}
```

## Dingana 5: Vue Index

```blade
@extends('layouts.app')
@section('content')
    <h1>Ny Lahatsoratro</h1>
    @if(session('success'))
        <div>{{ session('success') }}</div>
    @endif
    <a href="{{ route('articles.create') }}">Lahatsoratra vaovao</a>
    @foreach($articles as $article)
        <article>
            <h2><a href="{{ route('articles.show', $article) }}">{{ $article->title }}</a></h2>
            <p>{{ Str::limit($article->content, 150) }}</p>
        </article>
    @endforeach
@endsection
```
