---
title: "Les Vues Blade dans Laravel"
slug: "vues-blade-laravel"
excerpt: "Maîtrisez le moteur de templates Blade de Laravel pour créer des vues dynamiques et réutilisables."
cover_image: null
category: "backend"
tags: ["Laravel", "Blade", "PHP", "Templates"]
status: "published"
published_at: "2026-07-07"
reading_time: 6
order: 7
meta_title: "Blade Laravel - Moteur de templates"
meta_description: "Apprenez à utiliser Blade, le moteur de templates de Laravel : syntaxe, layouts, composants et directives."
---
## Qu'est-ce que Blade ?

**Blade** est le moteur de templates de Laravel. Il permet d'écrire des vues dynamiques avec une syntaxe simple et puissante. Les fichiers Blade utilisent l'extension `.blade.php`.

## Syntaxe de base

### Affichage de variables
```blade
<h1>{{ $title }}</h1>
<p>{{ $content }}</p>
```

### Sans échappement HTML
```blade
{!! $htmlContent !!}
```

### Conditions
```blade
@if($age >= 18)
    <p>Vous êtes majeur.</p>
@else
    <p>Vous êtes mineur.</p>
@endif
```

### Boucles
```blade
@foreach($articles as $article)
    <div class="article">
        <h2>{{ $article->title }}</h2>
        <p>{{ $article->excerpt }}</p>
    </div>
@endforeach
```

## Layouts (Mise en page)

### Layout principal (`layouts/app.blade.php`)
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

### Page qui utilise le layout
```blade
@extends('layouts.app')

@section('title', 'Accueil')

@section('content')
    <h1>Bienvenue sur mon site</h1>
@endsection
```

## Composants Blade

```blade
{{-- components/alert.blade.php --}}
<div class="alert alert-{{ $type }}">
    {{ $slot }}
</div>

{{-- Utilisation --}}
<x-alert type="success">Message de succès</x-alert>
```

## Directives utiles

```blade
@php
    // Code PHP brut
    $now = now();
@endphp

@csrf    {{-- Token CSRF --}}
@method('PUT')  {{-- Méthode HTTP --}}

@auth
    <p>Connecté</p>
@endauth

@guest
    <p>Non connecté</p>
@endguest
```

## Conclusion

Blade rend la création de vues agréable et efficace. Les layouts, composants et directives permettent d'écrire du code propre et réutilisable.
