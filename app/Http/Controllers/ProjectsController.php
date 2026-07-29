<?php

namespace App\Http\Controllers;

use App\DTO\ProjectDTO;
use App\Repositories\ProjectRepositoryInterface;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ProjectsController extends Controller
{
    public function __construct(
        protected ProjectRepositoryInterface $projects,
    ) {}

    public function index(Request $request): Response
    {
        $locale = app()->getLocale();

        $all = $this->projects->all($locale);

        $categories = $all
            ->pluck('category')
            ->unique()
            ->sort()
            ->values();

        $technologies = $all
            ->pluck('technologies')
            ->flatten()
            ->unique()
            ->sort()
            ->values();

        $projects = $all
            ->map(fn (ProjectDTO $p) => $p->toArray())
            ->values()
            ->all();

        return Inertia::render('Projects/Index', [
            'projects' => $projects,
            'categories' => $categories,
            'technologies' => $technologies,
        ]);
    }

    public function show(string $slug): Response
    {
        $locale = app()->getLocale();

        $project = $this->projects->findBySlug($slug, $locale);

        if (! $project) {
            abort(404);
        }

        $all = $this->projects->all($locale);
        $related = $all
            ->filter(fn (ProjectDTO $p) => (
                $p->slug !== $slug &&
                array_intersect($p->technologies, $project->technologies)
            ))
            ->take(3)
            ->map(fn (ProjectDTO $p) => $p->toArray())
            ->values()
            ->all();

        return Inertia::render('Projects/Show', [
            'project' => $project->toArray(),
            'relatedProjects' => $related,
        ]);
    }
}
