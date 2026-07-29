<?php

namespace App\Http\Controllers;

use App\DTO\SkillDTO;
use App\Repositories\SkillRepositoryInterface;
use Illuminate\Support\Str;
use Inertia\Inertia;

class SkillsController extends Controller
{
    public function __construct(
        protected SkillRepositoryInterface $skills,
    ) {}

    public function index()
    {
        $grouped = $this->skills->groupedByCategory();

        // Mappe chaque catégorie vers une liste de DTO sous forme d'array.
        $skillsByCategory = $grouped
            ->map(fn ($items) => $items->map(fn (SkillDTO $skill) => $skill->toArray())->values()->all())
            ->all();

        // Liste plate pour la recherche, l'ItemList JSON-LD et le calcul du nombre total.
        $flat = $this->skills->all()
            ->map(fn (SkillDTO $skill) => $skill->toArray())
            ->values()
            ->all();

        return Inertia::render('Skills/Index', [
            'skillsByCategory' => $skillsByCategory,
            'skills' => $flat,
        ]);
    }

    public function show(string $slug)
    {
        $skill = $this->skills->all()
            ->first(fn (SkillDTO $s) => Str::slug($s->name) === $slug);

        if (! $skill) {
            abort(404);
        }

        // Résolution des skills reliées par nom (toutes locales, peu importe la catégorie).
        $all = $this->skills->all();
        $related = $all
            ->filter(fn (SkillDTO $s) => in_array($s->name, $skill->relatedSkills, true))
            ->map(fn (SkillDTO $s) => $s->toArray())
            ->values()
            ->all();

        return Inertia::render('Skills/Show', [
            'skill' => $skill->toArray(),
            'relatedSkills' => $related,
        ]);
    }
}
