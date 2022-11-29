<?php
/**
 * Created by PhpStorm.
 * User: vitaly
 * Date: 6/15/20
 * Time: 3:58 PM
 */

namespace App\classes\askstat;

use App\VisitorLog;

class AbandonedAsk extends VisitorStat
{

    public function get($from_date, $to_date)
    {
        if(count($this->from_pages)==0)
            $ask_pages=[
                '/advisors-g1.php',
                '/advisors-ig.php',
                '/advisors-youtube.php',
                '/advisors-fb2.php',
            ];
        else{
            $ask_pages=[];
            foreach ($this->from_pages as $from_page)
                switch ($from_page){
                    case '/advisors/youtube':
                        $ask_pages[]='/advisors-youtube.php';
                        break;
                    case '/advisors/ig':
                        $ask_pages[]='/advisors-ig.php';
                        break;
                    case '/advisors/g1':
                        $ask_pages[]='/advisors-g1.php';
                        break;
                    case '/advisors/fb':
                    case '/advisors/fb2':
                        $ask_pages[]='/advisors-fb2.php';
                        break;
                }
        }

        $objs=$this->initVisitorLogs($from_date,$to_date)->select('ip')->distinct()
            ->whereIn('page',$ask_pages)
            ->get();
        $local_total=0;
//        $arr=[];
        foreach ($objs as $obj){
            $local_objs=$this->initVisitorLogs($from_date,$to_date)->select('ip')->distinct()
                ->where('ip',$obj->ip)
                ->where(function ($query){
                    foreach ($this->from_pages as $index=>$ppp)
                        if($index)
                            $query=$query->orWhere('from_page','like','%'.$ppp.'%');
                        else
                            $query=$query->where('from_page','like','%'.$ppp.'%');
                })
                ->whereRaw('length(from_page)>0')
                ->whereNotIn('page',$ask_pages);
            if(!$local_objs->count()) {
                $arr[]=$obj->ip;
                $local_total++;
            }
        }
        $percent=round(($local_total/$this->total)*100,2);
        return [$local_total,$percent];

    }
}