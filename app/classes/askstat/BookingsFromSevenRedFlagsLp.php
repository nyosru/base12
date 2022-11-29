<?php
namespace App\classes\askstat;

use App\VisitorLog;
use App\Tmoffer;
use App\TmfBooking;
use App\TmfClientTmsrTmoffer;

class BookingsFromSevenRedFlagsLp extends VisitorStat
{

    public function get($from_date,$to_date)
    {
        $ebook_pages = [
            '/tmf-ebook.php',
        ];

        $pages = [
            '/protect-it-now.php',
        ];

        $objs = Tmoffer::whereIn('client_ip',$this->initVisitorLogs($from_date, $to_date)
            ->select('ip')
            ->distinct()
            ->whereIn('ip',$this->initVisitorLogs($from_date, $to_date)
                ->select('ip')
                ->distinct()
                ->whereIn('ip',$this->initEbookRequests($from_date,$to_date)
                    ->select('ip')
                    ->distinct()
                    ->whereIn('ip',$this->initEbookRequestsLog($from_date,$to_date)
                        ->select('ip')
                        ->distinct()
                    )
                )
                ->whereRaw('length(from_page)>0')
                ->whereIn('page', $ebook_pages)
            )
            ->whereRaw('length(from_page)>0')
            ->whereIn('page', $pages)
        )->get();

        $local_total=0;
        if($objs->count())
            foreach ($objs as $obj){
                $tmf_booking=$this->getTmofferBooking($obj->ID);
                $first_checkout=$this->getFirstCheckoutVisit($from_date,$to_date,$obj->ip);
                if($tmf_booking)
                    if(
                    ($first_checkout &&
                        $first_checkout->created_at>$tmf_booking->created_at) ||
                        !$first_checkout
                    )
                        $local_total++;
            }
//        $local_total=$objs->count();
        if($this->total)
            $percent=round(($local_total/$this->total)*100,2);
        else
            $percent='N/A';

        return [$local_total,$percent];
    }

    private function getFirstCheckoutVisit($from_date, $to_date,$ip){
        return $this->initVisitorLogs($from_date, $to_date)
                ->where('page','/apply-online.php')
                ->where('ip',$ip)
                ->where('from_page','like','%protect-it-now?code=%')
                ->orderBy('created_at')
                ->first();
    }

    private function getTmofferBooking($tmoffer_id){
        return TmfBooking::whereIn('tmf_client_tmsr_tmoffer_id',
                TmfClientTmsrTmoffer::where('tmoffer_id',$tmoffer_id)->get()
            )
            ->orderBy('created_at')
            ->first();
    }
}