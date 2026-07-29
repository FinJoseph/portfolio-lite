<?php

namespace App\DTO;

class SettingsDTO
{
    public function __construct(
        public readonly string $siteName,
        public readonly string $jobTitle,
        public readonly string $heroHeadline,
        public readonly string $heroTagline,
        public readonly string $heroDescription,
        public readonly string $heroCtaPrimary,
        public readonly string $heroCtaSecondary,
        public readonly string $availabilityBadge,
        public readonly string $bio,
        public readonly ?string $avatar,
        public readonly string $email,
        public readonly ?string $phone,
        public readonly array $socialLinks,
        public readonly string $defaultMetaTitle,
        public readonly string $defaultMetaDescription,
        public readonly array $featureFlags,
    ) {}

    public function toArray(): array
    {
        return [
            'site_name' => $this->siteName,
            'job_title' => $this->jobTitle,
            'hero_headline' => $this->heroHeadline,
            'hero_tagline' => $this->heroTagline,
            'hero_description' => $this->heroDescription,
            'hero_cta_primary' => $this->heroCtaPrimary,
            'hero_cta_secondary' => $this->heroCtaSecondary,
            'availability_badge' => $this->availabilityBadge,
            'bio' => $this->bio,
            'avatar' => $this->avatar,
            'email' => $this->email,
            'phone' => $this->phone,
            'social_links' => $this->socialLinks,
            'default_meta_title' => $this->defaultMetaTitle,
            'default_meta_description' => $this->defaultMetaDescription,
            'feature_flags' => $this->featureFlags,
        ];
    }
}
