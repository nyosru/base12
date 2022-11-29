<?php
namespace App\classes\reportcall;


use App\TmfBooking;
use App\TmfClientTmsrTmoffer;
use App\Tmoffer;
use App\TmofferBin;

class BoomReportCallModal extends ReportCallModal
{

    protected function __construct(Tmoffer $tmoffer)
    {
        parent::__construct($tmoffer);
        $this->ajax_handler_url='/save-boom-report-call/'.$tmoffer->ID;
    }


    public function show()
    {
        $tmoffer_bin=TmofferBin::where('tmoffer_id',$this->tmoffer->ID)
            ->where('need_capture',0)
            ->first();
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

        return view('reportcallmodal.boom-report-call-modal',[
            'tmoffer'=>$this->tmoffer,
            'tmoffer_bin'=>$tmoffer_bin,
            'tmf_booking_id'=>$tmf_booking_id,
            'call_record_url'=>$call_record_url
        ]);
    }
}