<?php

namespace App\Repositories;

use Illuminate\Support\Collection;

interface ExperienceRepositoryInterface
{
    // locale requis, comme pour Project, car le contenu change selon la langue
    public function all(string $locale = 'fr'): Collection;
}
