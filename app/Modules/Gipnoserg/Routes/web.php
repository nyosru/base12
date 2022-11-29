<?php

use App\Modules\Gipnoserg\Http\Controllers\GipnosergController;

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

// Route::prefix('gipnoserg')->group(function() {
//     Route::get('/', 'GipnosergController@index');
// });


Route::domain('gipno-serg.php-cat.com')
    ->name('gs.')
    // ->prefix('job')
    ->group(function () {
        // Route::post('ulogin', [ UloginController::class, 'login' ] );
        // Route::prefix('buh')->group(function() {
        Route::get('{any?}', [GipnosergController::class, 'index']);
    });

