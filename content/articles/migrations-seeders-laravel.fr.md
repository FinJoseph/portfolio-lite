---
title: "Migrations et Seeders"
slug: "migrations-seeders-laravel"
excerpt: "Gérez le schéma de votre base de données avec les migrations et peuplez-la avec les seeders."
cover_image: null
category: "backend"
tags: ["Laravel", "Migrations", "Seeders", "Base de données"]
status: "published"
published_at: "2026-07-09"
reading_time: 6
order: 9
meta_title: "Migrations Laravel - Gestion de schéma"
meta_description: "Apprenez à utiliser les migrations et seeders Laravel pour gérer et peupler votre base de données."
---
## Qu'est-ce qu'une migration ?

Les **migrations** sont comme un contrôle de version pour votre base de données. Elles permettent de créer, modifier ou supprimer des tables de façon structurée et reproductible.

## Créer une migration

```bash
php artisan make:migration create_articles_table
php artisan make:migration add_category_id_to_articles_table
```

### Structure d'une migration

```php
<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('content');
            $table->boolean('published')->default(false);
            $table->foreignId('category_id')->constrained();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};
```

### Types de colonnes courants

```php
$table->id();                    // Clé primaire auto-incrémentée
$table->string('title', 100);    // VARCHAR
$table->text('content');         // TEXT
$table->integer('views');        // INT
$table->boolean('published');    // BOOLEAN
$table->date('published_at');    // DATE
$table->datetime('created_at');  // DATETIME
$table->foreignId('user_id');    // Clé étrangère
$table->timestamps();            // created_at + updated_at
$table->softDeletes();           // deleted_at
```

## Exécuter les migrations

```bash
php artisan migrate              # Exécute toutes les migrations
php artisan migrate:rollback     # Annule la dernière série
php artisan migrate:fresh        # Supprime tout et réexécute
php artisan migrate:status       # Voir l'état des migrations
```

## Les Seeders

Les **seeders** permettent de remplir la base de données avec des données de test.

### Créer un seeder

```bash
php artisan make:seeder ArticleSeeder
```

### Exemple de seeder

```php
<?php
namespace Database\Seeders;

use App\Models\Article;
use Illuminate\Database\Seeder;

class ArticleSeeder extends Seeder
{
    public function run(): void
    {
        Article::create([
            'title' => 'Premier article',
            'content' => 'Contenu...',
            'published' => true,
            'category_id' => 1,
        ]);
    }
}
```

### Factory + Seeder (données massives)

```bash
php artisan make:factory ArticleFactory --model=Article
```

```php
class ArticleFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(),
            'content' => fake()->paragraphs(3, true),
            'published' => fake()->boolean(),
        ];
    }
}
```

```php
class ArticleSeeder extends Seeder
{
    public function run(): void
    {
        Article::factory(50)->create();
    }
}
```

### Exécuter les seeders

```bash
php artisan db:seed
php artisan db:seed --class=ArticleSeeder
php artisan migrate:fresh --seed  # Migration + seed en une commande
```

## Enregistrer les seeders

Dans `DatabaseSeeder.php` :
```php
class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            CategorySeeder::class,
            ArticleSeeder::class,
        ]);
    }
}
```

## Conclusion

Les migrations et seeders sont essentiels pour gérer votre base de données de façon professionnelle. Ils permettent de versionner le schéma et de partager un environnement de développement cohérent.
