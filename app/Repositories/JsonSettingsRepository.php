<?php

namespace App\Repositories;

use App\DTO\SettingsDTO;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;

class JsonSettingsRepository implements SettingsRepositoryInterface
{
    protected string $path;

    public function __construct(?string $path = null)
    {
        $this->path = $path ?? base_path('content/settings.json');
    }

    public function get(string $locale = 'fr'): SettingsDTO
    {
        $cacheKey = "settings.{$locale}.".md5($this->path);

        $data = Cache::remember($cacheKey, 3600, function () use ($locale) {
            if (! File::exists($this->path)) {
                return $this->defaults();
            }

            $raw = json_decode(File::get($this->path), true);

            // Petite fonction locale pour résoudre un champ multilingue avec repli sur "fr"
            $resolve = fn (array $field) => $field[$locale] ?? $field['fr'] ?? '';

            return [
                'site_name' => $raw['site_name'] ?? 'Portfolio',
                'job_title' => $resolve($raw['job_title'] ?? []),
                'hero_headline' => $resolve($raw['hero_headline'] ?? []),
                'hero_tagline' => $resolve($raw['hero_tagline'] ?? []),
                'hero_description' => $resolve($raw['hero_description'] ?? []),
                'hero_cta_primary' => $resolve($raw['hero_cta_primary'] ?? []),
                'hero_cta_secondary' => $resolve($raw['hero_cta_secondary'] ?? []),
                'availability_badge' => $resolve($raw['availability_badge'] ?? []),
                'bio' => $resolve($raw['bio'] ?? []),
                'avatar' => $raw['avatar'] ?? null,
                'email' => $raw['email'] ?? '',
                'phone' => $raw['phone'] ?? null,
                'social_links' => $raw['social_links'] ?? [],
                'default_meta_title' => $resolve($raw['default_meta_title'] ?? []),
                'default_meta_description' => $resolve($raw['default_meta_description'] ?? []),
                'feature_flags' => $raw['feature_flags'] ?? [],
            ];
        });

        return new SettingsDTO(
            siteName: $data['site_name'] ?? 'Portfolio',
            jobTitle: $data['job_title'] ?? '',
            heroHeadline: $data['hero_headline'] ?? '',
            heroTagline: $data['hero_tagline'] ?? '',
            heroDescription: $data['hero_description'] ?? '',
            heroCtaPrimary: $data['hero_cta_primary'] ?? '',
            heroCtaSecondary: $data['hero_cta_secondary'] ?? '',
            availabilityBadge: $data['availability_badge'] ?? '',
            bio: $data['bio'] ?? '',
            avatar: $data['avatar'] ?? null,
            email: $data['email'] ?? '',
            phone: $data['phone'] ?? null,
            socialLinks: $data['social_links'] ?? [],
            defaultMetaTitle: $data['default_meta_title'] ?? '',
            defaultMetaDescription: $data['default_meta_description'] ?? '',
            featureFlags: $data['feature_flags'] ?? [],
        );
    }

    // Valeurs de secours si le fichier settings.json est totalement absent
    protected function defaults(): array
    {
        return [
            'site_name' => 'Portfolio',
            'job_title' => '',
            'hero_headline' => '',
            'hero_tagline' => '',
            'hero_description' => '',
            'hero_cta_primary' => '',
            'hero_cta_secondary' => '',
            'availability_badge' => '',
            'bio' => '',
            'avatar' => null,
            'email' => '',
            'phone' => null,
            'social_links' => [],
            'default_meta_title' => '',
            'default_meta_description' => '',
            'feature_flags' => [],
        ];
    }
}
