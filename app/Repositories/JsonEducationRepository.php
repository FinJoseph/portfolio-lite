<?php

namespace App\Repositories;

use App\DTO\EducationDTO;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;

class JsonEducationRepository implements EducationRepositoryInterface
{
    protected string $path;

    public function __construct(?string $path = null)
    {
        $this->path = $path ?? base_path('content/education.json');
    }

    public function all(string $locale = 'fr'): Collection
    {
        $cacheKey = "education.all.{$locale}.".md5($this->path);

        $cached = Cache::remember($cacheKey, 3600, function () use ($locale) {
            if (! File::exists($this->path)) {
                return [];
            }

            $data = json_decode(File::get($this->path), true);

            return collect($data)
                ->filter(fn ($edu) => $edu['is_active'] ?? true)
                ->map(function ($edu) use ($locale) {
                    return [
                        'degree' => $edu['degree'][$locale] ?? $edu['degree']['fr'] ?? '',
                        'institution' => $edu['institution'][$locale] ?? $edu['institution']['fr'] ?? '',
                        'description' => $edu['description'][$locale] ?? $edu['description']['fr'] ?? '',
                        'duration' => $edu['duration'],
                        'startDate' => $edu['start_date'] ?? null,
                        'endDate' => $edu['end_date'] ?? null,
                        'location' => $edu['location'] ?? null,
                        'institutionUrl' => $edu['institution_url'] ?? null,
                        'institutionLogo' => $edu['institution_logo'] ?? null,
                        'order' => $edu['order'],
                        'isActive' => $edu['is_active'] ?? true,
                    ];
                })
                ->sortBy('order')
                ->values()
                ->toArray();
        });

        return collect($cached)->map(fn ($data) => new EducationDTO(
            degree: $data['degree'],
            institution: $data['institution'],
            description: $data['description'],
            duration: $data['duration'],
            startDate: $data['startDate'] ?? null,
            endDate: $data['endDate'] ?? null,
            location: $data['location'] ?? null,
            institutionUrl: $data['institutionUrl'] ?? null,
            institutionLogo: $data['institutionLogo'] ?? null,
            order: $data['order'],
            isActive: $data['isActive'],
        ));
    }
}
