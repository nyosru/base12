<?php

namespace App\classes\bookingstat;


use App\TmfBooking;
use App\TmfClientTmsrTmoffer;
use App\TmfsalesTmofferNotBoomReason;
use App\Tmoffer;
use App\TmofferBin;
use Carbon\Carbon;

class CloserBookingsStat extends Stat
{
    private function initResultArr(){
        return [
            'total'=>0,
            'ga'=>0,
            'fb'=>0,
            'yt'=>0
        ];
    }

    public function get()
    {
        $data=[
            'Total Closer Bookings'=>$this->initResultArr(),
            'BOOMs'=>$this->initResultArr(),
            'No-Shows'=>$this->initResultArr(),
            'Follow-Ups Scheduled'=>$this->initResultArr(),
            'Other No-BOOMs'=>$this->initResultArr(),
            'Missing No-BOOM reason'=>$this->initResultArr(),
            'Future bookings'=>$this->initResultArr(),
        ];
        foreach ($this->loadData() as $tmf_booking){
            $tmoffer=$this->getTmofferByTmfBooking($tmf_booking);

            $data['Total Closer Bookings']['total']++;
            $source_index=$this->getBookingSourceIndex($tmoffer);
            $details_index=$this->getDetailsIndex($tmoffer,$tmf_booking);
            if(strlen($source_index))
                $data['Total Closer Bookings'][$source_index]++;

            if($details_index){
                $data[$details_index]['total']++;
                if(strlen($source_index))
                    $data[$details_index][$source_index]++;
            }
        }

        return view('post-boom-bookings-calendar.stat.closerbookings',compact('data'));
    }

    private function getDetailsIndex(Tmoffer $tmoffer,TmfBooking $tmf_booking){
        if($tmf_booking->booked_date>=Carbon::now()->format('Y-m-d H:i:s'))
            return 'Future bookings';
        else{
            $tmoffer_bin=TmofferBin::where('tmoffer_id',$tmoffer->ID)
                ->where('need_capture',0)
                ->first();
            if($tmoffer->DateConfirmed=='0000-00-00' ||
                ($tmoffer->DateConfirmed!='0000-00-00' && !$tmoffer_bin)){//nobooms
                $tmfsales_tmoffer_not_boom_reason=TmfsalesTmofferNotBoomReason::where('tmoffer_id',$tmoffer->ID)
                    ->first();
                if($tmfsales_tmoffer_not_boom_reason){
                    switch ($tmfsales_tmoffer_not_boom_reason->not_boom_reason_id){
                        case 79: return 'No-Shows';
                        case 85: return 'Follow-Ups Scheduled';
                        default: return 'Other No-BOOMs';
                    }
                }else
                    return 'Missing No-BOOM reason';
            }else
                return 'BOOMs';
        }
        return '';
    }

    private function loadData(){
        $tmf_booking_objs=TmfBooking::where([
            ['booked_date','>=',$this->from_date->format('Y-m-d H:i:s')],
            ['booked_date','<=',$this->to_date->format('Y-m-d H:i:s')],
        ])->get();
        $bookings=[];
        foreach ($tmf_booking_objs as $tmf_booking_obj){
            if($this->isLastClosersBooking($tmf_booking_obj))
                $bookings[]=$tmf_booking_obj;
        }
        return $bookings;
    }

    private function isLastClosersBooking($tmf_booking_obj){
        $last_booking_obj=TmfBooking::where('tmf_client_tmsr_tmoffer_id',$tmf_booking_obj->tmf_client_tmsr_tmoffer_id)
            ->orderBy('id','desc')
            ->first();
        return $tmf_booking_obj->id==$last_booking_obj->id;
    }

    public function getBookingSourceIndex(Tmoffer $tmoffer){
        if(stripos($tmoffer->how_find_out_us,'youtube')!==false)
            return 'yt';
        elseif($tmoffer->how_find_out_us=='Direct-to-Booking Google Ad')
            return 'ga';
        elseif(strpos($tmoffer->how_find_out_us,'FB')!==false)
            return 'fb';
        return '';
    }

    private function getTmofferByTmfBooking(TmfBooking $tmf_booking){
        return Tmoffer::whereIn('ID',TmfClientTmsrTmoffer::select('tmoffer_id')
            ->where('id',$tmf_booking->tmf_client_tmsr_tmoffer_id)
        )
            ->first();
    }


}