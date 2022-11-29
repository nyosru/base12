<?php
namespace App\Modules\TMFXQ\Actions;

use App\QueueCache;

class QueueCacheManager
{
    /**
     * @return mixed
     */
    public function getRandomRow(){
        $queue_cache_obj=QueueCache::orderByRaw('rand()')->first();

//        $dashboard_id=$queue_cache_obj->dashboard_id;
//        $dashboard_id=15251;
//        $dashboard_id=15326;
//        $dashboard_id=15350;
//        $queue_cache_obj=QueueCache::where('dashboard_id',$dashboard_id)->first();
        return $queue_cache_obj;
    }

    /**
     * @param int $dashboard_id
     * @return string
     */
    public function getJsonByDashboardId(int $dashboard_id){
        $queue_cache_obj=QueueCache::where('dashboard_id',$dashboard_id)->first();
        if($queue_cache_obj)
            return $queue_cache_obj->json;
        else
            return '';
    }

    /**
     * @param QueueCache $queue_cache
     * @return string
     */
    public function getJson(QueueCache $queue_cache){
        return $queue_cache->json;
    }

    /**
     * @param QueueCache $queue_cache
     * @return int
     */
    public function getDashboardId(QueueCache $queue_cache){
        return $queue_cache->dashboard_id;
    }
}