<?php

use App\Modules\Metrika\Http\Controllers\MetrikaController;

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

Route::domain('metrika.dev.php-cat.com')
    // ->name('metrika.')
    ->group(function () {
    Route::get('{any?}', [MetrikaController::class, 'index'] );
});
Route::domain('xn--90aefnapfpcbqdz7n.xn--p1ai')
    ->name('metrika.')
    ->group(function () {
    Route::get('{any?}', [MetrikaController::class, 'index'] )
        ->name('index');
});
