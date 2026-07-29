<?php

namespace App\Repositories;

use App\DTO\ArticleDTO;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;
use League\CommonMark\CommonMarkConverter;
use Spatie\YamlFrontMatter\YamlFrontMatter;

class FileArticleRepository implements ArticleRepositoryInterface
{
    protected string $path;

    public function __construct(?string $path = null)
    {
        $this->path = $path ?? base_path('content/articles');
    }

    public function all(string $locale = 'fr'): Collection
    {
        $cacheKey = "articles.all.{$locale}.".md5($this->path);

        $cached = Cache::remember($cacheKey, 3600, function () use ($locale) {
            $files = File::glob("{$this->path}/*.{$locale}.md");

            return collect($files)
                ->map(fn ($file) => $this->parseFileToArray($file))
                // Seuls les articles publiés apparaissent dans la liste publique
                ->filter(fn ($data) => ($data['status'] ?? 'draft') === 'published')
                // Tri du plus récent au plus ancien
                ->sortByDesc('publishedAt')
                ->values()
                ->toArray();
        });

        return collect($cached)->map(fn ($data) => $this->arrayToDto($data));
    }

    public function findBySlug(string $slug, string $locale = 'fr'): ?ArticleDTO
    {
        return $this->all($locale)->firstWhere('slug', $slug);
    }

    public function related(ArticleDTO $article, string $locale = 'fr', int $limit = 3): Collection
    {
        return $this->all($locale)
            // On exclut l'article lui-même
            ->reject(fn (ArticleDTO $a) => $a->slug === $article->slug)
            // On garde ceux qui partagent au moins un tag ou la même catégorie
            ->filter(function (ArticleDTO $a) use ($article) {
                $sharesTag = count(array_intersect($a->tags, $article->tags)) > 0;
                $sameCategory = $a->category === $article->category;

                return $sharesTag || $sameCategory;
            })
            ->take($limit)
            ->values();
    }

    protected function parseFileToArray(string $filePath): array
    {
        $document = YamlFrontMatter::parse(File::get($filePath));
        $meta = $document->matter();

        $converter = new CommonMarkConverter;
        $htmlContent = $converter->convert($document->body())->getContent();

        return [
            'title' => $meta['title'] ?? '',
            'slug' => $meta['slug'] ?? '',
            'excerpt' => $meta['excerpt'] ?? '',
            'content' => $htmlContent,
            'coverImage' => $meta['cover_image'] ?? null,
            'category' => $meta['category'] ?? 'general',
            'tags' => $meta['tags'] ?? [],
            'status' => $meta['status'] ?? 'draft',
            'publishedAt' => $meta['published_at'] ?? null,
            'readingTime' => $meta['reading_time'] ?? 1,
            'order' => $meta['order'] ?? 99,
            'metaTitle' => $meta['meta_title'] ?? ($meta['title'] ?? ''),
            'metaDescription' => $meta['meta_description'] ?? ($meta['excerpt'] ?? ''),
        ];
    }

    // Méthode utilitaire : centralise la reconstruction du DTO avec valeurs par défaut,
    // pour être blindé contre un vieux cache incomplet (même piège que Project)
    protected function arrayToDto(array $data): ArticleDTO
    {
        return new ArticleDTO(
            title: $data['title'] ?? '',
            slug: $data['slug'] ?? '',
            excerpt: $data['excerpt'] ?? '',
            content: $data['content'] ?? '',
            coverImage: $data['coverImage'] ?? null,
            category: $data['category'] ?? 'general',
            tags: $data['tags'] ?? [],
            status: $data['status'] ?? 'draft',
            publishedAt: $data['publishedAt'] ?? null,
            readingTime: $data['readingTime'] ?? 1,
            order: $data['order'] ?? 99,
            metaTitle: $data['metaTitle'] ?? ($data['title'] ?? ''),
            metaDescription: $data['metaDescription'] ?? ($data['excerpt'] ?? ''),
        );
    }
}
