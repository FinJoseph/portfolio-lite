<?php

namespace App\Http\Controllers;

use App\Repositories\TestimonialRepositoryInterface;
use Inertia\Inertia;

class TestimonialController extends Controller
{
    public function __construct(
        protected TestimonialRepositoryInterface $testimonials,
    ) {}

    public function __invoke()
    {
        $testimonials = $this->testimonials->all()
            ->map(fn ($t) => $t->toArray())
            ->values()
            ->all();

        return Inertia::render('Testimonials', [
            'testimonials' => $testimonials,
        ]);
    }
}
