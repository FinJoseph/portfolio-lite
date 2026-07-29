<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\ProjectRepositoryInterface;
use Illuminate\Http\JsonResponse;

class ProjectController extends Controller
{
    public function __construct(
        protected ProjectRepositoryInterface $projects,
    ) {}

    public function index(): JsonResponse
    {
        $locale = app()->getLocale();
        $projects = $this->projects->all($locale)->map->toArray()->values();

        return response()->json(['data' => $projects]);
    }

    public function show(string $slug): JsonResponse
    {
        $locale = app()->getLocale();
        $project = $this->projects->findBySlug($slug, $locale);

        if (! $project) {
            return response()->json(['message' => 'Not found'], 404);
        }

        return response()->json(['data' => $project->toArray()]);
    }
}
