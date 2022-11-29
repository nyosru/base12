<?php

namespace App\Modules\Narod\Http\Controllers;

use App\Modules\Narod\Models\ShopKontr;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Page;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Auth;

use Nyos\Msg;

use Illuminate\Support\Facades\Mail;
use App\Mail\Narodorder2;

use App\Modules\Narod\Models\ShopOst;

class NarodController extends Controller
{

    static $nowSite = '';
    /**
     * получаем конфиг по сайту (тащим из домена)
     */
    public static function getNowCfg($sait = '')
    {
        if (
            $_SERVER['HTTP_HOST'] === 'nr.dev.php-cat.com' ||
            $_SERVER['HTTP_HOST'] === 'xn--80aaaovlboecchebw6s7a.xn--p1ai' ||
            $_SERVER['HTTP_HOST'] === 'didrive.b12.dev.php-cat.com'
        ) {
            self::$nowSite = 'narod';
        }
    }

    /**
     * @return Renderable
     */
    public function creatMsg(string $fio, string  $phone, array $kolvo, object $goods)
    {
        $text = '----- Новый заказ -----' . PHP_EOL;
        $text .= 'фио:' . ($fio ?? '--') . PHP_EOL;
        $text .= 'тел:' . ($phone ?? '--') . PHP_EOL . PHP_EOL;

        $summa = 0;

        // dd($kolvo);

        foreach ($goods as $g) {
            if (!empty($kolvo[$g->id]) && $kolvo[$g->id] > 0) {
                // dd($g);
                // $text .= $g->naimenovanie . ' ' . $g->dobavka . ' (' . $g->cena1 . '/' . $g->cena2 . '/' . $g->cena3 . ')' . PHP_EOL;
                $text .= $g->naimenovanie . ' ' . $g->dobavka . PHP_EOL . '( ' . ($kolvo[$g->id] ?? '0') . ' ед * ' . $g->cena3 . ' = ';
                $summa0 = $kolvo[$g->id] > 0 ?
                    (round($kolvo[$g->id] * str_replace(',', '.', $g->cena3), 2)) : 0;
                $summa += $summa0;
                $text .= $summa0 . 'р )';
                $text .= PHP_EOL . PHP_EOL;
                // $text .= $return['good_db'][$g->id] . ' ед.' . PHP_EOL . PHP_EOL;
            }
        }

        $text .= 'Итого: ' . $summa;

        return $text;
    }

    /**
     * sendOrder
     * @return Renderable
     */
    public function sendOrder(Request $request)
    {
        $in = [];
        foreach ($request->goods as $k => $v) {
            if (!empty($v)) {
                $in[] = $k;
            }
        }

        $res = ShopOst::find($in);
        // $i = $res->toArray();
        // select(['id','naimenovanie', 'dobavka','cena1','cena2','cena3'])->

        $text = self::creatMsg($request->fio, $request->phone, $request->goods, $res);


        // вячеслав
        Msg::$admins_id[] = 729843637;

        Msg::sendTelegramm($text, null, 1);

        dd([
            $text
            // $msg, 
            // $request->fio, $request->phone,
            //$i, 
            // $res, $request->goods, 789789
        ]);
    }

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $in = [
            // 'user0' => Auth::user() ,
            'user0' => session('user') ?? [],
            'dd' => 123
        ];
        return view('narod::index', $in);
    }

    public function api(Request $request)
    {

        // dd([11,
        // $request->method(),
        // $request->action,
        // $request->var1,
        // $request->all() ]);

        $return = [
            'm' => $request->method() ?? '',
            'a' => $request->action ?? '',
            'fio' => $request->fio ?? '',
            'phone' => $request->phone ?? '',
            'v1' => $request->var1 ?? ''
        ];

        if ($request->action == 'sendOrder') {

            $return['good_db'] = [];
            $searchId = [];
            foreach ($request->goods as $k => $v) {
                if ($v > 0) {
                    $return['good_db'][$k] = $v;
                    $searchId[] = $k;
                }
            }

            $return['res'] = true;

            $return['data1'] =
                $goods = DB::table('shop_osts')
                ->addSelect('id', 'naimenovanie', 'dobavka', 'organizaciya', 'cena1', 'cena2', 'cena3')
                ->whereIn('id', $searchId)
                ->get();

            $text = '----- Новый заказ -----' . PHP_EOL;
            $text .= 'фио:' . ($request->fio ?? '--') . PHP_EOL;
            $text .= 'тел:' . ($request->phone ?? '--') . PHP_EOL;
            $text .=  '-----------' . PHP_EOL;

            $summa = 0;

            foreach ($goods as $g) {
                // $text .= $g->naimenovanie . ' ' . $g->dobavka . ' (' . $g->cena1 . '/' . $g->cena2 . '/' . $g->cena3 . ')' . PHP_EOL;
                $text .= $g->naimenovanie . ' ' . $g->dobavka . PHP_EOL . '( ' . ($return['good_db'][$g->id] ?? '0') . ' ед * ' . $g->cena3 . ' = ';
                $summa0 = (round($return['good_db'][$g->id] * $g->cena3, 2));
                $summa += $summa0;
                $text .= $summa0 . 'р )';
                $text .= PHP_EOL . PHP_EOL;
                // $text .= $return['good_db'][$g->id] . ' ед.' . PHP_EOL . PHP_EOL;
            }

            $text .= 'Итого: ' . $summa;

            // вячеслав
            Msg::$admins_id[] = 729843637;
            // Msg::$admins_id[] = 729843637;

            Msg::sendTelegramm($text, null, 2);

            // $params = [
            //     'value' => 'Значение'
            // ];
            // // Mail::to('example@domain.ru')->send(new Feedback($params));
            // Mail::to('support@uralweb.info')->send(new Narodorder2());

            mail(
                "1@php-cat.com",
                "новый заказ",
                nl2br($text),
                "From: support@php-cat.com \r\n"
                    . "Content-type: text/html; charset=utf-8\r\n"
                    . "X-Mailer: PHP/" . phpversion()
            );

            mail(
                "svet-dobra@bk.ru",
                "новый заказ",
                nl2br($text),
                "From: support@php-cat.com \r\n"
                    . "Content-type: text/html; charset=utf-8\r\n"
                    . "X-Mailer: PHP/" . phpversion()
            );

            // $params = [
            //     'value' => 'Значение'
            // ];
            // Mail::to('1@uralweb.info')->send(new Narodorder2($params));

            Storage::put('narod-data-orders/' . date('Y-m-d_H:i:s') . '_' . $summa . '.txt', $text);
        }
        //
        elseif ($request->action == 'getVitrin') {

            // $return['data'] = self::scanData1C('narod-data/IMKontr.csv');
            // if( !empty($return['data']['data_rows']
            // DB::table('shop_kontrs')->truncate();
            // foreach ($return['data']['data_rows'] as $k) {
            //     ShopKontr::insert($k);
            // }

            $r = DB::table('shop_osts')
                // ->join('contacts', function ($join) {
                //     $join->on('users.id', '=', 'contacts.user_id')
                //         ->where(
                //             'contacts.user_id',
                //             '>',
                //             5
                //         );
                // })
                ->get();
            $return['data'] = [];
            foreach ($r as $v) {
                $v->cena1 = str_replace(['\'', ','], ['', '.'], $v->cena1);
                $v->cena2 = str_replace(['\'', ','], ['', '.'], $v->cena2);
                $v->cena3 = str_replace(['\'', ','], ['', '.'], $v->cena3);
                $return['data'][] = $v;
            }
        }

        //
        elseif ($request->action == 'getVitrinTrebs') {

            $return['data'] = DB::table('shop_pots')
                ->get();
        }

        //
        elseif ($request->action == 'getParticipation') {

            $return['data'] = DB::table('shop_pays')
                ->get();
        }

        //
        elseif ($request->action == 'getVitrinBalance') {

            // $return['data'] = self::scanData1C('narod-data/IMKontr.csv');
            // if( !empty($return['data']['data_rows']
            // DB::table('shop_kontrs')->truncate();
            // foreach ($return['data']['data_rows'] as $k) {
            //     ShopKontr::insert($k);
            // }

            $r = DB::table('shop_ocbs')
                // ->join('contacts', function ($join) {
                //     $join->on('users.id', '=', 'contacts.user_id')
                //         ->where(
                //             'contacts.user_id',
                //             '>',
                //             5
                //         );
                // })
                ->get();

            $nn = [];

            foreach ($r as $v) {

                // $v2 = $v->toArray();
                $ns = $v->{'nomer-sceta'};

                if (!isset($nn[$ns])) {
                    $v->start = true;
                    $nn[$ns] = 1;
                    $v->show = true;
                } else {
                    $v->start = false;
                    $v->show = false;
                }
                $return['data'][] = $v;
            }
        }


        //
        else if ($request->action == 'scanDataFiles') {

            $scanFiles = [];
            $scanFiles[] = ['db_table' => 'shop_firs', 'file' => 'narod-data/IMFir.csv'];
            // if (1 == 1)
            $scanFiles[] = ['db_table' => 'shop_kontrs', 'file' => 'narod-data/IMKontr.csv'];
            // if (1 == 1)
            $scanFiles[] = ['db_table' => 'shop_pays', 'file' => 'narod-data/IMPay.csv'];
            // if (1 == 1)
            $scanFiles[] = ['db_table' => 'shop_pay_its', 'file' => 'narod-data/IMPayIt.csv'];
            // if (1 == 1)
            $scanFiles[] = ['db_table' => 'shop_pay_trs', 'file' => 'narod-data/IMPayTr.csv'];
            // if (1 == 1)
            $scanFiles[] = ['db_table' => 'shop_sets', 'file' => 'narod-data/IMSet.csv'];
            // if (1 == 1)
            $scanFiles[] = ['db_table' => 'shop_ocbs', 'file' => 'narod-data/IMOCB.csv'];
            // if (1 == 2) // формат
            $scanFiles[] = ['db_table' => 'shop_osts', 'file' => 'narod-data/IMOst.csv'];
            // if (1 == 1)
            $scanFiles[] = ['db_table' => 'shop_parts', 'file' => 'narod-data/IMPart.csv'];
            // if (1 == 1)
            $scanFiles[] = ['db_table' => 'shop_pay_ns', 'file' => 'narod-data/IMPayN.csv'];
            // if (1 == 1) // формат
            $scanFiles[] = ['db_table' => 'shop_pots', 'file' => 'narod-data/IMPot.csv'];
            // if (1 == 1) // формат
            $scanFiles[] = ['db_table' => 'shop_proects', 'file' => 'narod-data/Proekt.csv'];

            $return['resAll'] = 0;
            $return['res0'] = [];

            foreach ($scanFiles as $tt) {
                $re = self::scanData1C($tt['db_table'], $tt['file']);
                $return['res0'][] = $re;
                $return['res'][$tt['file']] = sizeof($re['data_rows'] ?? []);
                $return['resAll'] += sizeof($re['data_rows'] ?? []);
            }

            if ($return['resAll'] > 0) {
                // вячеслав
                Msg::$admins_id[] = 729843637;
                Msg::sendTelegramm('Файлы данных обработаны, добавлено записей ' . ($return['resAll'] ?? 0), null, 2);
            }

            // Msg::sendTelegramm('Файлы данных обработаны, добавлено записей '. ( $return['resAll'] ?? 0 )  , null, 2);

            $return['data'] = '';
            // $return = [];
        }
        //
        else if ($request->action == 'pageText' && !empty($request->var1)) {

            self::getNowCfg();

            // $module = 'Narod';

            try {
                //code...

                $return['data'] =
                    // $ee =
                    Page::where('site', '=', self::$nowSite)->
                    // where('module', '=', $module)->
                    where('module', '=', $request->var1)->
                    // where('level', '=', $request->var1)->
                    firstOrFail();
                // $return['data'] = $ee->firstOrFail();
                // $return['data'] = 777;

            } catch (\Throwable $th) {
                $return['data'] = ['html' => 'нет странички / ' . self::$nowSite . ' / ' . $request->var1];
                //throw $th;
            }
        }

        return response()->json($return);
        // return view('narod::index');

    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public static function scanData1C($db_table, $file0, $codirovka = 'cp1251')
    {
        $return = ['scan_file' => $file0];

        if (Storage::exists($file0)) {

            $return['scan_file_y?'] = 'yes';

            // $return['data'] = self::scanData1C($file0);
            $dater = Storage::get($file0);
            // dd( iconv('cp1251','utf-8',$ee) );

            // переименование
            Storage::move($file0, $file0 . '.old.' . date('Ymd_his'));

            if ($codirovka == 'cp1251') {
                $dater = iconv('cp1251', 'utf-8', $dater);
            }

            // $return['data0'] = $dater;
            $dater1 = explode("\n", $dater);

            $return['data_head'] = [];
            $return['data_rows'] = [];

            // проверяем формат файла
            $format_foo = false;
            for ($i = 0; $i <= 15; $i++) {
                if (strpos($dater1[$i] ?? 'x', '@@@=') !== false)
                    $format_foo = true;
            }

            foreach ($dater1 as $row) {

                // $return['rr'][] = $row;

                if ($format_foo === true) {
                    if (strpos($row, '@@@=') !== false) {
                        $format_foo = false;
                    }
                    continue;
                }

                // тащим шапку, первый проход
                if (empty($return['data_head'])) {
                    $return['data_head_ru0'] = explode(';', $row);
                    foreach ($return['data_head_ru0'] as $k => $r) {
                        if (!empty($r)) {
                            $return['data_head'][$k] = !empty($r) ? str_slug($r) : null;

                            if ($db_table === 'shop_sets') {
                                if (str_slug($r) == 'data') $return['data_head'][] = 'data_ru';
                                elseif (str_slug($r) == 'datadokp') $return['data_head'][] = 'datadokp_ru';
                            }
                        }
                    }
                }
                // если шапку уже собрали, обрабатываем данные
                else {

                    $in = [];
                    $re = explode(';', $row);

                    foreach ($re as $k => $t) {

                        if (!empty($return['data_head'][$k])) {
                            $in[$return['data_head'][$k]] = trim($t);

                            if ($db_table === 'shop_sets') {
                                if ($return['data_head'][$k] === 'data') $in['data_ru'] = date('Y-m-d', strtotime(substr($t, 0, 6) . '20' . substr($t, 6, 2)));
                                elseif ($return['data_head'][$k] === 'datadokp') $in['datadokp_ru'] = date('Y-m-d', strtotime(substr($t, 0, 6) . '20' . substr($t, 6, 2)));
                            }
                        }
                    }

                    $return['data_rows'][] = $in;
                    // $return['data_rows'][] = explode(';', $row);
                }
            }

            if (!empty($return['data_rows'])) {
                // DB::table('shop_firs')->truncate();
                DB::table($db_table)->truncate();
                // foreach ($return['data']['data_rows'] as $k) {
                foreach ($return['data_rows'] as $k) {
                    // ShopKontr::insert($k);
                    // DB::table('shop_firs')->insert($k);
                    DB::table($db_table)->insert($k);
                    // DB::table('shop_firs')->insert($return['data_rows']);
                }
            }
        }

        return $return;
        // return view('narod::create');
    }

    // /**
    //  * Store a newly created resource in storage.
    //  * @param Request $request
    //  * @return Renderable
    //  */
    // public function store(Request $request)
    // {
    //     //
    // }

    // /**
    //  * Show the specified resource.
    //  * @param int $id
    //  * @return Renderable
    //  */
    // public function show($id)
    // {
    //     return view('narod::show');
    // }

    // /**
    //  * Show the form for editing the specified resource.
    //  * @param int $id
    //  * @return Renderable
    //  */
    // public function edit($id)
    // {
    //     return view('narod::edit');
    // }

    // /**
    //  * Update the specified resource in storage.
    //  * @param Request $request
    //  * @param int $id
    //  * @return Renderable
    //  */
    // public function update(Request $request, $id)
    // {
    //     //
    // }

    // /**
    //  * Remove the specified resource from storage.
    //  * @param int $id
    //  * @return Renderable
    //  */
    // public function destroy($id)
    // {
    //     //
    // }
}
