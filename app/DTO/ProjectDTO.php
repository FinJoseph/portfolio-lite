<?php

namespace App\DTO;

class ProjectDTO
{
    public function __construct(
        public readonly string $title,
        public readonly string $slug,
        public readonly string $excerpt,
        public readonly string $content,
        public readonly ?string $coverImage,
        public readonly array $gallery,
        public readonly string $category,
        public readonly array $technologies,
        public readonly ?string $siteUrl,
        public readonly ?string $githubUrl,
        public readonly ?string $completedAt,
        public readonly string $status,
        public readonly bool $isFeatured,
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
            'gallery' => $this->gallery,
            'category' => $this->category,
            'technologies' => $this->technologies,
            'siteUrl' => $this->siteUrl,
            'githubUrl' => $this->githubUrl,
            'completedAt' => $this->completedAt,
            'status' => $this->status,
            'isFeatured' => $this->isFeatured,
            'order' => $this->order,
            'metaTitle' => $this->metaTitle,
            'metaDescription' => $this->metaDescription,
        ];
    }
}
