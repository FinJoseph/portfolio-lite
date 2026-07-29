<?php

namespace App\Http\Controllers;

use App\Repositories\ArticleRepositoryInterface;
use App\Repositories\ProjectRepositoryInterface;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PreviewController extends Controller
{
    public function project(
        string $slug,
        Request $request,
        ProjectRepositoryInterface $projects,
    ) {
        if (! $request->hasValidSignature()) {
            abort(403, 'Invalid or expired preview link.');
        }

        $locale = app()->getLocale();
        $project = $projects->findBySlug($slug, $locale);

        if (! $project) {
            abort(404);
        }

        return Inertia::render('Projects/Show', [
            'project' => $project->toArray(),
            'relatedProjects' => [],
        ]);
    }

    public function article(
        string $slug,
        Request $request,
        ArticleRepositoryInterface $articles,
    ) {
        if (! $request->hasValidSignature()) {
            abort(403, 'Invalid or expired preview link.');
        }

        $locale = app()->getLocale();
        $article = $articles->findBySlug($slug, $locale);

        if (! $article) {
            abort(404);
        }

        return Inertia::render('Blog/Show', [
            'article' => $article->toArray(),
            'relatedArticles' => [],
        ]);
    }
}
