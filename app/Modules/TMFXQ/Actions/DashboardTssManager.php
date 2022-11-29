<?php
namespace App\Modules\TMFXQ\Actions;

use App\DashboardTss;
use App\Modules\TMFXQ\Managers\DashboardTssQueryManager;

class DashboardTssManager
{
    /**
     * @param int $dashboard_id
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function getLastDashboardTss(int $dashboard_id){
        $filter=['dashboard_id'=>$dashboard_id];
        $sort=['id'=>'desc'];
        return (new DashboardTssQueryManager([], $filter, $sort))->build()->first();
    }

    /**
     * @param DashboardTss $dashboard_tss
     * @return string
     */
    public function getFilteredTssDescription(DashboardTss $dashboard_tss){
        return $this->filterTssDescription($dashboard_tss->description);
    }

    /**
     * @param string $tss_description
     * @return string
     */
    private function filterTssDescription(string $tss_description){
        $arr = explode('<div class="tsw"',$tss_description);
        return str_replace('%%%tmf-satisfaction-widget%%%','',$arr[0]);
    }

    public function getTssId(DashboardTss $dashboard_tss){
        return $dashboard_tss->id;
    }

}