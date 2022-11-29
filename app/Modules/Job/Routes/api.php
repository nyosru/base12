<?php

use Illuminate\Http\Request;

use App\Modules\Job\Http\Controllers\JobController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/job', function (Request $request) {
//     return $request->user();
// });

Route::domain('j.php-cat.com')
// ->name('job.')
// ->prefix('job')
->group(function () {

    // Route::post('pays', [JobController::class, 'apiPaysShow'])
    // 
    // Route::get('index', [JobController::class, 'pageShow'])
    //->name('index')
    // ;

    Route::post('pays', [JobController::class, 'apiPaysShow']);

//     Cooperativ

});