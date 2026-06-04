<?php
use App\Http\Controllers\CommandController;
use App\Http\Controllers\InterventionsController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ParametreController;
use App\Http\Controllers\EtapeController;

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

 


// Command routes
Route::resource('command', CommandController::class)
    ->only(['index', 'show', 'create', 'store','edit','update']);
Route::get('/search', [\App\Http\Controllers\CommandController::class, 'search'])->name('command.search');
Route::post('/command/{command}/parametres', [\App\Http\Controllers\CommandController::class, 'addParametres']) ->name('command.addParametres');

//Routes for show delete editing a parameter with  parametre controller
Route::get('command/{command}/parametre/{parametre}/edit', [ParametreController::class, 'edit'])    ->name('parametre.edit');
Route::put('command/{command}/parametre/{parametre}', [ParametreController::class, 'update'])        ->name('parametre.update');
Route::delete('command/{command}/parametre/{parametre}', [ParametreController::class, 'destroy'])    ->name('parametre.destroy');

//route for intervention
Route::resource('intervention', InterventionsController::class)
    ->only(['index', 'show', 'create', 'store','edit','destroy']);

//routes for Etape
Route::put('/etape/graph', [EtapeController::class, 'updateGraph'])->name('etape.updateGraph'); // <-- New route to update the graph
Route::post('/etape', [EtapeController::class, 'store'])->name('etape.store'); // <-- New route to add a step
