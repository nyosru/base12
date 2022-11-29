<?php

namespace App\classes\bookingstat;


use App\GroupMeeting;
use App\OeBookingCall;
use App\TmofferTmfCountryTrademark;

class OeSouBookingsStat extends Stat
{
    private $oe_bookings=[];
    private $sou_bookings=[];

    public function get()
    {
        $objs=GroupMeeting::where([
            ['meeting_at','>=',$this->from_date->format('Y-m-d H:i:s')],
            ['meeting_at','<=',$this->to_date->format('Y-m-d H:i:s')],
        ])
            ->where('tmoffer_id','>',0)
            ->whereNull('cancelled_at')
            ->get();

        foreach ($objs as $obj){
            $tmoffer_tmf_country_trademark=TmofferTmfCountryTrademark::where('tmoffer_id',$obj->tmoffer_id)
                ->whereNotNull('sou_sent_at')
                ->where('sou_sent_at','<=',$obj->meeting_at)
                ->orderBy('id','asc')
                ->first();
            if($tmoffer_tmf_country_trademark)
                $this->sou_bookings[]=$obj;
            else
                $this->oe_bookings[]=$obj;
        }

        $oe_booking_call_objs=OeBookingCall::where([
            ['datetime_pst','>=',$this->from_date->format('Y-m-d H:i:s')],
            ['datetime_pst','<=',$this->to_date->format('Y-m-d H:i:s')],
        ])
            ->whereNull('cancelled_at');

        return sprintf('OE Calls: %d<br/>SOU Calls: %d',
            count($this->oe_bookings)+$oe_booking_call_objs->count(),
                count($this->sou_bookings)
            );

    }


}