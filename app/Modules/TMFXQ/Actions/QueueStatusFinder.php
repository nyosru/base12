<?php
namespace App\Modules\TMFXQ\Actions;

use App\Modules\TMFXQ\Managers\QueueStatusQueryManager;

class QueueStatusFinder
{
    /**
     * @param int $cipostatus_status_formalized_id
     * @param int $dashboard_global_status_id
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|null|object
     */
    public function run(int $cipostatus_status_formalized_id, int $dashboard_global_status_id){
        $filters=[
            'cipostatus_status_formalized_id'=>$cipostatus_status_formalized_id,
            'dashboard_global_status_id'=>$dashboard_global_status_id
        ];

        $sort=['type'=>'desc'];

        $queue_status_query_manager=new QueueStatusQueryManager([],$filters,$sort);

        return $queue_status_query_manager->build()->first();
    }
}