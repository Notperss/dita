<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
//Dashboard
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ManagementAccess\UserController;
//Location
use App\Http\Controllers\ManagementAccess\TypeUserController;
use App\Http\Controllers\MasterData\WorkUnits\SectionController;
use App\Http\Controllers\MasterData\WorkUnits\DivisionController;
use App\Http\Controllers\MasterData\Location\SubLocationController;
//WorkUnits
use App\Http\Controllers\MasterData\WorkUnits\DepartmentController;
use App\Http\Controllers\MasterData\Location\MainLocationController;
use App\Http\Controllers\MasterData\Location\DetailLocationController;
//Classification
use App\Http\Controllers\MasterData\Location\ContainerLocationController;
use App\Http\Controllers\MasterData\Retention\RetentionArchivesController;
use App\Http\Controllers\MasterData\Classification\SubClassificationController;
use App\Http\Controllers\MasterData\Classification\MainClassificationController;

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

Route::get('/', function () {
    // cek apakah sudah login atau belum
    if (Auth::user() != null) {
        return redirect()->intended('backsite/dashboard');
    }
    return view('auth.login');
});

Route::group(['prefix' => 'backsite', 'as' => 'backsite.', 'middleware' => ['auth:sanctum', 'verified']], function () {
    //Dashboard
    Route::resource('dashboard', DashboardController::class);

    //Location
    Route::resource('main-location', MainLocationController::class);
    Route::resource('sub-location', SubLocationController::class);
    Route::resource('detail-location', DetailLocationController::class);
    Route::resource('container-location', ContainerLocationController::class);
    Route::get('/get-sub-location', [DetailLocationController::class, 'getSubLocations'])->name('getSubLocations');
    Route::get('/get-container', [DetailLocationController::class, 'getContainers'])->name('getContainers');

    //WorkUnits
    Route::resource('division', DivisionController::class);
    Route::resource('department', DepartmentController::class);
    Route::resource('section', SectionController::class);
    Route::get('/get-department', [SectionController::class, 'getDepartments'])->name('getDepartments');

    //Classification
    Route::resource('main-classification', MainClassificationController::class);
    Route::resource('sub-classification', SubClassificationController::class);

    //Retention
    Route::resource('retention', RetentionArchivesController::class);
    Route::get('/get-sub-classification', [RetentionArchivesController::class, 'getSubClassifications'])->name('getSubClassifications');

    //Management Access
    Route::resource('type_user', TypeUserController::class);
    Route::resource('user', UserController::class);




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
