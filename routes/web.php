<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\DashboardController;
use Illuminate\Support\Facades\Route;

// =================== PUBLIC ROUTES ===================

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/services', [HomeController::class, 'services'])->name('services');
Route::get('/about', [HomeController::class, 'about'])->name('about');

// Contact
Route::get('/contact', [ContactController::class, 'show'])->name('contact');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

// Booking
Route::get('/booking', [BookingController::class, 'index'])->name('booking');
Route::post('/booking', [BookingController::class, 'store'])->name('booking.store');
Route::get('/booking/success/{appointment}', [BookingController::class, 'success'])->name('booking.success');
Route::get('/booking/available-times', [BookingController::class, 'availableTimes'])->name('booking.times');

// Themes Showcase
Route::get('/themes', [HomeController::class, 'themesShowcase'])->name('themes');
Route::get('/themes/preview/{themeId}', [HomeController::class, 'themePreview'])->name('themes.preview');

// =================== ADMIN AUTH (no middleware) ===================

Route::get('/admin/login', [AdminAuthController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'login'])->name('admin.login.post');
Route::post('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

// =================== ADMIN PROTECTED ROUTES ===================

Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {

    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Appointments
    Route::get('/appointments', [DashboardController::class, 'appointments'])->name('appointments');
    Route::patch('/appointments/{appointment}/status', [DashboardController::class, 'updateStatus'])->name('appointments.status');

    // Services CRUD
    Route::get('/services', [DashboardController::class, 'services'])->name('services');
    Route::post('/services', [DashboardController::class, 'storeService'])->name('services.store');
    Route::get('/services/{service}/edit', [DashboardController::class, 'editService'])->name('services.edit');
    Route::put('/services/{service}', [DashboardController::class, 'updateService'])->name('services.update');
    Route::delete('/services/{service}', [DashboardController::class, 'destroyService'])->name('services.destroy');
    Route::patch('/services/{service}/toggle', [DashboardController::class, 'toggleService'])->name('services.toggle');

    // Branding (colors, logo, favicon)
    Route::get('/branding-settings', [DashboardController::class, 'brandingSettings'])->name('branding-settings');
    Route::put('/branding-settings', [DashboardController::class, 'updateBrandingSettings'])->name('branding-settings.update');

    // Contact & WhatsApp settings
    Route::get('/contact-settings', [DashboardController::class, 'contactSettings'])->name('contact-settings');
    Route::put('/contact-settings', [DashboardController::class, 'updateContactSettings'])->name('contact-settings.update');

    // Hero slider (images + videos)
    Route::get('/hero-slides', [DashboardController::class, 'heroSlides'])->name('hero-slides');
    Route::put('/hero-slides', [DashboardController::class, 'updateHeroSlides'])->name('hero-slides.update');
    Route::redirect('/hero-video', '/admin/hero-slides');

    // Theme Selector
    Route::get('/theme-selector', [DashboardController::class, 'themeSelector'])->name('theme-selector');
    Route::post('/theme-selector', [DashboardController::class, 'setActiveTheme'])->name('theme-selector.set');

    // Contact Messages
    Route::get('/contacts', [DashboardController::class, 'contacts'])->name('contacts');
    Route::patch('/contacts/{message}/read', [DashboardController::class, 'markRead'])->name('contacts.read');
    Route::patch('/contacts/mark-all-read', [DashboardController::class, 'markAllRead'])->name('contacts.markAllRead');
    Route::delete('/contacts/{message}', [DashboardController::class, 'destroyMessage'])->name('contacts.destroy');
});
