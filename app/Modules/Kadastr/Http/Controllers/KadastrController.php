<?php

namespace App\Modules\Kadastr\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class KadastrController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        return view('kadastr::index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('kadastr::create');
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
        return view('kadastr::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('kadastr::edit');
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


    public function page_index()
    {

        $in = [
            'uslugi' =>
            [
                [
                    'head' => 'Межевание земельного участка',
                    'opis' => '',
                    'price' => 5000
                ],
                [
                    'head' => 'Вынос границ в натуру',
                    'opis' => '',
                    'price' => 3500
                ],
                [
                    'head' => 'Технический план',
                    'opis' => '',
                    'price' => 3500
                ],
                [
                    'head' => 'Раздел, обьединение и перераспределение участков',
                    'opis' => '',
                    'price' => 5500
                ],
                [
                    'head' => 'Сопровождение сделки',
                    'opis' => '',
                    'price' => 8000
                ],
                [
                    'head' => 'Оформление под ключ',
                    'opis' => '',
                    'price' => 10000
                ],
                [
                    'head' => 'Поэтажный план, экспедиция',
                    'opis' => '',
                    'price' => 2000
                ],
                [
                    'head' => 'Акт обследования',
                    'opis' => '',
                    'price' => 2500
                ],
                [
                    'head' => 'Увеличение площади участка, оформление прирезки',
                    'opis' => '',
                    'price' => 5500
                ],
                [
                    'head' => 'Уведовление о строительстве/реконструкции',
                    'opis' => '',
                    'price' => 3000
                ],
            ]
        ];

        return view('kadastr::page_index', $in);
    }
}
