<?php
namespace App\classes\askstat;

use App\VisitorLog;
use App\RedFlagsEbookRequest;

class SevenRedFlagsOptInsVisits extends VisitorStat
{

    public function get($from_date,$to_date)
    {
        $pages = [
            '/tmf-ebook.php',
        ];

        $objs = $this->initVisitorLogs($from_date, $to_date)->select('ip')->distinct()
            ->whereIn('ip',$this->initEbookRequests($from_date,$to_date)
                                ->whereNull('tmoffer_id')
                                ->whereNull('tmfsales_id')
                                ->select('ip')
                                ->distinct()
            )
            ->where(function ($query){
                foreach ($this->from_pages as $index=>$ppp)
                    if($index)
                        $query=$query->orWhere('from_page','like','%'.$ppp.'%');
                    else
                        $query=$query->where('from_page','like','%'.$ppp.'%');
            })
            ->whereRaw('length(from_page)>0')
            ->whereIn('page', $pages)
            ->get();

        $local_total=$objs->count();
        if($this->total)
            $percent=round(($local_total/$this->total)*100,2);
        else
            $percent='N/A';

        return [$local_total,$percent];
    }
}