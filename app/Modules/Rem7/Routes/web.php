<?php

use App\Modules\Rem7\Http\Controllers\Rem7Controller;

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

//Route::prefix('rem7')->group(function() {
//    Route::get('/', 'Rem7Controller@index');
//});

Route::domain('7r.dev.php-cat.com')
    ->name('dev-rem.')
    // ->prefix('lk')
    ->group(function () {

        Route::get('/index', [Rem7Controller::class, 'page_index'])
            ->name('page.index');

        // Route::get('/', [Rem7Controller::class, 'page_index'])
        //         ->name('page.index')
        //         //->name('lk_login')
        //         ;

    });


// dd(123123);

Route::domain('xn--7-jtbaydwj1k.xn--p1ai')
    ->name('rem.')
    // ->prefix('lk')
    ->group(function () {

        Route::get('/index', [Rem7Controller::class, 'page_index'])
            ->name('page.index');

    });
