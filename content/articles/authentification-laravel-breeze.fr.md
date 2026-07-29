---
title: "Authentification avec Laravel Breeze"
slug: "authentification-laravel-breeze"
excerpt: "Ajoutez un système d'authentification complet à votre application Laravel avec Breeze."
cover_image: null
category: "backend"
tags: ["Laravel", "Authentification", "Breeze", "Sécurité"]
status: "published"
published_at: "2026-07-12"
reading_time: 6
order: 12
meta_title: "Authentification Laravel Breeze - Guide complet"
meta_description: "Installez et configurez Laravel Breeze pour ajouter connexion, inscription et gestion de profil."
---
## Qu'est-ce que Laravel Breeze ?

**Laravel Breeze** est un package d'authentification minimal et simple pour Laravel. Il fournit :

- Connexion / Inscription
- Mot de passe oublié
- Vérification d'email
- Confirmation de mot de passe
- Mise à jour du profil

## Installation

### Sur un nouveau projet Laravel

```bash
composer require laravel/breeze --dev
php artisan breeze:install blade
npm install && npm run build
php artisan migrate
```

### Options disponibles

```bash
php artisan breeze:install blade       # Templates Blade
php artisan breeze:install vue         # Vue.js avec Inertia
php artisan breeze:install react       # React avec Inertia
php artisan breeze:install api         # API uniquement (Sanctum)
```

## Structure après installation

### Routes d'authentification

```php
// routes/auth.php (inclus automatiquement)
Route::get('login', [AuthenticatedSessionController::class, 'create']);
Route::post('login', [AuthenticatedSessionController::class, 'store']);
Route::post('logout', [AuthenticatedSessionController::class, 'destroy']);

Route::get('register', [RegisteredUserController::class, 'create']);
Route::post('register', [RegisteredUserController::class, 'store']);

Route::get('forgot-password', [PasswordResetLinkController::class, 'create']);
Route::post('forgot-password', [PasswordResetLinkController::class, 'store']);
```

### Contrôleurs créés

```
app/Http/Controllers/Auth/
├── AuthenticatedSessionController.php
├── ConfirmPasswordController.php
├── EmailVerificationNotificationController.php
├── EmailVerificationPromptController.php
├── NewPasswordController.php
├── PasswordResetLinkController.php
├── RegisteredUserController.php
└── VerifyEmailController.php
```

### Vues créées (Blade)

```
resources/views/auth/
├── login.blade.php
├── register.blade.php
├── forgot-password.blade.php
├── reset-password.blade.php
├── confirm-password.blade.php
└── verify-email.blade.php

resources/views/profile/
├── edit.blade.php
└── partials/
    ├── delete-user-form.blade.php
    ├── update-password-form.blade.php
    └── update-profile-information-form.blade.php
```

## Protéger une route

```php
// routes/web.php
Route::middleware(['auth'])->group(function () {
    Route::resource('articles', ArticleController::class);
});
```

## Utiliser l'utilisateur connecté

```php
// Dans un contrôleur
auth()->user();           // Utilisateur connecté
auth()->id();             // Son ID
auth()->check();          // Est-il connecté ?
auth()->guest();          // Est-il invité ?

// Dans une vue Blade
@auth
    <p>Bonjour, {{ auth()->user()->name }}</p>
@endauth

@guest
    <p>Veuillez vous connecter</p>
@endguest
```

## Personnalisation

### Modifier les champs du formulaire d'inscription

```php
// app/Http/Controllers/Auth/RegisteredUserController.php
protected function create(array $input)
{
    return User::create([
        'name' => $input['name'],
        'email' => $input['email'],
        'password' => Hash::make($input['password']),
        'phone' => $input['phone'] ?? null,  // Champ personnalisé
    ]);
}
```

## Conclusion

Breeze est le moyen le plus rapide d'ajouter une authentification complète à votre application Laravel. Simple, sécurisé et facile à personnaliser.
