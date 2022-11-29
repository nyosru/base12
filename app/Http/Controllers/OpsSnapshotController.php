<?php

namespace App\Http\Controllers;

use App\classes\opsreport\SnapshotStatusInfo;
use App\classes\trends\OpsSnapshotsReloader;
use App\DashboardInTimingsType;
use App\DashboardV2;
use App\TmfCountry;
use App\traits\OpsStatTrait;
use Illuminate\Http\Request;

class OpsSnapshotController extends Controller
{
    use OpsStatTrait;
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
        $data=$this->getData($this->getAllCountriesIds());
        $result_table=$this->getResultTable($data);
        $other_countries=$this->getOtherCountriesIds();
        return view('ops-snapshot.index',compact('result_table','other_countries'));
    }

    private function getResultTable($data){
        return view('ops-snapshot.result-table',compact('data'))->render();
    }

    private function getOtherCountriesIds(){
        $objs=TmfCountry::select('id')->whereNotIn('id',[8,9])->get();
        $data=[];
        foreach ($objs as $el)
            $data[]=$el->id;
        return $data;
    }

    private function getAllCountriesIds(){
        $objs=TmfCountry::select('id')->get();
        $data=[];
        foreach ($objs as $el)
            $data[]=$el->id;
        return $data;
    }

    private function getData($countries){
        $data=[];
        $data[]=['caption'=>'Searching','status-info'=>new SnapshotStatusInfo([375],$countries),'border-top'=>0,'font-style'=>'normal'];
        $data[]=['caption'=>'Drafting','status-info'=>new SnapshotStatusInfo([376],$countries),'border-top'=>0,'font-style'=>'normal'];
        $data[]=['caption'=>'Waiting for Client Input Before Filing','status-info'=>new SnapshotStatusInfo([390,391,392,397],$countries),'border-top'=>0,'font-style'=>'normal'];
        $data[]=['caption'=>'<span class="ml-3 mr-3">&mdash;</span>Client to Move Forward','status-info'=>new SnapshotStatusInfo([390],$countries),'border-top'=>0,'font-style'=>'italic'];
        $data[]=['caption'=>'<span class="ml-3 mr-3">&mdash;</span>Client to Provide Info','status-info'=>new SnapshotStatusInfo([391],$countries),'border-top'=>0,'font-style'=>'italic'];
        $data[]=['caption'=>'<span class="ml-3 mr-3">&mdash;</span>Client to Approve Draft','status-info'=>new SnapshotStatusInfo([392],$countries),'border-top'=>0,'font-style'=>'italic'];
        $data[]=['caption'=>'<span class="ml-3 mr-3">&mdash;</span>Client to Pay Govt. Fees','status-info'=>new SnapshotStatusInfo([397],$countries),'border-top'=>0,'font-style'=>'italic'];

        $data[]=['caption'=>'Minor OA','status-info'=>new SnapshotStatusInfo([378],$countries),'border-top'=>1,'font-style'=>'normal'];
        $data[]=['caption'=>'Major OA','status-info'=>new SnapshotStatusInfo([381],$countries),'border-top'=>0,'font-style'=>'normal'];
        $data[]=['caption'=>'Suspended','status-info'=>new SnapshotStatusInfo([377],$countries),'border-top'=>0,'font-style'=>'normal'];
        $data[]=['caption'=>'Waiting for Client to ROA','status-info'=>new SnapshotStatusInfo([394,393],$countries),'border-top'=>0,'font-style'=>'normal'];
        $data[]=['caption'=>'<span class="ml-3 mr-3">&mdash;</span>Client to Provide Info for ROA','status-info'=>new SnapshotStatusInfo([394],$countries),'border-top'=>0,'font-style'=>'italic'];
        $data[]=['caption'=>'<span class="ml-3 mr-3">&mdash;</span>Client to Pay Govt. Fees for ROA','status-info'=>new SnapshotStatusInfo([393],$countries),'border-top'=>0,'font-style'=>'italic'];
        $data[]=['caption'=>'ROA Submitted & Awaiting Review','status-info'=>new SnapshotStatusInfo([383],$countries),'border-top'=>0,'font-style'=>'normal'];

        $data[]=['caption'=>'Published','status-info'=>new SnapshotStatusInfo([4],$countries),'border-top'=>1,'font-style'=>'normal'];
        $data[]=['caption'=>'Proposed Opposition','status-info'=>new SnapshotStatusInfo([379],$countries),'border-top'=>0,'font-style'=>'normal'];
        $data[]=['caption'=>'Opposed','status-info'=>new SnapshotStatusInfo([380],$countries),'border-top'=>0,'font-style'=>'normal'];

        $data[]=['caption'=>'Allowed','status-info'=>new SnapshotStatusInfo([5],$countries),'border-top'=>1,'font-style'=>'normal'];
        $data[]=['caption'=>'Post-Allowance OA','status-info'=>new SnapshotStatusInfo([384],$countries),'border-top'=>0,'font-style'=>'normal'];
        $data[]=['caption'=>'Post-Allowance Fees Paid / Post-Allowance ROA Submitted & Awaiting Review','status-info'=>new SnapshotStatusInfo([398,385],$countries),'border-top'=>0,'font-style'=>'normal'];
        $data[]=['caption'=>'Waiting for Client to ROA','status-info'=>new SnapshotStatusInfo([395,396],$countries),'border-top'=>0,'font-style'=>'normal'];
        $data[]=['caption'=>'<span class="ml-3 mr-3">&mdash;</span>Client to Provide Info for ROA','status-info'=>new SnapshotStatusInfo([395],$countries),'border-top'=>0,'font-style'=>'italic'];
        $data[]=['caption'=>'<span class="ml-3 mr-3">&mdash;</span>Client to Pay Govt. Fees for ROA','status-info'=>new SnapshotStatusInfo([396],$countries),'border-top'=>0,'font-style'=>'italic'];

        return $data;
    }

    public function reloadTable(Request $request){
        $countries=json_decode($request->countries);
        if(json_last_error()==JSON_ERROR_NONE){
            $data=$this->getData($countries);
            return $this->getResultTable($data);
        }
        return '';
    }


    public function loadingDetails(Request $request){
        $ids_assoc=json_decode($request->ids,true);
        $today=new \DateTime();
        if(json_last_error()==JSON_ERROR_NONE){
            $ids=[];
            foreach ($ids_assoc as $el)
                $ids[]=$el['id'];
            $dashboard_objs=DashboardV2::whereIn('id',$ids)->get();
            $data=[];
            foreach ($dashboard_objs as $dashboard_obj){

                if($dashboard_obj->formalized_status_modified_at=='0000-00-00 00:00:00')
                    $date=new \DateTime($dashboard_obj->created_at);
                else
                    $date=new \DateTime($dashboard_obj->formalized_status_modified_at);
                $diff=$today->getTimestamp()-$date->getTimestamp();

                $data[]=[
                    'id'=>$dashboard_obj->id,
                    'trademark'=>$this->getTrademark($dashboard_obj->tmfCountryTrademark,$dashboard_obj->id),
                    'client'=>$dashboard_obj->tmfCompany->name,
                    'status'=>$dashboard_obj->cipostatusStatusFormalized->status,
                    'status-since'=>$date->format('F j, Y g:ia'),
                    'days-till-now'=>round($diff/(24 * 3600),2),
                    'in-trends'=>$dashboard_obj->dashboard_in_timings_type_id
                ];
            }

            $dashboard_in_timings_type_objs=DashboardInTimingsType::orderBy('id')->get();
            return view('ops-snapshot.details-table',compact('data','dashboard_in_timings_type_objs'));
        }
        return '';
    }

    public function updateDashboardInTimingsType(Request $request){
        $dashboard_obj=DashboardV2::find($request->dashboard_id);
        if($dashboard_obj){
            $dashboard_obj->dashboard_in_timings_type_id=$request->id;
            $dashboard_obj->save();
            if($dashboard_obj->dashboard_in_timings_type_id==1)
                $active=1;
            else
                $active=0;
            (new OpsSnapshotsReloader($dashboard_obj->id))->run($active);
            return 'DONE';
        }
        return '';
    }

}
