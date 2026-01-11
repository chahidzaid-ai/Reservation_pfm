<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ResourceController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\ManagerReservationController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\MaintenanceController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\IncidentController;

Route::get('/', [ResourceController::class, 'publicIndex'])->name('home');

// Auth
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');

// Guest "account request" (simple: creates inactive user with role=user)
Route::get('/account-request', [AuthController::class, 'showAccountRequest'])->name('account.request');
Route::post('/account-request', [AuthController::class, 'accountRequest'])->name('account.request.post');

// Resources (public + authenticated)
Route::get('/resources', [ResourceController::class, 'index'])->name('resources.index');
Route::get('/resources/{resource}', [ResourceController::class, 'show'])->name('resources.show');

// Authenticated area
Route::middleware(['auth', 'active'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Reservations (user)
    Route::get('/reservations', [ReservationController::class, 'index'])->name('reservations.index');
    Route::get('/reservations/create', [ReservationController::class, 'create'])->name('reservations.create');
    Route::post('/reservations', [ReservationController::class, 'store'])->name('reservations.store');
    Route::get('/reservations/{reservation}', [ReservationController::class, 'show'])->name('reservations.show');

    // Notifications inbox
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/{notification}/read', [NotificationController::class, 'markRead'])->name('notifications.read');

    // Incidents
    Route::get('/incidents', [IncidentController::class, 'index'])->name('incidents.index');
    Route::get('/incidents/create', [IncidentController::class, 'create'])->name('incidents.create');
    Route::post('/incidents', [IncidentController::class, 'store'])->name('incidents.store');
    Route::get('/incidents/{incident}', [IncidentController::class, 'show'])->name('incidents.show');

    // Manager area
    Route::middleware(['role:manager,admin'])->prefix('manager')->name('manager.')->group(function () {
        Route::get('/requests', [ManagerReservationController::class, 'index'])->name('requests.index');
        Route::get('/requests/{reservation}', [ManagerReservationController::class, 'show'])->name('requests.show');
        Route::post('/requests/{reservation}/approve', [ManagerReservationController::class, 'approve'])->name('requests.approve');
        Route::post('/requests/{reservation}/refuse', [ManagerReservationController::class, 'refuse'])->name('requests.refuse');
    });

    // Admin area
    Route::middleware(['role:admin'])->prefix('admin')->name('admin.')->group(function () {
        // Users management
        Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
        Route::get('/users/{user}/edit', [AdminUserController::class, 'edit'])->name('users.edit');
        Route::post('/users/{user}', [AdminUserController::class, 'update'])->name('users.update');

        // Resources CRUD
        Route::get('/resources/create', [ResourceController::class, 'create'])->name('resources.create');
        Route::post('/resources', [ResourceController::class, 'store'])->name('resources.store');
        Route::get('/resources/{resource}/edit', [ResourceController::class, 'edit'])->name('resources.edit');
        Route::post('/resources/{resource}', [ResourceController::class, 'update'])->name('resources.update');

        // Maintenance planning
        Route::get('/maintenance', [MaintenanceController::class, 'index'])->name('maintenance.index');
        Route::get('/maintenance/create', [MaintenanceController::class, 'create'])->name('maintenance.create');
        Route::post('/maintenance', [MaintenanceController::class, 'store'])->name('maintenance.store');
        Route::post('/maintenance/{maintenance}/delete', [MaintenanceController::class, 'destroy'])->name('maintenance.delete');
    });
});
