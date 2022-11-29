<?php

use Illuminate\Http\Request;

// use App\Http\Controllers\Api\v1\SendMsgController;
use App\Modules\Narod\Http\Controllers\NarodController;

// народнаяэкономика.рф
Route::domain('xn--80aaaovlboecchebw6s7a.xn--p1ai')->group(function () {
    // Route::post('sendOrder', [SendMsgController::class, 'sendTelegramm']);
    Route::post('sendOrder', [NarodController::class, 'sendOrder']);
});