<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\EducationRepositoryInterface;
use Illuminate\Http\JsonResponse;

class EducationController extends Controller
{
    public function __construct(
        protected EducationRepositoryInterface $education,
    ) {}

    public function index(): JsonResponse
    {
        $locale = app()->getLocale();
        $education = $this->education->all($locale)->map->toArray()->values();

        return response()->json(['data' => $education]);
    }
}
