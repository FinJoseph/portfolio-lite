<?php

namespace App\Repositories;

use Illuminate\Support\Collection;

interface EducationRepositoryInterface
{
    // locale requis, comme pour Experience, car le contenu change selon la langue
    public function all(string $locale = 'fr'): Collection;
}
