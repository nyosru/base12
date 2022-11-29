<?php

namespace App\classes\queue;


use App\DashboardTss;
use App\TmfFilingQueueStatus;
use Carbon\Carbon;

class FilingQueueTmHistory extends  QueueTmHistory
{
    /**
     * Calculates filing queue status by dashboard_tss row
     *
     * @param DashboardTss $dashboard_tss
     * @return mixed
     */
    protected function getQueueStatus(DashboardTss $dashboard_tss)
    {
        if($dashboard_tss->dashboard_global_status_id==1){
            $obj=TmfFilingQueueStatus::where('dashboard_global_status_id',$dashboard_tss->dashboard_global_status_id)
                ->where('cipostatus_status_formalized_id',$dashboard_tss->cipostatus_status_formalized_id)
                ->first();
        }else
            $obj=TmfFilingQueueStatus::where('dashboard_global_status_id',$dashboard_tss->dashboard_global_status_id)
                ->first();

        return $obj;
    }
}