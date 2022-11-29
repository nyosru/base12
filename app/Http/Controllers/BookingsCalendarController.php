<?php

namespace App\Http\Controllers;

use App\AffiliateUser;
use App\classes\bookingstat\Stat;
use App\classes\ClientIpFirstPage;
use App\classes\GCalendar;
use App\classes\postboombookings\Booking;
use App\classes\postboombookings\BookingsLoader;
use App\classes\postboombookings\GcOeBooking;
use App\classes\postboombookings\OeBooking;
use App\classes\postboombookings\TmfsalesLoader;
use App\classes\reportcall\ReportCallModal;
use App\classes\tmoffer\CompanySubjectInfo;
use App\GroupMeeting;
use App\Mail\OutreachEmail1Sent;
use App\Mail\PostReportEmailSent;
use App\OeBookingCall;
use App\Offer;
use App\PrequalifyQuestion;
use App\PrequalifyQuestionOption;
use App\PrequalifyRequest;
use App\PrequalifyRequestAnswer;
use App\Tmf18botTmfsales;
use App\TmfBooking;
use App\TmfClientTmsrTmoffer;
use App\TmfEvent;
use App\Tmfsales;
use App\TmfsalesTmofferNotBoomReason;
use App\Tmoffer;
use App\TmofferActionsHistory;
use App\TmofferBin;
use App\TmofferRecordings;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Acaronlex\LaravelCalendar\Calendar;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Telegram\Bot\Api;

class BookingsCalendarController extends Controller
{

    private $dir='/closers-calls';
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //2020-07-22 15:23:37
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $today = Carbon::now();
//        $today = \DateTime::createFromFormat('Y-m-d H:i:s','2021-02-02 12:00:00');

        return $this->showPage($today);

    }

    private function showPage(\DateTime $today,$action_data=null){
        $calendar = $this->getCalendar($this->getEvents($today), $today);

        $tmfsales = (new TmfsalesLoader())->get(1);

        $closers = Tmfsales::where('Visible', 1)
            ->where('sales_calls', 1)
            ->get();
        $closers->push(Tmfsales::find(1));//Andrei

        $calendar_options_json = $calendar->getOptionsJson();
        $next_date = (clone $today)->modify('last day of next month')->format('Y-m-') . '01';
        $prev_date = (clone $today)->sub(\DateInterval::createFromDateString('1 month'))->format('Y-m-') . '01';

        $months_btns = '';
        $y = date('Y');
        for ($i = 1; $i < 13; $i++) {
            $from = sprintf('%s-01', ($i > 9 ? $i : '0' . $i));
            $to = date('m-d', strtotime($y . '-' . $from . ' + 1 month - 1 day'));
            $months_btns .= sprintf('<a href="#" class="btn btn-sm btn-info month-btn" style="margin-right: 7px;color:white" data-from="%s" data-to="%s">%s</a>',
                $from, $to, $i);
        }

        $q_btns = '';
        for ($i = 1; $i < 5; $i++) {
            $first_q_month = $i * 3 - 2;
            $last_q_month = $i * 3;
            $start = sprintf('%s-01', ($first_q_month > 9 ? $first_q_month : '0' . $first_q_month));
            $end = sprintf('%s-01', ($last_q_month > 9 ? $last_q_month : '0' . $last_q_month));
            $to = date('m-d', strtotime($y . '-' . $end . ' + 1 month - 1 day'));
            $q_btns .= sprintf('<a href="#" class="btn btn-sm btn-info q-btn" style="margin-right: 7px;color:white" data-from="%s" data-to="%s">Q%s</a>',
                $start, $to, $i);
        }

        $y_select = '<select id="s-year" class="form-control" style="width: auto;display: inline-block">';
        for ($i = 2020; $i < 2031; $i++)
            $y_select .= sprintf('<option value="%1$d" %2$s>%1$d</option>', $i, ($i == date('Y') ? 'selected' : ''));
        $y_select .= '</select>';

        return view('post-boom-bookings-calendar.index',
            compact('calendar_options_json',
                'tmfsales',
                'closers',
                'today',
                'prev_date',
                'next_date','action_data','months_btns', 'q_btns', 'y_select')
        );
    }

    public function enterBoomReason(Request $request){
        $tmoffer=Tmoffer::where('Login',$request->tmoffer_login)->first();
        $tmf_booking=TmfBooking::whereIn('tmf_client_tmsr_tmoffer_id',
            TmfClientTmsrTmoffer::select('id')->where('tmoffer_id',$tmoffer->ID))
            ->orderBy('id','desc')
            ->first();
        if($tmf_booking){
            $datetime=new \DateTime($tmf_booking->booked_date);
            return $this->showPage($datetime,['action'=>'enter-boom-reason','tmoffer_id'=>$tmoffer->ID]);
        }else
            echo 'wrong login!';
    }

    private function getParticipants($participants)
    {
        $arr = [];
        $ids = [];
        foreach ($participants as $el) {
            $arr[] = $el->LongID;
            $ids[] = $el->ID;
        }
        return [
            'logins' => $arr,
            'ids' => $ids
        ];
    }

    private function getOptions(Booking $booking)
    {
        $date = $booking->getBookedDatetime()->format('Y-m-d H:i:s');
        $now = (new \DateTime())->format('Y-m-d H:i:s');
        $participants = $this->getParticipants($booking->getParticipants());
        $options = [
            'textColor' => 'white',
            'borderColor' => 'white',
//            'backgroundColor' => ($date >= $now ? '#3490dc' : 'lightgray'),
            'backgroundColor' => $booking->getBorderColor(),
//            'title_bkg' => ($date >= $now ? '#3490dc' : 'lightgray'),
            'title_bkg' => $booking->getBorderColor(),
            'participants' => $participants['logins'],
            'participants_ids' => $participants['ids'],
            'content_bkg' => $booking->getBackground(),
            'client' => $booking->getClient(),
            'menu_items' => $booking->getMenu(),
            'border_color' => $booking->getBorderColor(),
            'time' => $booking->getBookedDatetime()->format('H:i'),
            'call_icon' => $booking->getBookingCallIcon(),
            'booking_source_icon' => $booking->getBookingSourceIcon(),
            'client_info' => $booking->getClientInfo(),
            'block_class'=>$booking->getBlockClass(),
            'booking_props'=>$booking->getBookingProps()

        ];
        return $options;
    }

/*    private function getBookingCallIcon($booking_obj)
    {
        switch ($booking_obj->who_will_call) {
            case 'ZOOM':
                return 'https://trademarkfactory.imgix.net/img/zoom-icon.png';
            case 'TMF':
                return 'https://trademarkfactory.imgix.net/img/outgoing-call.png';
            case 'CLIENT':
                return 'https://trademarkfactory.imgix.net/img/incoming-call.png';
        }

        return 'https://trademarkfactory.imgix.net/img/outgoing-call.png';
    }*/

    private function getEvents(\DateTime $datetime)
    {
        $events = [];
        $last_month_day = $datetime->format('Y-m-t');
        $first_month_day = $datetime->format('Y-m-') . '01';
        $from = new \DateTime($first_month_day . ' 00:00:00');
        $to = new \DateTime($last_month_day . ' 23:59:59');

        $bookings = (new BookingsLoader($from, $to))->run()->getBookings();
        foreach ($bookings as $booking) {
            $date = $booking->getBookedDatetime();
            $title = $booking->getTitle();
            $options = $this->getOptions($booking);
            $events[] = Calendar::event(
                $title,
                false, //full day event?
                $date->format('Y-m-d H:i:s'),
                $date->add(\DateInterval::createFromDateString('45 minutes'))->format('Y-m-d H:i:s'),
                uniqid(), //optionally, you can specify an event ID
                $options
            );
        }

        return $events;
    }

    private function getCalendar($events, \DateTime $datetime)
    {
        $calendar = new Calendar();

        $calendar->addEvents($events)
            ->setOptions([
                'locale' => 'en',
                'timeZone' => 'America/Los_Angeles',
                'themeSystem' => 'bootstrap',
                'initialDate' => $datetime->format('Y-m-d'),
                'firstDay' => 0,
                'dayMaxEvents' => 4,
                'displayEventTime' => false,
                'selectable' => false,
                'weekNumbers'=>true,
                'showNonCurrentDates' => false,
                'initialView' => 'dayGridMonth',
            ]);
        $calendar->setId('1');
        $calendar->setCallbacks([
            'eventDidMount' => 'function(info){return eventDidMount(info);}',
            'eventContent' => 'function(info){return renderContentEvent(info);}',
            'eventMouseLeave' => 'function(info){calendarMouseLeaveEvent(info);}',
            'eventMouseEnter' => 'function(info){calendarSetCurrentEvent(info);}',
            'weekNumberContent'=>'function(info){weekNumberContentPaint(info);}',
            'weekNumberDidMount'=>'function(info){weekNumberDidMount(info);}'
        ]);

        return $calendar;
    }

    private function getEventsAlt(\DateTime $datetime)
    {
        $last_month_day = $datetime->format('Y-m-t');
        $first_month_day = $datetime->format('Y-m-') . '01';
        $from = new \DateTime($first_month_day . ' 00:00:00');
        $to = new \DateTime($last_month_day . ' 23:59:59');

        $bookings = (new BookingsLoader($from, $to))->run()->getBookings();

        $events = [];
        foreach ($bookings as $booking) {
            $date = $booking->getBookedDatetime();
            $title = $booking->getTitle();
            $options = $this->getOptions($booking);

            $events[] = array_merge([
                'title' => $title,
                'start' => $date->format('Y-m-d H:i:s'),
                'end' => $date->format('Y-m-d H:i:s'),
                'id' => uniqid()

            ], $options);
        }
        return $events;
    }

    public function loadMonthData(Request $request)
    {
        $date = new \DateTime($request->start);
        return response()->json(
            json_encode($this->getEventsAlt($date))
        );
    }

    public function loadNoboomReasonData(Request $request)
    {
        $tmoffer = Tmoffer::find($request->tmoffer_id);
        $tmfsales_tmoffer_not_boom_reason = TmfsalesTmofferNotBoomReason::where('tmoffer_id', $request->tmoffer_id)->first();
        $response = [
            'notes' => $tmoffer->Notes,
            'noboom_reason' => 0,
            'lead_temp' => 0,
            'need_tm' => 0,
            'knows_tmf_offer' => 0,
            'no_boom_reason_text' => '',
            'call_record_url' => '',
            'closeable'=>$tmoffer->closeable,
            'closeable_notification_at'=>$tmoffer->closeable_notification_at
        ];
        if ($tmfsales_tmoffer_not_boom_reason) {
            $response['noboom_reason'] = $tmfsales_tmoffer_not_boom_reason->not_boom_reason_id;
            $response['no_boom_reason_text'] = $tmfsales_tmoffer_not_boom_reason->not_boom_reason_text;
            $response['lead_temp'] = $tmfsales_tmoffer_not_boom_reason->lead_temp;
            $response['need_tm'] = $tmfsales_tmoffer_not_boom_reason->lead_need_tm;
            $response['knows_tmf_offer'] = $tmfsales_tmoffer_not_boom_reason->lead_knows_tm_offer;
        }
        $tmf_booking = TmfBooking::whereIn('tmf_client_tmsr_tmoffer_id',
            TmfClientTmsrTmoffer::select('id')->where('tmoffer_id', $request->tmoffer_id)
        )->orderBy('id', 'desc')
            ->first();
        if ($tmf_booking)
            $response['call_record_url'] = $tmf_booking->call_record_url;

        return response()->json($response);
    }

    public function loadReportCallBody(Request $request){
        return ReportCallModal::init(Tmoffer::find($request->tmoffer_id))->show();
    }

    public function saveBoomReport(Request $request){
        $tmfsales = Auth::user();
        $tmoffer = Tmoffer::find($request->tmoffer_id);
        $add2notes=sprintf("\r\n\r\n%s %s Added Boom Reason:%s",
            (new \DateTime())->format('Y-m-d'),
            $tmfsales->LongID,
            $request->boom_reason);
        $tmoffer->Notes = ($request->notes?$request->notes:'').$add2notes;
        $tmoffer->lead_temp = $request->lead_temp;
        $tmoffer->lead_need_tm = $request->lead_need_tm;
        $tmoffer->lead_knows_tmf_offer = $request->knows_tmf_offer;
        $tmoffer->save();

        $tmoffer_bin=TmofferBin::where('tmoffer_id',$request->tmoffer_id)->first();
        if($tmoffer_bin){
            $tmoffer_bin->boom_reason=$request->boom_reason;
            $tmoffer_bin->save();
        }

        $tmf_booking = TmfBooking::whereIn('tmf_client_tmsr_tmoffer_id',
            TmfClientTmsrTmoffer::select('id')->where('tmoffer_id', $request->tmoffer_id)
        )->orderBy('id', 'desc')
            ->first();
        if ($tmf_booking) {
            $tmf_booking->call_record_url = ($request->call_record_url?$request->call_record_url:'');
            $tmf_booking->save();
        }
        return 'Saved';
    }
//2020-12-01 09:56 BFPNYC (#tmf2011301732074535):
//Godwin was talking to another group with lower prices, but his bigger issue was the Amazon Brand registry. He has an online shop from where he sells other brands.

    public function saveNoboomReasonData(Request $request)
    {
        $tmfsales = Auth::user();

        $tmoffer = Tmoffer::find($request->tmoffer_id);
        $add2notes=sprintf("\r\n\r\n%s %s Added No-Boom Reason:%s",
            (new \DateTime())->format('Y-m-d'),
            $tmfsales->LongID,
            $request->no_boom_reason_text);
        $tmoffer->Notes = ($request->notes?$request->notes:'').$add2notes;
        $tmoffer->lead_temp = $request->lead_temp;
        $tmoffer->lead_need_tm = $request->lead_need_tm;
        $tmoffer->lead_knows_tmf_offer = $request->knows_tmf_offer;
        $tmoffer->closeable=$request->closeable;
        if($request->closeable==-1)
            $tmoffer->closeable_notification_at=null;
        else{
/*            $interval=\DateInterval::createFromDateString($request->closeable_remind.' days');
            $notification_date=(new \DateTime())
                ->add($interval)
                ->format('Y-m-d H:i:s');*/
            $tmoffer->closeable_notification_at=$request->closeable_remind;
        }
        $tmoffer->save();

        $start_flowchart=false;
        $tmfsales_tmoffer_not_boom_reason = TmfsalesTmofferNotBoomReason::where('tmoffer_id', $request->tmoffer_id)->first();
        if (!$tmfsales_tmoffer_not_boom_reason) {
            $tmfsales_tmoffer_not_boom_reason = new TmfsalesTmofferNotBoomReason();
            $start_flowchart=true;
        }
        $tmfsales_tmoffer_not_boom_reason->tmfsales_id = $tmfsales->ID;
        $tmfsales_tmoffer_not_boom_reason->tmoffer_id = $request->tmoffer_id;
        $tmfsales_tmoffer_not_boom_reason->not_boom_reason_id = $request->no_boom_reason;
        $tmfsales_tmoffer_not_boom_reason->lead_temp = $request->lead_temp;
        $tmfsales_tmoffer_not_boom_reason->lead_need_tm = $request->lead_need_tm;
        $tmfsales_tmoffer_not_boom_reason->lead_knows_tmf_offer = $request->knows_tmf_offer;
        $tmfsales_tmoffer_not_boom_reason->not_boom_reason_text = ($request->no_boom_reason_text?$request->no_boom_reason_text:'');
        $tmfsales_tmoffer_not_boom_reason->created_at = Carbon::now()->format('Y-m-d H:i:s');
        $tmfsales_tmoffer_not_boom_reason->save();
        $tmf_booking = TmfBooking::whereIn('tmf_client_tmsr_tmoffer_id',
            TmfClientTmsrTmoffer::select('id')->where('tmoffer_id', $request->tmoffer_id)
        )->orderBy('id', 'desc')
            ->first();
        if ($tmf_booking && strlen($request->call_record_url)) {
            $tmf_booking->call_record_url = $request->call_record_url;
            $tmf_booking->save();
        }
        if($start_flowchart)
            $this->startFlowchart($tmoffer->ID);
        return 'Saved';
    }

    private function startFlowchart($tmoffer_id){
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
        $url=sprintf('https://trademarkfactory.com/mlcclients/start-flowchart.php?tmoffer_id=%d',$tmoffer_id);
        return file_get_contents($url,false,stream_context_create($arrContextOptions));
    }

    public function changeCloser(Request $request)
    {
        $booking = TmfBooking::find($request->booking_id);
        $old_closer = Tmfsales::find($booking->sales_id);
        $new_closer = Tmfsales::find($request->new_closer_id);
        $this->addGoogleCalendarEventToNewCloser($booking,$new_closer);
        $booking->sales_id = $request->new_closer_id;
        $booking->save();
        if ($request->new_closer_id != $old_closer->ID) {
            $this->sendPrivateTelegramMessage($old_closer->ID,
                $this->getMessageForOldCloser($booking));
            $this->sendPrivateTelegramMessage($new_closer->ID,
                $this->getMessageForNewCloser($booking, $old_closer));
        }
        return 'Saved';
    }

    private function addGoogleCalendarEventToNewCloser(TmfBooking $tmf_booking,Tmfsales $closer){
        $existing_gcalendar = new GCalendar();
        $old_closer=Tmfsales::find($tmf_booking->sales_id);
        $existing_gcalendar->authenticateByTMFSales($old_closer);
        $existing_item = $existing_gcalendar->getEventShortDataByID($tmf_booking->google_calendar_id);
        $old_event_id=$tmf_booking->google_calendar_id;

        $new_gcalendar=new GCalendar();
        $new_gcalendar->authenticateByTMFSales($closer);
        @ $event_id=$new_gcalendar->insertEvent(
            $closer->google_calendar_id,
            $existing_item['summary'],
            $existing_item['description'],
            $tmf_booking->booked_date);
        $tmf_booking->google_calendar_id=$event_id;
        $tmf_booking->save();
        @ $existing_gcalendar->deleteEvent($old_closer->google_calendar_id, $old_event_id);
    }

    private function getMessageForOldCloser($booking_obj)
    {
        $tmfsales = Tmfsales::find($booking_obj->sales_id);
        $tmoffer = Tmoffer::whereIn('ID', TmfClientTmsrTmoffer::select('tmoffer_id')->where('id', $booking_obj->tmf_client_tmsr_tmoffer_id))->first();
        return sprintf('%s %s snatched your booking with %s scheduled for %s PST.',
            $tmfsales->FirstName,
            $tmfsales->LastName,
            $this->getClient($tmoffer),
            (new \DateTime($booking_obj->booked_date))->format('F j, Y \a\t g:ia')
        );
    }

    private function getMessageForNewCloser($booking_obj, $old_tmfsales)
    {
        $tmoffer = Tmoffer::whereIn('ID', TmfClientTmsrTmoffer::select('tmoffer_id')->where('id', $booking_obj->tmf_client_tmsr_tmoffer_id))->first();
        return sprintf('You are now the closer for the booking with %s originally scheduled with %s %s for %s PST.',
            $this->getClient($tmoffer),
            $old_tmfsales->FirstName,
            $old_tmfsales->LastName,
            (new \DateTime($booking_obj->booked_date))->format('F j, Y \a\t g:ia')
        );
    }

    private function getClient($tmoffer)
    {
//        echo "tmoffer_id:{$this->tmoffer->ID}<br/>";
        $client_info = CompanySubjectInfo::init($tmoffer)->get();
        if ($client_info['company'] == $client_info['firstname'] . ' ' . $client_info['lastname'])
            return $client_info['company'];
        else
            if (strlen($client_info['company']))
                return sprintf('%s (%s %s)',
                    $client_info['company'],
                    $client_info['firstname'],
                    $client_info['lastname']
                );
            else
                return $client_info['firstname'] . ' ' . $client_info['lastname'];
    }


    private function sendPrivateTelegramMessage($tmfsales_id, $message)
    {
//        $tmfsales_id=53;
        $config = app('config')->get('telegram');
        $obj = Tmf18botTmfsales::where('tmfsales_id', $tmfsales_id)->first();
        if ($obj) {
            $telegram = new Api($config['token']); //Install token which we got from BotFather;
            $telegram->sendMessage(['chat_id' => $obj->chat_id, 'parse_mode' => 'HTML', 'text' => $message]);
        }
    }

    public function removeBooking(Request $request){
        $booking_obj=TmfBooking::find($request->booking_id);
//        var_dump($booking_obj);
        $tmoffer = Tmoffer::whereIn('ID',
            TmfClientTmsrTmoffer::select('tmoffer_id')
                ->where('id', $booking_obj->tmf_client_tmsr_tmoffer_id)
        )
        ->first();
        if($tmoffer){
            $tmf_events=TmfEvent::where('tmf_event_table','tmoffer')
                ->where('tmf_event_table_index_field_value',$tmoffer->ID)
                ->where('tmf_event_disable',0);
            if($tmf_events->count())
                $tmf_events->delete();
            $tmfsales=Tmfsales::find($booking_obj->sales_id);
            if(strlen($booking_obj->google_calendar_id)){
                $gcalendar=new GCalendar();
                @$gcalendar->authenticateByTMFSales($tmfsales);
                $event = @$gcalendar->issetEvent($booking_obj->google_calendar_id);
//                    var_dump($event->status);
                if ($event && $event->status!='cancelled')
                    $gcalendar->deleteEvent($tmfsales->google_calendar_id, $booking_obj->google_calendar_id);
                unset($gcalendar);
            }
        }
        TmfBooking::where('tmf_client_tmsr_tmoffer_id', $booking_obj->tmf_client_tmsr_tmoffer_id)->delete();
        return 'Removed';
    }

    public function loadNotes(Request $request){
        $tmoffer=Tmoffer::find($request->tmoffer_id);

        if($tmoffer)
            return $tmoffer->Notes;

        return '';
    }

    public function saveNotes(Request $request){
        $tmoffer=Tmoffer::find($request->tmoffer_id);

        if($tmoffer) {
            $tmoffer->Notes=$request->notes;
            $tmoffer->save();
            return 'Saved';
        }

        return '';
    }

    public function uploadRecordings(Request $request){
        $tmoffer=Tmoffer::find($request->tmoffer_id);
        if($tmoffer) {
            $paths=[];
            foreach ($request->file('tmf-file') as $file) {
                $filename=$file->getClientOriginalName();
                $tmoffer_recording=TmofferRecordings::where('tmoffer_id',$request->tmoffer_id)
                    ->where('filename',$filename)
                    ->first();
                if(!$tmoffer_recording) {
                    $paths[] = $file->storeAs($this->dir, $file->getClientOriginalName(), 'dropbox');
                    $tmoffer_recording=new TmofferRecordings();
                    $tmoffer_recording->tmoffer_id=$request->tmoffer_id;
                    $tmoffer_recording->filename=$filename;
                    $tmoffer_recording->save();
                }
            }
            if(count($paths))
                return 'Saved';
        }

        return '';
    }

    public function setCloseableNextReminder(Request $request){
        $tmoffer=Tmoffer::where('Login',$request->tmoffer_login)->first();
        if($tmoffer){
            if($request->delta_days_reminder==-1){
                $tmoffer->closeable_notification_at=null;
                $tmoffer->closeable=-1;
                echo "Marked Uncloseable and Reminders Stopped.";
            }else{
                $interval=\DateInterval::createFromDateString($request->delta_days_reminder.' days');
                $notification_date=(new \DateTime())
                    ->add($interval)
                    ->format('Y-m-d H:i:s');
                $tmoffer->closeable_notification_at=$notification_date;
                echo "New Reminder Saved.";
            }
            $tmoffer->save();
        }
    }

    public function loadBoomReason(Request $request){
        $tmoffer_bin=TmofferBin::where('tmoffer_id',$request->tmoffer_id)->first();

        if($tmoffer_bin)
            return $tmoffer_bin->boom_reason;

        return '';
    }

    public function saveBoomReason(Request $request){
        $tmoffer_bin=TmofferBin::where('tmoffer_id',$request->tmoffer_id)->first();

        if($tmoffer_bin) {
            $tmoffer_bin->boom_reason=$request->boom_reason;
            $tmoffer_bin->save();
            return 'Saved';
        }
        return '';
    }

    public function cancelGcBooking(Request $request){
        $obj=GroupMeeting::find($request->gc_id);
        $obj->cancelled_at=Carbon::now()->format('Y-m-d H:i:s');
        $obj->save();
        return 'Done';
    }

    public function cancelOeSouBooking(Request $request){
        $obj=$request->classname::find($request->id);
        if($obj) {
            $obj->cancelled_at = Carbon::now()->format('Y-m-d H:i:s');
            $obj->save();
            return 'DONE';
        }
        return '';
    }

    public function resendGcZoomLinkEmail(Request $request){
        $obj=GcOeBooking::initGcBooking(GroupMeeting::find($request->gc_id));
        return $this->resendZoomLinkToClient($obj);
    }

    public function resendOeSouZoomLinkEmail(Request $request){
        if($request->classname=='App\OeBookingCall')
            $obj=GcOeBooking::initOeBooking(OeBookingCall::find($request->id));
        else
            $obj=GcOeBooking::initGcBooking(GroupMeeting::find($request->id));

        return $this->resendZoomLinkToClient($obj);
    }

    private function filterTz($tz){
        $arr=explode('\\',$tz);
        if(isset($arr[1]))
            $tmp=$arr[1];
        else
            $tmp=$arr[0];

        return str_replace('_',' ',$tmp);
    }

    private function resendZoomLinkToClient(GcOeBooking $gc_oe_booking){
        $booking_obj=$gc_oe_booking->getBookingObj();
        $booking_datetime_pst=new \DateTime($gc_oe_booking->getBookingDateTime());
        $tz=new \DateTimeZone($booking_obj->timezone);
        $booking_datetime_tz=(clone $booking_datetime_pst)->setTimezone($tz);
        $client_firstname=$gc_oe_booking->getClientFirstName();

        $objs=$gc_oe_booking->getTmfsalesBookingCallObjs();
        $tmfsales_objs=[];
        $call_with_tmfsales=[];
        foreach ($objs as $el)
            $call_with_tmfsales[]=$el->tmfsales->FirstName.' '.$el->tmfsales->LastName;

        $last_tmfsales=array_pop($call_with_tmfsales);
        $tmfsales_str=implode(', ',$call_with_tmfsales).' and '.$last_tmfsales;
        $client_tz=$this->filterTz($booking_obj->timezone);

        $current_person=Auth::user();

        $arrContextOptions=array(
            "ssl"=>array(
                "verify_peer"=>false,
                "verify_peer_name"=>false,
            ),
        );
        $url='https://trademarkfactory.ca/signatureall_new.php?id='.$current_person->ID;
        $signature=file_get_contents($url,false,stream_context_create($arrContextOptions));


        $email_text=view('post-boom-bookings-calendar.zoom-email',
            compact('client_firstname',
                'tmfsales_str',
                'client_tz',
                'booking_datetime_tz',
                'booking_obj',
                'current_person',
                'gc_oe_booking','signature')
        )->render();

    }

    private function sendEmail($data,$andrei){
        Mail::to([['email' => $data['email'], 'name' => $data['firstname']]])
            ->cc($andrei->Email, $andrei->FirstName . ' ' . $andrei->LastName)
            ->send(new OutreachEmail1Sent($data['from']->Email,'Trademark Factory® | ROBOT',
                    $data['subj'],
                    $data['body'])
            );
    }

    public function loadPostReportEmail(Request $request){
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
        $url=sprintf('https://trademarkfactory.com/mlcclients/not-boom-reason-translated-email.php?tmoffer_id=%d&no_boom_reason_id=%d',
            $request->tmoffer_id,$request->id);
//        return $url;
        return response()->json(
            file_get_contents($url,false,stream_context_create($arrContextOptions))
        );
    }

    public function sendPostReportEmail(Request $request)
    {
        $tmoffer=Tmoffer::find($request->tmoffer_id);
        $tmfsales=Tmfsales::find($request->tmfsales_id);
        if($tmoffer && $tmfsales){
            $client_info=CompanySubjectInfo::init($tmoffer)->get();
            $arrContextOptions = array(
                "ssl" => array(
                    "verify_peer" => false,
                    "verify_peer_name" => false,
                ),
            );
            $signature_link = 'https://trademarkfactory.com/signatureall_new.php?id=' . $tmfsales->ID;
            $signature=file_get_contents(
                $signature_link,
                false,
                stream_context_create($arrContextOptions)
            );

            $message=$request->message.'<br/>'.$tmfsales->goodbye_text.'<br/>'.$tmfsales->FirstName.$signature;
            Mail::to([['email' => $request->email, 'name' => $client_info['firstname'].' '.$client_info['lastname']]])
                ->send(new PostReportEmailSent($tmfsales->Email,'Trademark Factory® | '.$tmfsales->FirstName.' '.$tmfsales->LastName,
                        $request->subj,
                        $message)
                );
            return 'Done';
        }
        return '';
    }

    public function loadBookingInfo(Request $request){
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
        $url=sprintf('https://trademarkfactory.com/mlcclients/get-google-params.php?tmf_booking_id=%d',
            $request->booking_id);
        $gparams=file_get_contents($url,false,stream_context_create($arrContextOptions));
        $tmf_booking=TmfBooking::find($request->booking_id);
        $tmoffer=Tmoffer::whereIn('ID',TmfClientTmsrTmoffer::select('tmoffer_id')
            ->where('id',$tmf_booking->tmf_client_tmsr_tmoffer_id)
        )
            ->first();
        $url=sprintf('https://trademarkfactory.com/mlcclients/get-offer.php?tmoffer_id=%d',$tmoffer->ID);
        $offer_id=file_get_contents($url,false,stream_context_create($arrContextOptions));
        $offer=Offer::find($offer_id);
        $offer_preview_url=sprintf('https://trademarkfactory.com/mlcclients/page-previewer.php?page=landing&id=%d&tmoffer=%d',
            $offer->offer_booking_page_landing_id,$tmoffer->ID);

        $how_find_out='';
        if(is_null($tmoffer->how_find_out_us)){
            if($tmoffer->affiliate_user_id){
                $affiliate=AffiliateUser::find($tmoffer->affiliate_user_id);
                $how_find_out=sprintf('Affiliate: %s %s',$affiliate->firstname,$affiliate->lastname);
            }
        }else
            $how_find_out=$tmoffer->how_find_out_us;
        $from_page=(new ClientIpFirstPage($tmoffer->client_ip))->get();
        return view('post-boom-bookings-calendar.booking-info',
            compact('gparams','how_find_out',
                'from_page','offer','offer_preview_url'));
    }
    public function confirmBookingLink(Request $request){
        $tmfsales=Auth::user();
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
        $tmoffer=Tmoffer::find($request->tmoffer_id);
        $url=sprintf('https://trademarkfactory.com/mlcclients/confirm-booking.php?code=%s',
            $tmoffer->ConfirmationCode);
        return file_get_contents($url,false,stream_context_create($arrContextOptions));
    }

    public function loadStat(Request $request){
        $from_date=\DateTime::createFromFormat('Y-m-d H:i:s',$request->date.' 00:00:00');
        $interval=\DateInterval::createFromDateString('1 week');
        $to_date=(clone $from_date)->add($interval);
        return Stat::closerBookings($from_date,$to_date)->get().
            '<br/><br/>'.
            Stat::groupCalls($from_date,$to_date)->get().
            '<br/>'.
            Stat::oeSouCalls($from_date,$to_date)->get();
    }

    private function loadActionsHistory($tmoffer_id){
        $tmoffer_actions_history_objs=TmofferActionsHistory::where('tmoffer_id',$tmoffer_id)
            ->orderBy('created_at','asc')
            ->get();
        return view('post-boom-bookings-calendar.tmoffer-actions-history',
            compact('tmoffer_actions_history_objs'));
    }

    public function loadEmails(Request $request){
        return $this->loadActionsHistory($request->tmoffer_id);
    }

    public function loadEmailsForTmoffer(Request $request){
        $tmoffer=Tmoffer::where('Login',$request->tmoffer_login)->first();
        $tmf_booking=TmfBooking::whereIn('tmf_client_tmsr_tmoffer_id',
            TmfClientTmsrTmoffer::select('id')->where('tmoffer_id',$tmoffer->ID))
            ->orderBy('id','desc')
            ->first();
        if($tmf_booking){
            $datetime=new \DateTime($tmf_booking->booked_date);
            return $this->showPage($datetime,['action'=>'load-emails','tmoffer_id'=>$tmoffer->ID]);
        }else
            echo 'wrong login!';
    }

    public function exportToCsv(Request $request){
        $where=[];
        if($request->from_date)
            $where[]=['booked_date','>=',$request->from_date.' 00:00:00'];
        if($request->to_date)
            $where[]=['booked_date','<=',$request->to_date.' 23:59:59'];
        if(count($where))
            $tmf_booking_objs=TmfBooking::where($where)
                ->where('sales_id',Auth::user()->ID)
//                ->where('sales_id',79)
                ->get();
        else
            $tmf_booking_objs=TmfBooking::where('sales_id',79)
                ->get();
        $data=[];
        $data[]=[
            'Client Name'=>'Client Name',
            'Email'=>'Email',
            'Phone'=>'Phone',
            'Shopping Cart Link'=>'Shopping Cart Link',
            'Call Report Notes'=>'Call Report Notes',
            'Booking Date'=>'Booking Date',
            'BOOM/NOBOOM Status'=>'BOOM/NOBOOM Status',
            'No-Show Status'=>'No-Show Status',
            'Follow-Up Scheduled Date'=>'Follow-Up Scheduled Date',
        ];
        foreach ($tmf_booking_objs as $tmf_booking_obj){
            if($this->isLastClosersBooking($tmf_booking_obj)){
                $tmoffer=Tmoffer::whereIn('ID',TmfClientTmsrTmoffer::select('tmoffer_id')->where('id',$tmf_booking_obj->tmf_client_tmsr_tmoffer_id))->first();
                if($tmoffer) {
                    $client_info = CompanySubjectInfo::init($tmoffer)->get();
                    $tmfsales_tmoffer_not_boom_reason=TmfsalesTmofferNotBoomReason::where('tmoffer_id',$tmoffer->ID)->first();
                    $data[]=[
                        'Client Name'=>$client_info['firstname'].' '.$client_info['lastname'],
                        'Email'=>$client_info['email'],
                        'Phone'=>$client_info['phone'],
                        'Shopping Cart Link'=>sprintf('https://trademarkfactory.com/shopping-cart/%s&donttrack=1',$tmoffer->Login),
                        'Call Report Notes'=>$tmoffer->Notes,
                        'Booking Date'=>$tmf_booking_obj->booked_date,
                        'BOOM/NOBOOM Status'=>($tmfsales_tmoffer_not_boom_reason?$tmfsales_tmoffer_not_boom_reason->notBoomReason->reason:''),
                        'No-Show Status'=>(($tmfsales_tmoffer_not_boom_reason && $tmfsales_tmoffer_not_boom_reason->not_boom_reason_id==79)?'No-Show':''),
                        'Follow-Up Scheduled Date'=>($tmoffer->closeable_notification_at?$tmoffer->closeable_notification_at:''),
                    ];

                }
            }
        }
//        dd($data);

/*
        $headers = [
            'Cache-Control'       => 'must-revalidate, post-check=0, pre-check=0'
            ,   'Content-type'        => 'text/csv'
            ,   'Content-Disposition' => 'attachment; filename=galleries.csv'
            ,   'Expires'             => '0'
            ,   'Pragma'              => 'public'
        ];
        $a=Storage::put('leads.csv', '');
        dd($data);
        $FH = fopen(Storage::path('leads.csv'), 'w');
        foreach ($data as $row) {
            fputcsv($FH, $row);
        }
        fclose($FH);


        return Storage::download('leads.csv');*/
        $headers = array(
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=leads.csv",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        );


        return response()->streamDownload(function() use ($data)
        {
            $file = fopen('php://output', 'w+');
            foreach ($data as $el) {
                fputcsv($file, $el);
            }
            fclose($file);
        }, '
        leads.csv',
            $headers);
    }

    private function isLastClosersBooking($tmf_booking_obj){
        $last_booking_obj=TmfBooking::where('tmf_client_tmsr_tmoffer_id',$tmf_booking_obj->tmf_client_tmsr_tmoffer_id)
            ->orderBy('id','desc')
            ->first();
        return $tmf_booking_obj->id==$last_booking_obj->id;
    }

    public function loadPqAnswersForTmoffer(Request $request){
        $tmoffer=Tmoffer::where('Login',$request->tmoffer_login)->first();
        return $this->showPage(Carbon::now(),['action'=>'load-pq-answers','tmoffer_id'=>$tmoffer->ID]);
    }

    public function pqAnswersForTmoffer(Request $request){
        $tmoffer=Tmoffer::find($request->tmoffer_id);
        $prequalify_request_obj=PrequalifyRequest::find($tmoffer->prequalify_request_id);
        if($prequalify_request_obj) {
            $data=$this->prepareAnswers($prequalify_request_obj);
            return view('post-boom-bookings-calendar.answers',
                compact('prequalify_request_obj','data'));
        }
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


}

