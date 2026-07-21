<?php

use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DistrictController;
use App\Http\Controllers\FrontOfficeController;
use App\Http\Controllers\LoginLogController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProvinceController;
use App\Http\Controllers\VillageController;
use Illuminate\Support\Facades\Route;

// Redirect root to dashboard or login
Route::get('/', function () {
    return redirect()->route('dashboard');
});

// Guest Routes
Route::middleware('guest')->group(function (): void {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
});

// Authenticated Routes
Route::middleware(['auth', 'active.fo'])->group(function (): void {
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profile Routes
    Route::prefix('profile')->as('profile.')->group(function (): void {
        Route::get('/', [ProfileController::class, 'show'])->name('show');
        Route::get('/edit', [ProfileController::class, 'edit'])->name('edit');
        Route::put('/', [ProfileController::class, 'update'])->name('update');
        Route::get('/password', [ProfileController::class, 'editPassword'])->name('password.edit');
        Route::put('/password', [ProfileController::class, 'updatePassword'])->name('password.update');
    });

    // System Routes
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/{notification}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::get('/activity-logs', [ActivityLogController::class, 'index'])->name('activity-logs.index');
    Route::get('/login-logs', [LoginLogController::class, 'index'])->name('login-logs.index');

    // Super Admin Routes: Front Office REST Resource with UUID binding
    Route::resource('front-offices', FrontOfficeController::class)->parameters([
        'front-offices' => 'user:uuid',
    ]);

    // Front Office & Admin Routes: Members REST Resource with UUID binding
    Route::resource('members', MemberController::class)->parameters([
        'members' => 'member:uuid',
    ]);

    // Master Data Location Routes
    Route::get('/provinces', [ProvinceController::class, 'index'])->name('provinces.index');
    Route::get('/cities', [CityController::class, 'index'])->name('cities.index');
    Route::get('/districts', [DistrictController::class, 'index'])->name('districts.index');
    Route::get('/villages', [VillageController::class, 'index'])->name('villages.index');
});
