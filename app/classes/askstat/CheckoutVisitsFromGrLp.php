<?php
namespace App\classes\askstat;

use App\VisitorLog;

class CheckoutVisitsFromGrLp extends VisitorStat
{
    private $from_page;

    public function setFromPage($from_page){
        $this->from_page=$from_page;
        return $this;
    }

    public function get($from_date,$to_date)
    {
        $grlp_pages = [
            '/guaranteed-result.php',
        ];

        $checkout_pages = [
            '/apply-online.php',
        ];

        $objs = $this->initVisitorLogs($from_date, $to_date)
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
            ->whereIn('page', $checkout_pages)
            ->get();

        $local_total=$objs->count();
        if($this->total)
            $percent=round(($local_total/$this->total)*100,2);
        else
            $percent='N/A';

        return [$local_total,$percent];
    }
}