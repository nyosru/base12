<?php

namespace App\Http\Controllers;

use App\classes\ClientIpFirstPage;
use App\classes\pqfollowup\PqFollowUpEmailsSeqCreator;
use App\classes\TmofferCreator;
use App\Offer;
use App\PrequalifyQuestion;
use App\PrequalifyQuestionOption;
use App\PrequalifyRequest;
use App\PrequalifyRequestAnswer;
use App\PrequalifyRequestLeadStatusesLog;
use App\Tmfsales;
use App\TmfSubject;
use App\TmfSubjectContact;
use App\Tmoffer;
use App\TmofferBin;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Vinkla\Hashids\Facades\Hashids;

class PqApplicationsController extends Controller
{
    private $current_user;
    private $finished_load_limit=50;
    private $hot_visible_for_users=[86];
    private $max_inprogress=15;

    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function __construct()
    {
        $this->middleware('auth');
//        dd(Auth::user());
//        $this->current_user=Tmfsales::find(Auth::user()->ID);
//        $this->current_user=Tmfsales::find(115);
        $this->middleware(function ($request, $next) {
            if(Auth::user() && !session('current_user'))
                session(['current_user'=>Auth::user()->ID]);

            return $next($request);
        });
        $this->hot_visible_for_users=Tmfsales::select('ID')
            ->where('sales_calls',1)
            ->where('Visible',1)
            ->where('ID','!=',111)
            ->get()
            ->pluck('ID')
            ->toArray();

        $this->hot_visible_for_users[]=1;
        $this->hot_visible_for_users[]=115;
        $this->hot_visible_for_users[]=116;
    }


    public function index($current_id=0){

/*        $prequalify_request_objs=PrequalifyRequest::where('handled_tmfsales_id',session('current_user'))
            ->where('lead_status_id','!=',5)
            ->whereIn('tmf_subject_id',TmfSubject::select('id')
                ->whereRaw("lower(concat(first_name, ' ', last_name)) like '%?%' ",strtolower('black'))
            )
            ->orderBy('created_at','desc')
            ->dd();*/


        $inprogress_count=PrequalifyRequest::where('handled_tmfsales_id',session('current_user'))
            ->where('lead_status_id',5)
            ->count();
        $finished_count=PrequalifyRequest::where('handled_tmfsales_id',session('current_user'))
            ->whereNotIn('lead_status_id',[5,7])
            ->count();
        $boomopportunities_count=PrequalifyRequest::where('handled_tmfsales_id',session('current_user'))
            ->where('lead_status_id',7)
            ->count();
        $finished_offset=$this->finished_load_limit;
        $hot_visible_for_users=$this->hot_visible_for_users;
//        dd(session('current_user'));
        $left_nav_bar=view('pq-applications.left-nav-bar')->render();
        $restrict_for_closers=Tmfsales::select('ID')
            ->where('sales_calls',1)
            ->where('Visible',1)
            ->where('ID','!=',86)//exclude Nick
            ->get()
            ->pluck('ID')
            ->toArray();
        $max_inprogress=$this->max_inprogress;
        return view('pq-applications.index-new',
            compact('inprogress_count', 'finished_count',
                'finished_offset','left_nav_bar','hot_visible_for_users','boomopportunities_count',
                'restrict_for_closers','max_inprogress')
        );
    }

    public function loadUnclaimedItems(Request $request){

        $prequalify_request_objs=PrequalifyRequest::whereNull('handled_tmfsales_id')
            ->whereNotIn('id',PrequalifyRequest::select('id')
                ->whereNull('handled_tmfsales_id')
                ->whereIn('id',
                    PrequalifyRequestAnswer::select('prequalify_request_id')
                        ->distinct()
                        ->where('prequalify_question_option_id',43)
                )
                ->whereIn('id',
                    PrequalifyRequestAnswer::select('prequalify_request_id')
                        ->distinct()
                        ->whereIn('prequalify_question_option_id',[55,56,57])
                ))
            ->orderBy('created_at')
            ->get();

/*        $prequalify_request_objs=PrequalifyRequest::select('prequalify_request.*')
            ->distinct()
            ->join('prequalify_request_answer','prequalify_request.id','=','prequalify_request_answer.prequalify_request_id')
            ->join('prequalify_question_option','prequalify_request_answer.prequalify_question_option_id','=','prequalify_question_option.id')
            ->where('prequalify_question_option.prequalify_question_id',8)
            ->whereNull('handled_tmfsales_id')
            ->where('prequalify_question_option_id','!=',43)
            ->orderBy('created_at')
            ->get();*/
        $current_status='unclaimed';
        return view('pq-applications.applications-list',compact('prequalify_request_objs','current_status'));
    }

    public function loadHotItems(Request $request){
        $prequalify_request_objs=PrequalifyRequest::whereNull('handled_tmfsales_id')
            ->whereIn('id',
                PrequalifyRequestAnswer::select('prequalify_request_id')
                    ->distinct()
                    ->where('prequalify_question_option_id',43)
            )
            ->whereIn('id',
                PrequalifyRequestAnswer::select('prequalify_request_id')
                    ->distinct()
                    ->whereIn('prequalify_question_option_id',[55,56,57])
            )
            ->orderBy('created_at')
            ->get();

        /*        $prequalify_request_objs=PrequalifyRequest::select('prequalify_request.*')
                    ->distinct()
                    ->join('prequalify_request_answer','prequalify_request.id','=','prequalify_request_answer.prequalify_request_id')
                    ->join('prequalify_question_option','prequalify_request_answer.prequalify_question_option_id','=','prequalify_question_option.id')
                    ->where('prequalify_question_option.prequalify_question_id',8)
                    ->whereNull('handled_tmfsales_id')
                    ->where('prequalify_question_option_id','=',43)
                    ->orderBy('created_at')
                    ->get();*/
        $current_status='hot';
        return view('pq-applications.applications-list',compact('prequalify_request_objs','current_status'));
    }

    public function loadInprogressItems(Request $request){
        $prequalify_request_objs=PrequalifyRequest::where('handled_tmfsales_id',session('current_user'))
            ->where('lead_status_id',5)
            ->orderBy('created_at')->get();
        $current_status='in-progress';
        return view('pq-applications.applications-list',compact('prequalify_request_objs','current_status'));
    }

    public function loadBoomOpportunitiesItems(Request $request){
        $prequalify_request_objs=PrequalifyRequest::where('handled_tmfsales_id',session('current_user'))
            ->where('lead_status_id',7)
            ->orderBy('created_at')->get();
        $current_status='boom-opportunities';
        return view('pq-applications.applications-list',compact('prequalify_request_objs','current_status'));
    }

    public function loadFinishedItems(Request $request){
        $prequalify_request_objs=PrequalifyRequest::where('handled_tmfsales_id',session('current_user'))
            ->whereNotIn('lead_status_id',[5,7])
            ->orderBy('created_at','desc')
            ->offset($request->offset)
            ->limit($this->finished_load_limit)
            ->get();

        $current_status='finished';
        $finished_count=PrequalifyRequest::where('handled_tmfsales_id',session('current_user'))
            ->whereNotIn('lead_status_id',[5,7])
            ->count();
        return response()->json([
            'html'=>view('pq-applications.applications-list',
                compact('prequalify_request_objs','current_status'))->render(),
            'count'=>$finished_count,
            'ids'=>$prequalify_request_objs->pluck('id')->toArray()
            ]);
    }

    public function searchFinishedByName(Request $request){
        $prequalify_request_objs=PrequalifyRequest::where('handled_tmfsales_id',session('current_user'))
            ->whereNotIn('lead_status_id',[5,7])
            ->whereIn('tmf_subject_id',TmfSubject::select('id')
                ->whereRaw("lower(concat(first_name, ' ', last_name)) like '%".strtolower($request->name)."%' ")
            )
            ->orderBy('created_at','desc')
            ->get();
        $current_status='finished';
        return response()->json([
            'html'=>view('pq-applications.applications-list',
                compact('prequalify_request_objs','current_status'))->render(),
            'count'=>$prequalify_request_objs->count(),
            'ids'=>$prequalify_request_objs->pluck('id')->toArray()
        ]);
    }

    public function approvedAndBookedEmail(Request $request){
        $prequalify_request_obj=PrequalifyRequest::find($request->id);
        if($prequalify_request_obj) {
            if($prequalify_request_obj->tmoffer->tmfClientTmsrTmoffer &&
                $tmf_booking=$prequalify_request_obj->tmoffer->tmfClientTmsrTmoffer->tmfBookings()->orderBy('id','desc')->first()) {
                $tmf_subject = $prequalify_request_obj->tmfSubject;
                $tmf_subject_contact = TmfSubjectContact::where('tmf_subject_id', $tmf_subject->id)
                    ->where('contact_data_type_id', 1)
                    ->first();
                $url = sprintf('https://trademarkfactory.com/request-approved/%s', Hashids::encode($prequalify_request_obj->id));


                $closer = $tmf_booking->closer;
                $closer_fn = $closer->FirstName . ' ' . $closer->LastName;
                $booking_time = \DateTime::createFromFormat('Y-m-d H:i:s', $tmf_booking->booked_date)
                    ->setTimezone(new \DateTimeZone($tmf_booking->timezone))
                    ->format('F j, Y \@ g:ia');

                $response = [
                    'status'=>'success',
                    'subj' => 'Your request has been approved!',
                    'message' => view('pq-applications.approved-and-booked-email',
                        compact('tmf_subject', 'url',
                            'closer_fn', 'booking_time')
                    )->render(),
                    'email' => $tmf_subject_contact->contact,
                ];
                return response()->json($response);
            }else
                return response()->json([
                    'status'=>'error',
                    'message'=>'This request does not have booking!'
                ]);
        }
        return response()->json([]);

    }

    public function setCurrentUser(Request $request){
        if($request->id)
            session(['current_user'=>$request->id]);
    }

    public function paintLegendPoints(Request $request){
        $result=[];
        $ids=json_decode($request->ids,true);
        foreach ($ids as $id){
            $prequalify_request_obj=PrequalifyRequest::find($id);
            $class='';
            $tmoffer=$prequalify_request_obj->tmoffer;
            if($tmoffer) {
                $tmoffer_bin = $tmoffer->tmofferBin;
                if ($tmoffer->tmfClientTmsrTmoffer &&
                    $tmoffer->tmfClientTmsrTmoffer->tmfBookings->count()) {
                    $tmf_booking = $tmoffer->tmfClientTmsrTmoffer->tmfBookings()->orderBy('id', 'desc')->first();
                    if ($tmoffer_bin && $tmoffer_bin->need_capture == 0)
                        $class = 'lp-boom';
                    else {
                        if ($tmf_booking->booked_date >= \Carbon\Carbon::now()->format('Y-m-d H:i:s'))
                            $class = 'lp-future-booking';
                        else
                            $class = 'lp-booking-noboom';
                    }

                    if ($tmf_booking->booked_date < \Carbon\Carbon::now()->format('Y-m-d H:i:s')) {
                        $tmfsales_tmoffer_not_boom_reason = \App\TmfsalesTmofferNotBoomReason::where('tmoffer_id', $tmoffer->ID)
                            ->where('not_boom_reason_id', 79)
                            ->first();
                        if ($tmfsales_tmoffer_not_boom_reason)
                            $class = 'lp-noshow';
                    }
                }elseif ($tmoffer_bin && $tmoffer_bin->need_capture == 0)
                    $class = 'lp-boom';
                elseif($prequalify_request_obj->lead_status_id && $prequalify_request_obj->lead_status_id<5)
                    $class='lp-filtered';

        }elseif($prequalify_request_obj->lead_status_id && $prequalify_request_obj->lead_status_id<5)
                $class='lp-filtered';
            $result[]=compact('id','class');
        }
        return response()->json($result);
    }

    public function loadCurrentStatus(Request $request){
        //test
        $prequalify_request_obj=PrequalifyRequest::find($request->id);
        if($prequalify_request_obj) {
            $booking_info='';
            $tmoffer=$prequalify_request_obj->tmoffer;
            if($tmoffer) {
                if (
                    $tmoffer->tmfClientTmsrTmoffer &&
                    $tmoffer->tmfClientTmsrTmoffer->tmfBookings->count()
                ) {
                    $tmf_booking = $tmoffer->tmfClientTmsrTmoffer->tmfBookings()->orderBy('id','desc')->first();
                    if($tmf_booking && $tmf_booking->booked_date!='0000-00-00 00:00:00')
                         $booking_info=sprintf('%s with %s for %s PST (<a href="/bookings-calendar/call-report/%s" class="call-report-link" data-tmoffer-id="%d" target="_blank">Call Report</a>)',
                        \DateTime::createFromFormat('Y-m-d H:i:s',$tmf_booking->created_at)->format('M j, Y \@ g:ia'),
                        Tmfsales::find($tmf_booking->sales_id)->FirstName,
                        \DateTime::createFromFormat('Y-m-d H:i:s',$tmf_booking->booked_date)->format('Y-m-d \@ g:ia'),
                        $tmoffer->Login,
                        $tmoffer->ID);
                }
            }
                    return response()->json([
                'status'=>$prequalify_request_obj->leadStatus->name,
                'booking_info'=>$booking_info
            ]);
        }
        return response()->json([]);
    }

    public function checkApplicationStatus(Request $request){
        $prequalify_request_obj=PrequalifyRequest::find($request->id);
        if($prequalify_request_obj){
            if(is_null($prequalify_request_obj->handled_tmfsales_id))
                return response()->json(['status'=>'unclaimed']);
            elseif($prequalify_request_obj->lead_status_id==5){
                return response()->json([
                    'status'=>'in-progress',
                    'tmfsales'=>$prequalify_request_obj->handled_tmfsales_id,
                    'tmfsales_fn'=>$prequalify_request_obj->tmfsales->FirstName.' '.$prequalify_request_obj->tmfsales->LastName
                ]);
            }elseif($prequalify_request_obj->lead_status_id==7) {
                return response()->json([
                    'status'=>'boom-opportunities',
                    'tmfsales'=>$prequalify_request_obj->handled_tmfsales_id,
                    'tmfsales_fn'=>$prequalify_request_obj->tmfsales->FirstName.' '.$prequalify_request_obj->tmfsales->LastName
                ]);
            }else
                return response()->json([
                    'status'=>'finished',
                    'tmfsales'=>$prequalify_request_obj->handled_tmfsales_id,
                    'tmfsales_fn'=>$prequalify_request_obj->tmfsales->FirstName.' '.$prequalify_request_obj->tmfsales->LastName
                ]);
        }
        return response()->json([]);
    }

    private function createTmoffer(PrequalifyRequest $prequalify_request_obj){
        $tmoffer=TmofferCreator::get();
        $tmoffer->prequalify_request_id=$prequalify_request_obj->id;
        $tmoffer->client_ip=$prequalify_request_obj->ip;
        $tmoffer->save();
        return $tmoffer;
    }

    public function loadClientInfo(Request $request){
        $prequalify_request_obj=PrequalifyRequest::find($request->id);
        if($prequalify_request_obj){
            $email=$prequalify_request_obj->tmfSubject->tmfSubjectContacts()->where('contact_data_type_id',1)->first()->contact;
            $phone=$prequalify_request_obj->tmfSubject->tmfSubjectContacts()->where('contact_data_type_id',4)->first()->contact;
            $tmoffer=Tmoffer::where('prequalify_request_id',$request->id)->first();
            if(!$tmoffer)
                $tmoffer=$this->createTmoffer($prequalify_request_obj);
            return response()->json([
                'client_fn'=>$prequalify_request_obj->tmfSubject->first_name.' '.$prequalify_request_obj->tmfSubject->last_name,
                'client_firstname'=>$prequalify_request_obj->tmfSubject->first_name,
                'client_lastname'=>$prequalify_request_obj->tmfSubject->last_name,
                'client_email'=>sprintf('<a href="mailto:%1$s" target="_blank">%1$s</a>',$email),
                'client_phone'=>sprintf('<a href="tel:%1$s" target="_blank">%1$s</a>',$phone),
                'tmf_subject_id'=>$prequalify_request_obj->tmf_subject_id,
                'tmoffer'=>($tmoffer?$tmoffer->Login:''),
                'tmoffer_id'=>($tmoffer?$tmoffer->ID:0),
                'lead_status_id'=>($prequalify_request_obj->lead_status_id?$prequalify_request_obj->lead_status_id:0)
            ]);
        }
        return response()->json([]);
    }

    private function saveTmfSubjectContactData($tmf_subject_id,$contact_data_type_id,$value){
        $tmf_subject_contact = TmfSubjectContact::where('tmf_subject_id', $tmf_subject_id)
            ->where('contact_data_type_id', $contact_data_type_id)
            ->first();
        if(!$tmf_subject_contact){
            $tmf_subject_contact=new TmfSubjectContact();
            $tmf_subject_contact->tmf_subject_id=$tmf_subject_id;
            $tmf_subject_contact->contact_data_type_id=$contact_data_type_id;
        }
        $tmf_subject_contact->contact=$value;
        $tmf_subject_contact->save();
    }

    public function saveTmfSubjectAttr(Request $request){
        $tmf_subject=TmfSubject::find($request->id);
        if($tmf_subject){
            $tmf_subject->first_name=$request->firstname;
            $tmf_subject->last_name=$request->lastname;
            $tmf_subject->save();
            $this->saveTmfSubjectContactData($request->id,1,$request->email);
            $this->saveTmfSubjectContactData($request->id,4,$request->phone);
            return 'done';
        }
        return '';
    }

    public function loadRequestDetails(Request $request){
        $prequalify_request=PrequalifyRequest::find($request->id);
        if($prequalify_request){
            $tmoffer=Tmoffer::where('prequalify_request_id',$prequalify_request->id)->first();
            if($tmoffer){
                $url=sprintf('https://trademarkfactory.com/mlcclients/get-offer.php?tmoffer_id=%d',$tmoffer->ID);
                $tmfsales=Tmfsales::find(1);
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
                $offer_id=file_get_contents($url,false,stream_context_create($arrContextOptions));
                $offer=Offer::find($offer_id);
                $offer_preview_url=sprintf('https://trademarkfactory.com/mlcclients/page-previewer.php?page=landing&id=%d&tmoffer=%d',
                    $offer->offer_booking_page_landing_id,$tmoffer->ID);
                $how_find_out=$tmoffer->how_find_out_us;
                $from_page=(new ClientIpFirstPage($tmoffer->client_ip))->get();
                return response()->json([
                    'from'=>$how_find_out,
                    'first_page'=>sprintf('<a href="https://trademarkfactory.com%s" target="_blank" style="overflow-wrap: break-word">%s</a>',
                        $from_page['url'],$from_page['title']),
                    'offer'=>sprintf('<a href="%s" target="_blank">%s</a>',$offer_preview_url,$offer->offer_name)
                ]);
            }else
                return response()->json([
                    'from'=>'N/A',
                    'first_page'=>'N/A',
                    'offer'=>'N/A',
                ]);
        }
    }

    public function loadProspectAnswers(Request $request)
    {
        $prequalify_request_obj=PrequalifyRequest::find($request->id);
        if($prequalify_request_obj) {
            $tz=$prequalify_request_obj->timezone;
            $arr_tz=explode("/",$tz);
            if(isset($arr_tz[1]))
                $timezone=str_replace('_',' ',$arr_tz[1]);
            else
                $timezone=str_replace('_',' ',$arr_tz[0]);

            $data=$this->prepareAnswers($prequalify_request_obj);
            return view('pq-applications.answers',
                compact('prequalify_request_obj','data','timezone'));
        }
        return '';
    }

    public function loadNotes(Request $request)
    {
        $prequalify_request_obj=PrequalifyRequest::find($request->id);
        if($prequalify_request_obj) {
            $tmoffer=Tmoffer::where('prequalify_request_id',$prequalify_request_obj->id)->first();
            if($tmoffer)
                return $tmoffer->Notes;
        }
        return '';
    }

    public function saveNotes(Request $request)
    {
        $prequalify_request_obj=PrequalifyRequest::find($request->id);
        if($prequalify_request_obj) {
            $tmoffer=Tmoffer::where('prequalify_request_id',$prequalify_request_obj->id)->first();
            if($tmoffer) {
                $tmoffer->Notes=$request->notes;
                $tmoffer->save();
                return 'Done';
            }
        }
        return '';
    }

    public function loadEmails(Request $request)
    {
        $prequalify_request_obj=PrequalifyRequest::find($request->id);
        if($prequalify_request_obj)
            return view('pq-applications.emails',compact('prequalify_request_obj'));
        return '';
    }

    private function prepareAnswers(PrequalifyRequest $prequalify_request_obj){
        $data=[];
        $questions=PrequalifyQuestion::all();
        foreach ($questions as $question){
            $data[$question->name]=[];
            $answers=PrequalifyRequestAnswer::where('prequalify_request_id',$prequalify_request_obj->id)
                ->whereIn('prequalify_question_option_id',
                    PrequalifyQuestionOption::select('id')->where('prequalify_question_id',$question->id))
                ->get();
            foreach ($answers as $answer)
                $data[$question->name][]=$answer->prequalifyQuestionOption->option;
        }
        return $data;
    }

    public function loadStatusData(Request $request){
        $prequalify_request_obj=PrequalifyRequest::find($request->id);
        if($prequalify_request_obj) {
            return response()->json([
                'temperature'=>$prequalify_request_obj->temperature,
                'needs_tm'=>$prequalify_request_obj->needs_tm,
                'knows_offer'=>$prequalify_request_obj->knows_offer,
                'lead_status'=>$prequalify_request_obj->lead_status_id
            ]);
        }
        return response()->json([]);
    }

    public function loadBoomStatus(Request $request){
        $tmoffer=Tmoffer::find($request->id);
        if($tmoffer){
            $tmoffer_bin=TmofferBin::where('tmoffer_id',$request->id)
                ->where('need_capture',0)
                ->first();
            return ($tmoffer_bin?'boom':'noboom');
        }
        return '';
    }

    public function setLeadStatus(Request $request){
        $prequalify_request=PrequalifyRequest::find($request->id);
        if($prequalify_request){
            $prequalify_request->lead_status_id=$request->lead_status_id;
            $prequalify_request->save();
            (new PqFollowUpEmailsSeqCreator())->run($prequalify_request);
            $sales=Tmfsales::find(session('current_user'));
            $tmoffer=$prequalify_request->tmoffer;
            $tmoffer->Sales=$sales->Login;
            $tmoffer->sales_id=$sales->ID;
            $tmoffer->save();
            $prequalify_request_lead_statuses_log=new PrequalifyRequestLeadStatusesLog();
            $prequalify_request_lead_statuses_log->prequalify_request_id=$prequalify_request->id;
            $prequalify_request_lead_statuses_log->lead_status_id=$request->lead_status_id;
            $prequalify_request_lead_statuses_log->tmfsales_id=Auth::user()->ID;
            $prequalify_request_lead_statuses_log->created_at=Carbon::now()->format('Y-m-d H:i:s');
            $prequalify_request_lead_statuses_log->save();
            return 'Done';
        }
        return '';
    }

}
