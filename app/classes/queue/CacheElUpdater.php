<?php
namespace App\classes\queue;


use App\DashboardV2;
use App\QueueCache;
use App\QueueStatus;

class CacheElUpdater
{
    private $queue_status;
    private $dashboard;

    public function __construct(QueueStatus $queue_status,DashboardV2 $dashboard)
    {
        $this->queue_status=$queue_status;
        $this->dashboard=$dashboard;
    }

    public function run(){
        $queue_cache=QueueCache::where('dashboard_id',$this->dashboard->id)->first();
        if(!$queue_cache){
            $queue_cache=new QueueCache();
            $queue_cache->dashboard_id=$this->dashboard->id;
            $queue_cache->save();
        }

        $dashboard_data_details_obj=new DashboardDataDetails($this->dashboard);
        $ldd = $dashboard_data_details_obj->getDashboardData();
        $dashboard_data_details_obj->formattedResultFromDataEl($ldd,$this->queue_status);
    }
}