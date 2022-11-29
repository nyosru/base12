<?php

namespace App\Http\Controllers;

use App\PrequalifyRequest;
use App\Tmfsales;
use App\TmfSubject;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PqStatsController extends Controller
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

/*        $prequalify_request_objs=PrequalifyRequest::join('tmoffer','prequalify_request.id','tmoffer.prequalify_request_id')
            ->join('tmf_client_tmsr_tmoffer','tmoffer.ID','tmf_client_tmsr_tmoffer.tmoffer_id')
            ->join('tmf_booking','tmf_client_tmsr_tmoffer.id','tmf_booking.tmf_client_tmsr_tmoffer_id')
            ->whereRaw('tmf_booking.created_at>="2021-03-01 00:00:00" and tmf_booking.created_at<="2021-03-10 00:00:00"')
            ->get();
        dd($prequalify_request_objs);*/

        $months_btns = '';
        $y = date('Y');
        for ($i = 1; $i < 13; $i++) {
            $from = sprintf('%s-01', ($i > 9 ? $i : '0' . $i));
            $to = date('m-d', strtotime($y . '-' . $from . ' + 1 month - 1 day'));
            $months_btns .= sprintf('<button class="btn btn-sm btn-info month-btn" style="margin-right: 7px;color:white" data-from="%s" data-to="%s">%s</button>',
                $from, $to, $i);
        }

        $q_btns = '';
        for ($i = 1; $i < 5; $i++) {
            $first_q_month = $i * 3 - 2;
            $last_q_month = $i * 3;
            $start = sprintf('%s-01', ($first_q_month > 9 ? $first_q_month : '0' . $first_q_month));
            $end = sprintf('%s-01', ($last_q_month > 9 ? $last_q_month : '0' . $last_q_month));
            $to = date('m-d', strtotime($y . '-' . $end . ' + 1 month - 1 day'));
            $q_btns .= sprintf('<button class="btn btn-sm btn-info q-btn" style="margin-right: 7px;color:white" data-from="%s" data-to="%s">Q%s</button>',
                $start, $to, $i);
        }

        $y_select = '<select id="s-year" class="form-control" style="width: auto;display: inline-block">';
        for ($i = 2020; $i < 2031; $i++)
            $y_select .= sprintf('<option value="%1$d" %2$s>%1$d</option>', $i, ($i == date('Y') ? 'selected' : ''));
        $y_select .= '</select>';
        $left_nav_bar=view('pq-stats.left-nav-bar')->render();
        return view('pq-stats.index',
                    compact('months_btns', 'q_btns',
                        'y_select','left_nav_bar'));
    }

    private function getHandledPrequalifyRequests(Request $request){
        $prequalify_request_objs = PrequalifyRequest::leftJoin('tmoffer', 'prequalify_request.id', 'tmoffer.prequalify_request_id');
        return $this->applyPostFilters($request,$prequalify_request_objs);
    }

    private function getPrequalifyRequestsWithBookings(Request $request){
        $prequalify_request_objs = PrequalifyRequest::join('tmoffer', 'prequalify_request.id', 'tmoffer.prequalify_request_id')
            ->join('tmf_client_tmsr_tmoffer', 'tmoffer.ID', 'tmf_client_tmsr_tmoffer.tmoffer_id')
            ->join('tmf_booking', 'tmf_client_tmsr_tmoffer.id', 'tmf_booking.tmf_client_tmsr_tmoffer_id');

        return $this->applyPostFilters($request,$prequalify_request_objs);
    }

    private function applyPostFilters(Request $request,$prequalify_request_objs){
        if($request->date_type_filer=='booking-confirmed') {
            if($request->from_date)
                $prequalify_request_objs->whereRaw(sprintf('tmf_booking.created_at>="%s 00:00:00"',$request->from_date));
            if($request->to_date)
                $prequalify_request_objs->whereRaw(sprintf('tmf_booking.created_at<="%s 23:59:59"',$request->to_date));
        }else{
//            $prequalify_request_objs=null;
            if($request->from_date)
                $prequalify_request_objs = $prequalify_request_objs->where('prequalify_request.created_at','>=',$request->from_date.' 00:00:00');
            if($request->to_date)
                $prequalify_request_objs->where('prequalify_request.created_at','<=',\DateTime::createFromFormat('Y-m-d',$request->to_date)->format('Y-m-d 23:59:59'));
        }

        if($request->name || $request->email || $request->phone){
            $tmf_subject=TmfSubject::select('id');
            if($request->email || $request->phone) {
                $tmf_subject->join('tmf_subject_contact', 'tmf_subject.id', 'tmf_subject_contact.tmf_subject_id');
                if($request->email) {
                    $tmf_subject->whereRaw(sprintf('tmf_subject_contact.contact="%s"',$request->email));
                    if($request->phone)
                        $tmf_subject->orWhereRaw(sprintf('tmf_subject_contact.contact="%s"',$request->phone));
                }elseif($request->phone)
                    $tmf_subject->whereRaw(sprintf('tmf_subject_contact.contact="%s"',$request->phone));
            }
            if($request->name)
                $tmf_subject->whereRaw("lower(concat(first_name, ' ', last_name)) like '%".strtolower($request->name)."%' ");
            $prequalify_request_objs->whereIn('tmf_subject_id',$tmf_subject);
        }
        if($request->lead_statuses){
            $arr=json_decode($request->lead_statuses,true);
//            $arr=$request->lead_statuses;
            if(json_last_error()==JSON_ERROR_NONE) {
                $prequalify_request_objs->where(function ($query) use ($arr) {
                    $query->whereIn('lead_status_id', $arr);
                    if(in_array(-1,$arr))
                        $query->orWhereNull('lead_status_id');
                });
            }
        }

        if($request->sdrs){
            $arr=json_decode($request->sdrs,true);
//            $arr=$request->sdrs;
            if(json_last_error()==JSON_ERROR_NONE && count($arr))
                $prequalify_request_objs->whereIn('handled_tmfsales_id',$arr);
        }

        if($request->came_from) {
            $arr = json_decode($request->came_from, true);
//            $arr = $request->came_from;
            if (json_last_error() == JSON_ERROR_NONE
            ) {
                $prequalify_request_objs->where(function ($query) use($arr){
//                    $query->whereRaw('tmoffer.how_find_out_us is not NULL');
                    foreach ($arr as $index=>$from)
                        switch ($from) {
                            case 'FB Paul LaMarca Ad':
                            case 'FB Paul LaMarca Ad 1':
                            case 'FB Paul LaMarca Ad 2':
                            case 'Instagram':
                                if($index)
                                    $query->orWhereRaw(sprintf('tmoffer.how_find_out_us="%s"',$from));
                                else
                                    $query->whereRaw(sprintf('tmoffer.how_find_out_us="%s"',$from));
                                break;
                            case 'Other':
                                if($index)
                                    $query->orWhereRaw('tmoffer.how_find_out_us not in ("FB Paul LaMarca Ad","Instagram","FB Paul LaMarca Ad 1","FB Paul LaMarca Ad 2")');
                                else
                                    $query->whereRaw('tmoffer.how_find_out_us not in ("FB Paul LaMarca Ad","Instagram","FB Paul LaMarca Ad 1","FB Paul LaMarca Ad 2")');
                                $query->orWhereRaw('tmoffer.how_find_out_us is NULL');
                                break;
                        }
                });
            }
        }
        return $prequalify_request_objs;
    }

    private function getTmofferBinIdsTms($objs){
        $count=0;
        foreach ($objs->select('tmoffer_bin.*')->get() as $el)
            $count+=count(json_decode($el->tms,true));
        return $count;
    }

    public function loadDetails(Request $request){
        $ids=json_decode($request->ids,true);
        if(json_last_error()==JSON_ERROR_NONE) {
            $current_status='finished';
            $action=$request->action;
            $prequalify_request_objs = PrequalifyRequest::whereIn('id',$ids)->get();
            $data=[];
            foreach ($prequalify_request_objs as $prequalify_request_obj){
                $data[]=[
                    'id'=>$prequalify_request_obj->id,
                    'request_date'=>\DateTime::createFromFormat('Y-m-d H:i:s',$prequalify_request_obj->created_at)->format('M j, Y \<\b\r\/\>\@ H:i'),
                    'prospect'=>$prequalify_request_obj->tmfSubject->first_name.' '.$prequalify_request_obj->tmfSubject->last_name,
                    'sdr'=>($prequalify_request_obj->tmfsales?$prequalify_request_obj->tmfsales->FirstName.' '.$prequalify_request_obj->tmfsales->LastName:'UNCLAIMED'),
                    'custom-info'=>$this->loadCustomInfo($prequalify_request_obj,$request->action)
                ];
            }
            return view('pq-stats.applications-list',
                compact('data','current_status','action'));
        }
        return '';
    }

    private function getBookingInfo($tmf_booking){
        if($tmf_booking && $tmf_booking->closer)
                return sprintf(' ⏰%s with %s %s for %s PST',
                    \DateTime::createFromFormat('Y-m-d H:i:s',$tmf_booking->created_at)->format('M j, Y \@ g:ia'),
                    $tmf_booking->closer->FirstName,
                    $tmf_booking->closer->LastName,
                    \DateTime::createFromFormat('Y-m-d H:i:s',$tmf_booking->booked_date)->format('Y-m-d \@ g:ia'));
        return 'N/A';
    }

    private function loadCustomInfo($prequalify_request_obj,$action){
        switch ($action){
            case 'Requests handled':
            case 'Successful calls': return ($prequalify_request_obj->lead_status_id?$prequalify_request_obj->leadStatus->name:'N/A');
            case 'Total Bookings':
            case 'Future Bookings':
            $tmoffer=$prequalify_request_obj->tmoffer;
            if($tmoffer && $tmoffer->tmfClientTmsrTmoffer &&
                $tmf_booking=$tmoffer->tmfClientTmsrTmoffer->tmfBookings()->where('sales_id','!=',0)->orderBy('id','desc')->first())
                return $this->getBookingInfo($tmf_booking);

            case 'No-Shows':
                $tmoffer=$prequalify_request_obj->tmoffer;
                $tmfsales_tmoffer_not_boom_reason=$tmoffer->tmfsalesTmofferNotBoomReason;
                if($tmfsales_tmoffer_not_boom_reason->not_boom_reason_id==79)
                    if($tmoffer && $tmoffer->tmfClientTmsrTmoffer &&
                        $tmf_booking=$tmoffer->tmfClientTmsrTmoffer->tmfBookings()->where('sales_id','!=',0)->orderBy('id','desc')->first())
                        return $this->getBookingInfo($tmf_booking);
            case 'BOOMS':
                $tmoffer_bin=$prequalify_request_obj->tmoffer->tmofferBin;
                if($tmoffer_bin && $tmoffer_bin->need_capture==0){
                    $tmoffer_tmf_country_trademarks_count=count(json_decode($tmoffer_bin->tms,true));
                    return sprintf('💣 %s %s closed (%d TM%s)',
                        \DateTime::createFromFormat('Y-m-d H:i:s',$tmoffer_bin->modified_at)->format('Y-m-d'),
                        Tmfsales::where('Login',$prequalify_request_obj->tmoffer->Sales)->first()->FirstName,
                        $tmoffer_tmf_country_trademarks_count,
                        ($tmoffer_tmf_country_trademarks_count>1?'s':''));
                }
                return 'N/A';
        }
    }

    public function loadStats(Request $request){
//        $prequalify_request_objs->dd();
//        echo implode(',',$prequalify_request_objs->get()->pluck('id')->toArray());
//        exit;
        $prequalify_request_objs=$this->getHandledPrequalifyRequests($request);
        $copy_prequalify_request_objs=clone $prequalify_request_objs;
//        $prequalify_request_objs->dd();
        $b_prequalify_request_objs=$this->getPrequalifyRequestsWithBookings($request);
        $orig_objs=clone $prequalify_request_objs;
        $prequalify_request_objs=$prequalify_request_objs->select('prequalify_request.*')->get();
//        dd($prequalify_request_objs);

        $sc_objs=(clone $orig_objs)->whereNotIn('lead_status_id',[1,5]);
//        echo implode(',',$sc_objs->distinct()->select('prequalify_request.id')->get()->pluck('id')->toArray());
//        exit;
        $fb_objs=(clone $b_prequalify_request_objs)->where('tmf_booking.booked_date','>=',Carbon::now()->format('Y-m-d H:i:s'));
        $tb_objs=(clone $copy_prequalify_request_objs)->join('tmoffer_bin','tmoffer_bin.tmoffer_id','tmoffer.ID')->where('tmoffer_bin.need_capture',0);
        $ttnbr_objs=(clone $b_prequalify_request_objs)->join('tmfsales_tmoffer_not_boom_reason','tmfsales_tmoffer_not_boom_reason.tmoffer_id','tmoffer.ID')->where('tmfsales_tmoffer_not_boom_reason.not_boom_reason_id',79);

//        dd($ttnbr_objs->select('prequalify_request.id')->get()->toArray());
//        echo $ttnbr_objs->distinct()->select('prequalify_request.id')->get()->count();
//        echo implode(',',$ttnbr_objs->distinct()->select('prequalify_request.id')->count());
//        exit;

        $data=[
            'Requests handled'=>['count'=>$prequalify_request_objs->count(),
                'ids'=>$prequalify_request_objs->pluck('id')->toArray()
            ],
            'Successful calls'=>['count'=>$sc_objs->distinct()->select('prequalify_request.id')->get()->count(),
                'ids'=>$sc_objs->distinct()->select('prequalify_request.id')->get()->pluck('id')->toArray()],
//            'Successful calls'=>['count'=>0,'ids'=>[]],
            'Total Bookings'=>['count'=>$b_prequalify_request_objs->distinct()->select('prequalify_request.id')->get()->count(),'ids'=>$b_prequalify_request_objs->distinct()->select('prequalify_request.id')->get()->pluck('id')->toArray()],
//            'Future Bookings'=>['count'=>0,'ids'=>[]],
            'Future Bookings'=>['count'=>$fb_objs->distinct()->select('prequalify_request.id')->get()->count(),'ids'=>$fb_objs->distinct()->select('prequalify_request.id')->get()->pluck('id')->toArray()],
            'No-Shows'=>['count'=>$ttnbr_objs->distinct()->select('prequalify_request.id')->get()->count(),'ids'=>$ttnbr_objs->distinct()->select('prequalify_request.id')->get()->pluck('id')->toArray()],
//            'BOOMS'=>['count'=>0,'ids'=>[],'tms-count'=>0],
            'BOOMS'=>['count'=>$tb_objs->distinct()->select('prequalify_request.id')->get()->count(),'ids'=>(clone $tb_objs)->distinct()->select('prequalify_request.id')->get()->pluck('id')->toArray(),'tms-count'=>$this->getTmofferBinIdsTms($tb_objs)],
        ];

/*        foreach ($prequalify_request_objs as $el){
            if($el->lead_status_id && !in_array($el->lead_status_id,[1,5])) {
                $data['Successful calls']['count']++;
                $data['Successful calls']['ids'][]=$el->id;
            }
            $tmoffer=$el->tmoffer;
            if($tmoffer) {
                if ($tmoffer->tmfClientTmsrTmoffer &&
                    $tmf_booking = $tmoffer->tmfClientTmsrTmoffer->tmfBookings()->orderBy('id', 'desc')->first()) {
                    $data['Total Bookings']['count']++;
                    $data['Total Bookings']['ids'][] = $el->id;
                    if ($tmf_booking->booked_date >= Carbon::now()->format('Y-m-d H:i:s')) {
                        $data['Future Bookings']['count']++;
                        $data['Future Bookings']['ids'][] = $el->id;
                    }
                }
                $tmoffer_bin = $tmoffer->tmofferBin;
                if ($tmoffer_bin && $tmoffer_bin->need_capture == 0) {
                    $data['BOOMS']['count']++;
                    $data['BOOMS']['ids'][] = $el->id;
                    $data['BOOMS']['tms-count'] += count(json_decode($tmoffer_bin->tms, true));
                }
                if ($tmoffer->tmfsalesTmofferNotBoomReason &&
                    $tmoffer->tmfsalesTmofferNotBoomReason->not_boom_reason_id == 79) {
                    $data['No-Shows']['count']++;
                    $data['No-Shows']['ids'][] = $el->id;
                }
            }
        }*/

        return view('pq-stats.stats',compact('data'));
    }

}
