<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AgentController;

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
Route::get('agent/addNewAgent', [AgentController::class, 'addNewAgent']);
Route::get('agent/newAgent', [AgentController::class, 'newAgent']);
// Route::resource('posts', AgentController::class)->only([
//     'destroy', 'show', 'store', 'update'
//  ]);
// Route::get('/', function () {
//     return view('login');
// });
Route::get('/', function () {
    return view('dashboard/dashboard');
});