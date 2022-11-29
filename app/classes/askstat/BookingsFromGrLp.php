<?php
namespace App\classes\askstat;

use App\VisitorLog;
use App\Tmoffer;
use App\TmfBooking;
use App\TmfClientTmsrTmoffer;

class BookingsFromGrLp extends VisitorStat
{

    private $from_page;

    public function setFromPage($from_page){
        $this->from_page=$from_page;
        return $this;
    }

    public function get($from_date,$to_date)
    {
//        echo $from_date;exit;
        $grlp_pages = [
            '/guaranteed-result.php',
        ];

        if ($from_date && $to_date)
            $objs = Tmoffer::whereBetween('created_date', [$from_date . ' 00:00:00', $to_date . ' 23:59:59']);
        elseif ($from_date)
            $objs = Tmoffer::where('created_date', '>=', $from_date . ' 00:00:00');
        elseif ($to_date)
            $objs = Tmoffer::where('created_date', '<=', $to_date . ' 23:59:59');


        $objs = $objs->whereIn('client_ip',$this->initVisitorLogs($from_date, $to_date)
            ->select('ip')
            ->distinct()
            ->whereIn('ip',$this->initVisitorLogs($from_date, $to_date)
                ->select('ip')
                ->distinct()
                ->whereIn('ip',$this->initVisitorLogs($from_date, $to_date)
                    ->select('ip')
                    ->distinct()
                    ->whereRaw('length(from_page)>0')
                    ->whereIn('page', $grlp_pages)
                )
                ->whereRaw('length(from_page)>0')
                ->whereIn('page', $this->pages)
            )
            ->where('from_page','like','%'.$this->from_page.'%')
            ->where('page', '/consultationcallbooked.php')
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
                    ) {
                        $local_total++;
                        echo $obj->ID.',';
                    }
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
                ->where('from_page','like','%'.$this->from_page.'%')
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