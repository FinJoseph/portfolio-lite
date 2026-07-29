<?php

namespace App\Http\Controllers;

use App\Repositories\EducationRepositoryInterface;
use App\Repositories\ExperienceRepositoryInterface;
use Inertia\Inertia;

class AboutController extends Controller
{
    public function __construct(
        protected ExperienceRepositoryInterface $experiences,
        protected EducationRepositoryInterface $education,
    ) {}

    public function __invoke()
    {
        $locale = app()->getLocale();

        $experiences = $this->experiences->all($locale)
            ->where('isActive', true)
            ->sortBy('order')
            ->values();

        $education = $this->education->all($locale)
            ->where('isActive', true)
            ->sortBy('order')
            ->values();

        return Inertia::render('About', [
            'experiences' => $experiences,
            'education' => $education,
        ]);
    }
}
