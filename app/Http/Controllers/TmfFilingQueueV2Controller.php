<?php

namespace App\Http\Controllers;

use App\classes\queue\QueueHoursCalculator;
use App\classes\tmoffer\CompanySubjectInfo;
use App\DashboardTss;
use App\DashboardV2;
use App\TmfAftersearches;
use App\TmfCompany;
use App\TmfCompanySubject;
use App\TmfConditionTmfsalesTmoffer;
use App\TmfCountryTrademark;
use App\TmfFilingQueueRootStatus;
use App\TmfFilingQueueStatus;
use App\Tmfsales;
use App\TmfSubject;
use App\TmfTrademark;
use App\Tmoffer;
use App\TmofferBin;
use App\TmofferTmfCountryTrademark;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TmfFilingQueueV2Controller extends Controller
{
    private $days_select_arr=[3,7,10,14,30];
    private $show_mode='tms';
//    private $show_mode='client';
    private $days;

    public function __construct()
    {
        $this->middleware('auth');
        $this->days=$this->days_select_arr[1];
    }

    public function index(){
        $tmf_filing_queue_root_status_objs=TmfFilingQueueRootStatus::orderBy('place_id','asc')->get();


        return view('tmf-filing-queue.index',[
            'tmf_filing_queue_root_status_objs'=>$tmf_filing_queue_root_status_objs,
            'days_select_arr'=>$this->days_select_arr,
            'selected_day'=>$this->days,
            'left_nav_bar'=>view('tmf-filing-queue.left-nav-bar')->render()
        ]);
    }

    public function loadSubStatusTms(Request $request){
        $tmf_filing_queue_status=TmfFilingQueueStatus::find($request->id);
        if($request->days)
            $this->days=$request->days;
        if($request->group_by_client)
            $this->show_mode='client';
        else
            $this->show_mode='tms';
        if($tmf_filing_queue_status)
            return $this->subStatusTms($tmf_filing_queue_status);
        return '';
    }

    public function reloadSubStatuses(Request $request){
        $el=TmfFilingQueueRootStatus::find($request->id);
        if($el)
            return view('tmf-filing-queue.sub-statuses-list',compact('el'));
        return '';
    }

    public function loadSubStatusNumbers(Request $request){
        $tmf_filing_queue_status=TmfFilingQueueStatus::find($request->id);
        if($tmf_filing_queue_status) {
            if($request->days)
                $this->days=$request->days;
            $data=$this->getSubStatusData($tmf_filing_queue_status);
            $result=[
                'badge-success'=>0,
                'badge-warning'=>0,
                'badge-danger'=>0
            ];
            foreach($data as $el) {
                if ($tmf_filing_queue_status->deadline_warning_hours > 0 && $tmf_filing_queue_status->deadline_overdue_hours > 0) {
                    $index='badge-success';
                    if (($el['pending_in_this_status_delta'] > $tmf_filing_queue_status->deadline_warning_hours * 3600) &&
                        ($el['pending_in_this_status_delta'] < $tmf_filing_queue_status->deadline_overdue_hours * 3600))
                        $index = 'badge-warning';
                    elseif ($el['pending_in_this_status_delta'] > $tmf_filing_queue_status->deadline_overdue_hours * 3600)
                        $index = 'badge-danger';
                    $result[$index]++;
                }
            }
            return response()->json([
                'id'=>$request->id,
                'root_id'=>$tmf_filing_queue_status->tmf_filing_queue_root_status_id,
                'total'=>count($data),
                'html'=>view('tmf-filing-queue.badges',compact('result'))->render()
            ]);
        }
        return response()->json([
            'id'=>$request->id,
            'root_id'=>($tmf_filing_queue_status?$tmf_filing_queue_status->tmf_filing_queue_root_status_id:0),
            'total'=>0,
            'html'=>''
        ]);
    }

    private function tmsList(TmfFilingQueueStatus $tmf_filing_queue_status,$data){
        switch ($this->show_mode){
            case 'tms':return view('tmf-filing-queue.tms-list',compact('tmf_filing_queue_status','data'));
            case 'client':
                $original_data=$data;
                $data=[];
                foreach ($original_data as $od_el){
                    if(!isset($data[$od_el['client']]))
                        $data[$od_el['client']]=[];
                    $data[$od_el['client']][]=$od_el;
                }
                return view('tmf-filing-queue.client-tms-list',compact('tmf_filing_queue_status','data'));
        }

    }

    private function getSubStatusData(TmfFilingQueueStatus $tmf_filing_queue_status){
        if($tmf_filing_queue_status->removable)
            $data=$this->getStandartSubStatusTms($tmf_filing_queue_status);
        else
            $data=$this->getCustomSubStatusTms($tmf_filing_queue_status);
        return $data;
    }

    private function subStatusTms(TmfFilingQueueStatus $tmf_filing_queue_status){
        return $this->tmsList($tmf_filing_queue_status,$this->getSubStatusData($tmf_filing_queue_status));
    }

    private function getStandartSubStatusTms(TmfFilingQueueStatus $tmf_filing_queue_status){
        $dashboard_objs=DashboardV2::where('cipostatus_status_formalized_id',
            $tmf_filing_queue_status->cipostatus_status_formalized_id)
            ->where([
                ['dashboard_global_status_id', $tmf_filing_queue_status->dashboard_global_status_id],
                ['ready_status', 1],
            ])
            ->whereNull('deleted_at')
            ->get();
        $data=[];
        foreach ($dashboard_objs as $dashboard_obj)
            $data[]=$this->getDashboardData($dashboard_obj);
        return $data;
    }

    private function getDashboardData(DashboardV2 $dashboard_obj,TmfFilingQueueStatus $tmf_filing_queue_status=null)
    {

//        echo "dashboard_id:{$dashboard_id}<br/>";
        if (!$dashboard_obj->tmf_country_trademark_id) {
            echo "dashboard:{$dashboard_obj->id} not linked with tms!";
            exit;
        }

        $tmoffer = Tmoffer::whereIn('ID', TmofferTmfCountryTrademark::select('tmoffer_id')
            ->where('tmf_country_trademark_id', $dashboard_obj->tmf_country_trademark_id)
        )
            ->where('is_nobook', 1)
            ->first();

        if(!$tmoffer)
            $tmoffer = Tmoffer::whereIn('ID', TmofferTmfCountryTrademark::select('tmoffer_id')
                ->where('tmf_country_trademark_id', $dashboard_obj->tmf_country_trademark_id)
            )
                ->where('DateConfirmed','!=', '0000-00-00')
                ->first();


        if($dashboard_obj->formalized_status_modified_at=='0000-00-00 00:00:00')
            $date=new \DateTime($dashboard_obj->created_at);
        else
            $date=new \DateTime($dashboard_obj->formalized_status_modified_at);

        $time_since_delta=1000000;
        $today=new \DateTime();
        if(is_null($tmf_filing_queue_status))
            $diff=$today->getTimestamp()-$date->getTimestamp();
        else
            $diff=QueueHoursCalculator::init($tmf_filing_queue_status->hoursCalculationMethod)->getDiff($date,$today);

        $pending_in_this_status=$this->formattedTime($diff);
        $pending_in_this_status_delta=$diff;
        $boom_when_by='';
        if ($tmoffer) {
            $client_info = CompanySubjectInfo::init($tmoffer)->get();

            if (strlen($client_info['company']))
                $client_data = $client_info['company'];
            else
                $client_data = trim((strlen($client_info['gender']) ? $client_info['gender'] . ' ' : '') . $client_info['firstname'] . ' ' . $client_info['lastname']);

            if ($tmoffer->is_nobook) {
                $time_since_caption = 'NOBOOK';
                $time_since_caption_icon = '🔎';
                $delta = time() - strtotime($tmoffer->created_date);
                $time_since_formatted = $this->formattedTime($delta);
                $time_since_delta=$delta;
            } elseif ($tmoffer->DateConfirmed != '0000-00-00') {
                $time_since_caption = 'BOOM';
                $time_since_caption_icon ='💣';
                $closer=($tmoffer->Sales?Tmfsales::where('Login',$tmoffer->Sales)->first():null);
                if(is_null($closer) && $tmoffer->sales_id)
                    $closer=Tmfsales::find($tmoffer->sales_id);

                $tmoffer_bin = TmofferBin::where('tmoffer_id', $tmoffer->ID)->where('need_capture', 0)->first();
                if ($tmoffer_bin) {
                    if($closer)
                        $boom_when_by=sprintf('%s by %s %s',$tmoffer_bin->modified_at,$closer->FirstName,$closer->LastName);
                    else
                        $boom_when_by=sprintf('%s AUTOBOOM',$tmoffer_bin->modified_at);
                    $delta = time() - strtotime($tmoffer_bin->modified_at);
                    $time_since_formatted = $this->formattedTime($delta);
                    $time_since_delta=$delta;
                }
                else {
//                    throw new \Exception("tmoffer:{$tmoffer->ID}, payment was not captured!");
                    $boom_when_by=sprintf('%s AUTOBOOM',$tmoffer->DateConfirmed);
                    $delta = time() - strtotime($tmoffer->DateConfirmed);
                    $time_since_formatted = $this->formattedTime($delta);
                    $time_since_delta=$delta;
                }

                $tmf_aftersearch_obj = TmfAftersearches::where('tmoffer_id', $tmoffer->ID)
                    ->where('cancelled', '0000-00-00 00:00:00')
                    ->orderBy('id','desc')
                    ->first();
                if($tmf_aftersearch_obj){
                    $time_since_caption = 'AFTERSEARCH';
                    $time_since_caption_icon='<i class="fas fa-search-plus"></i>';
                    $delta = time() - strtotime($tmf_aftersearch_obj->assigned_date);
                    $time_since_formatted = $this->formattedTime($delta);
                    $tmfsales=Tmfsales::find($tmf_aftersearch_obj->tmfsales_id);
//                    echo "id:{$tmf_aftersearch_obj->id}<br/>";
                    if($tmfsales)
                        $boom_when_by=sprintf('%s by %s %s',$tmf_aftersearch_obj->assigned_date,$tmfsales->FirstName,$tmfsales->LastName);
                    else
                        $boom_when_by=sprintf('created %s. UNCLAIMED',$tmf_aftersearch_obj->assigned_date);
                    $time_since_delta=$delta;
                }
            } else{
                $time_since_caption = '';
                $time_since_caption_icon ='N/A';
                $time_since_formatted = 'N/A';
            }

            $last_condition = TmfConditionTmfsalesTmoffer::where('tmoffer_id', $tmoffer->ID)
                ->orderBy('when_date', 'desc')
                ->first();
            if($last_condition && $last_condition->tmf_condition_id>=5 && $last_condition->tmf_condition_id<=7) {
                $tmf_aftersearch_objs = TmfAftersearches::where('tmoffer_id', $tmoffer->ID)
                    ->where('cancelled', '0000-00-00 00:00:00')
                    ->get();
//                if($tmoffer->ID==498377)
//                    dd($tmf_aftersearch_objs);
                $searching_finished = 1;
                if ($tmf_aftersearch_objs && $tmf_aftersearch_objs->count()) {
                    foreach ($tmf_aftersearch_objs as $tmf_aftersearch_obj)
                        if ($tmf_aftersearch_obj->prepared_date == '0000-00-00 00:00:00') {
                            $searching_finished = 0;
                            break;
                        }
                }
            }else
                $searching_finished = 0;

        } else {
            $time_since_caption = '';
            $time_since_caption_icon ='N/A';
            $time_since_formatted = 'N/A';
            $pending_in_this_status = 'N/A';

            $tmf_company = $dashboard_obj->tmfCompany;
            $rep_info = [
                'company' => '',
            ];
            if ($tmf_company->tmf_lawyer_id) {
                $rep_company = TmfCompany::find($tmf_company->tmf_lawyer_id);

                $tmf_company_subject_objs = TmfCompanySubject::where('tmf_company_id', $rep_company->id)
                    ->orderBy('order_position')
                    ->get();
                $rep_info['company'] = sprintf('(%s)', $rep_company->name);
            } else {
                $tmf_company_subject_objs = TmfCompanySubject::where('tmf_company_id', $tmf_company->id)
                    ->orderBy('order_position')
                    ->get();
            }
            if ($tmf_company_subject_objs && $tmf_company_subject_objs->count())
                foreach ($tmf_company_subject_objs as $index => $tmf_company_subject) {
                    $tmf_subject = $tmf_company_subject->tmfSubject;
                    if (!$index && !strlen($rep_info['company'])) {
                        $rep_info['company'] = trim(($tmf_subject->gender ? $tmf_subject->gender . ' ' : '') . $tmf_subject->first_name . ' ' . $tmf_subject->last_name);
                        break;
                    }
                }
            $client_data = $rep_info['company'];
            $searching_finished=0;
        }
        $tmf_country_trademark = $dashboard_obj->tmfCountryTrademark;
        $flag = sprintf('<img src="https://trademarkfactory.imgix.net/img/countries/%s" style="max-width: 20px;max-height:13px;margin-bottom: 3px;">', $tmf_country_trademark->tmfCountry->tmf_country_flag);
        $country = $tmf_country_trademark->tmfCountry->tmf_country_name;
        $tmf_trademark = $tmf_country_trademark->tmfTrademark;
        $tm_type = $tmf_trademark->tmf_trademark_type_id;
        $tm_id = $tmf_trademark->id;
        $tm_country_id = $tmf_country_trademark->tmfCountry->id;
        $logo_descr = ($tm_type == 1 ? $tmf_trademark->logo_descr : '');
        if ($tmf_trademark->tmf_trademark_type_id == 2)
            $mark = $tmf_trademark->tmf_trademark_mark;
        else
            $mark = sprintf('<img src="https://trademarkfactory.imgix.net/offerimages/%s" class="img-responsive" style="margin: auto;max-width:75px;max-height: 75px;">', $tmf_trademark->tmf_trademark_mark);
        return [
            'mark' => $mark,
            'flag' => $flag,
            'country' => $country,
            'client' => $client_data,
            'time_since_delta'=>$time_since_delta,
            'time_since_caption' => $time_since_caption,
            'time_since_formatted' => $time_since_formatted,
            'pending_in_this_status' => $pending_in_this_status,
            'pending_in_this_status_delta'=>$pending_in_this_status_delta,
            'tmoffer' => $tmoffer,
            'dashboard' => $dashboard_obj,
            'searching_finished'=>$searching_finished,
            'time_since_caption_icon'=>$time_since_caption_icon,
            'boom_when_by'=>$boom_when_by
//                'tctt'=>$last_condition
        ];
    }


    private function getCustomSubStatusTms(TmfFilingQueueStatus $tmf_filing_queue_status){
        $interval=\DateInterval::createFromDateString($this->days.' days');
        $datetime_xd=Carbon::now()->sub($interval)->format('Y-m-d').' 23:59:59';

        switch ($tmf_filing_queue_status->id){
            case 1:
            case 3:
                $data=$this->getCustomSubStatus13Tms($tmf_filing_queue_status);
                $index=($tmf_filing_queue_status->id==1?0:1);
                if(count($data))
                    return (isset($data[$index])?$data[$index]:[]);
                return [];
            case 21:
            case 22:;
            case 25:
                $dashboard_objs=DashboardV2::where('cipostatus_status_formalized_id',
                    $tmf_filing_queue_status->cipostatus_status_formalized_id)
                    ->where([
                        ['dashboard_global_status_id', $tmf_filing_queue_status->dashboard_global_status_id],
                        ['ready_status', 1],
                    ])
                    ->whereNull('deleted_at')
                    ->where('formalized_status_modified_at','>=', $datetime_xd)
                    ->get();
                $data=[];
                foreach ($dashboard_objs as $dashboard_obj)
                    $data[]=$this->getDashboardData($dashboard_obj,$tmf_filing_queue_status);
                return $data;
            case 23:
            case 24:
            case 26:
            $dashboard_objs=DashboardV2::where([
                    ['dashboard_global_status_id', $tmf_filing_queue_status->dashboard_global_status_id],
                    ['ready_status', 1],
                ])
                ->whereNull('deleted_at')
                ->where('formalized_status_modified_at','>=', $datetime_xd)
                ->get();
            $data=[];
            foreach ($dashboard_objs as $dashboard_obj)
                $data[]=$this->getDashboardData($dashboard_obj,$tmf_filing_queue_status);
            return $data;
        }
    }

    private function getCustomSubStatus13Tms(TmfFilingQueueStatus $tmf_filing_queue_status){
            $dashboard_objs=DashboardV2::where('cipostatus_status_formalized_id',
                $tmf_filing_queue_status->cipostatus_status_formalized_id)
                ->where([
                    ['dashboard_global_status_id', $tmf_filing_queue_status->dashboard_global_status_id],
                    ['ready_status', 1],
                ])
                ->whereNull('deleted_at')
                ->get();
            $data=[];
            foreach ($dashboard_objs as $dashboard_obj) {
                $tmf_data = $this->getDashboardData($dashboard_obj,$tmf_filing_queue_status);
                $data[$tmf_data['searching_finished']][]=$tmf_data;
            }
            return $data;
    }

    private function formattedTime($delta)
    {
        $d = intval($delta / (24 * 3600));
        $h = intval($delta % (24 * 3600) / 3600);
        $m = intval($delta % (24 * 3600) % 3600 / 60);
        $s = intval($delta % (24 * 3600) % 3600 % 60);
        return sprintf('%sd %sh %sm', $d, $h, $m);
    }

    public function loadDashboardNotes(Request $request){
        $dashboard=DashboardV2::find($request->id);
        if($dashboard){
            return $dashboard->notes;
        }
        return '';
    }

    public function saveDashboardNotes(Request $request){
        $dashboard=DashboardV2::find($request->id);
        if($dashboard){
            $dashboard->notes=$request->notes;
            $dashboard->save();
            return 'Done';
        }
        return '';
    }

    public function applyNewStatus(Request $request){
        $tmf_filing_queue_status=TmfFilingQueueStatus::find($request->new_status_id);
        $dashboard=DashboardV2::find($request->dashboard_id);
        if($tmf_filing_queue_status && $dashboard){
            $tmfsales=Tmfsales::find(Auth::user()->ID);
            $auth = base64_encode($tmfsales->Login.":".$tmfsales->passw);
            $arrContextOptions=array(
                "ssl"=>array(
                    "verify_peer"=>false,
                    "verify_peer_name"=>false,
                ),
                "http" => [
                    "header" => "Authorization: Basic $auth"
                ]
            );
            $url=sprintf('https://trademarkfactory.com/mlcclients/apply-new-status.php?dashboard_id=%d&dashboard_tss_template_id=%d',
                $request->dashboard_id,
                $tmf_filing_queue_status->dashboard_tss_template_id);
            return file_get_contents($url,false,stream_context_create($arrContextOptions));
        }
        return '';
    }

    public function search(Request $request){
        $dashboard_objs=DashboardV2::where('ready_status', 1)
            ->whereNull('deleted_at');
        if($request->client_fn){
            $tmf_subject_objs = TmfSubject::select('id')->where(function($query) use ($request) {
                $query->where('first_name', 'like', '%' . $request->client_fn . '%')
                    ->orWhere('last_name', 'like', '%' . $request->client_fn . '%')
                    ->orWhereRaw('concat(first_name," ",last_name) like "%' . $request->client_fn . '%"');
            });
            $dashboard_objs=$dashboard_objs->where(function($query) use ($request,$tmf_subject_objs) {
                $query->whereIn('tmf_company_id',
                    TmfCompanySubject::select('tmf_company_id')->whereIn('tmf_subject_id',$tmf_subject_objs))
                    ->orWhereIn('tmf_company_id',TmfCompany::select('id')->where('name','like','%'.$request->client_fn.'%'));
            });
        }

        if($request->tm){
            $tmf_country_trademark_objs=TmfCountryTrademark::select('id')
                ->whereIn('tmf_trademark_id',
                    TmfTrademark::select('id')->where('tmf_trademark_mark','like','%'.$request->tm.'%')
                );
            $dashboard_objs=$dashboard_objs->whereIn('tmf_country_trademark_id',$tmf_country_trademark_objs);
        }
        $dashboard_objs=$dashboard_objs->get();
        $data=[];
        foreach ($dashboard_objs as $dashboard_obj) {
            $ldd = $this->getDashboardData($dashboard_obj);
            $tmf_filing_queue_status=$this->getDashboardQueueStatus($dashboard_obj,$ldd);
            $dd['current-status']=$tmf_filing_queue_status;
            $dd = $this->getDashboardData($dashboard_obj,$tmf_filing_queue_status);
            $data[]=$dd;
        }
        $show_not_in_queue=$request->show_not_in_queue;
        $interval=\DateInterval::createFromDateString($request->done_status_days.' days');
        $datetime_xd=Carbon::now()->sub($interval)->format('Y-m-d').' 23:59:59';
        $done_ids=TmfFilingQueueStatus::select('id')->where('tmf_filing_queue_root_status_id',7)->pluck('id')->toArray();
        return view('tmf-filing-queue.search-results',
            compact('data',
                'show_not_in_queue',
                'datetime_xd','done_ids'));
    }

    private function getDashboardQueueStatus(DashboardV2 $dashboard_obj,$data){
        $dashboard_tss_obj=DashboardTss::where('dashboard_id',$dashboard_obj->id)
            ->orderBy('id','desc')
            ->first();
        if($dashboard_tss_obj){
            $csf_id=$dashboard_tss_obj->cipostatus_status_formalized_id;
            $dgs_id=$dashboard_tss_obj->dashboard_global_status_id;
        }else{
            $csf_id=$dashboard_obj->cipostatus_status_formalized_id;
            $dgs_id=$dashboard_obj->dashboard_global_status_id;
        }

        $tmf_filing_queue_status_objs=TmfFilingQueueStatus::where('cipostatus_status_formalized_id',$csf_id)
            ->where('dashboard_global_status_id',$dgs_id)
            ->get();
        if($tmf_filing_queue_status_objs->count()>1){
            if($data['searching_finished'])
                return $tmf_filing_queue_status_objs[1];
            else
                return $tmf_filing_queue_status_objs[0];
        }elseif ($tmf_filing_queue_status_objs->count()==1){
            return $tmf_filing_queue_status_objs[0];
        }else{
            $tmf_filing_queue_status_objs=TmfFilingQueueStatus::where('tmf_filing_queue_root_status_id',7)
                ->where('dashboard_global_status_id',$dgs_id)
                ->get();
            if($tmf_filing_queue_status_objs->count()>1){
                if($data['searching_finished'])
                    return $tmf_filing_queue_status_objs[1];
                else
                    return $tmf_filing_queue_status_objs[0];
            }elseif ($tmf_filing_queue_status_objs->count()==1) {
                return $tmf_filing_queue_status_objs[0];
            }else
                return null;
        }
        return null;
    }
}
