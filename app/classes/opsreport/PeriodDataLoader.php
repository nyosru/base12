<?php
namespace App\classes\opsreport;


use App\DashboardTss;

abstract class PeriodDataLoader
{
//    protected $dashboard_objs;
    protected $dashboard_ids;
    protected $unfiltered_dashboard_ids=[];
    protected $countries;
    protected $from_date;
    protected $to_date;
    protected $cipostatus_status_formalized_ids;

    protected function __construct($from_date,$to_date,$countries,$cipostatus_status_formalized_ids,DashboardStatus $dashboard_status=null)
    {
        $this->from_date=$from_date;
        $this->to_date=$to_date;
        $this->cipostatus_status_formalized_ids=$cipostatus_status_formalized_ids;
        $this->countries=$countries;
        $this->dashboard_ids=array_unique($this->loadDashboardData($dashboard_status));

    }

    public static function statusPeriodData($from_date,$to_date,$countries,$cipostatus_status_formalized_ids){
        return new StatusPeriodDataLoader($from_date,$to_date,$countries,$cipostatus_status_formalized_ids);
    }

    public static function stillStatusPeriodData($from_date,$to_date,$countries,$cipostatus_status_formalized_ids){
        return new StillStatusPeriodDataLoader($from_date,$to_date,$countries,$cipostatus_status_formalized_ids);
    }
    public static function noLongerStatusPeriodData($from_date,$to_date,$countries,$cipostatus_status_formalized_ids){
        return new NoLongerStatusPeriodDataLoader($from_date,$to_date,$countries,$cipostatus_status_formalized_ids);
    }

    public static function noLongerSinceStatusPeriodData($from_date,$to_date,$countries,$cipostatus_status_formalized_ids,DashboardStatus $dashboard_status=null){
        return new NoLongerSinceStatusPeriodDataLoader($from_date,$to_date,$countries,$cipostatus_status_formalized_ids,$dashboard_status);
    }

    abstract protected function loadDashboardData(DashboardStatus $dashboard_status=null);

    public function getNum(){
//        return count($this->dashboard_ids);
        return count(array_unique($this->unfiltered_dashboard_ids));
    }

    public function getDashboardIds(){
        return $this->dashboard_ids;
    }

    public function getUnfilteredDashboardIds(){
        return array_unique($this->unfiltered_dashboard_ids);
    }

    protected function idsFromDashboardObjs($dashboard_objs){
        $data=[];
        foreach ($dashboard_objs as $el)
            $data[]=$el->id;
        return $data;
    }
}