<?php

namespace App\Modules\TMFXQ\Actions;


use App\Modules\TMFXQ\Managers\QueueStatusChangeLogQueryManager;
use App\Modules\TMFXQ\Managers\QueueStatusChangeLogStatManager;
use App\Modules\TMFXQ\Models\QueueStatusChangeLog;
use Carbon\Carbon;

class QueueRandomCheckerAllTimeLeader
{
    /**
     * @return array|int
     */
    public function run(){
        $queue_status_change_log_stat_manager=new QueueStatusChangeLogStatManager();
        return $queue_status_change_log_stat_manager->getAllTimeLeader();
    }
}