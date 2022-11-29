<?php

use App\Modules\Billiard\Http\Controllers\BilliardController;

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

// Route::prefix('billiard')->group(function() {
//     Route::get('/', 'BilliardController@index');
// });

Route::domain( 'bill.dev.php-cat.com' )->group(function () {
    Route::get('{any}', [BilliardController::class, 'page_page'])
        ->where('any', '.*')
        ;

});

Route::domain( 'xn--90agbnpci1al7hdqv.xn--p1ai' )->group(function () {
    Route::get('{any}', [BilliardController::class, 'page_page'])
        ->where('any', '.*')
        ;

});
