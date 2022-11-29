<?php
namespace App\classes\askstat;
use App\VisitorLog;
use App\RedFlagsEbookRequest;
use App\RedFlagsEbookRequestLog;

abstract class VisitorStat
{
    protected $total;
    protected $pages;
    protected $from_pages=[];

    public function setPages($pages){
        $this->pages=$pages;
        return $this;
    }

    public function setFromPages($pages){
        $this->from_pages=$pages;
        return $this;
    }


    private function __construct($total)
    {
        $this->total=$total;
    }

    public static function init($classname,$total){
        return new $classname($total);
    }

    protected function initVisitorLogs($from_date,$to_date){
        if ($from_date && $to_date)
            $objs = VisitorLog::whereBetween('created_at', [$from_date . ' 00:00:00', $to_date . ' 23:59:59']);
        elseif ($from_date)
            $objs = VisitorLog::where('created_at', '>=', $from_date . ' 00:00:00');
        elseif ($to_date)
            $objs = VisitorLog::where('created_at', '<=', $to_date . ' 23:59:59');

        return $objs;
    }

    protected function initEbookRequests($from_date,$to_date){
        if ($from_date && $to_date)
            $objs = RedFlagsEbookRequest::whereBetween('created_at', [$from_date . ' 00:00:00', $to_date . ' 23:59:59']);
        elseif ($from_date)
            $objs = RedFlagsEbookRequest::where('created_at', '>=', $from_date . ' 00:00:00');
        elseif ($to_date)
            $objs = RedFlagsEbookRequest::where('created_at', '<=', $to_date . ' 23:59:59');

        return $objs;
    }

    protected function initEbookRequestsLog($from_date,$to_date){
        if ($from_date && $to_date)
            $objs = RedFlagsEbookRequestLog::whereBetween('created_at', [$from_date . ' 00:00:00', $to_date . ' 23:59:59']);
        elseif ($from_date)
            $objs = RedFlagsEbookRequestLog::where('created_at', '>=', $from_date . ' 00:00:00');
        elseif ($to_date)
            $objs = RedFlagsEbookRequestLog::where('created_at', '<=', $to_date . ' 23:59:59');

        return $objs;
    }

    protected function checkIpInObjs($objs,$pages,$from_date,$to_date){
        foreach ($objs as $obj){
            $local_objs=$this->initVisitorLogs($from_date,$to_date)->select('ip')->distinct()
                ->whereNotIn('page',$pages)
                ->where('ip',$obj->ip)
                ->get();
            if($local_objs->count()<1) {
                echo "ip:{$obj->ip}<br/>";
//                $arr[]=$obj->ip;
//                $local_total++;
            }
        }

    }

    abstract public function get($from_date,$to_date);
}