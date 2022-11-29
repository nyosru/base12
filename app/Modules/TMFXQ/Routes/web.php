<?php

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

Route::get('/queue-random-check','QueueRandomCheckController@index');
Route::get('/queue-random-check/reload-tm/{dashboard_id}','QueueRandomCheckController@loadTmData');
Route::get('/queue-random-check/reload-queue-status/{dashboard_id}','QueueRandomCheckController@loadQueueStatus');
Route::get('/queue-random-check/reload-context-menu/{dashboard_id}','QueueRandomCheckController@loadContextMenu');
Route::get('/queue-random-check/reload-tss/{dashboard_id}','QueueRandomCheckController@loadTss');
Route::post('/queue-random-check/all-good/{dashboard_id}','QueueRandomCheckController@saveAllGoodCondition');
Route::post('/queue-random-check/new-status-note/{dashboard_id}','QueueRandomCheckController@newStatusNote');
