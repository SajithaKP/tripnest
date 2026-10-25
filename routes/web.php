<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminReviewController;
use App\Http\Controllers\AdminSettingController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\Admin\TravelManagementController;

// ======================================================
// PUBLIC WEBSITE
// ======================================================

Route::get('/', [HomeController::class, 'index'])
    ->name('home');

Route::get('/packages/{package:slug}', [PackageController::class, 'show'])
    ->name('packages.show');

Route::post('/contact', [ContactController::class, 'store'])
    ->name('contact.store');


// ======================================================
// CUSTOMER REVIEWS
// ======================================================

Route::get('/review', [ReviewController::class, 'create'])
    ->name('review.create');

Route::post('/review', [ReviewController::class, 'store'])
    ->name('review.store');


// ======================================================
// ADMIN LOGIN
// ======================================================

Route::get('/admin/login', [AdminAuthController::class, 'loginForm'])
    ->name('admin.login');

Route::post('/admin/login', [AdminAuthController::class, 'login'])
    ->name('admin.login.submit');

Route::post('/admin/logout', [AdminAuthController::class, 'logout'])
    ->name('admin.logout');


// ======================================================
// ADMIN PANEL
// ======================================================

Route::prefix('admin')
    ->name('admin.')
    ->middleware('admin.auth')
    ->group(function () {

        // ----------------------------------------------
        // DASHBOARD
        // ----------------------------------------------

        Route::get('/', [AdminController::class, 'dashboard'])
            ->name('dashboard');

        // ==================================================
        // WEBSITE SETTINGS
        // IMPORTANT: BEFORE /{type}
        // ==================================================

        Route::get('/settings', [AdminSettingController::class, 'index'])
            ->name('settings');

        Route::post('/settings/logo', [AdminSettingController::class, 'updateLogo'])
            ->name('settings.logo');

        // ----------------------------------------------
        // CUSTOMER REVIEWS
        // IMPORTANT: MUST COME BEFORE /{type}
        // ----------------------------------------------

        Route::get('/reviews', [AdminReviewController::class, 'index'])
            ->name('reviews.index');

        Route::post('/reviews/{review}/approve', [AdminReviewController::class, 'approve'])
            ->name('reviews.approve');

        Route::post('/reviews/{review}/reject', [AdminReviewController::class, 'reject'])
            ->name('reviews.reject');

        Route::delete('/reviews/{review}', [AdminReviewController::class, 'destroy'])
            ->name('reviews.destroy');


        Route::prefix('travel-management')
        ->name('travel-management.')
        ->controller(TravelManagementController::class)
        ->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::post('/', 'store')->name('store');
            Route::get('/{travelRecord}/edit', 'edit')->name('edit');
            Route::put('/{travelRecord}', 'update')->name('update');
            Route::delete('/{travelRecord}', 'destroy')->name('destroy');
        });


        // ----------------------------------------------
        // GENERIC CONTENT MANAGEMENT
        // ----------------------------------------------

        Route::get('/{type}', [AdminController::class, 'index'])
            ->name('content.index');

        Route::get('/{type}/create', [AdminController::class, 'create'])
            ->name('content.create');

        Route::post('/{type}', [AdminController::class, 'store'])
            ->name('content.store');

        Route::get('/{type}/{id}/edit', [AdminController::class, 'edit'])
            ->name('content.edit');

        Route::put('/{type}/{id}', [AdminController::class, 'update'])
            ->name('content.update');

        Route::delete('/{type}/{id}', [AdminController::class, 'destroy'])
            ->name('content.destroy');

        
    });
    
    
    Route::get('/sitemap.xml', function () {
    $packages = \App\Models\Package::where('active', 1)
        ->whereNotNull('slug')
        ->get();

    return response()
        ->view('sitemap', compact('packages'))
        ->header('Content-Type', 'application/xml');
});
