<?php

namespace App\Repositories;

use Illuminate\Support\Collection;

interface SkillRepositoryInterface
{
    public function all(): Collection;

    // Pour l'affichage groupé prévu sur la page /skills (galerie par catégorie)
    public function groupedByCategory(): Collection;
}
