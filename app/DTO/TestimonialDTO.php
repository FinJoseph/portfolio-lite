<?php

namespace App\DTO;

class TestimonialDTO
{
    public function __construct(
        public readonly string $name,
        public readonly string $email,
        public readonly ?string $company, // ?string = peut être null
        public readonly ?string $jobTitle,
        public readonly string $message,
        public readonly int $rating,
        public readonly ?string $photo,
        public readonly ?string $submittedAt,
        public readonly int $order,
        public readonly bool $isActive,
    ) {}

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'email' => $this->email,
            'company' => $this->company,
            'jobTitle' => $this->jobTitle,
            'message' => $this->message,
            'rating' => $this->rating,
            'photo' => $this->photo,
            'submittedAt' => $this->submittedAt,
            'order' => $this->order,
            'isActive' => $this->isActive,
        ];
    }
}
