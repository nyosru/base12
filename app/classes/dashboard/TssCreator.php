<?php

namespace App\classes\dashboard;


use App\DashboardTss;
use App\DashboardV2;
use App\QueueStatus;
use Carbon\Carbon;

class TssCreator
{
    private $tmfsales_id;
    private $dashboard_id;

    public function __construct($tmfsales_id, int $dashboard_id)
    {
        $this->tmfsales_id = $tmfsales_id;
        $this->dashboard_id=$dashboard_id;
    }

    /**
     * Save new dashboard tss with tss_text
     *
     * @param int cipostatus_status_formalized_id
     * @param int dashboard_global_status_id
     * @param string tss_text
     * @return DashboardTss
     */
    public function run(int $cipostatus_status_formalized_id, int $dashboard_global_status_id, string $tss_text)
    {
        $dashboard_tss = new DashboardTss();
        $dashboard_tss->dashboard_id = $this->dashboard_id;
        $dashboard_tss->cipostatus_status_formalized_id = $cipostatus_status_formalized_id;
        $dashboard_tss->dashboard_global_status_id = $dashboard_global_status_id;
        $dashboard_tss->description = $tss_text;
        $dashboard_tss->tmfsales_id = $this->tmfsales_id;
        $dashboard_tss->created_at = Carbon::now()->format('Y-m-d H:i:s');
        $dashboard_tss->save();

        $this->updateDashboardV2Statuses($cipostatus_status_formalized_id,$dashboard_global_status_id);

        return $dashboard_tss;
    }

    /**
     * Save new last formalized status and last global status in dashboard_v2
     *
     * @param int cipostatus_status_formalized_id
     * @param int dashboard_global_status_id
     * @return DashboardV2
     */
    private function updateDashboardV2Statuses(int $cipostatus_status_formalized_id, int $dashboard_global_status_id)
    {
        $dashboard=DashboardV2::find($this->dashboard_id);
        $dashboard->cipostatus_status_formalized_id=$cipostatus_status_formalized_id;
        $dashboard->dashboard_global_status_id=$dashboard_global_status_id;
        $dashboard->modified_at=Carbon::now()->format('Y-m-d H:i:s');
        $dashboard->save();
        return $dashboard;
    }


    /**
     * Save new dashboard tss with tss_text
     *
     * @param int $queue_status_id
     * @param string tss_text
     * @return DashboardTss
     */
    public function runWithQueueStatusId(int $queue_status_id, string $tss_text)
    {
        $queue_status = QueueStatus::find($queue_status_id);
        return $this->run(
            $queue_status->cipostatus_status_formalized_id,
            $queue_status->dashboard_global_status_id,
            $tss_text
        );
    }
}