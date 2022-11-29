<?php

namespace App\Http\Controllers;

use App\classes\trends\HistorySnapshotDataLoader;
use App\classes\trends\TrendPeriods;
use App\classes\trends\TrendsChart;
use App\classes\trends\TrendsChartEl;
use App\OpsSnapshotCountryPreset;
use App\OpsSnapshotTitle;
use App\OpsSnapshotTitleGroup;
use App\TmfCountry;
use Illuminate\Http\Request;

class OpsTrendsController extends Controller
{
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
        $last=6;
//        $detalization='Months';
        $detalization='Weeks';

        $tp=TrendPeriods::init($last,$detalization);
        $chart_data=$this->getChartData();
        $ops_snapshot_country_preset_obj=OpsSnapshotCountryPreset::find(4);
//        $countries=$ops_snapshot_country_preset_obj->tmfCountries()->pluck('tmf_country.id')->toArray();

        $tchart=new TrendsChart($tp,$chart_data,$ops_snapshot_country_preset_obj);

//        foreach($tchart->getDatasets() as $dataset_el)
//            echo array_values($dataset_el)[0]['trends_chart_id']."<br/>";
//        exit;
//        dd(array_values($tchart->getDatasets()));
        $ops_snapshot_title_group_objs=OpsSnapshotTitleGroup::orderBy('id','asc')->get();
        $other_countries=$this->getOtherCountriesIds();
        $periods=view('ops-trends.periods',compact('tchart'));
        $config=view('ops-trends.config',compact('tchart'));
        return view('ops-trends.index',
            compact('other_countries','tchart','chart_data','ops_snapshot_title_group_objs','config','periods')
        );
    }

    public function reloadCharts(Request $request){
        $countries=json_decode($request->countries,true);
        $ops_snapshot_country_preset=OpsSnapshotCountryPreset::where('name',implode('+',$countries))->first();
        $last=$request->days;
        $detalization=$request->period;

        $tp=TrendPeriods::init($last,$detalization);
        $chart_data=$this->getChartData();


        $tchart=new TrendsChart($tp,$chart_data,$ops_snapshot_country_preset);
        return response()->json([
            view('ops-trends.periods',compact('tchart'))->render(),
            view('ops-trends.config',compact('tchart'))->render()
        ]);

    }

    private function getOtherCountriesIds(){
        $objs=TmfCountry::select('id')->whereNotIn('id',[8,9])->get();
        $data=[];
        foreach ($objs as $el)
            $data[]=$el->id;
        return $data;
    }

    private function getChartData(){
        return OpsSnapshotTitle::orderBy('ops_snapshot_title_group_id','asc')
            ->orderBy('chart_group_num','asc')
            ->get();
    }


    public function loadChartDetails(Request $request){
        $countries=json_decode($request->countries,true);
        $ops_snapshot_country_preset=OpsSnapshotCountryPreset::where('name',implode('+',$countries))->first();
        $ops_snapshot_title=OpsSnapshotTitle::find($request->ops_snapshot_title_id);

        $static_method = $ops_snapshot_title->code . 'DataLoader';
        $obj=HistorySnapshotDataLoader::$static_method(
            $ops_snapshot_country_preset,
            new \DateTime($request->from_date.' 00:00:00'),
            new \DateTime($request->to_date.' 23:59:59')
        );

        return $obj->showDetails()->render();
    }


}
