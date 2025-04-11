<?php

use App\Http\Middleware\RoleMiddleware;

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\EventController;


use Illuminate\Support\Facades\Route;

// Route for the home page
Route::get('/', function () {
    return view('welcome');
});

// Route for home page
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Route for user profile
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Route for roles
Route::resource('roles', \App\Http\Controllers\RoleController::class)->middleware(['auth', 'role:admin,superadmin']);

// Route for Users Management
Route::middleware(['auth', 'role:admin,superadmin'])->prefix('admin/users')->name('admin.users.')->group(function () {
    Route::get('/', [AdminUserController::class, 'index'])->name('index');
    Route::get('/{user}', [AdminUserController::class, 'show'])->name('show');
    Route::get('/{user}/edit', [AdminUserController::class, 'edit'])->name('edit');
    Route::put('/{user}', [AdminUserController::class, 'update'])->name('update');
    Route::delete('/{user}', [AdminUserController::class, 'destroy'])->name('destroy');
    Route::post('/{user}/reset-password', [AdminUserController::class, 'sendReset'])->name('reset');
});

// Route for Categories
Route::middleware(['auth', 'role:admin,superadmin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('categories', CategoryController::class);
});

// Route for Companies
Route::middleware(['auth', 'role:admin,superadmin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('companies', \App\Http\Controllers\CompanyController::class);
});

// Route for Packages
Route::middleware(['auth', 'role:admin,superadmin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('packages', PackageController::class);
});

// Route for Events
Route::middleware(['auth', 'role:admin,superadmin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('events', EventController::class);
});


require __DIR__.'/auth.php';
