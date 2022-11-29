<?php
namespace App\Modules\TMFXQ\Managers;


use App\Modules\TMFXQ\Models\QueueStatusChangeLog;
use Carbon\Carbon;

class QueueStatusChangeLogManager
{
    /**
     * @param int $dashboard_id
     * @param int $tmfsales_id
     * @param int $old_queue_status_id
     * @param int $new_queue_status_id
     * @return QueueStatusChangeLog
     */
    public function createNew(int $dashboard_id, int $tmfsales_id, int $old_queue_status_id, int $new_queue_status_id){
        $queue_status_change_log=new QueueStatusChangeLog();
        $queue_status_change_log->dashboard_id=$dashboard_id;
        $queue_status_change_log->tmfsales_id=$tmfsales_id;
        $queue_status_change_log->old_queue_status_id=$old_queue_status_id;
        $queue_status_change_log->new_queue_status_id=$new_queue_status_id;
        $queue_status_change_log->save();
        return $queue_status_change_log;
    }
}