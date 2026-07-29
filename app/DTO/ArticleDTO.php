<?php

namespace App\DTO;

class ArticleDTO
{
    public function __construct(
        public readonly string $title,
        public readonly string $slug,
        public readonly string $excerpt,
        public readonly string $content,
        public readonly ?string $coverImage,
        public readonly string $category,
        public readonly array $tags,
        public readonly string $status,        // "draft" ou "published"
        public readonly ?string $publishedAt,   // nullable si status = draft
        public readonly int $readingTime,       // en minutes
        public readonly int $order,
        public readonly string $metaTitle,
        public readonly string $metaDescription,
    ) {}

    public function toArray(): array
    {
        return [
            'title' => $this->title,
            'slug' => $this->slug,
            'excerpt' => $this->excerpt,
            'content' => $this->content,
            'coverImage' => $this->coverImage,
            'category' => $this->category,
            'tags' => $this->tags,
            'status' => $this->status,
            'publishedAt' => $this->publishedAt,
            'readingTime' => $this->readingTime,
            'order' => $this->order,
            'metaTitle' => $this->metaTitle,
            'metaDescription' => $this->metaDescription,
        ];
    }
}
