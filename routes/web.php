<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PartnerTypeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RolesAndPermission\GivePermissionController;
use App\Http\Controllers\RolesAndPermission\PermissionController;
use App\Http\Controllers\RolesAndPermission\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


Route::middleware(['auth'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('users', UserController::class)->only(['index','store','update','show']);

    // Roles and Permissions
    Route::group(['middleware' => ['role:admin']], function () {
        // Roles routes (only create and store)
        Route::resource('roles', RoleController::class)->only(['index', 'store']);

        // Permissions routes (full CRUD)
        Route::resource('permissions', PermissionController::class);

        // Role-Permissions routes
        Route::prefix('roles')->group(function () {
            Route::get('permissions', [GivePermissionController::class, 'index'])->name('roles.permissions.index');
            Route::post('permissions/sync', [GivePermissionController::class, 'sync'])->name('roles.permissions.sync');
        });
    });



    Route::resource('partner-types',PartnerTypeController::class)
        ->only(['index', 'store', 'destroy','update'])
        ->names('partner-types');

});

require __DIR__.'/auth.php';

