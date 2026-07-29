<?php

use App\Repositories\JsonTestimonialRepository;
use Illuminate\Support\Facades\File;

beforeEach(function () {
    $this->testPath = storage_path('framework/testing/testimonials-test.json');
    File::ensureDirectoryExists(dirname($this->testPath));

    File::put($this->testPath, json_encode([
        [
            'name' => 'Jean Rakoto',
            'email' => 'jean@example.com',
            'company' => 'ACME Corp',
            'job_title' => 'CEO',
            'message' => 'Excellent travail.',
            'rating' => 5,
            'photo' => null,
            'submitted_at' => '2026-05-12',
            'order' => 1,
            'is_active' => true,
        ],
        [
            'name' => 'Marie Rasoa',
            'email' => 'marie@example.com',
            'company' => null,
            // Entrée volontairement "à l'ancienne" : pas de job_title ni submitted_at,
            // pour tester la rétrocompatibilité
            'message' => 'Site livré à temps.',
            'rating' => 4,
            'photo' => null,
            'order' => 2,
            'is_active' => true,
        ],
        [
            'name' => 'Faux Avis',
            'email' => 'spam@example.com',
            'company' => null,
            'message' => 'Note invalide, ne doit jamais apparaître.',
            'rating' => 7, // rating invalide (au-delà de 5) → doit être filtré
            'photo' => null,
            'order' => 3,
            'is_active' => true,
        ],
        [
            'name' => 'Désactivé',
            'email' => 'inactive@example.com',
            'company' => null,
            'message' => 'Ne doit pas apparaître non plus.',
            'rating' => 3,
            'photo' => null,
            'order' => 4,
            'is_active' => false, // désactivé → doit être filtré
        ],
    ]));
});

afterEach(function () {
    File::delete($this->testPath);
});

it('peut lire les témoignages valides', function () {
    $repository = new JsonTestimonialRepository($this->testPath);
    $testimonials = $repository->all();

    // Seuls Jean et Marie doivent apparaître (2 sur 4)
    expect($testimonials)->toHaveCount(2);
});

it('filtre les ratings invalides (hors 1-5)', function () {
    $repository = new JsonTestimonialRepository($this->testPath);
    $testimonials = $repository->all();

    expect($testimonials->pluck('name'))->not->toContain('Faux Avis');
});

it('filtre les témoignages inactifs', function () {
    $repository = new JsonTestimonialRepository($this->testPath);
    $testimonials = $repository->all();

    expect($testimonials->pluck('name'))->not->toContain('Désactivé');
});

it('accepte un témoignage sans entreprise (nullable)', function () {
    $repository = new JsonTestimonialRepository($this->testPath);
    $testimonials = $repository->all();
    $marie = $testimonials->firstWhere('name', 'Marie Rasoa');

    expect($marie->company)->toBeNull();
});

it('trie les témoignages par ordre', function () {
    $repository = new JsonTestimonialRepository($this->testPath);
    $testimonials = $repository->all();

    expect($testimonials->first()->name)->toBe('Jean Rakoto');
    expect($testimonials->last()->name)->toBe('Marie Rasoa');
});

it('lit correctement job_title et submitted_at', function () {
    $repository = new JsonTestimonialRepository($this->testPath);
    $jean = $repository->all()->firstWhere('name', 'Jean Rakoto');

    expect($jean->jobTitle)->toBe('CEO');
    expect($jean->submittedAt)->toBe('2026-05-12');
});

it('gère un témoignage sans job_title ni submitted_at sans planter (rétrocompatibilité)', function () {
    $repository = new JsonTestimonialRepository($this->testPath);
    $marie = $repository->all()->firstWhere('name', 'Marie Rasoa');

    expect($marie->jobTitle)->toBeNull();
    expect($marie->submittedAt)->toBeNull();
});
