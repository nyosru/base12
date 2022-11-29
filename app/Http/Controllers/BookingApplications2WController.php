<?php

namespace App\Http\Controllers;

use App\classes\ClientIpFirstPage;
use App\classes\common\LinkShortener;
use App\classes\SmsSender;
use App\Mail\PostReportEmailSent;
use App\Offer;
use App\PrequalifyQuestion;
use App\PrequalifyQuestionOption;
use App\PrequalifyRequest;
use App\PrequalifyRequestAnswer;
use App\PrequalifyRequestEmailHistory;
use App\Tmfsales;
use App\TmfSubject;
use App\TmfSubjectContact;
use App\Tmoffer;
use Carbon\Carbon;
use Telegram\Bot\Api;
use Vinkla\Hashids\Facades\Hashids;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\traits\SaveToSent;

class BookingApplications2WController extends Controller
{
    use SaveToSent;

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
//        $prequalify_request_obj=PrequalifyRequest::find(2);
//        $data=$this->prepareAnswers($prequalify_request_obj);
//        dd($data);

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

        $prequalify_request_objs=$this->getPQrequests();
        $current_id=0;
        $show_lead_statuses=[];
        $show_stats=0;
        return view('booking-applications.index',
            compact('prequalify_request_objs',
                'current_id',
                'show_lead_statuses','months_btns', 'q_btns', 'y_select','show_stats'));
    }

    private function getPQrequests(){
        $today=Carbon::now();
        $interval_2weeks=\DateInterval::createFromDateString('2 weeks');
        $today->sub($interval_2weeks);
        return PrequalifyRequest::where('created_at','>=',$today->format('Y-m-d 00:00:00'))->get();
    }

    public function reloadTable(){
        $prequalify_request_objs=$this->getPQrequests();
        $current_id=0;
        $show_lead_statuses=[];
        return view('booking-applications.index',compact('prequalify_request_objs','current_id','show_lead_statuses'));
    }

    public function showRequest(Request $request){
        $prequalify_request_objs=$this->getPQrequests();
        $current_id=$request->id;
//        dd($current_id);
        return view('booking-applications.result-table',compact('prequalify_request_objs','current_id'));
    }

    public function loadClientAnswers(Request $request)
    {
        $prequalify_request_obj=PrequalifyRequest::find($request->id);
        if($prequalify_request_obj) {
            $data=$this->prepareAnswers($prequalify_request_obj);
            return view('booking-applications.answers',
                compact('prequalify_request_obj','data'));
        }
        return '';
    }

    public function approveForBookingData(Request $request)
    {
        $prequalify_request_obj=PrequalifyRequest::find($request->id);
        if($prequalify_request_obj) {
            $tmf_subject=$prequalify_request_obj->tmfSubject;
            $tmf_subject_contact=TmfSubjectContact::where('tmf_subject_id',$tmf_subject->id)
                ->where('contact_data_type_id',1)
                ->first();
            $url=sprintf('https://trademarkfactory.com/request-approved/%s',Hashids::encode($prequalify_request_obj->id));
            $response=[
                'subj'=>'👍 Your request has been approved!',
                'message'=>view('booking-applications.approve-for-booking-email',compact('tmf_subject','url'))->render(),
                'email'=>$tmf_subject_contact->contact
            ];
            return response()->json($response);
        }
        return response()->json([]);
    }

    private function getPixel($hash){
        $url='https://trademarkfactory.com/p/baph/'.$hash;
        return sprintf('<img src="%s"/>',$url);
    }

    public function followUpEmailData(Request $request)
    {
        $prequalify_request_obj=PrequalifyRequest::find($request->id);
        if($prequalify_request_obj) {
            $tmf_subject=$prequalify_request_obj->tmfSubject;
            $tmf_subject_contact=TmfSubjectContact::where('tmf_subject_id',$tmf_subject->id)
                ->where('contact_data_type_id',1)
                ->first();
            $response=[
                'subj'=>'About your request',
                'message'=>view('booking-applications.follow-up-email',compact('tmf_subject'))->render(),
                'email'=>$tmf_subject_contact->contact
            ];
            return response()->json($response);
        }
        return response()->json([]);
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

    public function sendEmail(Request $request)
    {

        $prequalify_request_obj=PrequalifyRequest::find($request->id);
        $tmfsales=Tmfsales::find($request->who);
        if($prequalify_request_obj) {
            $signature=$this->getSignature($tmfsales);
            $now=Carbon::now()->format('Y-m-d H:i:s');
            $tmf_subject_contact_email=TmfSubjectContact::where('tmf_subject_id',$prequalify_request_obj->tmf_subject_id)
                ->where('contact_data_type_id',1)
                ->first();

            switch ($request->action){
                case 'approve-for-booking':
//                    $prequalify_request_obj->approved_for_booking_at=$now;
                    $prequalify_request_email_type_id=2;
                    $url=sprintf('https://trademarkfactory.com/request-approved/%s',Hashids::encode($prequalify_request_obj->id));
                    $sms_message=sprintf('Congratulations, %s! Your request for a free call with a Trademark Factory advisor has been approved. Please pick a time that works for you at http://tmf.rocks/%s . Check your email for more details.',
                        $prequalify_request_obj->tmfSubject->first_name,
                        (new LinkShortener())->getTinyURL($url));

                    break;
                case 'follow-up-email':
//                    $prequalify_request_obj->follow_up_email_sent_at=$now;
                    $prequalify_request_email_type_id=1;
                    $sms_message=sprintf('%s, we just sent you an email to %s that requires your prompt response. Trademark Factory.',
                        $prequalify_request_obj->tmfSubject->first_name,
                        $tmf_subject_contact_email->contact);
                    break;
            }

//            $prequalify_request_obj->handled_tmfsales_id=Auth::user()->ID;
            $prequalify_request_obj->save();

            $prequalify_request_email_history=new PrequalifyRequestEmailHistory();
            $prequalify_request_email_history->prequalify_request_id=$prequalify_request_obj->id;
            $prequalify_request_email_history->prequalify_request_email_type_id=$prequalify_request_email_type_id;
            $prequalify_request_email_history->sent_tmfsales_id=Auth::user()->ID;
            $prequalify_request_email_history->from_tmfsales_id=$request->who;
            $prequalify_request_email_history->subj=$request->subj;
            $prequalify_request_email_history->message=$request->message;
            $prequalify_request_email_history->created_at=$now;
            $prequalify_request_email_history->save();

            $pixel=$this->getPixel(md5($now));
            $tmf_subject=$prequalify_request_obj->tmfSubject;
            $tmf_subject_contact=TmfSubjectContact::where('tmf_subject_id',$tmf_subject->id)
                ->where('contact_data_type_id',1)
                ->first();
//            $request->email='vitaly.polukhin@yahoo.com';
            $request->email=$tmf_subject_contact->contact;
            $andrei = Tmfsales::find(1);
            Mail::to([['email' => $request->email, 'name' => $tmf_subject->first_name.' '.$tmf_subject->last_name]])
//                ->bcc([$andrei->Email])
                ->send(new PostReportEmailSent($tmfsales->Email,'Trademark Factory® | '.$tmfsales->FirstName.' '.$tmfsales->LastName,
                        $request->subj,
                        $request->message.$pixel.$signature)
                );
            $this->saveToSentWithAttachment(
                $tmfsales,
                $request->email,
                $tmf_subject->first_name.' '.$tmf_subject->last_name,
                $request->subj,
                $request->message.$signature);
            $this->sendMessageInTelegram($prequalify_request_email_history);
            if($request->notify_by_sms)
                (new SmsSender($prequalify_request_obj->tmfSubject))->send($sms_message);
            return 'Done';
        }
        return '';
    }

    private function sendMessageInTelegram($prequalify_request_email_history){
        $tmf_subject=$prequalify_request_email_history->prequalifyRequest->tmfSubject;
        $message=sprintf('%s sent %s email to %s %s',
            $prequalify_request_email_history->sentTmfsales->FirstName,
            $prequalify_request_email_history->prequalifyRequestEmailType->name,
            $tmf_subject->first_name,
            $tmf_subject->last_name);
        $config = app('config')->get('telegram');
        $telegram = new Api($config['token']);
        $telegram->sendMessage([
            'chat_id' => $config['tmf-sdr-id'],
            'parse_mode' => 'HTML',
            'text' => $message
        ]);

    }

    private function getSignature(Tmfsales $tmfsales){
        $arrContextOptions=array(
            "ssl"=>array(
                "verify_peer"=>false,
                "verify_peer_name"=>false,
            ),
        );
        $signature_link='https://trademarkfactory.com/signatureall_new.php?id='.$tmfsales->ID;
        return file_get_contents(
            $signature_link,
            false,
            stream_context_create($arrContextOptions)
        );
    }

    public function showRequestInfo(Request $request){
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
                $gparams='';
                return view('post-boom-bookings-calendar.booking-info',
                    compact('gparams','how_find_out',
                        'from_page','offer','offer_preview_url'));
            }else
                return '<p>NO DATA</p>';
        }
    }

    public function showEmailDetails(Request $request){
        $prequalify_request_email_history=PrequalifyRequestEmailHistory::find($request->id);
        if($prequalify_request_email_history){
            return view('booking-applications.email-details',compact('prequalify_request_email_history'));
        }
    }

    public function callReportSave(Request $request){
        $prequalify_request=PrequalifyRequest::find($request->id);
        if($prequalify_request){
            $prequalify_request->temperature=$request->temperature;
            $prequalify_request->needs_tm=$request->needs_tm;
            $prequalify_request->knows_offer=$request->knows_offer;
            $prequalify_request->lead_status_id=$request->lead_status;
            $tmoffer=\App\Tmoffer::where('prequalify_request_id',$prequalify_request->id)->first();
            if($tmoffer) {
                $tmoffer->Notes = $request->notes;
                $tmoffer->save();
            }
            $prequalify_request->handled_tmfsales_id=Auth::user()->ID;
            $prequalify_request->save();
            return 'DONE';
        }
        return '';
    }

    public function sdrStatus(Request $request){
        $prequalify_request=PrequalifyRequest::find($request->id);
        if($prequalify_request){
            if($prequalify_request->claimed_tmfsales_id && $prequalify_request->claimed_tmfsales_id!=Auth::user()->ID){
                return response()->json([
                    'status'=>'claimed',
                    'background'=>$prequalify_request->lead_status_id?$prequalify_request->leadStatus->color:'transparent',
                    'html'=>view('booking-applications.sdr-status-cell',compact('prequalify_request'))->render(),
                    'sdr_fname'=>$prequalify_request->tmfsalesClaimed->FirstName,
                    'claimed_datetime'=>\DateTime::createFromFormat('Y-m-d H:i:s',$prequalify_request->claimed_at)->format('Y-m-d \@ H:i:s')
                ]);
            }else {
                $prequalify_request->claimed_tmfsales_id=Auth::user()->ID;
                $prequalify_request->claimed_at=Carbon::now()->format('Y-m-d H:i:s');
                $prequalify_request->save();
                return response()->json(['status' => 'free']);
            }
        }
        return response()->json(['status'=>'error']);
    }

}
