<?php

namespace App\Console\Commands;

use App\Repositories\ArticleRepositoryInterface;
use App\Repositories\ProjectRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;

class GenerateSitemap extends Command
{
    protected $signature = 'sitemap:generate';
    protected $description = 'Generate the XML sitemap';

    public function handle(
        ProjectRepositoryInterface $projects,
        ArticleRepositoryInterface $articles,
    ): int {
        $this->info('Generating sitemap...');

        $siteUrl = rtrim(config('app.url') ?: url('/'), '/');

        $sitemap = Sitemap::create();

        $sitemap->add(Url::create('/')->setPriority(1.0)->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY));
        $sitemap->add(Url::create('/about')->setPriority(0.8)->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY));
        $sitemap->add(Url::create('/skills')->setPriority(0.8)->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY));
        $sitemap->add(Url::create('/projects')->setPriority(0.9)->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY));
        $sitemap->add(Url::create('/blog')->setPriority(0.8)->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY));
        $sitemap->add(Url::create('/testimonials')->setPriority(0.6)->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY));
        $sitemap->add(Url::create('/contact')->setPriority(0.7)->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY));

        foreach (['fr', 'en', 'mg'] as $locale) {
            foreach ($projects->all($locale) as $project) {
                $sitemap->add(Url::create("/projects/{$project->slug}")
                    ->setPriority(0.7)
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
                    ->setLastModificationDate(Carbon::parse($project->completedAt ?? now())));
            }

            foreach ($articles->all($locale) as $article) {
                $sitemap->add(Url::create("/blog/{$article->slug}")
                    ->setPriority(0.7)
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
                    ->setLastModificationDate(Carbon::parse($article->publishedAt ?? now())));
            }
        }

        $sitemap->writeToFile(public_path('sitemap.xml'));

        $this->info('Sitemap generated at public/sitemap.xml');
        return Command::SUCCESS;
    }
}
