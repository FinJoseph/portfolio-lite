<?php

use App\Http\Controllers\Api\EducationController;
use App\Http\Controllers\Api\ExperienceController;
use App\Http\Controllers\Api\ProjectController;
use App\Http\Controllers\Api\SkillController;
use App\Http\Controllers\Api\TestimonialController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->name('api.v1.')->group(function () {
    Route::get('/projects', [ProjectController::class, 'index'])->name('projects.index');
    Route::get('/projects/{slug}', [ProjectController::class, 'show'])->name('projects.show');

    Route::get('/skills', [SkillController::class, 'index'])->name('skills.index');

    Route::get('/experiences', [ExperienceController::class, 'index'])->name('experiences.index');

    Route::get('/education', [EducationController::class, 'index'])->name('education.index');

    Route::get('/testimonials', [TestimonialController::class, 'index'])->name('testimonials.index');
});
