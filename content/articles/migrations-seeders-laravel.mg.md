---
title: "Migration sy Seeders"
slug: "migrations-seeders-laravel"
excerpt: "Tantano ny schema database miaraka amin'ny migration ary fenoy amin'ny seeders."
cover_image: null
category: "backend"
tags: ["Laravel", "Migrations", "Seeders", "Database"]
status: "published"
published_at: "2026-07-09"
reading_time: 6
order: 9
meta_title: "Migration Laravel - Fitantanana schema"
meta_description: "Ianaro ny fampiasana migration sy seeders Laravel hitantanana sy hamenoana ny database."
---
## Inona ny migration?

Ny **migrations** dia toy ny contrôle de version ho an'ny database. Mamela anao hamorona, hanova na hamafa tabilao amin'ny fomba voarafitra sy azo averina.

## Mamorona migration

```bash
php artisan make:migration create_articles_table
```

### Rafitry ny migration

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

### Karazana colonne

```php
$table->id();
$table->string('title', 100);
$table->text('content');
$table->boolean('published');
$table->foreignId('user_id');
$table->timestamps();
$table->softDeletes();
```

## Fampandehanana migration

```bash
php artisan migrate
php artisan migrate:rollback
php artisan migrate:fresh
php artisan migrate:status
```

## Seeders

Ny **seeders** dia mamela anao hameno ny database amin'ny data andrana.

### Mamorona seeder

```bash
php artisan make:seeder ArticleSeeder
```

### Ohatra seeder

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
            'title' => 'Lahatsoratra voalohany',
            'content' => 'Votoatiny...',
            'published' => true,
        ]);
    }
}
```

### Factory sy Seeder (data marobe)

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
Article::factory(50)->create();
```

### Fampandehanana seeders

```bash
php artisan db:seed
php artisan migrate:fresh --seed
```
