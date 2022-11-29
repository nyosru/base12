<?php
namespace App\classes\askstat;

use App\VisitorLog;

class GuaranteedResultLpVisits extends VisitorStat
{

    public function get($from_date,$to_date)
    {
        $pages=[
            '/secure-it-now.php',
            '/guaranteed-result.php',
        ];

        $objs=$this->initVisitorLogs($from_date,$to_date)->select('ip')->distinct()
            ->whereIn('page',$pages)
            ->whereRaw('length(from_page)>0')
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