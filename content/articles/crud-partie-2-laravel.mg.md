---
title: "CRUD Ampahany 2: Fanavaozana sy Famafana"
slug: "crud-partie-2-laravel"
excerpt: "Ampio ny fanavaozana sy famafana amin'ny application CRUD Laravel."
cover_image: null
category: "backend"
tags: ["Laravel", "CRUD", "Vao manomboka", "Tetikasa azo ampiharina"]
status: "published"
published_at: "2026-07-11"
reading_time: 7
order: 11
meta_title: "CRUD Laravel Ampahany 2 - Fanavaozana sy Famafana"
meta_description: "Fenoy ny CRUD Laravel miaraka amin'ny fanavaozana sy famafana lahatsoratra."
---
## Fampahatsiarovana

Tamin'ny ampahany 1, dia namorona ny **Create** sy **Read** isika. Andeha hanampy **Update** sy **Delete**.

## Méthodes Update ao amin'ny Controller

```php
class ArticleController extends Controller
{
    public function edit(Article $article)
    {
        return view('articles.edit', compact('article'));
    }

    public function update(Request $request, Article $article)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
        ]);

        $article->update($validated);

        return redirect()->route('articles.index')
            ->with('success', 'Lahatsoratra nohavaozina!');
    }

    public function destroy(Article $article)
    {
        $article->delete();
        return redirect()->route('articles.index')
            ->with('success', 'Lahatsoratra voafafa!');
    }
}
```

## Vue Edit

```blade
@extends('layouts.app')
@section('content')
    <h1>Hanova ny lahatsoratra</h1>
    <form action="{{ route('articles.update', $article) }}" method="POST">
        @csrf
        @method('PUT')
        <div>
            <label>Lohateny</label>
            <input type="text" name="title" value="{{ old('title', $article->title) }}" required>
        </div>
        <div>
            <label>Votoatiny</label>
            <textarea name="content" rows="10" required>{{ old('content', $article->content) }}</textarea>
        </div>
        <button type="submit">Tehirizo</button>
    </form>
@endsection
```

## CRUD feno

| Hetsika | Verbe | URL | Méthode |
|-----------|-------|-------|---------|
| Lisitra | GET | /articles | index |
| Foromazy (create) | GET | /articles/create | create |
| Mamorona | POST | /articles | store |
| Mijery | GET | /articles/{id} | show |
| Manova (form) | GET | /articles/{id}/edit | edit |
| Manova (action) | PUT | /articles/{id} | update |
| Mamafa | DELETE | /articles/{id} | destroy |
