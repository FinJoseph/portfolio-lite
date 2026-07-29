---
title: "Migrations and Seeders"
slug: "migrations-seeders-laravel"
excerpt: "Manage your database schema with migrations and populate it with seeders."
cover_image: null
category: "backend"
tags: ["Laravel", "Migrations", "Seeders", "Database"]
status: "published"
published_at: "2026-07-09"
reading_time: 6
order: 9
meta_title: "Laravel Migrations - Schema Management"
meta_description: "Learn how to use Laravel migrations and seeders to manage and populate your database."
---
## What is a Migration?

**Migrations** are like version control for your database. They allow you to create, modify or delete tables in a structured and reproducible way.

## Creating a Migration

```bash
php artisan make:migration create_articles_table
php artisan make:migration add_category_id_to_articles_table
```

### Migration Structure

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

### Common Column Types

```php
$table->id();
$table->string('title', 100);
$table->text('content');
$table->integer('views');
$table->boolean('published');
$table->date('published_at');
$table->datetime('created_at');
$table->foreignId('user_id');
$table->timestamps();
$table->softDeletes();
```

## Running Migrations

```bash
php artisan migrate
php artisan migrate:rollback
php artisan migrate:fresh
php artisan migrate:status
```

## Seeders

**Seeders** allow you to fill the database with test data.

### Creating a Seeder

```bash
php artisan make:seeder ArticleSeeder
```

### Seeder Example

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
            'title' => 'First article',
            'content' => 'Content...',
            'published' => true,
            'category_id' => 1,
        ]);
    }
}
```

### Factory + Seeder (mass data)

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

### Running Seeders

```bash
php artisan db:seed
php artisan db:seed --class=ArticleSeeder
php artisan migrate:fresh --seed
```
