<?php

namespace App\Modules\TMFXQ\Actions;


use App\Modules\TMFXQ\Managers\QueueStatusChangeLogQueryManager;
use App\Modules\TMFXQ\Managers\QueueStatusChangeLogStatManager;
use App\Modules\TMFXQ\Models\QueueStatusChangeLog;
use Carbon\Carbon;

class QueueRandomCheckerDayLeader
{
    private $date;

    /**
     * QueueRandomCheckedDayLeader constructor.
     * @param Carbon $date
     */
    public function __construct(Carbon $date)
    {
        $this->date=$date;
    }

    /**
     * @return array|null
     */
    public function run(){
        $queue_status_change_log_stat_manager=new QueueStatusChangeLogStatManager();
        return $queue_status_change_log_stat_manager->getDayLeader($this->date);
    }
}