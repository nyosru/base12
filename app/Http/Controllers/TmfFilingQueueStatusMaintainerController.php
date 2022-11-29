<?php

namespace App\Http\Controllers;

use App\classes\queue\FlagSettings;
use App\DashboardTssTemplate;
use App\QueueFlagSettings;
use App\QueueStatusType;
use App\TmfFilingQueueRootStatus;
use App\TmfFilingQueueStatus;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TmfFilingQueueStatusMaintainerController extends Controller
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

    public function index(){
        $flag_settings=new FlagSettings();
        $flags_prefixes=[
            [
                'caption'=>'warning',
                'class'=>'badge badge-warning',
            ],
            [
                'caption'=>'danger',
                'class'=>'badge badge-danger',
            ]
        ];

        $queue_status_type_objs=QueueStatusType::all();
        return view('tmf-filing-queue-status-maintainer.index',
            compact('flag_settings','flags_prefixes','queue_status_type_objs'));
    }

    public function loadRootStatuses(){
        $tmf_filing_queue_root_status_objs=TmfFilingQueueRootStatus::orderBy('place_id','asc')->get();
        $status_type='root-status';
        return view('tmf-filing-queue-status-maintainer.statuses-list',
            compact('tmf_filing_queue_root_status_objs','status_type'));
    }

    public function loadRootStatusOptions(){
        $tmf_filing_queue_root_status_objs=TmfFilingQueueRootStatus::orderBy('place_id','asc')->get();
        return view('tmf-filing-queue-status-maintainer.root-status-options',
            compact('tmf_filing_queue_root_status_objs'));
    }

    public function dashboardTssOptions(Request $request){
        $global_status_tss_objs=DashboardTssTemplate::where('dashboard_global_status_id',$request->global_status_id)
            ->get();
        $cipostatus_status_formalized_tss_objs=DashboardTssTemplate::where('cipostatus_status_formalized_id',
            $request->dashboard_status_id)
            ->get();
        return view('tmf-filing-queue-status-maintainer.dashboard-tss-options',
            compact('global_status_tss_objs','cipostatus_status_formalized_tss_objs'));
    }

    public function loadSubStatuses(Request $request){
        $tmf_filing_queue_root_status_obj=TmfFilingQueueRootStatus::find($request->id);
        if($tmf_filing_queue_root_status_obj){
            $status_type='sub-status';
            return view('tmf-filing-queue-status-maintainer.sub-statuses-list',
                compact('tmf_filing_queue_root_status_obj','status_type'));

        }
        return '';
    }

    public function saveStatus(Request $request){
        if($request->action=='root-status')
            return $this->saveNewRootStatus($request);
        else
            return $this->saveNewSubStatus($request);

    }

    private function saveNewRootStatus(Request $request){
        if($request->id){
            $obj=TmfFilingQueueRootStatus::find($request->id);
            $obj->name = $request->name;
        }else {
            $obj = new TmfFilingQueueRootStatus();
            $obj->name = $request->name;
            $obj->place_id = TmfFilingQueueRootStatus::all()->count();
        }
        $obj->save();
        return 'Done';
    }

    private function getQueueFlagSettingsId($data){
        $obj=QueueFlagSettings::where('dashboard_relative_start_date_type_id',$data['relative_date_type'])
            ->where('plus_minus_settings_id',$data['plus_minus_settings'])
            ->where('plus_minus',$data['plus_minus'])
            ->where('year',$data['year'])
            ->where('month',$data['month'])
            ->where('day',$data['day'])
            ->where('hour',$data['hour'])
            ->first();
        if(!$obj){
            $obj=new QueueFlagSettings();
            $obj->dashboard_relative_start_date_type_id=$data['relative_date_type'];
            $obj->plus_minus_settings_id=$data['plus_minus_settings'];
            $obj->plus_minus=($data['plus_minus']=='+'?1:-1);
            $obj->year=$data['year'];
            $obj->month=$data['month'];
            $obj->day=$data['day'];
            $obj->hour=$data['hour'];
            $obj->created_at=Carbon::now()->format('Y-m-d H:i:s');
            $obj->save();
        }
        return $obj->id;
    }

    private function saveNewSubStatus(Request $request){
        if($request->id){
            $obj=TmfFilingQueueStatus::find($request->id);
        }else{
            $obj=new TmfFilingQueueStatus();
            $obj->place_id=TmfFilingQueueStatus::all()->count();
        }
        $obj->name=$request->name;
        $obj->tmf_filing_queue_root_status_id=$request->parent_id;
        $obj->cipostatus_status_formalized_id=$request->cipostatus_status_formalized_id;
        $obj->dashboard_global_status_id=$request->global_status_id;
        if($request->tss_template_id)
            $obj->dashboard_tss_template_id=$request->tss_template_id;
        $obj->queue_status_type_id=$request->queue_status_type;
        $obj->description=$request->description;
//        if($obj->status_color=$request->status_color)
//            $obj->status_color=$request->status_color;
//        $obj->deadline_warning_hours=$request->warning_hrs;
//        $obj->deadline_overdue_hours=$request->overdue_hrs;
//        $obj->hours_calculation_method_id=$request->hrs_calculation_method;
        $flag_settings_data=json_decode($request->flags_settings_data,true);
        if(json_last_error()==JSON_ERROR_NONE)
            foreach ($flag_settings_data as $key=>$data){
                $field=$key.'_flag_settings_id';
                $obj->$field=$this->getQueueFlagSettingsId($data);
            }
        $obj->save();
        return 'DONE';
    }

    public function reorderRootStatuses(Request $request){
        $ids=json_decode($request->arr,true);
        if(json_last_error()==JSON_ERROR_NONE){
            foreach ($ids as $index=>$id){
                $obj=TmfFilingQueueRootStatus::find($id);
                $obj->place_id=$index+1;
                $obj->save();
            }
            return 'DONE';
        }
        return '';
    }

    public function reorderSubStatuses(Request $request){
        $ids=json_decode($request->arr,true);
        if(json_last_error()==JSON_ERROR_NONE){
            foreach ($ids as $index=>$id){
                $obj=TmfFilingQueueStatus::find($id);
                $obj->place_id=$index+1;
                $obj->save();
            }
            return 'DONE';
        }
        return '';
    }

    public function removeRootStatus(Request $request){
        $obj=TmfFilingQueueRootStatus::find($request->id);
        if($obj){
            $obj->delete();
            return 'Done';
        }
        return '';
    }

    public function removeSubStatus(Request $request){
        $obj=TmfFilingQueueStatus::find($request->id);
        if($obj){
            $obj->delete();
            return 'Done';
        }
        return '';
    }

}
