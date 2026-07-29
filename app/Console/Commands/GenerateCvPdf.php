<?php

namespace App\Console\Commands;

use App\Repositories\EducationRepositoryInterface;
use App\Repositories\ExperienceRepositoryInterface;
use App\Repositories\SettingsRepositoryInterface;
use App\Repositories\SkillRepositoryInterface;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Console\Command;

class GenerateCvPdf extends Command
{
    protected $signature = 'cv:generate {locale=fr}';
    protected $description = 'Generate CV PDF from content files';

    public function handle(
        SettingsRepositoryInterface $settings,
        ExperienceRepositoryInterface $experiences,
        EducationRepositoryInterface $education,
        SkillRepositoryInterface $skills,
    ): int {
        $locale = $this->argument('locale');

        $data = [
            'settings' => $settings->get($locale)->toArray(),
            'experiences' => $experiences->all($locale)->map->toArray(),
            'education' => $education->all($locale)->map->toArray(),
            'skills' => $skills->all()->map->toArray(),
            'locale' => $locale,
        ];

        $pdf = Pdf::loadView('pdf.cv', $data);
        $path = public_path("cv-{$locale}.pdf");
        $pdf->save($path);

        $this->info("CV PDF generated at {$path}");
        return Command::SUCCESS;
    }
}
