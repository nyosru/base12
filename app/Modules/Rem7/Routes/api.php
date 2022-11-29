<?php

use Illuminate\Http\Request;

use Nyos\Msg;

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

Route::middleware('auth:api')->get('/rem7', function (Request $request) {
    return $request->user();
});

Route::post('/send_form', function (Request $request) {

    $vars = $request->all();

    $phone = preg_replace("/[^0-9]/", '', $request->phone ?? '');

    if ( strlen($phone) > 5) {
        // $vars_ar = [];
        $txt = '';
        foreach ($vars as $k => $v) {

            // $vars_ar[$k] = $v;
            $txt .= $k . ': ' . $v . PHP_EOL;
        }

        // мой тест ак
        // Msg::$admins_id[] = 1367479173;
        // сергей афанасьев
        Msg::$admins_id = [1609843660];
        // я
        // Msg::$admins_id[] = 360209578;

        Msg::sendTelegramm($txt, null, 2);

        $re = [
            'status' => 'ok',
            'text' => 'Телефон ' . $phone . ' отправлен, в ближайшее рабочее время позвоним',
            // 'vars' => $request,
            // 'vars_p' => $request->phone,
            // 'vars1' => $vars,
            // 'vars2' => $vars_ar
        ];
    } else {
        $re = [
            'status' => 'ok',
            'text' => 'Телефона не обнаружено, ничего не отправлено, спасибо',
        ];
    }

    return response()->json($re);
    // return $request->user();

})
    ->name('page.index');
