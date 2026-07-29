<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\SkillRepositoryInterface;
use Illuminate\Http\JsonResponse;

class SkillController extends Controller
{
    public function __construct(
        protected SkillRepositoryInterface $skills,
    ) {}

    public function index(): JsonResponse
    {
        $skills = $this->skills->all()->map->toArray()->values();

        return response()->json(['data' => $skills]);
    }
}
