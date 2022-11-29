<?php
namespace App\classes\dashboard\closers;

use App\classes\tmoffer\CompanySubjectInfo;
use App\TmfBooking;
use App\TmfClientTmsrTmoffer;
use App\Tmfsales;
use App\Tmoffer;
use Carbon\Carbon;

class UpcomingBookingCalls
{

    private $tmfsales;

    public function __construct(Tmfsales $tmfsales)
    {
        $this->tmfsales=$tmfsales;
    }

    private function isLastClosersBooking($tmf_booking_obj){
        $last_booking_obj=TmfBooking::where('tmf_client_tmsr_tmoffer_id',$tmf_booking_obj->tmf_client_tmsr_tmoffer_id)
            ->orderBy('id','desc')
            ->first();
        return $tmf_booking_obj->id==$last_booking_obj->id;
    }

    private function loadClosersBookings($from_date,$to_date,$limit){
        if($limit)
            $tmf_booking_objs=TmfBooking::where([
                ['booked_date','>=',$from_date->format('Y-m-d H:i:s')],
                ['booked_date','<=',$to_date->format('Y-m-d H:i:s')],
            ])
                ->where('sales_id',$this->tmfsales->ID)
                ->orderBy('booked_date','asc')
                ->limit($limit)
                ->get();
        else
            $tmf_booking_objs=TmfBooking::where([
                ['booked_date','>=',$from_date->format('Y-m-d H:i:s')],
                ['booked_date','<=',$to_date->format('Y-m-d H:i:s')],
            ])
                ->where('sales_id',$this->tmfsales->ID)
                ->orderBy('booked_date','asc')
                ->get();
        $result=[];
        foreach ($tmf_booking_objs as $tmf_booking_obj){
            if($this->isLastClosersBooking($tmf_booking_obj))
                $result[]=$tmf_booking_obj;
        }
        return $result;
    }


    public function getData($limit=5){
        $today=Carbon::now();
        $from=clone $today;
        $interval=\DateInterval::createFromDateString('2 months');
        $today->add($interval);
        $to=(clone $today);
        $bookings = $this->loadClosersBookings($from,$to,$limit);
        $result=[];
        foreach ($bookings as $booking){
            $tmoffer=Tmoffer::whereIn('ID',TmfClientTmsrTmoffer::select('tmoffer_id')
                ->where('id',$booking->tmf_client_tmsr_tmoffer_id)
            )->first();
            $result[]=[
                'company_info'=>CompanySubjectInfo::init($tmoffer)->get(),
                'tmoffer_id'=>$tmoffer->ID,
                'tmoffer_login'=>$tmoffer->Login,
                'booking_datetime'=>\DateTime::createFromFormat('Y-m-d H:i:s',$booking->booked_date)->format('M j, Y \@ g:ia')
            ];
        }
        return $result;
    }
}