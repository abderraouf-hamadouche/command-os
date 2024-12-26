<?php

use Illuminate\Support\Facades\Route;

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
    return view('welcome');
});


// The route we have created to show all blog posts.
Route::get('/command', [\App\Http\Controllers\CommandController::class, 'index']);
Route::get('/command/tag/{tag}', [\App\Http\Controllers\CommandController::class, 'tag']);
Route::get('/command/{command}', [\App\Http\Controllers\CommandController::class, 'show']);
Route::get('/command/{command}/edit', [\App\Http\Controllers\CommandController::class, 'edit']);


Route::get('/command/create/{command}', [\App\Http\Controllers\CommandController::class, 'create']);
Route::post('/command/create/{command}',          [\App\Http\Controllers\CommandController::class, 'store']);

Route::get('search', [\App\Http\Controllers\CommandController::class, 'search']);
Route::get('searchcommand', [\App\Http\Controllers\CommandController::class, 'searchcommand']);
//Route::get('/live_search', 'LiveSearch@index');
//Route::get('/live_search/action', 'LiveSearch@action')->name('live_search.action');


//route for intervention
Route::get('/intervention', [\App\Http\Controllers\InterventionsController::class, 'index']);
Route::get('/intervention/{intervention}', [\App\Http\Controllers\InterventionsController::class, 'show']);
Route::get('/intervention/create/{intervention}', [\App\Http\Controllers\InterventionsController::class, 'create']);
Route::post('/intervention/create/{intervention}', [\App\Http\Controllers\InterventionsController::class, 'store']);


Route::get('searchparam', [\App\Http\Controllers\CommandController::class, 'searchparam']);

