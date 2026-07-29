---
title: "Authentication with Laravel Breeze"
slug: "authentification-laravel-breeze"
excerpt: "Add a complete authentication system to your Laravel application with Breeze."
cover_image: null
category: "backend"
tags: ["Laravel", "Authentication", "Breeze", "Security"]
status: "published"
published_at: "2026-07-12"
reading_time: 6
order: 12
meta_title: "Laravel Breeze Authentication - Complete Guide"
meta_description: "Install and configure Laravel Breeze to add login, registration and profile management."
---
## What is Laravel Breeze?

**Laravel Breeze** is a minimal and simple authentication package for Laravel. It provides:

- Login / Registration
- Forgot password
- Email verification
- Password confirmation
- Profile update

## Installation

### On a new Laravel project

```bash
composer require laravel/breeze --dev
php artisan breeze:install blade
npm install && npm run build
php artisan migrate
```

### Available Options

```bash
php artisan breeze:install blade       # Blade templates
php artisan breeze:install vue         # Vue.js with Inertia
php artisan breeze:install react       # React with Inertia
php artisan breeze:install api         # API only (Sanctum)
```

## Protecting a Route

```php
Route::middleware(['auth'])->group(function () {
    Route::resource('articles', ArticleController::class);
});
```

## Using the Authenticated User

```php
// In a controller
auth()->user();           // Current user
auth()->id();             // User ID
auth()->check();          // Is logged in?
auth()->guest();          // Is guest?

// In a Blade view
@auth
    <p>Hello, {{ auth()->user()->name }}</p>
@endauth

@guest
    <p>Please log in</p>
@endguest
```

## Conclusion

Breeze is the fastest way to add complete authentication to your Laravel application. Simple, secure and easy to customize.
