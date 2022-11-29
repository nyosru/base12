<?php

namespace App\Modules\Job\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
// use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Modules\Job\Models\Jobs;
use App\Modules\Job\Models\Cooperativ;
use App\Modules\Job\Models\Clients;
use App\Modules\Job\Models\Pays;
use App\Modules\Job\Models\Contract;

class JobController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {



        return view('job::index');
    }


    public function pageIndex()
    {
        $in = [];
        $in['jobs'] = Jobs::orderBy('kooperativ')->orderBy('nomer', 'desc')->get();
        // $in['clients'] = Clients::orderBy('kooperativ')->orderBy('nomer','desc')->get();

        $in['clients'] = Clients::ShowTable()->get();
        $h = $in['clients']->toArray();
        $in['clients_head'] = array_keys($h[0]);

        return view('job::index', $in);
    }



    public function pageCooperativ( )
    {

        $in = [];
        $in['jobs'] = Jobs::orderBy('kooperativ')->orderBy('nomer', 'desc')->get();
        // $in['clients'] = Clients::orderBy('kooperativ')->orderBy('nomer','desc')->get();

        return view('job::cooperativ', $in);
    }








    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create(Request $request)
    {

        // передаём массив пар поле/значение в конструктор:
        $new = new Jobs($request->all());
        // и не забудем сохранить новую запись:
        $new->save();

        return redirect()->route('job.index');
    }

    public function createCooperativ(Request $request)
    {

        // передаём массив пар поле/значение в конструктор:
        $new = new Cooperativ($request->all());
        // и не забудем сохранить новую запись:
        $new->save();

        return redirect()->route('job.index');
    }




    public function pageClients()
    {
        $in = [];
        $in['clients'] = Clients::ShowTable()->get();
        $h = $in['clients']->toArray();
        $in['clients_head'] = array_keys($h[0] ?? [1, 2, 3]);

        return view('job::clients', $in);
    }

    public function createClient(Request $request)
    {

        // передаём массив пар поле/значение в конструктор:
        $new = new Clients($request->all());
        // и не забудем сохранить новую запись:
        $new->save();

        return back();
        // return redirect()->route('job.index');
    }






    public function pagePays()
    {
        $in = [];
        $in['data'] = Pays::ShowTable()->get();
        $h = $in['data']->toArray();
        $in['data_head'] = array_keys($h[0] ?? [1, 2, 3]);
        $in['data_head'][] = 'Object';

        $in['d_job_client_id'] = Clients::ShowTable()->get();

        $in['d_job_jobs_id'] = Jobs::ShowTable()->get();

        // dd($in['d_job_jobs_id']);

        return view('job::pays', $in);
    }

    public function createPays(Request $request)
    {

        // передаём массив пар поле/значение в конструктор:
        // dd($request->all());
        $new = new Pays($request->all());
        // и не забудем сохранить новую запись:
        $new->save();

        return back();
        // return redirect()->route('job.index');
    }






    public function pageContract()
    {
        $in = [];

        $in['data'] = Contract::ShowTable()->get();
        $h = $in['data']->toArray();
        $in['data_head'] = array_keys($h[0] ?? [1, 2, 3]);
        $in['data_head'][] = 'Object';

        $in['d_job_client_id'] = Clients::ShowTable()->get();
        $in['d_job_jobs_id'] = Jobs::ShowTable()->get();
        // dd($in['d_job_jobs_id']);

        return view('job::contract', $in);

    }

    public function createContract(Request $request)
    {

        // передаём массив пар поле/значение в конструктор:
        // dd($request->all());
        $new = new Contract($request->all());
        // и не забудем сохранить новую запись:
        $new->save();

        return back();
        // return redirect()->route('job.index');
    }










    public function pageLive()
    {

        $in = [];

        $i = Contract::GetLive()->get();
        $in['data'] = $i->toArray();

        // $in['data'] = Contract::ShowTable()->get();
        // $h = $in['data']->toArray();
        // $in['data_head'] = array_keys($h[0] ?? [1, 2, 3]);
        // $in['data_head'][] = 'Object';

        $in['d_job_client_id'] = Clients::ShowTable()->get();
        $in['d_job_jobs_id'] = Jobs::ShowTable()->get();
        // dd($in['d_job_jobs_id']);

        return view('job::live', $in);

    }

    // public function createContract(Request $request)
    // {

    //     // передаём массив пар поле/значение в конструктор:
    //     // dd($request->all());
    //     $new = new Contract($request->all());
    //     // и не забудем сохранить новую запись:
    //     $new->save();

    //     return back();
    //     // return redirect()->route('job.index');
    // }











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
        return view('job::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('job::edit');
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
