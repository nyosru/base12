<?php

use App\Http\Controllers\UloginController;

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

// разработка.народнаяэкономика.рф
// xn--80aaad2au1alcx.xn--80aaaovlboecchebw6s7a.xn--p1ai

// Route::domain('xn--80aaad2au1alcx.xn--80aaaovlboecchebw6s7a.xn--p1ai')
Route::domain('nr.dev.php-cat.com')
    // ->name('metrika.')
    ->group(function () {

        // Route::get('/index', 'NarodController@index');
        // Route::get('/', 'NarodController@index');
        // Route::get('{any?}/{any1?}/{any2?}/{any3?}', 'NarodController@index');
        // Route::get('{any?}/{any1?}/{any2?}', 'NarodController@index');
        // Route::get('{any?}/{any1?}', 'NarodController@index');
        Route::get('api47/{action?}/{var1?}', 'NarodController@api');
        Route::post('api47/{action?}/{var1?}', 'NarodController@api');
        Route::get('{any?}', 'NarodController@index');

        // Route::get('ulogout', [UloginController::class, 'logout']);
        Route::post('ulogin', [UloginController::class, 'login']);

    });
// Route::prefix('narod')->group(function() {
//     Route::get('/', 'NarodController@index');
// });

Route::domain('xn--80aaaovlboecchebw6s7a.xn--p1ai')
    ->group(function () {
        Route::get('api47/{action?}/{var1?}', 'NarodController@api');
        Route::post('api47/{action?}/{var1?}', 'NarodController@api');
        Route::get('{any?}', 'NarodController@index');
        Route::post('ulogin', [UloginController::class, 'login']);
    });
Route::domain('base12.46.ru')
    ->group(function () {
        Route::get('api47/{action?}/{var1?}', 'NarodController@api');
        Route::post('api47/{action?}/{var1?}', 'NarodController@api');
        Route::get('{any?}', 'NarodController@index');
        Route::post('ulogin', [UloginController::class, 'login']);
    });
