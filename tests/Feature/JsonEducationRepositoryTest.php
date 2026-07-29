<?php

use App\Repositories\JsonEducationRepository;
use Illuminate\Support\Facades\File;

beforeEach(function () {
    $this->testPath = storage_path('framework/testing/education-test.json');
    File::ensureDirectoryExists(dirname($this->testPath));

    File::put($this->testPath, json_encode([
        [
            'degree' => [
                'fr' => 'Licence en Informatique',
                'en' => 'Bachelor in Computer Science',
                // volontairement PAS de "mg" ici, pour tester le repli sur "fr"
            ],
            'institution' => [
                'fr' => 'Université d\'Antananarivo',
                'en' => 'University of Antananarivo',
            ],
            'description' => [
                'fr' => 'Description en français',
                'en' => 'English description',
            ],
            'duration' => '2021 - 2024',
            'start_date' => '2021-09',
            'end_date' => '2024-06',
            'location' => 'Antananarivo, Madagascar',
            'institution_url' => 'https://example.edu',
            'institution_logo' => '/images/schools/univ.png',
            'order' => 1,
            'is_active' => true,
        ],
        [
            'degree' => ['fr' => 'Baccalauréat', 'en' => 'High School Diploma'],
            'institution' => ['fr' => 'Lycée X', 'en' => 'X High School'],
            'description' => ['fr' => 'Série scientifique', 'en' => 'Science track'],
            'duration' => '2021',
            'order' => 2,
            'is_active' => false, // désactivé, pour tester le filtre
        ],
    ]));
});

afterEach(function () {
    File::delete($this->testPath);
});

it('retourne le contenu dans la langue demandée', function () {
    $repository = new JsonEducationRepository($this->testPath);
    $education = $repository->all('en');

    expect($education->first()->degree)->toBe('Bachelor in Computer Science');
    expect($education->first()->description)->toBe('English description');
});

it('se replie sur le français si la langue demandée n\'existe pas', function () {
    $repository = new JsonEducationRepository($this->testPath);
    // "mg" n'existe pas dans le JSON de test → doit retourner la version "fr"
    $education = $repository->all('mg');

    expect($education->first()->degree)->toBe('Licence en Informatique');
});

it('filtre les formations inactives', function () {
    $repository = new JsonEducationRepository($this->testPath);
    $education = $repository->all('fr');

    expect($education)->toHaveCount(1);
    expect($education->pluck('degree'))->not->toContain('Baccalauréat');
});

it('trie les formations par ordre', function () {
    $repository = new JsonEducationRepository($this->testPath);
    $education = $repository->all('fr');

    expect($education->first()->order)->toBe(1);
});

it('lit correctement les champs de dates et de lieu', function () {
    $repository = new JsonEducationRepository($this->testPath);
    $edu = $repository->all('fr')->first();

    expect($edu->startDate)->toBe('2021-09');
    expect($edu->endDate)->toBe('2024-06');
    expect($edu->location)->toBe('Antananarivo, Madagascar');
    expect($edu->institutionUrl)->toBe('https://example.edu');
    expect($edu->institutionLogo)->toBe('/images/schools/univ.png');
});
