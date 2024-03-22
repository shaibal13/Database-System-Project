<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AgentController;
use App\Http\Controllers\OwnersController;
use App\Http\Controllers\HomesController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\AppliancesController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/', function () {
    return view('dashboard/dashboard');
});
Route::get('agent/addNewAgent', [AgentController::class, 'addNewAgent']);
Route::get('agent/newAgent', [AgentController::class, 'newAgent']);

Route::get('owners/addNewOwners/{id?}', [OwnersController::class, 'addNewOwners'])->name('owners.addoredit');
Route::post('owners/addorupdateNewOwnerForm', [OwnersController::class, 'addorupdateNewOwnerForm']);
Route::get('owners', [OwnersController::class, 'index']);

Route::get('appliances/addNewAppliances/{id?}', [AppliancesController::class, 'addNewAppliances'])->name('appliances.addoredit');
Route::post('appliances/addorupdateNewApplianceForm', [AppliancesController::class, 'addorupdateNewApplianceForm']);
Route::get('appliances', [AppliancesController::class, 'index']);

Route::get('homes/addNewHomes/{id?}', [HomesController::class, 'addNewHomes'])->name('homes.addoredit');
Route::post('homes/addorupdateNewHomeForm', [HomesController::class, 'addorupdateNewHomeForm']);
Route::get('homes', [HomesController::class, 'index']);


// Route::resource('posts', AgentController::class)->only([
//     'destroy', 'show', 'store', 'update'
//  ]);
// Route::get('/', function () {
//     return view('login');
// });
