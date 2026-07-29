<?php

namespace App\Repositories;

use App\DTO\ProjectDTO;
use Illuminate\Support\Collection;

// L'interface définit LE CONTRAT : peu importe l'implémentation (fichiers, BDD, API externe...),
// n'importe quelle classe qui l'implémente DOIT fournir ces 2 méthodes
interface ProjectRepositoryInterface
{
    public function all(string $locale = 'fr'): Collection;

    public function findBySlug(string $slug, string $locale = 'fr'): ?ProjectDTO;
}
