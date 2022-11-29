<?php

namespace App\Modules\Rem7\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class Rem7Controller extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        return view('rem7::index');
    }

    public function page_index()
    {

        $inin = [];
        $inin['uslugi'] = [
            ['name' => 'ОБРАЩЕНИЕ К МАСТЕРУ', 'opis' => 'Вызов мастера или доставка техники до мастерской'],
            ['name' => 'ДИАГНОСТИКА ТЕХНИКИ', 'opis' => 'Нахождение неисправных блоков или компонентов'],
            ['name' => 'РЕМОНТ И ЗАМЕНА', 'opis' => 'Замена неисправных узлов и компонентов на новые'],
            ['name' => 'НАСТРОЙКА И НАЛАДКА', 'opis' => 'Установление настроек техники до заводских параметров'],
            ['name' => 'ПРОВЕРКА ТЕХНИКИ', 'opis' => 'Испытание аппарата в максимально допустимых режимах'],
            ['name' => 'ГАРАНТИЯ 30 ДНЕЙ', 'opis' => 'Предоставление гарантии на работу и запчасти'],
        ];

        $inin['remont_items'] = [

            ['name' => 'Смартфон'],
            ['name' => 'Компьютер'],
            ['name' => 'Телевизор'],
            // ['name' => 'Гироскутер'],
            ['name' => 'Робот-пылесос'],
            ['name' => 'Видеорегистратор'],
            // [ 'name' => 'Бытовая техника' ],
            ['name' => 'Кофемашина'],
            // ['name' => 'МФУ, Принтер, сканер'],
            // ['name' => 'Источник бесперебойного питания'],
            // [ 'name' => '' ],
            // [ 'name' => '' ],

        ];


        // $inin['otzuvs'] = [
        //     ['who' => 'Иван петров', 'text' => 'Хороший ремонт всё такое'],
        //     ['who' => 'Иван петров', 'text' => 'Хороший ремонт всё такое'],
        //     ['who' => 'Иван петров', 'text' => 'Хороший ремонт всё такое'],
        //     ['who' => 'Иван петров', 'text' => 'Хороший ремонт всё такое'],
        //     ['who' => 'Иван петров', 'text' => 'Хороший ремонт всё такое'],
        // ];

        // dd([123123]);
        return view('rem7::page_index', $inin);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('rem7::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('rem7::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('rem7::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
    }
}
