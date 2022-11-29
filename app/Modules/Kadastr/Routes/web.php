<?php

use App\Modules\Kadastr\Http\Controllers\KadastrController;

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

// Route::prefix('kadastr')->group(function() {
//     Route::get('/', 'KadastrController@index');
// });

Route::domain('zz1.php-cat.com')->name('ka.')->group(function () {


    /**
     * ещё какая то страничка
     */
    // Route::get('/kk/', function () {
    //     return response()->json([    'name' => 'Abigail',    'state' => 'CA']);
    //     // return redirect('/lk');
    // });


    /**
     * главная или любая другая страничка
     */
    Route::get('{any}', [KadastrController::class, 'page_index'])
        ->name('page_index')
        // return response()->json([    'name' => '000Abigail',    'state' => '00CA']);
        // return redirect('/lk');
        ->where('any', '.*')
        ;

});


