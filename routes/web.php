<?php

use App\Http\Controllers\{AgentController,
    ApiController,
    BalanceController,
    BookingController,
    BookingDetailController,
    BookingExpenseController,
    BookingGuideController,
    DailyRecordController,
    DailyReportController,
    DashboardController,
    ExpenseController,
    GuideCategoryController,
    GuideController,
    MashrutController,
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

use App\Models\Partner;
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
    Route::get('guide-calendar', [GuideController::class, 'calendar'])->name('guides.calendar');


    Route::resource('tour-categories', TourCategoryController::class)->names('tour-categories')->only('index', 'store', 'update', 'destroy');
    Route::resource('tours', TourController::class)->names('tours');

    Route::resource('price-lists', PriceListController::class)->names('price-lists')->only('index', 'store', 'update', 'destroy');

    Route::resource('bookings', BookingController::class)->names('bookings')->only('index','show', 'store', 'update', 'destroy');
    Route::get('booking-templates', [BookingController::class, 'templates'])->name('bookings.templates');
    Route::get('changeMarked/{booking}', [BookingController::class, 'changeMarked'])->name('bookings.changeMarked');

    Route::prefix('bookings/{booking}')->group(function () {
        Route::resource('group-members', GroupMemberController::class)->only(['index','show', 'store','update','destroy',])->names('bookings.group-members');

        // Booking Expenses routes
        Route::resource('expenses', BookingExpenseController::class)->only(['index', 'store', 'update', 'destroy'])->names('bookings.expenses');
        Route::resource('mashruts', MashrutController::class)->only(['index', 'store', 'update', 'destroy']);
        // Booking Guides routes
        Route::resource('booking-guides', BookingGuideController::class)->only(['index', 'store', 'update', 'destroy']);
        // Booking Details routes
        Route::resource('details', BookingDetailController::class)->only(['index', 'store', 'update', 'destroy']);

        Route::get('mashruts/pdf', [MashrutController::class, 'downloadPdf'])->name('bookings.mashruts.pdf');
    });

    // Buyurtma nusxalash uchun route'lar
    Route::get('/bookings/copy', [BookingController::class, 'showCopyModal'])->name('bookings.copy');
    Route::get('/bookings/copy-from-template', [BookingController::class, 'copyFromTemplate'])->name('bookings.copy.from.template');
    Route::get('/bookings/copy-from-booking/{booking}', [BookingController::class, 'copyFromBooking'])->name('bookings.copy.from.booking');
    Route::post('/bookings/store-copy', [BookingController::class, 'storeCopy'])->name('bookings.store.copy');


    Route::resource('daily-records', DailyRecordController::class)->names('daily-records')->only('index','store','update','destroy');


    Route::resource('agents', AgentController::class)->names('agents')->except('create','edit');

    Route::resource('balances', BalanceController::class)->names('balances')->only('index','update','store');

    Route::resource('expenses', ExpenseController::class)->names('expenses')->only('index','update','store');

    Route::get('/daily-reports', [DailyReportController::class, 'index'])->name('daily-reports.index');
    Route::post('/daily-reports', [DailyReportController::class, 'store'])->name('daily-reports.store');
    // Get agents for selected bookings
    Route::post('/daily-reports/get-agents', [DailyReportController::class, 'getAgents'])
            ->name('daily-reports.get-agents');

    // Send emails
    Route::post('/daily-reports/send-emails', [DailyReportController::class, 'sendEmails'])
            ->name('daily-reports.send-emails');

});

require __DIR__.'/auth.php';


Route::prefix('api')->group(function (){
    // Existing routes
    Route::get('/partners/{partner}/objects', [ApiController::class, 'get_object_items']);
    Route::get('/partners/by-type/{type}', [ApiController::class, 'get_partners_by_type']);
    Route::get('/partners', [ApiController::class, 'get_all_partners']);
    Route::get('/partner-objects/by-partner/{partnerId}', [ApiController::class, 'get_partner_objects_by_partner']);

    // New routes to match the API endpoints used in JavaScript
    Route::get('/partner-objects', [ApiController::class, 'get_partner_objects']);
    Route::get('/object-items', [ApiController::class, 'get_object_items']);
    Route::get('/object-items/by-object/{objectId}', [ApiController::class, 'get_object_items_by_object']);
});

