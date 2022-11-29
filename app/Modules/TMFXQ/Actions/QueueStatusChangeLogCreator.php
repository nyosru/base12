<?php
namespace App\Modules\TMFXQ\Actions;


use App\Modules\TMFXQ\Managers\QueueStatusChangeLogManager;

class QueueStatusChangeLogCreator
{
    private $dashboard_id;
    private $tmfsales_id;
    private $old_queue_status_id;
    private $new_queue_status_id;

    /**
     * QueueStatusChangeLogCreator constructor.
     * @param int $dashboard_id
     * @param int $tmfsales_id
     * @param int $old_queue_status_id
     * @param int $new_queue_status_id
     */
    public function __construct(int $dashboard_id, int $tmfsales_id, int $old_queue_status_id, int $new_queue_status_id)
    {
        $this->dashboard_id=$dashboard_id;
        $this->tmfsales_id=$tmfsales_id;
        $this->old_queue_status_id=$old_queue_status_id;
        $this->new_queue_status_id=$new_queue_status_id;
    }

    /**
     * @return \App\Modules\TMFXQ\Models\QueueStatusChangeLog
     */
    public function run(){
        $queue_status_change_log_manager=new QueueStatusChangeLogManager();
        return $queue_status_change_log_manager->createNew(
            $this->dashboard_id,
            $this->tmfsales_id,
            $this->old_queue_status_id,
            $this->new_queue_status_id
        );
    }
}