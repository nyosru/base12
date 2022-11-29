<?php

namespace App\Http\Controllers;

use App\Cipostatus;
use App\CipostatusStatusFormalized;
use App\classes\dashboard\DashboardDeadlineTemplateModelGenerator;
use App\classes\dashboard\DashboardOwnerManager;
use App\classes\dashboard\TssCreator;
use App\classes\queue\QueuePainter;
use App\classes\tsstranslator\TssTemplateVariablesTranslator;
use App\DashboardDeadline;
use App\DashboardOwner;
use App\DashboardReminder;
use App\DashboardReminderTmfResourceLevel;
use App\DashboardReminderTmfsales;
use App\DashboardTss;
use App\DashboardTssTemplate;
use App\DashboardV2;
use App\Events\ReloadSubStatuses;
use App\Events\ReloadTM;
use App\QueueFlagSettings;
use App\QueueRootStatus;
use App\QueueStatus;
use App\TmfFilingQueueStatus;
use App\TmfRegQueueStatus;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChangeQueueStatusController extends Controller
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

    public function loadTssList(Request $request)
    {
        $queue_painter=new QueuePainter();
        return $queue_painter->tssOptions($request->id);
    }

    public function dashboardAndTssParams(Request $request){
        $dashboard=DashboardV2::find($request->id);
        $last_formal_status=Carbon::now()->format('Y-m-d');
        $filed_date=$last_formal_status;
        $registered_date=$last_formal_status;
        if($dashboard->cipostatus){
            $cipostatus=$dashboard->cipostatus;
            if($cipostatus && $cipostatus->LastStatusDate!='0000-00-00 00:00:00') {
                $last_formal_status = \DateTime::createFromFormat('Y-m-d H:i:s',$cipostatus->LastStatusDate)->format('Y-m-d');

                if($cipostatus->registered_date!='0000-00-00')
                    $registered_date=$cipostatus->registered_date;

                if($cipostatus->filed_date!='0000-00-00 00:00:00')
                    $filed_date=\DateTime::createFromFormat('Y-m-d H:i:s',$cipostatus->filed_date)->format('Y-m-d');
            }
        }
        $queue_root_status=QueueRootStatus::find($request->root_id);
        $queue_painter=new QueuePainter();
        if($dashboard){
            return response()->json([
                'accordion'=>$queue_painter->accordion($queue_root_status->queue_type_id)->render(),
                'tss_vars'=>(new TssTemplateVariablesTranslator($dashboard))->createVariablesValue(),
                'last_formal_status'=>$last_formal_status,
                'filed_date'=>$filed_date,
                'registered_date'=>$registered_date,
                'dashboard_params'=>[
                    'How_Long_Before_Online_Txt'=>$dashboard->tmfCountryTrademark->tmfCountry->how_long_before_online_txt,
                    'How_Long_Before_Online_Math'=>$dashboard->tmfCountryTrademark->tmfCountry->how_long_before_online_math,
                    'How_Long_To_FirstReview_Txt'=>$dashboard->tmfCountryTrademark->tmfCountry->how_long_to_firstreview_txt,
                    'How_Long_To_FirstReview_Math'=>$dashboard->tmfCountryTrademark->tmfCountry->how_long_to_firstreview_math,
                    'How_Long_To_ROA_Txt'=>$dashboard->tmfCountryTrademark->tmfCountry->how_long_to_roa_txt,
                    'How_Long_To_ROA_Math'=>$dashboard->tmfCountryTrademark->tmfCountry->how_long_to_roa_math,
                    'How_Long_To_Oppose_Txt'=>$dashboard->tmfCountryTrademark->tmfCountry->how_long_to_oppose_txt,
                    'How_Long_To_Oppose_Math'=>$dashboard->tmfCountryTrademark->tmfCountry->how_long_to_oppose_math,
                    'current_country_code'=>$dashboard->tmfCountryTrademark->tmfCountry->tmf_country_code,
                    'apponline'=>$dashboard->tmfCountryTrademark->tmfCountry->app_online,
                ],
            ]);
        }
        return response()->json([]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function queueTypeStatuses(Request $request){
        $queue_painter=new QueuePainter();
        return $queue_painter->accordion($request->queue_type_id);
    }

    public function loadDashboardTssTemplateAndDeadlines(Request $request){
        $dashboard_tss_template=DashboardTssTemplate::find($request->id);
        $queue_status=QueueStatus::find($request->queue_status_id);
        return response()->json([
            'template'=>$dashboard_tss_template->full_text,
            'deadlines'=>(new DashboardDeadlineTemplateModelGenerator($dashboard_tss_template))->run(),
            'warning_flag_settings'=>$this->getConvertedQueueFlagSettings($queue_status->warningFlagSettings),
            'danger_flag_settings'=>$this->getConvertedQueueFlagSettings($queue_status->dangerFlagSettings),
        ]);
    }

    private function getConvertedQueueFlagSettings(QueueFlagSettings $queue_flag_settings){
        return [
            'relative_data_type'=>[
                'id'=>$queue_flag_settings->dashboardRelativeStartDateType->id,
                'text'=>$queue_flag_settings->dashboardRelativeStartDateType->type_name
            ],
            'plus_minus'=>($queue_flag_settings->plus_minus==1?'+':'-'),
            'year'=>$queue_flag_settings->year,
            'month'=>$queue_flag_settings->month,
            'day'=>$queue_flag_settings->day,
            'hour'=>$queue_flag_settings->hour,
            'plus_minus_settings'=>$queue_flag_settings->plus_minus_settings_id,
        ];

    }

    private function generateStatusFromQueueStatusObj($queue_status_obj){
        return [
            'dashboard_global_status_id'=>$queue_status_obj->dashboard_global_status_id,
            'cipostatus_status_formalized_id'=>$queue_status_obj->cipostatus_status_formalized_id
        ];
    }

    private function saveNewTss(DashboardV2 $dashboard, $tss_text)
    {
        $cipostatus_status_formalized_id = $dashboard->cipostatus_status_formalized_id;
        $dashboard_global_status_id = $dashboard->dashboard_global_status_id;
        $obj=new TssCreator(Auth::user()->ID,$dashboard->id);
        return $obj->run($cipostatus_status_formalized_id,$dashboard_global_status_id,$tss_text);
/*        $dashboard_tss = new DashboardTss();
        $dashboard_tss->dashboard_id=$dashboard->id;
        $dashboard_tss->cipostatus_status_formalized_id=$cipostatus_status_formalized_id;
        $dashboard_tss->dashboard_global_status_id=$dashboard_global_status_id;
        $dashboard_tss->description=$tss_text;
        $dashboard_tss->tmfsales_id=Auth::user()->ID;
        $dashboard_tss->created_at=Carbon::now()->format('Y-m-d H:i:s');
        $dashboard_tss->save();
        return $dashboard_tss;*/
    }


    private function newStatus(Request $request,QueueStatus $queue_status,$dashboard_tss_template){
        $status=$this->generateStatusFromQueueStatusObj($queue_status);
        $dashboard=DashboardV2::find($request->dashboard_id);
        $cipostatus_status_formalized=CipostatusStatusFormalized::find($status['cipostatus_status_formalized_id']);
        $oa_event_id = 0;
        if (
            strpos(strtolower($cipostatus_status_formalized->status), 'minor') !== false &&
            $dashboard->dashboard_oa_event_status_id < 3
        )
            $oa_event_id = 2;
        elseif (strpos(strtolower($cipostatus_status_formalized->status), 'major') !== false)
            $oa_event_id = 3;

        if ($oa_event_id) {
            $dashboard->dashboard_oa_event_status_id($oa_event_id);
            $dashboard->save();
        }
        $dashboard->dashboard_global_status_id=$status['dashboard_global_status_id'];
        $dashboard->cipostatus_status_formalized_id=$status['cipostatus_status_formalized_id'];
        $now = Carbon::now()->format('Y-m-d H:i:s');
        $dashboard->modified_at=$now;
        $dashboard->client_opened_at=NULL;
        $dashboard->formalized_status_modified_at=$now;
        $dashboard->save();
        $dashboard_tss=$this->saveNewTss($dashboard, $request->tss_text);
        $dashboard_tss->warning_at=$request->warning_flag_date;
        $dashboard_tss->danger_at=$request->danger_flag_date;
        $dashboard_tss->save();
        $deadlines_arr=json_decode($request->deadlines,true);

        $dashboard_owner_manager=new DashboardOwnerManager($request->dashboard_id);
        $dashboard_owner_manager->releaseOwnerFromMark(Auth::user()->ID,1);

        if(json_last_error()==JSON_ERROR_NONE && count($deadlines_arr)) {
            $this->saveGeneratedDeadlinesAndReminders($deadlines_arr,$dashboard->id);
//            $this->generateAndSaveFlagValues($dashboard_tss, $queue_status, $deadlines_arr);
        }

        event(new ReloadSubStatuses($request->current_status_root_id));
        if($request->current_status_root_id != $request->new_status_root_id)
            event(new ReloadSubStatuses($request->new_status_root_id));
        event(new ReloadTM($request->dashboard_id));
    }


    private function saveGeneratedDeadlinesAndReminders($deadlines,$dashboard_id){
        foreach ($deadlines as $el){
            $dashboard_deadline=new DashboardDeadline();
            $dashboard_deadline->dashboard_id=$dashboard_id;
            $dashboard_deadline->deadline_type_id=$el['deadline_type'];
            $dashboard_deadline->tmfsales_id=Auth::user()->ID;
            $dashboard_deadline->deadline_action_id=$el['deadline_action']['id'];
            $dashboard_deadline->deadline_date_at=$el['date'].' 00:00:00';
//            $dashboard_deadline->setCreatedAt(date('Y-m-d H:i:s'));
            $dashboard_deadline->created_at=Carbon::now()->format('Y-m-d H:i:s');
            $dashboard_deadline->save();
            $this->saveDashboardReminders($dashboard_deadline->id,$el['reminders']);
        }
    }

    private function saveDashboardReminders($dashboard_deadline_id,$reminders_arr){
        $dashboard_reminder_objs=DashboardReminder::where('dashboard_deadline_id',$dashboard_deadline_id)->get();

        if($dashboard_reminder_objs && $dashboard_reminder_objs->count())
            $dashboard_reminder_objs->delete();
//        var_dump($reminders_arr);echo '<br/><br/>';
        if(count($reminders_arr))
            foreach ($reminders_arr as $el){
                $dashboard_reminder=new DashboardReminder();
                $dashboard_reminder->dashboard_deadline_id=$dashboard_deadline_id;
                $dashboard_reminder->reminder_date=$el['date'];
                $dashboard_reminder->save();
                if(isset($el['who']['group']) && count($el['who']['group']))
                    foreach ($el['who']['group'] as $group_el){
//                        var_dump($group_el);
                        $dashboard_reminder_tmf_resource_level=new DashboardReminderTmfResourceLevel();
                        $dashboard_reminder_tmf_resource_level->dashboard_reminder_id=$dashboard_reminder->id;
                        $dashboard_reminder_tmf_resource_level->tmf_resource_level_id=$group_el['id'];
                        $dashboard_reminder_tmf_resource_level->save();
                    }
                if(isset($el['who']['users']) && count($el['who']['users']))
                    foreach ($el['who']['users'] as $users_el){
//                    var_dump($users_el);
                        $dashboard_reminder_tmfsales=new DashboardReminderTmfsales();
                        $dashboard_reminder_tmfsales->dashboard_reminder_id=$dashboard_reminder->id;
                        $dashboard_reminder_tmfsales->tmfsales_id=$users_el['id'];
                        $dashboard_reminder_tmfsales->save();
                    }
            }
    }

    public function applyNewTmfRegQueueStatus(Request $request){
        $tmf_reg_queue_status=TmfRegQueueStatus::find($request->new_status_id);
        $status=$this->generateStatusFromQueueStatusObj($tmf_reg_queue_status);
        $this->newStatus($request,$status,DashboardTssTemplate::find($request->tss_template_id));
        return 'DONE';
    }

    public function applyNewTmfFilingQueueStatus(Request $request){
        $tmf_filing_queue_status=TmfFilingQueueStatus::find($request->new_status_id);
        $status=$this->generateStatusFromQueueStatusObj($tmf_filing_queue_status);
        if($status['dashboard_global_status_id']!=1)
            $dashboard_tss_template=DashboardTssTemplate::where('dashboard_global_status_id',
                $status['dashboard_global_status_id'])
                ->orderBy('id')
                ->first();
        else
            $dashboard_tss_template=DashboardTssTemplate::where('cipostatus_status_formalized_id',
                $status['cipostatus_status_formalized_id'])
                ->orderBy('id')
                ->first();
        $this->newStatus($request,$status,$dashboard_tss_template);
        return 'DONE';
    }

    public function applyNewQueueStatus(Request $request){
        $this->releaseOwnerFromMark($request->dashboard_id, 1);
        $queue_status=QueueStatus::find($request->new_status_id);
        $this->newStatus($request,$queue_status,DashboardTssTemplate::find($request->tss_template_id));
        return 'DONE';
    }

    private function releaseOwnerFromMark($dashboard_id,$release_reason_id){
        $dashboard_owner=DashboardOwner::where('dashboard_id',$dashboard_id)
            ->where('tmfsales_id',Auth::user()->ID)
            ->whereNull('released_at')
            ->orderBy('id','desc')
            ->first();
        if($dashboard_owner){
            $dashboard_owner->released_at=Carbon::now()->format('Y-m-d H:i:s');
            $dashboard_owner->release_reason_id=$release_reason_id;
            $dashboard_owner->save();
            return true;
        }
        return false;
    }

    public function loadTssTemplateId(Request $request){
        $queue_painter=new QueuePainter();
        return $queue_painter->tssTemplateId($request->id);
    }
}
