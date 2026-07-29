<?php

use App\Repositories\SkillRepositoryInterface;
use Illuminate\Support\Facades\File;

beforeEach(function () {
    $this->testPath = storage_path('framework/testing/skills-route.json');
    File::ensureDirectoryExists(dirname($this->testPath));

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
            'name' => 'PHP',
            'icon' => 'php',
            'level' => 80,
            'category' => 'backend',
            'description' => 'Langage de script côté serveur.',
            'related_skills' => ['Laravel'],
            'order' => 2,
            'is_active' => true,
        ],
        [
            'name' => 'MySQL',
            'icon' => 'mysql',
            'level' => 75,
            'category' => 'database',
            'description' => 'Base de données relationnelle.',
            'related_skills' => ['Laravel'],
            'order' => 3,
            'is_active' => true,
        ],
        [
            'name' => 'Vue.js',
            'icon' => 'vuejs',
            'level' => 75,
            'category' => 'frontend',
            'description' => 'Framework JavaScript progressif.',
            'related_skills' => ['Tailwind CSS'],
            'order' => 4,
            'is_active' => true,
        ],
        [
            'name' => 'Tailwind CSS',
            'icon' => 'tailwindcss',
            'level' => 80,
            'category' => 'frontend',
            'description' => 'Framework CSS utility-first.',
            'related_skills' => ['Vue.js'],
            'order' => 5,
            'is_active' => true,
        ],
        [
            'name' => 'Hidden Skill',
            'icon' => 'unknown',
            'level' => 10,
            'category' => 'misc',
            'description' => 'Ne doit pas apparaître publiquement.',
            'related_skills' => [],
            'order' => 6,
            'is_active' => false,
        ],
    ]));

    $this->app->instance(
        SkillRepositoryInterface::class,
        new \App\Repositories\JsonSkillRepository($this->testPath),
    );

    \Illuminate\Support\Facades\Cache::flush();
    app()->setLocale('fr');
});

afterEach(function () {
    if (File::exists($this->testPath)) {
        File::delete($this->testPath);
    }
});

it('affiche la page index des skills groupés par catégorie', function () {
    $response = $this->get('/skills');

    $response->assertStatus(200);
    $response->assertInertia(fn ($page) => $page
        ->component('Skills/Index')
        ->has('skillsByCategory.backend', 2)
        ->has('skillsByCategory.frontend', 2)
        ->has('skillsByCategory.database', 1)
        ->where('skillsByCategory.backend.0.name', 'Laravel')
        ->where('skillsByCategory.backend.1.name', 'PHP')
        ->where('skillsByCategory.frontend.0.name', 'Vue.js')
        ->where('skillsByCategory.frontend.1.name', 'Tailwind CSS')
        ->where('skillsByCategory.database.0.name', 'MySQL')
        ->has('skills', 5)
    );
});

it("n'expose pas les skills désactivés sur la page index", function () {
    $response = $this->get('/skills');

    $response->assertInertia(fn ($page) => $page
        ->where('skills', fn ($skills) => collect($skills)->every(fn ($s) => $s['name'] !== 'Hidden Skill'))
    );
});

it("affiche la page show d'une skill existante avec ses skills reliées", function () {
    $response = $this->get('/skills/laravel');

    $response->assertStatus(200);
    $response->assertInertia(fn ($page) => $page
        ->component('Skills/Show')
        ->where('skill.name', 'Laravel')
        ->where('skill.slug', 'laravel')
        ->has('relatedSkills', 2)
        ->where('relatedSkills.0.name', 'PHP')
        ->where('relatedSkills.1.name', 'MySQL')
    );
});

it("normalise correctement le slug des skills avec espaces et points", function () {
    // Vue.js → vuejs (le point est supprimé par Str::slug)
    $this->get('/skills/vuejs')->assertStatus(200);
    // Tailwind CSS → tailwind-css
    $this->get('/skills/tailwind-css')->assertStatus(200);
});

it('retourne 404 pour une skill inexistante', function () {
    $this->get('/skills/inexistante')->assertStatus(404);
});

it('expose les routes skills.index et skills.show', function () {
    expect(route('skills.index'))->toContain('/skills');
    expect(route('skills.show', 'laravel'))->toContain('/skills/laravel');
});
