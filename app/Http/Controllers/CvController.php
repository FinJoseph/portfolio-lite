<?php

namespace App\Http\Controllers;

use App\Repositories\EducationRepositoryInterface;
use App\Repositories\ExperienceRepositoryInterface;
use App\Repositories\SettingsRepositoryInterface;
use App\Repositories\SkillRepositoryInterface;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Response;

class CvController extends Controller
{
    public function __construct(
        protected SettingsRepositoryInterface $settings,
        protected ExperienceRepositoryInterface $experiences,
        protected EducationRepositoryInterface $education,
        protected SkillRepositoryInterface $skills,
    ) {}

    public function download(string $locale = 'fr'): Response
    {
        $data = [
            'settings' => $this->settings->get($locale)->toArray(),
            'experiences' => $this->experiences->all($locale)->map->toArray(),
            'education' => $this->education->all($locale)->map->toArray(),
            'skills' => $this->skills->all()->map->toArray(),
            'locale' => $locale,
        ];

        $pdf = Pdf::loadView('pdf.cv', $data);

        return $pdf->download("cv-{$locale}.pdf");
    }
}
