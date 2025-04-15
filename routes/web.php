<?php

use App\Http\Middleware\RoleMiddleware;
use App\Http\Middleware\CheckUserStatus;

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\SponsorController;
use App\Http\Controllers\CodeController;
use App\Http\Controllers\EnvSettingsController;
use App\Http\Controllers\Admin\ApprovalController;
use App\Http\Controllers\BusinessController;


use Illuminate\Support\Facades\Route;

// Route for the home page
Route::get('/', function () {
    return view('welcome');
});

// Route for home page
// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');
// Route::view('/dashboard', 'dashboard')->middleware(['auth', 'role:admin,superadmin'])->name('dashboard');
Route::get('/dashboard', function () {
    $user = Auth::user();

    if (!$user) {
        return redirect()->route('login');
    }

    return match ($user->role) {
        'admin', 'superadmin' => view('dashboard'),
        'business' => redirect()->route('business.dashboard'),
        'user' => redirect()->route('user.dashboard'),
        default => abort(403, 'Ruolo non riconosciuto.'),
    };
})->middleware(['auth'])->name('dashboard');
Route::view('/business-dashboard', 'business-dashboard')->middleware(['auth', 'role:business'])->name('business.dashboard');
Route::view('/user-dashboard', 'user-dashboard')->middleware(['auth', 'role:user'])->name('user.dashboard');


// Route for user profile
Route::middleware(['auth', CheckUserStatus::class])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Route for roles
Route::resource('roles', \App\Http\Controllers\RoleController::class)->middleware(['auth', 'role:admin,superadmin']);

// Route for Users Management
Route::middleware(['auth', 'role:admin,superadmin', CheckUserStatus::class])->prefix('admin/users')->name('admin.users.')->group(function () {
    Route::get('/', [AdminUserController::class, 'index'])->name('index');
    Route::get('/{user}', [AdminUserController::class, 'show'])->name('show');
    Route::get('/{user}/edit', [AdminUserController::class, 'edit'])->name('edit');
    Route::put('/{user}', [AdminUserController::class, 'update'])->name('update');
    Route::delete('/{user}', [AdminUserController::class, 'destroy'])->name('destroy');
    Route::post('/{user}/reset-password', [AdminUserController::class, 'sendReset'])->name('reset');
});

// Route for Categories
Route::middleware(['auth', 'role:admin,superadmin', CheckUserStatus::class])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('categories', CategoryController::class);
});

// Route for Companies
Route::middleware(['auth', 'role:admin,superadmin', CheckUserStatus::class])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('companies', \App\Http\Controllers\CompanyController::class);
});

// Route for Packages
Route::middleware(['auth', 'role:admin,superadmin', CheckUserStatus::class])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('packages', PackageController::class);
});

// Route for Events
Route::middleware(['auth', 'role:admin,superadmin', CheckUserStatus::class])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('events', EventController::class);
});

// Route for Sponsors
Route::middleware(['auth', 'role:admin,superadmin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('sponsors', SponsorController::class);
});

// Route for Codes
Route::middleware(CheckUserStatus::class)->prefix('admin/codes')->name('admin.codes.')->group(function () {
    Route::get('/', [CodeController::class, 'index'])->name('index');
    Route::get('/create', [CodeController::class, 'create'])->name('create');
    Route::post('/', [CodeController::class, 'store'])->name('store');
    Route::get('/{code}', [CodeController::class, 'show'])->name('show');
    Route::get('/{code}/edit', [CodeController::class, 'edit'])->name('edit');
    Route::put('/{code}', [CodeController::class, 'update'])->name('update');
    Route::delete('/{code}', [CodeController::class, 'destroy'])->name('destroy');
});

// Route for Env Settings
Route::get('/admin/env', [EnvSettingsController::class, 'edit'])->name('admin.env.edit')->middleware(['auth', 'role:superadmin', CheckUserStatus::class]);
Route::post('admin/env', [EnvSettingsController::class, 'update'])->name('admin.env.update')->middleware(['auth', 'role:superadmin', CheckUserStatus::class]);

// Route for Business Approval
Route::middleware(['auth', 'role:admin,superadmin'])->get('/admin/approve-business/{user}', [App\Http\Controllers\Admin\ApprovalController::class, 'approve'])->name('admin.approve.business');
Route::view('/business-pending', 'auth.business-pending')->name('business.pending');
Route::get('/attendi-approvazione', function () {
    return view('auth.pending-approval');
})->name('business.pending');

// Route for Business Users
Route::middleware(['auth', 'role:business'])->prefix('business')->group(function () {
    Route::get('/assign', [BusinessController::class, 'assign'])->name('business.assign');
    Route::get('/discount', [BusinessController::class, 'discount'])->name('business.discount');
    Route::get('/verify', [BusinessController::class, 'verify'])->name('business.verify');
});
Route::get('/business/burn', [BusinessController::class, 'burn'])->middleware(['auth', 'role:business'])->name('business.burn');

Route::post('/business/assign', [BusinessController::class, 'storeAssign'])->middleware(['auth', 'role:business'])->name('business.assign.store');
Route::post('/business/discount', [App\Http\Controllers\BusinessController::class, 'storeDiscount'])->middleware(['auth', 'role:business'])->name('business.discount.store');
Route::get('/business/verify', [BusinessController::class, 'verify'])->name('business.verify')->middleware(['auth', 'role:business']);
Route::post('/business/burn', [BusinessController::class, 'storeBurn'])->middleware(['auth', 'role:business'])->name('business.burn.store');
Route::middleware(['auth', 'role:business'])->group(function () {
    Route::get('/business/analytics', [BusinessController::class, 'analytics'])->name('business.analytics');
});
Route::middleware(['auth', 'role:business'])->group(function () {
    Route::get('/business/assign-user', [BusinessController::class, 'assignUser'])->name('business.assign-user');
    Route::post('/business/assign-user', [BusinessController::class, 'storeAssignUser'])->name('business.assign-user.store');
});
Route::delete('/business/remove-user/{user}', [BusinessController::class, 'removeAssignedUser'])
    ->middleware(['auth', 'role:business'])
    ->name('business.remove-user');
Route::middleware(['auth', 'role:business'])->prefix('business')->group(function () {
    Route::get('/mycodes', [BusinessController::class, 'myCodes'])->name('business.mycodes');
    Route::delete('/remove-code/{id}', [BusinessController::class, 'removeCode'])->name('business.remove-code');
});
Route::middleware(['auth', 'role:business'])->group(function () {
    // ...
    Route::get('/business/codes/generate', [BusinessController::class, 'generateCode'])->name('business.generate-code');
});
Route::middleware(['auth', 'role:business'])->prefix('business')->name('business.')->group(function () {
    // ...
    Route::get('/mycodes-user', [BusinessController::class, 'myCodesUser'])->name('mycodes-user');
    Route::delete('/mycodes-user/remove/{id}', [BusinessController::class, 'removeUserCode'])->name('mycodes-user.remove');
});
Route::get('/business/associate-code', [BusinessController::class, 'codeAssociation'])
->middleware(['auth', 'role:business'])
->name('business.code-association');

Route::post('/business/associate-code', [BusinessController::class, 'storeCodeAssociation'])
->middleware(['auth', 'role:business'])
->name('business.code-association.store');

Route::middleware(['auth', 'role:business'])->prefix('business')->name('business.')->group(function () {
    Route::get('/company', [BusinessController::class, 'editCompany'])->name('company.edit');
    Route::put('/company', [BusinessController::class, 'updateCompany'])->name('company.update');
});
    


    











require __DIR__.'/auth.php';
