<?php
/**
 * Created by PhpStorm.
 * User: vitaly
 * Date: 6/24/20
 * Time: 3:15 PM
 */

namespace App\classes\askstat;

use App\VisitorLog;

class LpVisitsFromGuaranteeResultLp extends VisitorStat
{

    public function get($from_date, $to_date)
    {
        $objs=$this->initVisitorLogs($from_date,$to_date)->select('ip')->distinct()
            ->whereIn('page',$this->pages)
//            ->whereRaw('length(from_page)>0')
            ->get();

//        $this->checkIpInObjs($objs,$pages,$from_date,$to_date);

        $local_total=$objs->count();
        if($this->total)
            $percent=round(($local_total/$this->total)*100,2);
        else
            $percent='N/A';

        return [$local_total,$percent];

    }
}