<?php

namespace App\Repositories;

use App\DTO\ArticleDTO;
use Illuminate\Support\Collection;

interface ArticleRepositoryInterface
{
    public function all(string $locale = 'fr'): Collection;

    public function findBySlug(string $slug, string $locale = 'fr'): ?ArticleDTO;

    // Utile pour Blog/Show.vue : "articles similaires" basés sur les tags/catégorie communs
    public function related(ArticleDTO $article, string $locale = 'fr', int $limit = 3): Collection;
}
