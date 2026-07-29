---
title: "Laravel Project Structure"
slug: "structure-projet-laravel"
excerpt: "Understand the organization of folders and files in a Laravel project to navigate with ease."
cover_image: null
category: "backend"
tags: ["Laravel", "PHP", "Architecture", "Structure"]
status: "published"
published_at: "2026-07-05"
reading_time: 7
order: 5
meta_title: "Laravel Project Structure - Complete Guide"
meta_description: "Understand Laravel project architecture: app, config, database, resources, routes and more."
---
## MVC Architecture

Laravel follows the **Model-View-Controller (MVC)** architecture:

- **Model**: Manages data and business logic
- **View**: Displays data to the user
- **Controller**: Processes requests and bridges Model and View

## Main Directory Structure

```
my-project/
├── app/
│   ├── Http/
│   │   ├── Controllers/    # Controllers
│   │   └── Middleware/      # Request filters
│   ├── Models/              # Eloquent Models
│   └── Providers/           # Service Providers
│
├── config/                  # Configuration (app, database, mail...)
├── database/
│   ├── migrations/          # Database structure
│   └── seeders/             # Test data
│
├── resources/
│   ├── views/               # Blade templates
│   └── lang/                # Translation files
│
├── routes/
│   ├── web.php              # Web routes
│   ├── api.php              # API routes
│   └── console.php          # Artisan commands
│
├── public/                  # Entry point (index.php)
├── storage/                 # Logs, cache, uploaded files
├── tests/                   # Automated tests
└── .env                     # Environment configuration
```

## The app/ Directory in Detail

The `app/` directory contains the core of your application:

- **Http/Controllers**: Your controllers that handle requests
- **Http/Middleware**: Filters for HTTP requests (auth, CORS, etc.)
- **Models**: Your Eloquent models
- **Providers**: Service registration
- **Http/Requests**: Form validation
- **Exceptions**: Custom error handling

## routes/ Directory

- **web.php**: Routes with session, CSRF (for web pages)
- **api.php**: API routes (stateless, token authentication)
- **console.php**: Custom Artisan commands

## resources/ Directory

- **views/**: Blade templates (`.blade.php`)
- **lang/**: Translation files (fr/, en/, mg/)
- **css/**: CSS files
- **js/**: JavaScript files

## The .env File

Contains environment variables: database, mail, debug, etc. **Never share this file** (it is in `.gitignore`).

## Conclusion

Understanding Laravel's structure is essential to navigate your project efficiently. Each directory has a precise and well-defined role.
