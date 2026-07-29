---
title: "Vues Blade ao amin'ny Laravel"
slug: "vues-blade-laravel"
excerpt: "Fehezo ny moteur template Blade ao amin'ny Laravel mba hamoronana vues dynamique sy azo ampiasaina indray."
cover_image: null
category: "backend"
tags: ["Laravel", "Blade", "PHP", "Templates"]
status: "published"
published_at: "2026-07-07"
reading_time: 6
order: 7
meta_title: "Laravel Blade - Moteur Template"
meta_description: "Ianaro ny fampiasana Blade, moteur template Laravel: syntaxe, layouts, composants ary directives."
---
## Inona ny Blade?

**Blade** dia moteur template Laravel. Mamela anao hanoratra vues dynamique miaraka amin'ny syntaxe tsotra nefa mahery. Ny rakitra Blade dia mampiasa ny extension `.blade.php`.

## Syntaxe fototra

### Fampisehoana variable
```blade
<h1>{{ $title }}</h1>
<p>{{ $content }}</p>
```

### Tsy misy échappement HTML
```blade
{!! $htmlContent !!}
```

### Condition
```blade
@if($age >= 18)
    <p>Lehilahy lehibe ianao.</p>
@else
    <p>Mbola tsy ampy taona ianao.</p>
@endif
```

### Boucle
```blade
@foreach($articles as $article)
    <div class="article">
        <h2>{{ $article->title }}</h2>
        <p>{{ $article->excerpt }}</p>
    </div>
@endforeach
```

## Layouts

### Layout lehibe (`layouts/app.blade.php`)
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

### Pejy mampiasa layout
```blade
@extends('layouts.app')

@section('title', 'Fandraisana')

@section('content')
    <h1>Tongasoa eto amin'ny tranokalako</h1>
@endsection
```

## Composants Blade

```blade
{{-- components/alert.blade.php --}}
<div class="alert alert-{{ $type }}">
    {{ $slot }}
</div>

{{-- Fampiasana --}}
<x-alert type="success">Hafatra fahombiazana</x-alert>
```

## Directives ilaina

```blade
@php
    $now = now();
@endphp

@csrf
@method('PUT')

@auth
    <p>Tafiditra</p>
@endauth

@guest
    <p>Tsy tafiditra</p>
@endguest
```
