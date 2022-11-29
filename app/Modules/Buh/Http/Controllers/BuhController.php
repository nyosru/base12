<?php

namespace App\Modules\Buh\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class BuhController extends Controller
{

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {

        // $menu = [
        //     'Raschet_zarabotnoy_platyi' => [ 'name' => 'Расчет заработной платы' ] ,
        //     'https://xn--72-9kcq9deapt.xn--p1ai/010.uslugi/Nalogovyiy_audit/' => [ 'name' => 'Налоговый аудит' ] ,
        //     'https://xn--72-9kcq9deapt.xn--p1ai/010.uslugi/Sverka_raschetov_s_byudzhetom/' => [ 'name' => 'Сверка расчетов с бюджетом' ] ,
        //     'https://xn--72-9kcq9deapt.xn--p1ai/010.uslugi/Vozmeschenie_NDS/' => [ 'name' => 'Возмещение НДС' ] ,
        //     'https://xn--72-9kcq9deapt.xn--p1ai/010.uslugi/Nalogovoe_planirovanie_i_optimizatsiya_nalogooblozheniya/' => [ 'name' => 'Налоговое планирование и оптимизация налогообложения' ] ,
        //     '' => [ 'name' => 'Регистрация ООО , ИП' ] ,
        //     '' => [ 'name' => 'Ликвидация ООО, ИП' ] ,
        //     '' => [ 'name' => 'Прочие юридические услуги' ] ,
        //     '' => [ 'name' => 'Нулевая отчетность' ] ,
        //     '' => [ 'name' => 'Бухгалтерское сопровождение и обслуживание' ] ,
        //     '' => [ 'name' => 'Составление и сдача отчетности' ] ,
        //     '' => [ 'name' => 'Восстановление бухгалтерского учета' ] ,
        //     '' => [ 'name' => 'Консультирование' ]
        // ];

        // dd( 2222222 );
        return view('buh::index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('buh::create');
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
        return view('buh::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('buh::edit');
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
