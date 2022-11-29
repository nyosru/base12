<?php

namespace App\Modules\TMFXQ\Managers;


use App\classes\QueryManager;
use App\Modules\TMFXQ\Models\QueueStatusChangeLog;
use App\QueueRootStatus;
use App\QueueStatus;
use App\QueueType;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class QueueStatusChangeLogStatManager
{
    /**
     * @param Carbon $from_datetime
     * @param Carbon $to_datetime
     * @param int $tmfsales_id
     * @return int
     */
    public function getTmsUserClearedByDate(Carbon $from_datetime, Carbon $to_datetime, int $tmfsales_id){
        $filters=[
            'created_at'=>[
                ['operator'=>'>=', 'value'=>$from_datetime->format('Y-m-d H:i:s')],
                ['operator'=>'<', 'value'=>$to_datetime->format('Y-m-d H:i:s')]
            ],
            'tmfsales_id'=>$tmfsales_id
        ];

        $queue_status_change_log_query_manager=new QueueStatusChangeLogQueryManager([],$filters,[]);

        return $queue_status_change_log_query_manager->build()->count();
    }

    /**
     * @return array|null
     */
    public function getAllTimeLeader(){
        $queue_status_change_log=QueueStatusChangeLog::selectRaw('count(id) as count_id,tmfsales_id')
            ->groupByRaw('date_format(created_at,"%Y-%m-%d")')
            ->groupBy('tmfsales_id')
            ->orderByRaw('count(id) desc')
            ->first();
        if($queue_status_change_log)
            return [$queue_status_change_log->tmfsales,$queue_status_change_log->count_id];
        else
            return null;
    }

    /**
     * @param Carbon $date
     * @return array|null
     */
    public function getDayLeader(Carbon $date){
        $queue_status_change_log=QueueStatusChangeLog::selectRaw('count(id) as count_id,tmfsales_id')
            ->whereRaw(sprintf('date_format(created_at,"%%Y-%%m-%%d")="%s"',$date->format('Y-m-d')))
            ->groupByRaw('date_format(created_at,"%Y-%m-%d")')
            ->groupBy('tmfsales_id')
            ->orderByRaw('count(id) desc')
            ->first();
        if($queue_status_change_log) {
            return [$queue_status_change_log->tmfsales,$queue_status_change_log->count_id];
        }else
            return null;
    }
}
