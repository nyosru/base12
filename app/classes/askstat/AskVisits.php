<?php
namespace App\classes\askstat;

use App\VisitorLog;
use Illuminate\Support\Facades\DB;

class AskVisits extends VisitorStat{

    public function get($from_date,$to_date)
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

//        $data=VisitorLog::select('ip')->distinct()->get();
//        dd(str_replace_array('?', $objs->getBindings(), $objs->toSql()));
//        dd(DB::QueryLog());
        $local_total=$objs->count();
        $percent=round(($local_total/$this->total)*100,2);
        return [$local_total,$percent];
    }
}