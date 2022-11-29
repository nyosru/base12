<?php

namespace App\classes\reportcall;


use App\TmfBooking;
use App\TmfClientTmsrTmoffer;
use App\TmfsalesTmofferNotBoomReason;
use App\Tmoffer;

class NoBoomReportCallModal extends ReportCallModal
{
    protected function __construct(Tmoffer $tmoffer)
    {
        parent::__construct($tmoffer);
        $this->ajax_handler_url='/save-noboom-report-call/'.$tmoffer->ID;
    }

    public function show()
    {
        $tmf_booking = TmfBooking::whereIn('tmf_client_tmsr_tmoffer_id',
            TmfClientTmsrTmoffer::select('id')
                ->where('tmoffer_id', $this->tmoffer->ID)
        )->orderBy('id', 'desc')
            ->first();
        $tmf_booking_id=0;
        $call_record_url='';
        if ($tmf_booking) {
            $tmf_booking_id=$tmf_booking->id;
            $call_record_url = $tmf_booking->call_record_url;
        }
        $tmfsales_tmoffer_not_boom_reason = TmfsalesTmofferNotBoomReason::where('tmoffer_id', $this->tmoffer->ID)->first();
        $not_boom_reason_text='';
        $not_boom_reason_id=0;
        if($tmfsales_tmoffer_not_boom_reason) {
            $not_boom_reason_text = $tmfsales_tmoffer_not_boom_reason->not_boom_reason_text;
            $not_boom_reason_id=$tmfsales_tmoffer_not_boom_reason->not_boom_reason_id;
        }

        $today=new \DateTime();
        if($this->tmoffer->closeable_notification_at) {
            $reminder_date_text = (new \DateTime($this->tmoffer->closeable_notification_at))->format('F j, Y');
            $reminder_date=$this->tmoffer->closeable_notification_at;
        }else{
            $interval=\DateInterval::createFromDateString('7 days');
            $today->add($interval);
            $reminder_date_text=$today->format('F j, Y');
            $reminder_date=$today->format('Y-m-d');
        }

        return view('reportcallmodal.noboom-report-call-modal',[
            'tmoffer'=>$this->tmoffer,
            'tmf_booking_id'=>$tmf_booking_id,
            'call_record_url'=>$call_record_url,
            'not_boom_reason_text'=>$not_boom_reason_text,
            'reminder_date_text'=>$reminder_date_text,
            'not_boom_reason_id'=>$not_boom_reason_id,
            'reminder_date'=>$reminder_date
        ]);

    }
}