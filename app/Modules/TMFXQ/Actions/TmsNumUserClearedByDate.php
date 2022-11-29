<?php

namespace App\Modules\TMFXQ\Actions;


use App\Modules\TMFXQ\Managers\QueueStatusChangeLogStatManager;
use Carbon\Carbon;

class TmsNumUserClearedByDate
{

    private $from_datetime;
    private $to_datetime;
    private $tmfsales_id;

    /**
     * TmsNumUserClearedByDate constructor.
     * @param Carbon $from_datetime
     * @param Carbon $to_datetime
     * @param int $tmfsales_id
     */
    public function __construct(Carbon $from_datetime, Carbon $to_datetime, int $tmfsales_id)
    {
        $this->from_datetime=$from_datetime;
        $this->to_datetime=$to_datetime;
        $this->tmfsales_id=$tmfsales_id;
    }

    public function run(){
        $queue_status_change_log=new QueueStatusChangeLogStatManager();
        return $queue_status_change_log->getTmsUserClearedByDate(
            $this->from_datetime,
            $this->to_datetime,
            $this->tmfsales_id
        );
    }
}