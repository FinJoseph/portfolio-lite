<?php

namespace App\Console\Commands;

use App\Repositories\ArticleRepositoryInterface;
use App\Repositories\ProjectRepositoryInterface;
use App\Repositories\SkillRepositoryInterface;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class GenerateSearchIndex extends Command
{
    protected $signature = 'search:index';
    protected $description = 'Generate search index JSON for client-side Fuse.js search';

    public function handle(
        ProjectRepositoryInterface $projects,
        ArticleRepositoryInterface $articles,
        SkillRepositoryInterface $skills,
    ): int {
        $this->info('Generating search index...');

        $index = [];

        foreach (['fr', 'en', 'mg'] as $locale) {
            foreach ($projects->all($locale) as $project) {
                $index[] = [
                    'type' => 'project',
                    'title' => $project->title,
                    'slug' => $project->slug,
                    'excerpt' => $project->excerpt,
                    'url' => "/projects/{$project->slug}",
                    'locale' => $locale,
                ];
            }

            foreach ($articles->all($locale) as $article) {
                $index[] = [
                    'type' => 'article',
                    'title' => $article->title,
                    'slug' => $article->slug,
                    'excerpt' => $article->excerpt,
                    'url' => "/blog/{$article->slug}",
                    'locale' => $locale,
                ];
            }
        }

        foreach ($skills->all() as $skill) {
            $index[] = [
                'type' => 'skill',
                'title' => $skill->name,
                'slug' => Str::slug($skill->name),
                'excerpt' => $skill->description,
                'url' => '/skills/'.Str::slug($skill->name),
                'locale' => 'all',
            ];
        }

        File::put(public_path('search-index.json'), json_encode($index, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));

        $this->info('Search index generated at public/search-index.json');
        return Command::SUCCESS;
    }
}
