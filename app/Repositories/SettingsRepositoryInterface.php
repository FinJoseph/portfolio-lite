<?php

namespace App\Repositories;

use App\DTO\SettingsDTO;

interface SettingsRepositoryInterface
{
    public function get(string $locale = 'fr'): SettingsDTO;
}
