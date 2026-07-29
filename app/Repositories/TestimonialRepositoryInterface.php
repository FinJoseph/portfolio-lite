<?php

namespace App\Repositories;

use Illuminate\Support\Collection;

interface TestimonialRepositoryInterface
{
    public function all(): Collection;
}
