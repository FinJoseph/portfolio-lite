<?php

namespace App\DTO;

class EducationDTO
{
    public function __construct(
        // degree, institution, description sont DÉJÀ résolus dans la bonne langue
        // (la traduction se fait dans le Repository, jamais dans le DTO)
        public readonly string $degree,
        public readonly string $institution,
        public readonly string $description,
        public readonly string $duration,
        public readonly ?string $startDate,
        public readonly ?string $endDate,
        public readonly ?string $location,
        public readonly ?string $institutionUrl,
        public readonly ?string $institutionLogo,
        public readonly int $order,
        public readonly bool $isActive,
    ) {}

    public function toArray(): array
    {
        return [
            'degree' => $this->degree,
            'institution' => $this->institution,
            'description' => $this->description,
            'duration' => $this->duration,
            'start_date' => $this->startDate,
            'end_date' => $this->endDate,
            'location' => $this->location,
            'institution_url' => $this->institutionUrl,
            'institution_logo' => $this->institutionLogo,
            'order' => $this->order,
            'is_active' => $this->isActive,
        ];
    }
}
