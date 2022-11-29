<?php

// use app/modules/Buh/Http/controllers/BuhController;
// use App\Modules\Buh\Http\Controllers\BuhController;

use App\Modules\Buh\Http\Controllers\BuhController;
use App\Modules\Buh\Http\Controllers\DidriveController;
// use App\Modules\Buh\Http\Controllers\UloginController;

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





Route::post('ulogin', [UloginController::class, 'login']);

Route::get('/logout', function (Auth $a) {
    $a::logout();
    return redirect('/');
});


Route::get('/aut_load', function (Auth $a) {

    $user = Auth::user();
    return response()->json([
        'status' => 'okey',
        'result' => [
            'id' => ( $user->id ?? false ),
            'name' => ($user->name ?? '')
        ]
    ]);
    // return response()->json(['status' => ( $a::id() ? 'okey' : 'error' ) , 'result' => $user ?? false ]);

});




Route::name('didrive.')
    ->prefix('didrive')
    ->group(function () {

        // Route::prefix('buh')->group(function() {
        Route::get('', [DidriveController::class, 'index']);

    });



Route::domain('buh2.dev.php-cat.com')
    ->name('job.')
    // ->prefix('job')
    ->group(function () {

        Route::post('ulogin', [ UloginController::class, 'login' ] );

        // Route::prefix('buh')->group(function() {
        Route::get('index', [BuhController::class, 'index']);

    });
