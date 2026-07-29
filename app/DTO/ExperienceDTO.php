<?php

namespace App\DTO;

class ExperienceDTO
{
    public function __construct(
        // Contrairement à SkillDTO, ces 3 champs sont DÉJÀ résolus dans la bonne langue
        // (la traduction se fait dans le Repository, pas ici)
        public readonly string $title,
        public readonly string $company,
        public readonly string $description,
        public readonly string $duration,
        public readonly ?string $startDate,
        public readonly ?string $endDate,
        public readonly ?string $location,
        public readonly ?string $companyUrl,
        public readonly ?string $companyLogo,
        public readonly int $order,
        public readonly bool $isActive,
    ) {}

    public function toArray(): array
    {
        return [
            'title' => $this->title,
            'company' => $this->company,
            'description' => $this->description,
            'duration' => $this->duration,
            'start_date' => $this->startDate,
            'end_date' => $this->endDate,
            'location' => $this->location,
            'company_url' => $this->companyUrl,
            'company_logo' => $this->companyLogo,
            'order' => $this->order,
            'is_active' => $this->isActive,
        ];
    }
}
