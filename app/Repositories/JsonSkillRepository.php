<?php

namespace App\Repositories;

use App\DTO\SkillDTO;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;

class JsonSkillRepository implements SkillRepositoryInterface
{
    // Ici c'est le chemin d'UN FICHIER (pas un dossier comme pour Project)
    protected string $path;

    public function __construct(?string $path = null)
    {
        // Même principe que pour Project : injectable pour les tests
        $this->path = $path ?? base_path('content/skills.json');
    }

    public function all(): Collection
    {
        $cacheKey = 'skills.all.'.md5($this->path);

        $cached = Cache::remember($cacheKey, 3600, function () {
            if (! File::exists($this->path)) {
                return [];
            }

            // json_decode(..., true) : décode en array PHP associatif (pas en objet stdClass)
            $data = json_decode(File::get($this->path), true);

            return collect($data)
                ->filter(fn ($skill) => $skill['is_active'] ?? true)
                ->map(function ($skill) {
                    return [
                        'name' => $skill['name'],
                        'icon' => $skill['icon'],
                        'level' => $skill['level'],
                        'category' => $skill['category'],
                        // ?? protège contre un vieux cache/JSON qui ne contient pas encore ces champs
                        'description' => $skill['description'] ?? '',
                        'relatedSkills' => $skill['related_skills'] ?? [],
                        'order' => $skill['order'],
                        'is_active' => $skill['is_active'] ?? true,
                    ];
                })
                ->sortBy('order')
                ->values()
                ->toArray();
        });

        return collect($cached)->map(fn ($data) => new SkillDTO(
            name: $data['name'],
            icon: $data['icon'],
            level: $data['level'],
            category: $data['category'],
            description: $data['description'] ?? '',
            relatedSkills: $data['relatedSkills'] ?? [],
            order: $data['order'],
            isActive: $data['is_active'] ?? true,
        ));
    }

    public function groupedByCategory(): Collection
    {
        // groupBy sur une Collection d'objets : on passe une closure qui extrait la clé de groupement
        return $this->all()->groupBy(fn (SkillDTO $skill) => $skill->category);
    }
}
