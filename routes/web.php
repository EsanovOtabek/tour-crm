<?php

use App\Http\Controllers\{BookingController,
    DashboardController,
    GuideCategoryController,
    GuideController,
    ObjectItemController,
    PartnerController,
    PartnerObjectController,
    PartnerTypeController,
    PriceListController,
    ProfileController,
    RolesAndPermission\GivePermissionController,
    RolesAndPermission\PermissionController,
    RolesAndPermission\RoleController,
    ToolsController,
    TourCategoryController,
    TourCitiesController,
    TourController,
    UserController,
    GroupMemberController};

use Illuminate\Support\Facades\Route;


Route::middleware(['auth'])->group(callback: function () {
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

    Route::prefix('tools')->group(function() {
        Route::get('/davlatlar', [ToolsController::class, 'countries'])->name('tools.countries');
        Route::resource('/shaharlar', TourCitiesController::class)->names('tools.cities')->only(['index', 'store', 'update', 'destroy']);

        Route::get('/tillar', [ToolsController::class, 'languages'])->name('tools.languages');
        Route::get('/valyutalar', [ToolsController::class, 'currencies'])->name('tools.currencies');
    });


    Route::resource('partner-types',PartnerTypeController::class)
        ->only(['index', 'store', 'destroy','update'])
        ->names('partner-types');

    // Partners Routes
    Route::resource('partners', PartnerController::class)
        ->only(['index', 'store', 'destroy', 'update']);

    // Partner Objects Routes
    Route::get('partner-objects', [PartnerController::class, 'show'])->name('partners.show');
    Route::resource('partner-objects', PartnerObjectController::class)->names('partners.objects')
        ->only(['update', 'store', 'destroy']);

    Route::resource('object-items', ObjectItemController::class)->names('object-items');


    Route::resource('guide-categories', GuideCategoryController::class)->names('guide-categories')->only('index', 'store', 'update', 'destroy');
    Route::resource('guides', GuideController::class)->names('guides');


    Route::resource('tour-categories', TourCategoryController::class)->names('tour-categories')->only('index', 'store', 'update', 'destroy');
    Route::resource('tours', TourController::class)->names('tours');

    Route::resource('price-lists', PriceListController::class)->names('price-lists')->only('index', 'store', 'update', 'destroy');

    Route::resource('bookings', BookingController::class)->names('bookings')->only('index', 'store', 'update', 'destroy');
    Route::prefix('bookings/{booking}')->group(function () {
        Route::resource('group-members', GroupMemberController::class)->only(['index','store','update','destroy',])->names('bookings.group-members');
    });



});

require __DIR__.'/auth.php';

