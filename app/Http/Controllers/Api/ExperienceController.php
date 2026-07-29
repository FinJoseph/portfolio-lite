<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\ExperienceRepositoryInterface;
use Illuminate\Http\JsonResponse;

class ExperienceController extends Controller
{
    public function __construct(
        protected ExperienceRepositoryInterface $experiences,
    ) {}

    public function index(): JsonResponse
    {
        $locale = app()->getLocale();
        $experiences = $this->experiences->all($locale)->map->toArray()->values();

        return response()->json(['data' => $experiences]);
    }
}
