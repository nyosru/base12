<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Bni;
use App\BniMeeting;

class BniAmericaResultsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $result_table=$this->getResultTable();
        $regions_filters=$this->getRegionsFilter();
        return view('bniamerica-results.index',
            compact('result_table','regions_filters'));
    }

    private function getRegionsFilter(){
        $objs=BniMeeting::select('region_id')
            ->distinct()
            ->orderBy('region_id')
            ->get();
        return view('bniamerica-results.regions-filters',compact('objs'));
    }

    private function getResultTable($region_ids=null){
        if(is_null($region_ids))
            $objs=BniMeeting::all();
        else
            $objs=BniMeeting::whereIn('region_id',$region_ids)->get();

        return view('bniamerica-results.result-table',compact('objs'));
    }

}
