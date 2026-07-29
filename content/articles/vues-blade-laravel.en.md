---
title: "Blade Views in Laravel"
slug: "vues-blade-laravel"
excerpt: "Master Laravel's Blade template engine to create dynamic and reusable views."
cover_image: null
category: "backend"
tags: ["Laravel", "Blade", "PHP", "Templates"]
status: "published"
published_at: "2026-07-07"
reading_time: 6
order: 7
meta_title: "Laravel Blade - Template Engine"
meta_description: "Learn how to use Blade, Laravel's template engine: syntax, layouts, components and directives."
---
## What is Blade?

**Blade** is Laravel's template engine. It allows you to write dynamic views with a simple and powerful syntax. Blade files use the `.blade.php` extension.

## Basic Syntax

### Displaying Variables
```blade
<h1>{{ $title }}</h1>
<p>{{ $content }}</p>
```

### Without HTML Escaping
```blade
{!! $htmlContent !!}
```

### Conditions
```blade
@if($age >= 18)
    <p>You are an adult.</p>
@else
    <p>You are underage.</p>
@endif
```

### Loops
```blade
@foreach($articles as $article)
    <div class="article">
        <h2>{{ $article->title }}</h2>
        <p>{{ $article->excerpt }}</p>
    </div>
@endforeach
```

## Layouts

### Main layout (`layouts/app.blade.php`)
```blade
<!DOCTYPE html>
<html>
<head>
    <title>@yield('title')</title>
</head>
<body>
    <header>@include('partials.nav')</header>
    <main>
        @yield('content')
    </main>
</body>
</html>
```

### Page Using Layout
```blade
@extends('layouts.app')

@section('title', 'Home')

@section('content')
    <h1>Welcome to my site</h1>
@endsection
```

## Blade Components

```blade
{{-- components/alert.blade.php --}}
<div class="alert alert-{{ $type }}">
    {{ $slot }}
</div>

{{-- Usage --}}
<x-alert type="success">Success message</x-alert>
```

## Useful Directives

```blade
@php
    // Raw PHP code
    $now = now();
@endphp

@csrf    {{-- CSRF Token --}}
@method('PUT')  {{-- HTTP Method --}}

@auth
    <p>Logged in</p>
@endauth

@guest
    <p>Not logged in</p>
@endguest
```

## Conclusion

Blade makes view creation enjoyable and efficient. Layouts, components and directives allow you to write clean and reusable code.
