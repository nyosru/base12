<?php
namespace App\classes\opsreport;


use App\DashboardTss;
use App\DashboardV2;
use App\TmfCountryTrademark;

class StatusPeriodDataLoader extends PeriodDataLoader
{

    protected function loadDashboardData(DashboardStatus $dashboard_status=null)
    {
        if(in_array(375,$this->cipostatus_status_formalized_ids)){
            $local_dashboard_objs=DashboardV2::whereIn('cipostatus_status_formalized_id',$this->cipostatus_status_formalized_ids)
                ->where([
                    ['created_at','>=',$this->from_date->format('Y-m-d H:i:s')],
                    ['created_at','<=',$this->to_date->format('Y-m-d H:i:s')],
                ])
                ->whereIn('tmf_country_trademark_id',TmfCountryTrademark::select('id')->whereIn('tmf_country_id',$this->countries))
                ->get();
        }else
            $local_dashboard_objs=DashboardV2::whereIn('cipostatus_status_formalized_id',$this->cipostatus_status_formalized_ids)
                ->where([
                    ['formalized_status_modified_at','>=',$this->from_date->format('Y-m-d H:i:s')],
                    ['formalized_status_modified_at','<=',$this->to_date->format('Y-m-d H:i:s')],
                ])
                ->whereIn('tmf_country_trademark_id',TmfCountryTrademark::select('id')->whereIn('tmf_country_id',$this->countries))
                ->get();

        $ids=[];
        foreach ($local_dashboard_objs as $local_dashboard_obj) {
            if($local_dashboard_obj->dashboard_in_timings_type_id==1)
                $ids[] = $local_dashboard_obj->id;
            $this->unfiltered_dashboard_ids[]=$local_dashboard_obj->id;
        }

        $dasboard_ids=DashboardTss::select('dashboard_id')
            ->distinct()
            ->whereNotIn('dashboard_id',$ids)
            ->whereIn('dashboard_id',DashboardV2::select('id')->whereIn('tmf_country_trademark_id',TmfCountryTrademark::select('id')->whereIn('tmf_country_id',$this->countries)))
            ->whereIn('cipostatus_status_formalized_id',$this->cipostatus_status_formalized_ids)
            ->where([
                ['created_at','>=',$this->from_date->format('Y-m-d H:i:s')],
                ['created_at','<=',$this->to_date->format('Y-m-d H:i:s')],
            ])->get();

        foreach ($dasboard_ids as $el) {
            $dashboard_obj=DashboardV2::find($el->dashboard_id);
            if($dashboard_obj->dashboard_in_timings_type_id==1)
                $ids[] = $el->dashboard_id;
            $this->unfiltered_dashboard_ids[]=$el->dashboard_id;
        }
        return $ids;
    }
}