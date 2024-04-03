<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AgentController;
use App\Http\Controllers\OwnersController;
use App\Http\Controllers\HomesController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\AppliancesController;
use App\Http\Controllers\CompaniesController;
use App\Http\Controllers\SaleshistoryController;
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
// Route::get('/', function () {
//     return view('dashboard/dashboard');
// });
Route::get('/', [SaleshistoryController::class, 'index']);


Route::get('agents/addNewAgents/{id?}', [AgentController::class, 'addNewAgents'])->name('agents.addoredit');
Route::post('agents/addorupdateNewAgentForm', [AgentController::class, 'addorupdateNewAgentForm']);
Route::get('agents', [AgentController::class, 'index'])->name('agents.index');
Route::delete('/agents/{id}', [AgentController::class, 'destroy'])->name('agents.delete');


Route::get('owners/addNewOwners/{id?}', [OwnersController::class, 'addNewOwners'])->name('owners.addoredit');
Route::post('owners/addorupdateNewOwnerForm', [OwnersController::class, 'addorupdateNewOwnerForm']);
Route::get('owners', [OwnersController::class, 'index']);
Route::any('homes/previousOwner', [OwnersController::class, 'previousOwner'])->name('homes.previousOwner');

Route::get('appliances/addNewAppliances/{id?}', [AppliancesController::class, 'addNewAppliances'])->name('appliances.addoredit');
Route::post('appliances/addorupdateNewApplianceForm', [AppliancesController::class, 'addorupdateNewApplianceForm']);
Route::get('appliances', [AppliancesController::class, 'index']);
Route::any('appliances/findHomebyMaker', [AppliancesController::class, 'findHomebyMaker'])->name('appliances.appliances_by_maker');

Route::get('homes/addNewHomes/{id?}', [HomesController::class, 'addNewHomes'])->name('homes.addoredit');
Route::get('homes/addAppliancesToHome/{id?}', [HomesController::class, 'addAppliancesToHome'])->name('homes.add_appliances');
Route::post('homes/addorupdateNewHomeForm', [HomesController::class, 'addorupdateNewHomeForm']);
Route::post('homes/addorupdateNewApplianceForm', [HomesController::class, 'addorupdateNewApplianceForm']);
Route::any('homes', [HomesController::class, 'index']);
Route::get('homes/forSale', [HomesController::class, 'forSale']);
Route::get('homes/owned', [HomesController::class, 'owned']);
Route::get('homes/statuschange/{id?}/{status?}', [HomesController::class, 'statuschange'])->name('homes.statuschange');
Route::post('homes/addtosale', [HomesController::class, 'addtosale']);
Route::get('/homes/saledetails/{id}', [HomesController::class, 'saledetails'])->name('homes.saledetails');


Route::get('companies', [CompaniesController::class, 'index']);
Route::get('companies/addNewCompanies/{id?}', [CompaniesController::class, 'addNewCompanies'])->name('companies.addoredit');
Route::post('companies/addorupdateNewCompaniesForm', [CompaniesController::class, 'addorupdateNewCompaniesForm']);
Route::get('/company/getAgentDetails/{id}', [CompaniesController::class, 'getAgentDetails'])->name('company.getAgentDetails');


Route::post('/sale', [SaleshistoryController::class, 'addSale']);
Route::get('/salehistory', [SaleshistoryController::class, 'index']);
// Route::resource('posts', AgentController::class)->only([
//     'destroy', 'show', 'store', 'update'
//  ]);
// Route::get('/', function () {
//     return view('login');
// });
