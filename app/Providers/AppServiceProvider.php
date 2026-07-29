<?php

namespace App\Providers;

use App\Events\ContactMessageSubmitted;
use App\Listeners\LogContactMessage;
use App\Listeners\SendContactEmail;
use App\Listeners\SendWebhookNotification;
use App\Repositories\ArticleRepositoryInterface;
use App\Repositories\EducationRepositoryInterface;
use App\Repositories\ExperienceRepositoryInterface;
use App\Repositories\FileArticleRepository;
use App\Repositories\FileProjectRepository;
use App\Repositories\JsonEducationRepository;
use App\Repositories\JsonExperienceRepository;
use App\Repositories\JsonSettingsRepository;
use App\Repositories\JsonSkillRepository;
use App\Repositories\JsonTestimonialRepository;
use App\Repositories\ProjectRepositoryInterface;
use App\Repositories\SettingsRepositoryInterface;
use App\Repositories\SkillRepositoryInterface;
use App\Repositories\TestimonialRepositoryInterface;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Chaque fois qu'une classe demande ProjectRepositoryInterface (via injection de dépendances),
        // Laravel lui donnera automatiquement une instance de FileProjectRepository
        $this->app->bind(
            ProjectRepositoryInterface::class,
            FileProjectRepository::class
        );

        // AJOUT
        $this->app->bind(
            SkillRepositoryInterface::class,
            JsonSkillRepository::class
        );

        $this->app->bind(
            ExperienceRepositoryInterface::class,
            JsonExperienceRepository::class
        );

        $this->app->bind(
            TestimonialRepositoryInterface::class,
            JsonTestimonialRepository::class
        );

        $this->app->bind(
            SettingsRepositoryInterface::class,
            JsonSettingsRepository::class
        );

        $this->app->bind(
            ArticleRepositoryInterface::class,
            FileArticleRepository::class
        );

        $this->app->bind(
            EducationRepositoryInterface::class,
            JsonEducationRepository::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Event::listen(ContactMessageSubmitted::class, SendContactEmail::class);
        Event::listen(ContactMessageSubmitted::class, SendWebhookNotification::class);
        Event::listen(ContactMessageSubmitted::class, LogContactMessage::class);
    }
}
