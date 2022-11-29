<?php

use App\Modules\Phpcat\Http\Controllers\PhpcatController;

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

// Route::prefix('phpcat')->group(function() {
//     Route::get('/', 'PhpcatController@index');
// });

Route::domain('php-cat.com')
    // ->name('metrika.')
    ->group(function () {

        Route::get('api/{model?}', [PhpcatController::class, 'apiGet']);
        Route::post('api/{model?}', [PhpcatController::class, 'apiPost']);
        Route::delete('api/{model?}/{id?}', [PhpcatController::class, 'apiPost']);

        Route::get('/{any1?}/{any?}', [PhpcatController::class, 'index'])
        ->where('any1','.*')
        ->where('any','.*')
        ;
        // Route::get('/timeline/{any?}', [PhpcatController::class, 'index'])
        // ->where('any','.*');

    });
