<?php

use App\Repositories\JsonExperienceRepository;
use Illuminate\Support\Facades\File;

beforeEach(function () {
    $this->testPath = storage_path('framework/testing/experiences-test.json');
    File::ensureDirectoryExists(dirname($this->testPath));

    File::put($this->testPath, json_encode([
        [
            'title' => [
                'fr' => 'Développeur Web',
                'en' => 'Web Developer',
                // volontairement PAS de "mg" ici, pour tester le repli sur "fr"
            ],
            'company' => [
                'fr' => 'Freelance',
                'en' => 'Freelance',
            ],
            'description' => [
                'fr' => 'Description en français',
                'en' => 'English description',
            ],
            'duration' => '2024 - Présent',
            'start_date' => '2024-01',
            'end_date' => null,
            'location' => 'Antananarivo, Madagascar',
            'company_url' => 'https://example.com',
            'company_logo' => '/images/companies/freelance.png',
            'order' => 1,
            'is_active' => true,
        ],
        [
            'title' => ['fr' => 'Stage', 'en' => 'Internship'],
            'company' => ['fr' => 'ACME', 'en' => 'ACME'],
            'description' => ['fr' => 'Stage description', 'en' => 'Internship description'],
            'duration' => '2023',
            'order' => 2,
            'is_active' => false, // désactivé, pour tester le filtre
        ],
        [
            // Entrée volontairement "à l'ancienne" (avant enrichissement) : aucun des nouveaux
            // champs n'est présent. Simule un vieux JSON pas encore migré.
            'title' => ['fr' => 'Ancien poste'],
            'company' => ['fr' => 'Ancienne Entreprise'],
            'description' => ['fr' => 'Ancienne description'],
            'duration' => '2022',
            'order' => 3,
            'is_active' => true,
        ],
    ]));
});

afterEach(function () {
    File::delete($this->testPath);
});

it('retourne le contenu dans la langue demandée', function () {
    $repository = new JsonExperienceRepository($this->testPath);
    $experiences = $repository->all('en');

    expect($experiences->first()->title)->toBe('Web Developer');
    expect($experiences->first()->description)->toBe('English description');
});

it('se replie sur le français si la langue demandée n\'existe pas', function () {
    $repository = new JsonExperienceRepository($this->testPath);
    // "mg" n'existe pas dans le JSON de test → doit retourner la version "fr"
    $experiences = $repository->all('mg');

    expect($experiences->first()->title)->toBe('Développeur Web');
});

it('filtre les experiences inactives', function () {
    $repository = new JsonExperienceRepository($this->testPath);
    $experiences = $repository->all('fr');

    expect($experiences)->toHaveCount(2);
    expect($experiences->pluck('title'))->not->toContain('Stage');
});

it('trie les experiences par ordre', function () {
    $repository = new JsonExperienceRepository($this->testPath);
    $experiences = $repository->all('fr');

    expect($experiences->pluck('order')->toArray())->toBe([1, 3]);
});

it('lit correctement les nouveaux champs enrichis', function () {
    $repository = new JsonExperienceRepository($this->testPath);
    $experience = $repository->all('fr')->first();

    expect($experience->startDate)->toBe('2024-01');
    expect($experience->endDate)->toBeNull();
    expect($experience->location)->toBe('Antananarivo, Madagascar');
    expect($experience->companyUrl)->toBe('https://example.com');
    expect($experience->companyLogo)->toBe('/images/companies/freelance.png');
});

it('gère une entrée sans les nouveaux champs sans planter (rétrocompatibilité)', function () {
    $repository = new JsonExperienceRepository($this->testPath);
    $oldEntry = $repository->all('fr')->firstWhere('title', 'Ancien poste');

    expect($oldEntry->startDate)->toBeNull();
    expect($oldEntry->endDate)->toBeNull();
    expect($oldEntry->location)->toBeNull();
    expect($oldEntry->companyUrl)->toBeNull();
    expect($oldEntry->companyLogo)->toBeNull();
});
