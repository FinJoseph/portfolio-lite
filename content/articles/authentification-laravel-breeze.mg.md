---
title: "Fampidirana miaraka amin'ny Laravel Breeze"
slug: "authentification-laravel-breeze"
excerpt: "Ampio rafitra fampidirana feno amin'ny application Laravel miaraka amin'ny Breeze."
cover_image: null
category: "backend"
tags: ["Laravel", "Fampidirana", "Breeze", "Fiarovana"]
status: "published"
published_at: "2026-07-12"
reading_time: 6
order: 12
meta_title: "Fampidirana Laravel Breeze - Tari-dalana feno"
meta_description: "Ampidiro sy configure ny Laravel Breeze mba hanampiana fidirana, fisoratana anarana ary fitantanana profil."
---
## Inona ny Laravel Breeze?

**Laravel Breeze** dia package authentication minimal sy tsotra ho an'ny Laravel. Manome:

- Fidirana / Fisoratana anarana
- Tenimiafina hadino
- Fanamarinana email
- Fanamafisana tenimiafina
- Fanavaozana profil

## Fametrahana

### Amin'ny tetikasa Laravel vaovao

```bash
composer require laravel/breeze --dev
php artisan breeze:install blade
npm install && npm run build
php artisan migrate
```

### Safidy misy

```bash
php artisan breeze:install blade       # Templates Blade
php artisan breeze:install vue         # Vue.js miaraka amin'ny Inertia
php artisan breeze:install react       # React miaraka amin'ny Inertia
php artisan breeze:install api         # API ihany (Sanctum)
```

## Fiarovana ny route

```php
Route::middleware(['auth'])->group(function () {
    Route::resource('articles', ArticleController::class);
});
```

## Fampiasana ny mpampiasa tafiditra

```php
auth()->user();
auth()->id();
auth()->check();
auth()->guest();
```

@auth
    <p>Salama, {{ auth()->user()->name }}</p>
@endauth
