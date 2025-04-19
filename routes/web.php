<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\PartnerController;
use App\Http\Controllers\PartnerTypeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RolesAndPermission\GivePermissionController;
use App\Http\Controllers\RolesAndPermission\PermissionController;
use App\Http\Controllers\RolesAndPermission\RoleController;
use App\Http\Controllers\ToolsController;
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

    Route::resource('partners', PartnerController::class)
        ->only(['index','show', 'store', 'destroy','update']);

    Route::prefix('tools')->group(function() {
        Route::get('/davlatlar', [ToolsController::class, 'countries'])->name('tools.countries');
//        Route::get('/shaharlar', [ToolsController::class, 'shaharlar'])->name('tools.cities');
        Route::get('/tillar', [ToolsController::class, 'languages'])->name('tools.languages');
        Route::get('/valyutalar', [ToolsController::class, 'currencies'])->name('tools.currencies');
    });

});

require __DIR__.'/auth.php';

