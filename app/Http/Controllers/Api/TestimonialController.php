<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\TestimonialRepositoryInterface;
use Illuminate\Http\JsonResponse;

class TestimonialController extends Controller
{
    public function __construct(
        protected TestimonialRepositoryInterface $testimonials,
    ) {}

    public function index(): JsonResponse
    {
        $testimonials = $this->testimonials->all()->map->toArray()->values();

        return response()->json(['data' => $testimonials]);
    }
}
