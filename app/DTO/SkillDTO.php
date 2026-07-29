<?php

namespace App\DTO;

class SkillDTO
{
    public function __construct(
        public readonly string $name,
        public readonly string $icon,
        public readonly int $level,
        public readonly string $category,
        public readonly string $description,
        /** @var string[] */
        public readonly array $relatedSkills,
        public readonly int $order,
        public readonly bool $isActive,
    ) {}

    /**
     * Serialize the DTO to the array shape expected by Vue/Inertia.
     *
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'slug' => \Illuminate\Support\Str::slug($this->name),
            'icon' => $this->icon,
            'level' => $this->level,
            'category' => $this->category,
            'description' => $this->description,
            'relatedSkills' => $this->relatedSkills,
            'order' => $this->order,
            'isActive' => $this->isActive,
        ];
    }
}
