<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
//Dashboard
use App\Http\Controllers\RoleController;
//Company
use App\Http\Controllers\RouteController;
//Location
use App\Http\Controllers\SettingController;
use App\Http\Controllers\MenuItemController;
//WorkUnits
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MenuGroupController;
use App\Http\Controllers\PermissionController;
//Classification
use App\Http\Controllers\UserManagementController;
use App\Http\Controllers\ManagementAccess\UserController;
use App\Http\Controllers\ManagementAccess\TypeUserController;
use App\Http\Controllers\MasterData\Company\CompanyController;
use App\Http\Controllers\MasterData\WorkUnits\SectionController;
//Management User
use App\Http\Controllers\MasterData\WorkUnits\DivisionController;
use App\Http\Controllers\MasterData\Location\SubLocationController;
use App\Http\Controllers\MasterData\WorkUnits\DepartmentController;
use App\Http\Controllers\MasterData\Location\MainLocationController;
use App\Http\Controllers\MasterData\Location\DetailLocationController;
use Laravel\Jetstream\Http\Controllers\Livewire\UserProfileController;
use App\Http\Controllers\MasterData\Location\ContainerLocationController;
use App\Http\Controllers\MasterData\Retention\RetentionArchivesController;
use App\Http\Controllers\MasterData\Classification\SubClassificationController;
use App\Http\Controllers\TransactionArchive\Archive\ArchiveContainerController;
use App\Http\Controllers\MasterData\Classification\MainClassificationController;
use App\Http\Controllers\TransactionArchive\LendingArchive\LendingArchiveController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('pages.dashboard.index');
// });
Route::get('/qr/{id}', [ContainerLocationController::class, 'detailContainer'])->name('show-qr');

Route::get('/qr-cont/{id}', [ArchiveContainerController::class, 'detailArchive'])->name('qr-archive');


Route::get('/', function () {
    // cek apakah sudah login atau belum
    if (Auth::user() != null) {
        return redirect()->intended('backsite/dashboard');
    }
    return view('auth.login');
});

Route::group(['prefix' => 'backsite', 'as' => 'backsite.', 'middleware' => ['auth:sanctum', 'verified']], function () {
    //Dashboard
    Route::resource('dashboard', DashboardController::class)->only('index');

    //Company
    Route::resource('company', CompanyController::class);

    //Location
    Route::resource('main-location', MainLocationController::class)->only('index', 'create', 'store', 'edit', 'update', 'destroy');
    Route::resource('sub-location', SubLocationController::class)->only('index', 'create', 'store', 'edit', 'update', 'destroy');
    Route::resource('detail-location', DetailLocationController::class)->only('index', 'create', 'store', 'edit', 'update', 'destroy');
    Route::resource('container-location', ContainerLocationController::class);
    Route::get('/get-sub-location', [DetailLocationController::class, 'getSubLocations'])->name('getSubLocations');
    Route::get('/get-container', [DetailLocationController::class, 'getContainers'])->name('getContainers');

    Route::get('/show-qr/{id}', [ContainerLocationController::class, 'showBarcode'])->name('showBarcode');



    //WorkUnits
    Route::resource('division', DivisionController::class)->only('index', 'create', 'store', 'edit', 'update', 'destroy');
    Route::resource('department', DepartmentController::class)->only('index', 'create', 'store', 'edit', 'update', 'destroy');
    Route::resource('section', SectionController::class)->only('index', 'create', 'store', 'edit', 'update', 'destroy');
    Route::get('/get-department', [SectionController::class, 'getDepartments'])->name('getDepartments');

    //Classification
    Route::resource('main-classification', MainClassificationController::class)->only('index', 'create', 'store', 'edit', 'update', 'destroy');
    Route::resource('sub-classification', SubClassificationController::class)->only('index', 'create', 'store', 'edit', 'update', 'destroy');

    //Retention
    Route::resource('retention', RetentionArchivesController::class);
    Route::get('/get-sub-classification', [RetentionArchivesController::class, 'getSubClassifications'])->name('getSubClassifications');
    Route::get('/get-sub-series', [RetentionArchivesController::class, 'getSeriesClassifications'])->name('getSeriesClassifications');

    //Management Access
    // Route::resource('type_user', TypeUserController::class);
    // Route::resource('user', UserController::class);

    //Transaction Archives
    Route::resource('archive-container', ArchiveContainerController::class);
    Route::controller(ArchiveContainerController::class)->group(function () {
        Route::get('form_upload', 'form_upload')->name('form_upload');
        Route::get('/get-number-container', 'getNumberContainer')->name('getNumberContainer');
        Route::get('/get-data-container', 'getDataContainer')->name('getDataContainer');
        Route::get('/show-qr-container/{id}', 'showBarcode')->name('showBarcodeContainer');
    });


    //Lending Archive
    Route::resource('lending-archive', LendingArchiveController::class);
    Route::get('/detail-lending', [LendingArchiveController::class, 'show_file'])->name('show_file');
    // Route::controller(LendingArchiveController::class)->group(function () {
    //     Route::get('lending-archive', 'show_file')->name('show_file');
    // });




});

Route::group(['middleware' => ['web', 'auth', 'verified']], function () {
    Route::resource('dashboard', DashboardController::class)->only('index');
    Route::resource('user', UserManagementController::class)->only('index', 'store', 'update', 'destroy');
    Route::prefix('user')->group(function () {
        Route::resource('profile', UserProfileController::class)->only('index', 'edit');
    });
    Route::resource('setting', SettingController::class)->only('index', 'update');
    Route::resource('contoh', SettingController::class)->only('index', 'update');

    Route::resource('route', RouteController::class)->only('index', 'store', 'update', 'destroy');
    Route::resource('role', RoleController::class)->only('index', 'store', 'update', 'destroy');
    Route::resource('permission', PermissionController::class)->only('index', 'store', 'update', 'destroy');

    Route::resource('menu', MenuGroupController::class)->only('index', 'store', 'update', 'destroy');
    Route::resource('menu.item', MenuItemController::class)->only('index', 'store', 'update', 'destroy');

});


// Route::middleware([
//     'auth:sanctum',
//     config('jetstream.auth_session'),
//     'verified',
// ])->group(function () {
//     Route::get('/dashboard', function () {
//         return view('dashboard');
//     })->name('dashboard');
// });
