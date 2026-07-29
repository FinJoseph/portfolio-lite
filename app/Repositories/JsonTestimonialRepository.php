<?php

namespace App\Repositories;

use App\DTO\TestimonialDTO;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;

class JsonTestimonialRepository implements TestimonialRepositoryInterface
{
    protected string $path;

    public function __construct(?string $path = null)
    {
        $this->path = $path ?? base_path('content/testimonials.json');
    }

    public function all(): Collection
    {
        $cacheKey = 'testimonials.all.'.md5($this->path);

        $cached = Cache::remember($cacheKey, 3600, function () {
            if (! File::exists($this->path)) {
                return [];
            }

            $data = json_decode(File::get($this->path), true);

            return collect($data)
                ->filter(fn ($t) => $t['is_active'] ?? true)
                // On s'assure que le rating reste dans la plage valide 1-5,
                // même si le fichier JSON contient une erreur de saisie
                ->filter(fn ($t) => ($t['rating'] ?? 0) >= 1 && ($t['rating'] ?? 0) <= 5)
                ->map(function ($t) {
                    return [
                        'name' => $t['name'],
                        'email' => $t['email'],
                        'company' => $t['company'] ?? null,
                        // ?? null protège contre un vieux cache/JSON sans ces champs
                        'jobTitle' => $t['job_title'] ?? null,
                        'message' => $t['message'],
                        'rating' => $t['rating'],
                        'photo' => $t['photo'] ?? null,
                        'submittedAt' => $t['submitted_at'] ?? null,
                        'order' => $t['order'],
                        'is_active' => $t['is_active'] ?? true,
                    ];
                })
                ->sortBy('order')
                ->values()
                ->toArray();
        });

        return collect($cached)->map(fn ($data) => new TestimonialDTO(
            name: $data['name'],
            email: $data['email'],
            company: $data['company'] ?? null,
            jobTitle: $data['jobTitle'] ?? null,
            message: $data['message'],
            rating: $data['rating'],
            photo: $data['photo'] ?? null,
            submittedAt: $data['submittedAt'] ?? null,
            order: $data['order'],
            isActive: $data['is_active'] ?? true,
        ));
    }
}
