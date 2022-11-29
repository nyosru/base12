<?php
namespace App\classes\reportcall;


use App\Tmoffer;
use App\TmofferBin;

abstract class ReportCallModal
{
    protected $tmoffer;
    protected $ajax_handler_url;

    protected function __construct(Tmoffer $tmoffer)
    {
        $this->tmoffer=$tmoffer;
    }

    public static function init(Tmoffer $tmoffer){
        $tmoffer_bin=TmofferBin::where('tmoffer_id',$tmoffer->ID)
            ->where('need_capture',0)
            ->first();
        if($tmoffer_bin)
            return new BoomReportCallModal($tmoffer);
        else
            return new NoBoomReportCallModal($tmoffer);
    }

    abstract public function show();
}