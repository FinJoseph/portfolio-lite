<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\CvController;
use App\Http\Controllers\HealthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PreviewController;
use App\Http\Controllers\ProjectsController;
use App\Http\Controllers\SkillsController;
use App\Http\Controllers\TestimonialController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// ↑ facade Inertia : permet de "render" une page Vue depuis une route/contrôleur

Route::get('/', HomeController::class)->name('home');

Route::get('/about', AboutController::class)->name('about');
Route::get('/skills', [SkillsController::class, 'index'])->name('skills.index');
Route::get('/skills/{slug}', [SkillsController::class, 'show'])->name('skills.show');
Route::get('/projects', [ProjectsController::class, 'index'])->name('projects.index');
Route::get('/projects/{slug}', [ProjectsController::class, 'show'])->name('projects.show');
Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{slug}', [BlogController::class, 'show'])->name('blog.show');
Route::get('/feed.xml', [BlogController::class, 'feed'])->name('blog.feed');
Route::get('/testimonials', TestimonialController::class)->name('testimonials');
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact', [ContactController::class, 'store'])
    ->middleware('throttle:5,1')
    ->name('contact.store');

Route::get('/cv/{locale?}', [CvController::class, 'download'])->name('cv.download')->where('locale', 'fr|en|mg');
Route::get('/up', HealthController::class)->name('health');

Route::get('/preview/project/{slug}', [PreviewController::class, 'project'])->name('preview.project')->middleware('signed');
Route::get('/preview/article/{slug}', [PreviewController::class, 'article'])->name('preview.article')->middleware('signed');
