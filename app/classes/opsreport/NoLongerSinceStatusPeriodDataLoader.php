<?php

namespace App\classes\opsreport;


use App\DashboardTss;
use App\DashboardV2;
use App\TmfCountryTrademark;

class NoLongerSinceStatusPeriodDataLoader extends PeriodDataLoader
{
    protected function loadDashboardData(DashboardStatus $dashboard_status = null)
    {
        if (is_null($dashboard_status)) {
            $dashboard_ids = DashboardTss::select('dashboard_id')
                ->distinct()
                ->where([
                    ['created_at', '>=', $this->from_date->format('Y-m-d H:i:s')],
                    ['created_at', '<=', $this->to_date->format('Y-m-d H:i:s')],
                ])
                ->whereIn('dashboard_id', DashboardV2::select('id')->whereIn('tmf_country_trademark_id', TmfCountryTrademark::select('id')->whereIn('tmf_country_id', $this->countries)))
                ->get();
        } else {
            $dashboard_ids = DashboardTss::select('dashboard_id')
                ->distinct()
                ->where([
                    ['created_at', '>=', $this->from_date->format('Y-m-d H:i:s')],
                    ['created_at', '<=', $this->to_date->format('Y-m-d H:i:s')],
                ])
                ->whereIn('dashboard_id', DashboardV2::select('id')->whereIn('tmf_country_trademark_id', TmfCountryTrademark::select('id')->whereIn('tmf_country_id', $this->countries)));
            if (count($dashboard_status->cipostatus_status_formalized_ids))
                $dashboard_ids->whereIn('cipostatus_status_formalized_id', $dashboard_status->cipostatus_status_formalized_ids);
            if (count($dashboard_status->dashboard_global_status_ids)) {
                $dashboard_ids->whereIn('dashboard_global_status_id', $dashboard_status->dashboard_global_status_ids);
//                exit;
            }
            $dashboard_ids = $dashboard_ids->get();
        }

        $ids=[];
        foreach ($dashboard_ids as $dashboard_el) {
            $flag=1;
            if (!is_null($dashboard_status)) {
                $last_tss=$this->dashboardLastStatus($dashboard_el->dashboard_id);
                if (count($dashboard_status->cipostatus_status_formalized_ids))
                    if(!in_array($last_tss->cipostatus_status_formalized_id,$dashboard_status->cipostatus_status_formalized_ids))
                        $flag=0;

                if (count($dashboard_status->dashboard_global_status_ids))
                    if(!in_array($last_tss->dashboard_global_status_id,$dashboard_status->dashboard_global_status_ids))
                        $flag=0;
            }

            if ($flag && $this->statusChangedInPeriod($dashboard_el->dashboard_id)) {
                $dashboard_obj=DashboardV2::find($dashboard_el->dashboard_id);
                if($dashboard_obj->dashboard_in_timings_type_id==1)
                    $ids[] = $dashboard_el->dashboard_id;
                $this->unfiltered_dashboard_ids[] = $dashboard_el->dashboard_id;
            }
        }

//        echo implode(',',$ddd);exit;
        return $ids;
    }

    private function dashboardTssObjsHadStatus($dashboard_id)
    {
        return DashboardTss::where('dashboard_id', $dashboard_id)
            ->whereIn('cipostatus_status_formalized_id', $this->cipostatus_status_formalized_ids)
            ->where('dashboard_global_status_id', 1)
            ->get();
    }

    private function dashboardLastStatus($dashboard_id)
    {
        return DashboardTss::where('dashboard_id', $dashboard_id)
            ->orderBy('id', 'desc')
            ->first();
    }

    private function statusChangedInPeriod($dashboard_id)
    {
        $dasboard_tss_objs = $this->dashboardTssObjsHadStatus($dashboard_id);


        foreach ($dasboard_tss_objs as $dasboard_tss_obj) {
            $obj = DashboardTss::where('dashboard_id', $dashboard_id)
                ->where('id', '>', $dasboard_tss_obj->id)
                ->orderBy('id')
                ->first();
            if ($obj &&
                ($obj->created_at >= $this->from_date->format('Y-m-d H:i:s') && $obj->created_at <= $this->to_date->format('Y-m-d H:i:s'))
            )
                return true;
        }
        return false;
    }

}