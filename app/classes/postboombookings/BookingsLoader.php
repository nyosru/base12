<?php
namespace App\classes\postboombookings;


use App\GroupMeeting;
use App\OeBookingCall;
use App\TmfBooking;

class BookingsLoader
{
    private $from_date;
    private $to_date;
    private $bookings;

    public function __construct(\DateTime $from_date,\DateTime $to_date)
    {
        $this->from_date=$from_date;
        $this->to_date=$to_date;
        $this->bookings=[];
    }

    public function run(){
        $this->loadClosersBookings();
        $this->loadGmBookings();
        $this->loadOeSouBookings();
        return $this;
    }

    public function getBookings(){
        return $this->bookings;
    }

    private function loadClosersBookings(){
        $tmf_booking_objs=TmfBooking::where([
            ['booked_date','>=',$this->from_date->format('Y-m-d H:i:s')],
            ['booked_date','<=',$this->to_date->format('Y-m-d H:i:s')],
        ])->get();
        foreach ($tmf_booking_objs as $tmf_booking_obj){
            if($this->isLastClosersBooking($tmf_booking_obj))
                $this->bookings[]=Booking::closersBooking($tmf_booking_obj);
        }
    }

    private function isLastClosersBooking($tmf_booking_obj){
        $last_booking_obj=TmfBooking::where('tmf_client_tmsr_tmoffer_id',$tmf_booking_obj->tmf_client_tmsr_tmoffer_id)
            ->orderBy('id','desc')
            ->first();
        return $tmf_booking_obj->id==$last_booking_obj->id;
    }

    private function loadGmBookings(){
        $group_meeting_objs=GroupMeeting::where([
            ['meeting_at','>=',$this->from_date->format('Y-m-d H:i:s')],
            ['meeting_at','<=',$this->to_date->format('Y-m-d H:i:s')],
        ])
            ->where('tmoffer_id',0)
            ->whereNull('cancelled_at')
            ->get();
        foreach ($group_meeting_objs as $group_meeting_obj)
            $this->bookings[]=Booking::gmBooking($group_meeting_obj);
    }

    private function loadOeSouBookings(){
        $group_meeting_objs=GroupMeeting::where([
            ['meeting_at','>=',$this->from_date->format('Y-m-d H:i:s')],
            ['meeting_at','<=',$this->to_date->format('Y-m-d H:i:s')],
        ])
            ->where('tmoffer_id','>',0)
            ->whereNull('cancelled_at')
            ->get();

        foreach ($group_meeting_objs as $gc_meeting)
            $this->bookings[]=Booking::oeSouBooking(GcOeBooking::initGcBooking($gc_meeting));

        $oe_booking_call_objs=OeBookingCall::where([
            ['datetime_pst','>=',$this->from_date->format('Y-m-d H:i:s')],
            ['datetime_pst','<=',$this->to_date->format('Y-m-d H:i:s')],
        ])
            ->whereNull('cancelled_at')
            ->get();

        foreach ($oe_booking_call_objs as $oe_booking_call_obj)
            $this->bookings[]=Booking::oeSouBooking(GcOeBooking::initOeBooking($oe_booking_call_obj));
    }
}