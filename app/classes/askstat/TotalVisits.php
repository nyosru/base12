<?php
namespace App\classes\askstat;

use App\VisitorLog;
use Illuminate\Support\Facades\DB;


class TotalVisits extends VisitorStat{

    public function get($from_date,$to_date)
    {

        $objs=$this->initVisitorLogs($from_date,$to_date)->select('ip')->distinct()
            ->get();

//        $data=VisitorLog::select('ip')->distinct()->get();
//        dd(str_replace_array('?', $objs->getBindings(), $objs->toSql()));
//        dd(DB::QueryLog());
        return [$objs->count(),0];
    }
}