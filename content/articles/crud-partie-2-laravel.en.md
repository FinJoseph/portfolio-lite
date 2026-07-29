---
title: "CRUD Part 2: Update and Delete"
slug: "crud-partie-2-laravel"
excerpt: "Add update and delete functionality to your Laravel CRUD application."
cover_image: null
category: "backend"
tags: ["Laravel", "CRUD", "Beginner", "Practical Project"]
status: "published"
published_at: "2026-07-11"
reading_time: 7
order: 11
meta_title: "Laravel CRUD Part 2 - Update and Delete"
meta_description: "Complete your Laravel CRUD with article editing and deletion."
---
## Recap

In part 1, we created the **Create** and **Read** operations. Now let's add **Update** and **Delete**.

## Update Methods in the Controller

```php
<?php
namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    // ... index, create, store, show ...

    public function edit(Article $article)
    {
        return view('articles.edit', compact('article'));
    }

    public function update(Request $request, Article $article)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
            'category' => 'nullable|max:100',
        ]);

        $article->update($validated);

        return redirect()->route('articles.index')
            ->with('success', 'Article updated successfully!');
    }

    public function destroy(Article $article)
    {
        $article->delete();

        return redirect()->route('articles.index')
            ->with('success', 'Article deleted successfully!');
    }
}
```

## Edit View

```blade
@extends('layouts.app')

@section('content')
    <h1>Edit Article</h1>

    <form action="{{ route('articles.update', $article) }}" method="POST">
        @csrf
        @method('PUT')

        <div>
            <label for="title">Title</label>
            <input type="text" name="title" id="title"
                   value="{{ old('title', $article->title) }}" required>
            @error('title') <p>{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="content">Content</label>
            <textarea name="content" id="content" rows="10"
                      required>{{ old('content', $article->content) }}</textarea>
            @error('content') <p>{{ $message }}</p> @enderror
        </div>

        <button type="submit">Save</button>
    </form>
@endsection
```

## Action Buttons in Index View

```blade
@foreach($articles as $article)
    <article>
        <h2><a href="{{ route('articles.show', $article) }}">{{ $article->title }}</a></h2>
        <div class="actions">
            <a href="{{ route('articles.edit', $article) }}">Edit</a>
            <form action="{{ route('articles.destroy', $article) }}"
                  method="POST"
                  onsubmit="return confirm('Delete this article?')">
                @csrf
                @method('DELETE')
                <button type="submit">Delete</button>
            </form>
        </div>
    </article>
@endforeach
```

## Complete CRUD Summary

| Operation | Verb | URL | Method |
|-----------|-------|-------|---------|
| List | GET | /articles | index |
| Create (form) | GET | /articles/create | create |
| Create (action) | POST | /articles | store |
| Show | GET | /articles/{id} | show |
| Edit (form) | GET | /articles/{id}/edit | edit |
| Update (action) | PUT | /articles/{id} | update |
| Delete | DELETE | /articles/{id} | destroy |
