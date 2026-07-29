<?php

namespace App\Http\Controllers;

use App\Repositories\ProjectRepositoryInterface;
use App\Repositories\SkillRepositoryInterface;
use App\Repositories\TestimonialRepositoryInterface;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class HomeController extends Controller
{
    public function __construct(
        protected ProjectRepositoryInterface $projects,
        protected SkillRepositoryInterface $skills,
        protected TestimonialRepositoryInterface $testimonials,
    ) {}

    public function __invoke(Request $request): Response
    {
        $locale = app()->getLocale();

        $skills = $this->skills->all()
            ->take(6)
            ->values();

        $projects = $this->projects->all($locale)
            ->filter(fn ($project) => $project->isFeatured)
            ->take(3)
            ->values();

        $testimonials = $this->testimonials->all()
            ->sortByDesc('rating')
            ->take(3)
            ->values();

        return Inertia::render('Home', [
            'skills' => $skills,
            'projects' => $projects,
            'testimonials' => $testimonials,
        ]);
    }
}
