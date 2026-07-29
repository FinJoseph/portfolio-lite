<?php

namespace App\Repositories;

use App\DTO\ProjectDTO;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;
use League\CommonMark\CommonMarkConverter;
use Spatie\YamlFrontMatter\YamlFrontMatter;

class FileProjectRepository implements ProjectRepositoryInterface
{
    protected string $path;

    public function __construct(?string $path = null)
    {
        $this->path = $path ?? base_path('content/projects');
    }

    public function all(string $locale = 'fr'): Collection
    {
        $cacheKey = "projects.all.{$locale}.".md5($this->path);

        $cached = Cache::remember($cacheKey, 3600, function () use ($locale) {
            $files = File::glob("{$this->path}/*.{$locale}.md");

            return collect($files)
                ->map(fn ($file) => $this->parseFileToArray($file))
                ->sortBy('order')
                ->values()
                ->toArray();
        });

        // ?? avec valeur par défaut à CHAQUE clé : même si le cache contient une ancienne
        // structure incomplète (avant un enrichissement de champs), le site ne plante jamais
        return collect($cached)->map(fn ($data) => new ProjectDTO(
            title: $data['title'] ?? '',
            slug: $data['slug'] ?? '',
            excerpt: $data['excerpt'] ?? '',
            content: $data['content'] ?? '',
            coverImage: $data['coverImage'] ?? null,
            gallery: $data['gallery'] ?? [],
            category: $data['category'] ?? 'web',
            technologies: $data['technologies'] ?? [],
            siteUrl: $data['siteUrl'] ?? null,
            githubUrl: $data['githubUrl'] ?? null,
            completedAt: $data['completedAt'] ?? null,
            status: $data['status'] ?? 'draft',
            isFeatured: $data['isFeatured'] ?? false,
            order: $data['order'] ?? 99,
            metaTitle: $data['metaTitle'] ?? ($data['title'] ?? ''),
            metaDescription: $data['metaDescription'] ?? ($data['excerpt'] ?? ''),
        ));
    }

    public function findBySlug(string $slug, string $locale = 'fr'): ?ProjectDTO
    {
        return $this->all($locale)->firstWhere('slug', $slug);
    }

    protected function parseFileToArray(string $filePath): array
    {
        $document = YamlFrontMatter::parse(File::get($filePath));
        $meta = $document->matter();

        $converter = new CommonMarkConverter;
        $htmlContent = $converter->convert($document->body())->getContent();

        return [
            'title' => $meta['title'],
            'slug' => $meta['slug'],
            'excerpt' => $meta['excerpt'],
            'content' => $htmlContent,
            'coverImage' => $meta['cover_image'] ?? null,
            'gallery' => $meta['gallery'] ?? [],
            'category' => $meta['category'] ?? 'web',
            'technologies' => $meta['technologies'] ?? [],
            'siteUrl' => $meta['site_url'] ?? null,
            'githubUrl' => $meta['github_url'] ?? null,
            'completedAt' => $meta['completed_at'] ?? null,
            'status' => $meta['status'] ?? 'draft',
            'isFeatured' => $meta['is_featured'] ?? false,
            'order' => $meta['order'] ?? 99,
            'metaTitle' => $meta['meta_title'] ?? $meta['title'],
            'metaDescription' => $meta['meta_description'] ?? $meta['excerpt'],
        ];
    }
}
