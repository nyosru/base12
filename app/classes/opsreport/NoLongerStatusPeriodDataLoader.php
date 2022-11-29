<?php
namespace App\classes\opsreport;


use App\DashboardTss;
use App\DashboardV2;
use App\TmfCountryTrademark;

class NoLongerStatusPeriodDataLoader extends StatusPeriodDataLoader
{
    protected function loadDashboardData(DashboardStatus $dashboard_status=null)
    {

        parent::loadDashboardData($dashboard_status);
        $data=[];
        $dashboard_ids=$this->unfiltered_dashboard_ids;
//        var_dump($dashboard_ids);echo '<br/><br/>';
        $this->unfiltered_dashboard_ids=[];
        foreach ($dashboard_ids as $dashboard_id) {
            $dashboard_obj=DashboardV2::find($dashboard_id);
            if(
                !in_array($dashboard_obj->cipostatus_status_formalized_id,$this->cipostatus_status_formalized_ids) ||
                $dashboard_obj->dashboard_global_status_id!=1
            ) {
                if($dashboard_obj->dashboard_in_timings_type_id==1)
                    $data[] = $dashboard_obj->id;
                $this->unfiltered_dashboard_ids[]=$dashboard_id;
            }
        }
        return $data;
    }
}