<?php
/**
 * Created by PhpStorm.
 * User: vitaly
 * Date: 6/15/20
 * Time: 3:58 PM
 */

namespace App\classes\askstat;

use App\VisitorLog;

class AbandonedGrLp extends VisitorStat
{

    public function get($from_date, $to_date)
    {
        $objs=$this->initVisitorLogs($from_date,$to_date)->select('ip')->distinct()
            ->whereIn('page',$this->pages)
            ->get();
        $local_total=0;
//        $arr=[];
        foreach ($objs as $obj){
            $local_objs=$this->initVisitorLogs($from_date,$to_date)->select('ip')->distinct()
                ->whereRaw('length(from_page)>0')
                ->where('ip',$obj->ip)
                ->where('from_page','like','%/guaranteed-result%')
                ->whereNotIn('page',$this->pages);
            if(!$local_objs->count()) {
                $arr[]=$obj->ip;
                $local_total++;
            }
        }
        $percent=round(($local_total/$this->total)*100,2);
        return [$local_total,$percent];

    }
}