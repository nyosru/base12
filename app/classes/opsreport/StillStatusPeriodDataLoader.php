<?php
namespace App\classes\opsreport;


use App\DashboardV2;
use App\TmfCountryTrademark;

class StillStatusPeriodDataLoader extends StatusPeriodDataLoader
{
    protected function loadDashboardData(DashboardStatus $dashboard_status=null)
    {
        parent::loadDashboardData($dashboard_status);
        $local_dashboard_objs=DashboardV2::whereIn('cipostatus_status_formalized_id',$this->cipostatus_status_formalized_ids)
            ->whereIn('id',$this->unfiltered_dashboard_ids)
            ->whereIn('tmf_country_trademark_id',TmfCountryTrademark::select('id')->whereIn('tmf_country_id',$this->countries))
            ->where('dashboard_global_status_id',1)
            ->where(function ($query){
                $query->where([
                    ['formalized_status_modified_at','>=',$this->from_date->format('Y-m-d H:i:s')],
                    ['formalized_status_modified_at','<=',$this->to_date->format('Y-m-d H:i:s')],
                ])
                    ->orWhere('formalized_status_modified_at','=','0000-00-00 00:00:00');
            })
            ->get();
        $ids=[];
        $this->unfiltered_dashboard_ids=[];
        foreach ($local_dashboard_objs as $local_dashboard_obj){
            if($local_dashboard_obj->dashboard_in_timings_type_id==1)
                $ids[] = $local_dashboard_obj->id;
            $this->unfiltered_dashboard_ids[]=$local_dashboard_obj->id;
        }
        return $ids;
//        exit;
//        return $this->idsFromDashboardObjs($local_dashboard_objs);
    }

}