<?php

use App\Http\Controllers\ActivityLogController;
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
use App\Http\Controllers\TransactionArchive\FolderDivision\FolderDivisionController;
use App\Http\Controllers\TransactionArchive\LendingArchive\LendingArchiveController;
use App\Http\Controllers\TransactionArchive\DestructionArchive\DestructionArchiveController;

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

Route::get('/archives/search', [ArchiveContainerController::class, 'search'])->name('archives.search');


Route::get('/', function () {
    // cek apakah sudah login atau belum
    if (Auth::user() != null) {
        return redirect()->intended('/dashboard');
    }
    return view('auth.login');
});

// Route::group(['prefix' => '', 'as' => '', 'middleware' => ['auth:sanctum', 'verified']], function () {
Route::group(['middleware' => ['auth:sanctum', 'verified']], function () {
    //Dashboard
    Route::resource('dashboard', DashboardController::class)->only('index');
    Route::get('/division-archive/{id}', [DashboardController::class, 'division_archive'])->name('division-archive');
    Route::get('/division-lending/{id}', [DashboardController::class, 'division_lending'])->name('division-lending');

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

    //MainClassification
    Route::resource('main-classification', MainClassificationController::class)->only('index', 'create', 'store', 'edit', 'update', 'destroy');
    Route::get('/get-main-classification', [MainClassificationController::class, 'getMainClassifications'])->name('getMainClassifications');
    Route::get('/get-sub-classification', [MainClassificationController::class, 'getSubClassifications'])->name('getSubClassifications');

    //MainClassification
    Route::resource('sub-classification', SubClassificationController::class)->only('index', 'create', 'store', 'edit', 'update', 'destroy');
    //Retention
    Route::resource('retention', RetentionArchivesController::class);
    // Route::get('/get-sub-classification', [RetentionArchivesController::class, 'getSubClassifications'])->name('getSubClassifications');
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
        Route::get('/archive', 'dataArchive')->name('dataArchive');
    });


    //Lending Archive
    Route::resource('lending-archive', LendingArchiveController::class);
    // Route::get('/detail-lending', [LendingArchiveController::class, 'show_file'])->name('show_file');
    Route::controller(LendingArchiveController::class)->group(function () {
        Route::get('/detail-lending', 'show_file')->name('show_file');
        Route::get('/history/{id}', 'historyDetail')->name('historyDetail');
        Route::get('/history', 'history')->name('history');
        Route::get('/digital', 'digital')->name('digital');
        Route::get('/fisik', 'fisik')->name('fisik');
        Route::put('/approval', 'approval')->name('approval');
        Route::put('/closing/{id}', 'closing')->name('closing');
    });

    Route::resource('destruction-archive', DestructionArchiveController::class);
    Route::controller(DestructionArchiveController::class)->group(function () {
        Route::get('/division-destruction/{id}', 'divisionDestruct')->name('division-destruct');
        Route::get('/destroying-archive', 'archiveDestroy')->name('archive-destroy');
        Route::put('/check-to-destroy', 'checkDestroy')->name('check-destroy');
        Route::put('/check-not-destroyed/{id}', 'checkNotDestroy')->name('checkNotDestroy');
        Route::put('/cancel-destroy/{id}', 'cancelDestroy')->name('cancelDestroy');
        // Route::put('/approval-destruction', [DestructionArchiveController::class, 'approvalDestruction'])->name('approvalDestruction');
    });

    Route::get('/get-division', [UserManagementController::class, 'getDivisions'])->name('getDivisions');

    Route::resource('folder', FolderDivisionController::class);

    Route::controller(FolderDivisionController::class)->group(function () {
        Route::post('/folder/form', 'form_upload')->name('folder.form_upload');
        Route::post('/folder/upload', 'upload')->name('folder.upload');
        Route::delete('/folder/{id}/delete_file', 'delete_file')->name('folder.delete_file');
    });


});

Route::group(['middleware' => ['web', 'auth', 'verified']], function () {
    Route::resource('dashboard', DashboardController::class)->only('index');
    Route::resource('user', UserManagementController::class)->only('index', 'store', 'update', 'destroy');

    Route::prefix('user')->group(function () {
        Route::resource('profile', UserProfileController::class)->only('index', 'show', 'edit');
    });
    Route::resource('setting', SettingController::class)->only('index', 'update');
    Route::resource('contoh', SettingController::class)->only('index', 'update');

    Route::resource('route', RouteController::class)->only('index', 'store', 'update', 'destroy');
    Route::resource('role', RoleController::class)->only('index', 'store', 'update', 'destroy');
    Route::resource('permission', PermissionController::class)->only('index', 'store', 'update', 'destroy');

    Route::resource('menu', MenuGroupController::class)->only('index', 'store', 'update', 'destroy');
    Route::resource('menu.item', MenuItemController::class)->only('index', 'store', 'update', 'destroy');

    Route::resource('activity-log', ActivityLogController::class)->only('index');

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
