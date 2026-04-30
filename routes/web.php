<?php

use App\Http\Controllers\PageController;
use App\Http\Controllers\PartnerController;
use App\Http\Controllers\ServiceViewController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\WelcomeController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', WelcomeController::class)->name('home');
Route::get('/device-test', TestController::class)->name('test');
Route::get('/oferty/{service:slug}', ServiceViewController::class)->name('service');
Route::get('/partner/{slug}', [PartnerController::class, 'show'])->name('partner.show');

Route::get('/dashboard', function () {
    return Inertia::render('dashboard');
})->middleware(['auth', 'disable_routes'])->name('dashboard');

Route::get('/p/{slug}', [PageController::class, 'show'])->name('page');

require __DIR__.'/settings.php';
