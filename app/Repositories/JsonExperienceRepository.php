<?php

namespace App\Repositories;

use App\DTO\ExperienceDTO;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;

class JsonExperienceRepository implements ExperienceRepositoryInterface
{
    protected string $path;

    public function __construct(?string $path = null)
    {
        $this->path = $path ?? base_path('content/experiences.json');
    }

    public function all(string $locale = 'fr'): Collection
    {
        // La clé de cache inclut la locale, car le résultat change selon la langue demandée
        $cacheKey = "experiences.all.{$locale}.".md5($this->path);

        $cached = Cache::remember($cacheKey, 3600, function () use ($locale) {
            if (! File::exists($this->path)) {
                return [];
            }

            $data = json_decode(File::get($this->path), true);

            return collect($data)
                ->filter(fn ($exp) => $exp['is_active'] ?? true)
                ->map(function ($exp) use ($locale) {
                    // On "résout" les champs multilingues ICI :
                    // on extrait uniquement la langue demandée, avec repli sur le français si absent
                    return [
                        'title' => $exp['title'][$locale] ?? $exp['title']['fr'] ?? '',
                        'company' => $exp['company'][$locale] ?? $exp['company']['fr'] ?? '',
                        'description' => $exp['description'][$locale] ?? $exp['description']['fr'] ?? '',
                        'duration' => $exp['duration'],
                        // Nouveaux champs : ?? null protège contre un vieux cache/JSON
                        // qui ne les contient pas encore (même logique que ProjectDTO)
                        'startDate' => $exp['start_date'] ?? null,
                        'endDate' => $exp['end_date'] ?? null,
                        'location' => $exp['location'] ?? null,
                        'companyUrl' => $exp['company_url'] ?? null,
                        'companyLogo' => $exp['company_logo'] ?? null,
                        'order' => $exp['order'],
                        'isActive' => $exp['is_active'] ?? true,
                    ];
                })
                ->sortBy('order')
                ->values()
                ->toArray();
        });

        return collect($cached)->map(fn ($data) => new ExperienceDTO(
            title: $data['title'],
            company: $data['company'],
            description: $data['description'],
            duration: $data['duration'],
            startDate: $data['startDate'] ?? null,
            endDate: $data['endDate'] ?? null,
            location: $data['location'] ?? null,
            companyUrl: $data['companyUrl'] ?? null,
            companyLogo: $data['companyLogo'] ?? null,
            order: $data['order'],
            isActive: $data['isActive'],
        ));
    }
}
