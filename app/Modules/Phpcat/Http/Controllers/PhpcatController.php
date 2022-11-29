<?php

namespace App\Modules\Phpcat\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

use App\Modules\Phpcat\Models\News;
use App\Modules\Phpcat\Models\Tests;

class PhpcatController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        return view('phpcat::index');
    }


    public function apiGet($model)
    {

        $return = [
            'model' => $model,
            'result' => ''
        ];

        if ($model == 'news') {

            $return['result'] =
                News::orderBy('date', 'DESC')
                ->get();
        } else if ($model == 'tests') {

            $return['result'] =
                Tests::orderBy('date', 'DESC')
                ->get();
        }

        return response()->json($return);
    }


    public function apiPost(Request $request, $model)
    {

        $return = [
            'model' => $model
        ];

        if ($model == 'tests') {

            if ($request->isMethod('delete')) {

                if ($request->id) {
                    $return['result'] = Tests::destroy($request->id);
                }

            } else {

                // $in_db = [
                //     'head' => $request->head,
                //     'date' => $request->date,
                //     'text' => $request->text,
                // ];

                $return['val'] =
                    $in_db = $request->validate([
                        'head' => 'string',
                        'date' => 'string',
                        'text' => 'string|nullable',
                        'code' => 'string|nullable',
                        'link1' => 'string|nullable',
                        'link2' => 'string|nullable',
                        'link3' => 'string|nullable',
                        // 'head' => '|boolean'
                        // 'title' => 'required|unique:posts|max:255',
                        // 'author.name' => 'required',
                        // 'author.description' => 'required',
                    ]);

                // $return['res'] = Tests::insert($request);
                $return['result'] = DB::table('phpcat-tests')->insert($in_db);
            }
        } else if ($model == 'news') {

            if ($request->isMethod('delete')) {

                if ($request->id) {
                    $return['res'] = News::destroy($request->id);
                }
            } elseif ($request->isMethod('post')) {

                $in_db = [
                    'head' => $request->head,
                    'date' => $request->date,
                    'text' => $request->text,
                ];

                if (!empty($request->link)) {
                    $in_db['link'] = $request->link;
                }

                if ($request->hasFile('attachment')) {
                    $path = $request->file('attachment')
                        ->store('phpcat-news', 'public');
                    $in_db['img'] = Storage::url($path);
                }

                $return['result'] = DB::table('phpcat-news')->insert($in_db);
            }
        }

        return response()->json($return);
        // return view('phpcat::create');
    }









    // /**
    //  * Show the form for creating a new resource.
    //  * @return Renderable
    //  */
    // public function create()
    // {
    //     return view('phpcat::create');
    // }

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
    //     return view('phpcat::show');
    // }

    // /**
    //  * Show the form for editing the specified resource.
    //  * @param int $id
    //  * @return Renderable
    //  */
    // public function edit($id)
    // {
    //     return view('phpcat::edit');
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
