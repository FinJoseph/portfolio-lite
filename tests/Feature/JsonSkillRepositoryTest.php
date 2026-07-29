<?php

use App\Repositories\JsonSkillRepository;
use Illuminate\Support\Facades\File;

beforeEach(function () {
    // Ici c'est un FICHIER, pas un dossier — on crée un chemin de fichier temporaire isolé
    $this->testPath = storage_path('framework/testing/skills-test.json');

    // On s'assure que le dossier parent existe avant d'écrire dedans
    File::ensureDirectoryExists(dirname($this->testPath));

    // On écrit un faux fichier skills.json, avec un skill actif et un désactivé
    File::put($this->testPath, json_encode([
        [
            'name' => 'Laravel',
            'icon' => 'laravel',
            'level' => 85,
            'category' => 'backend',
            'description' => 'Framework PHP robuste.',
            'related_skills' => ['PHP', 'MySQL'],
            'order' => 1,
            'is_active' => true,
        ],
        [
            'name' => 'jQuery',
            'icon' => 'jquery',
            'level' => 40,
            'category' => 'frontend',
            'order' => 2,
            'is_active' => false, // désactivé volontairement, pour tester le filtre
        ],
        [
            'name' => 'Vue.js',
            'icon' => 'vuejs',
            'level' => 75,
            'category' => 'frontend',
            // Entrée volontairement "à l'ancienne" : pas de description ni related_skills,
            // pour tester la rétrocompatibilité
            'order' => 3,
            'is_active' => true,
        ],
    ]));
});

afterEach(function () {
    // Nettoyage : on supprime le fichier de test après chaque test
    File::delete($this->testPath);
});

it('peut lire et parser le fichier skills.json', function () {
    $repository = new JsonSkillRepository($this->testPath);
    $skills = $repository->all();

    // On attend 2 skills, pas 3 : jQuery est filtré car is_active = false
    expect($skills)->toHaveCount(2);
    expect($skills->first()->name)->toBe('Laravel');
});

it('filtre les skills inactifs', function () {
    $repository = new JsonSkillRepository($this->testPath);
    $skills = $repository->all();

    // On vérifie qu'aucun skill retourné ne s'appelle 'jQuery'
    expect($skills->pluck('name'))->not->toContain('jQuery');
});

it('trie les skills par ordre', function () {
    $repository = new JsonSkillRepository($this->testPath);
    $skills = $repository->all();

    // Laravel (order:1) doit être avant Vue.js (order:3)
    expect($skills->first()->name)->toBe('Laravel');
    expect($skills->last()->name)->toBe('Vue.js');
});

it('groupe les skills par catégorie', function () {
    $repository = new JsonSkillRepository($this->testPath);
    $grouped = $repository->groupedByCategory();

    // On doit avoir 2 groupes : "backend" et "frontend"
    expect($grouped)->toHaveKey('backend');
    expect($grouped)->toHaveKey('frontend');
    // Le groupe "backend" ne doit contenir que Laravel (1 seul skill actif dans cette catégorie)
    expect($grouped->get('backend'))->toHaveCount(1);
});

it('retourne une collection vide si le fichier n\'existe pas', function () {
    $repository = new JsonSkillRepository(storage_path('framework/testing/fichier-inexistant.json'));
    $skills = $repository->all();

    expect($skills)->toHaveCount(0);
});

it('lit correctement description et related_skills', function () {
    $repository = new JsonSkillRepository($this->testPath);
    $laravel = $repository->all()->firstWhere('name', 'Laravel');

    expect($laravel->description)->toBe('Framework PHP robuste.');
    expect($laravel->relatedSkills)->toBe(['PHP', 'MySQL']);
});

it('gère un skill sans description ni related_skills sans planter (rétrocompatibilité)', function () {
    $repository = new JsonSkillRepository($this->testPath);
    $vuejs = $repository->all()->firstWhere('name', 'Vue.js');

    expect($vuejs->description)->toBe('');
    expect($vuejs->relatedSkills)->toBe([]);
});
