<?php

namespace App\Http\Controllers;

use App\classes\queue\FlagSettings;
use App\CustomContextMenuItem;
use App\CustomContextMenuItemQueueStatus;
use App\DashboardTssTemplate;
use App\QueueFlagSettings;
use App\QueueRootStatus;
use App\QueueStatus;
use App\QueueStatusCustomContextMenuItem;
use App\QueueStatusStandartContextMenuItem;
use App\QueueStatusType;
use App\QueueType;
use App\StandartContextMenuItem;
use Carbon\Carbon;
use Illuminate\Http\Request;

class QueueStatusMaintainerController extends Controller
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
        $queue_type_objs=QueueType::all();

        $standart_menu_items=StandartContextMenuItem::all();

        return view('queue-status-maintainer.index',
            compact(
                'flag_settings','flags_prefixes',
                'queue_status_type_objs','queue_type_objs','standart_menu_items'
            )
        );
    }

    public function loadRootStatuses(Request $request){
        $queue_root_status_objs=QueueRootStatus::where('queue_type_id',$request->id)
            ->orderBy('place_id','asc')
            ->get();
        $status_type='root-status';
        return view('queue-status-maintainer.statuses-list',
            compact('queue_root_status_objs','status_type'));
    }

    public function loadRootStatusOptions(Request $request){
        $queue_root_status_objs=QueueRootStatus::where('queue_type_id',$request->id)
            ->orderBy('place_id','asc')
            ->get();
        return view('queue-status-maintainer.root-status-options',
            compact('queue_root_status_objs'));
    }

    public function dashboardTssOptions(Request $request){
        $global_status_tss_objs=DashboardTssTemplate::where('dashboard_global_status_id',$request->global_status_id)
            ->get();
        $cipostatus_status_formalized_tss_objs=DashboardTssTemplate::where('cipostatus_status_formalized_id',
            $request->dashboard_status_id)
            ->get();
        return view('queue-status-maintainer.dashboard-tss-options',
            compact('global_status_tss_objs','cipostatus_status_formalized_tss_objs'));
    }

    public function loadSubStatuses(Request $request){
        $queue_root_status_obj=QueueRootStatus::find($request->id);
        if($queue_root_status_obj){
            $status_type='sub-status';
            return view('queue-status-maintainer.sub-statuses-list',
                compact('queue_root_status_obj','status_type'));

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
            $obj=QueueRootStatus::find($request->id);
            $obj->name = $request->name;
        }else {
            $obj = new QueueRootStatus();
            $obj->name = $request->name;
            $obj->queue_type_id = $request->queue_type_id;
            $obj->place_id = QueueRootStatus::all()->count();
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
            $obj=QueueStatus::find($request->id);
        }else{
            $obj=new QueueStatus();
            $obj->place_id=QueueStatus::all()->count();
        }
        $obj->name=$request->name;
        $obj->queue_root_status_id=$request->parent_id;
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
                $obj=QueueRootStatus::find($id);
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
                $obj=QueueStatus::find($id);
                $obj->place_id=$index+1;
                $obj->save();
            }
            return 'DONE';
        }
        return '';
    }

    public function removeRootStatus(Request $request){
        $obj=QueueRootStatus::find($request->id);
        if($obj){
            $obj->delete();
            return 'Done';
        }
        return '';
    }

    public function removeSubStatus(Request $request){
        $obj=QueueStatus::find($request->id);
        if($obj){
            $obj->delete();
            return 'Done';
        }
        return '';
    }

    public function saveCustomContextMenu(Request $request){
        $response=[
            'id'=>$request->id,
            'class'=>'text-secondary'
        ];
        $standart_context_menu_ids=json_decode($request->standart_context_menu_ids,true);
        if(count($standart_context_menu_ids)) {
            foreach ($standart_context_menu_ids as $standart_context_menu_id)
                $this->saveStandartContextMenuItem($request->id, $standart_context_menu_id);
            $response['class'] = 'text-success';
        }else{
            $objs=QueueStatusStandartContextMenuItem::where('queue_status_id',$request->id);
            if($objs->count())
                $objs->delete();
        }

        $custom_context_menu_data=json_decode($request->custom_context_menu_data,true);
        if(count($custom_context_menu_data)) {
            $this->saveCustomContextMenuItems($request->id, $custom_context_menu_data);
            $response['class'] = 'text-success';
        }else{
            $objs=CustomContextMenuItemQueueStatus::where('queue_status_id',$request->id);
            if($objs->count())
                $objs->delete();
        }
        return response()->json($response);
    }

    private function saveCustomContextMenuItems($queue_status_id,$custom_context_menu_data){
        $ids=[];
        foreach ($custom_context_menu_data as $el){
            $custom_context_menu_item_obj=CustomContextMenuItem::where('icon',$el['icon'])
                ->where('name',$el['name'])
                ->where('url',$el['url'])
                ->first();
            if(!$custom_context_menu_item_obj){
                $custom_context_menu_item_obj=new CustomContextMenuItem();
                $custom_context_menu_item_obj->icon=$el['icon'];
                $custom_context_menu_item_obj->name=$el['name'];
                $custom_context_menu_item_obj->url=$el['url'];
                $custom_context_menu_item_obj->save();
            }
            $obj=CustomContextMenuItemQueueStatus::where('queue_status_id',$queue_status_id)
                ->where('custom_context_menu_item_id',$custom_context_menu_item_obj->id)
                ->first();
            if(!$obj){
                $obj=new CustomContextMenuItemQueueStatus();
                $obj->queue_status_id=$queue_status_id;
                $obj->custom_context_menu_item_id=$custom_context_menu_item_obj->id;
                $obj->save();
            }
            $ids[]=$obj->id;
        }
        $objs=CustomContextMenuItemQueueStatus::where('queue_status_id',$queue_status_id)
            ->whereNotIn('custom_context_menu_item_id',$ids);
        if($objs->count())
            $objs->delete();

    }

    private function saveStandartContextMenuItem($queue_status_id,$standart_menu_item_id){
        $obj=QueueStatusStandartContextMenuItem::where('queue_status_id',$queue_status_id)
            ->where('standart_context_menu_item_id',$standart_menu_item_id)
            ->first();
        if(!$obj){
            $obj=new QueueStatusStandartContextMenuItem();
            $obj->queue_status_id=$queue_status_id;
            $obj->standart_context_menu_item_id=$standart_menu_item_id;
            $obj->save();
        }
        return $obj;
    }

    public function loadContextMenuData(Request $request){
        $queue_status=QueueStatus::find($request->queue_status_id);
        $data=[
            'standart_menu_items'=>$queue_status->standartContextMenuItemRows->pluck('id')->toArray(),
            'custom_menu_items'=>$queue_status->customContextMenuItemRows->toArray()
        ];

        return response()->json($data);
    }
}
