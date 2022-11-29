<?php

namespace App\Modules\TMFXQ\View\context_menu;


use App\Modules\TMFXQ\Managers\QueueStatusQueryManager;

class ShowHistoryMenuItem extends ContextMenuItem
{

    public function __construct(int $dashboard_id, int $queue_status_id = 0)
    {
        parent::__construct($dashboard_id, $queue_status_id);
        $this->icon = '<i class="fas fa-history"></i>';
        $this->classname = 'show-history-link';
        $this->caption = 'History';
    }

    /**
     * @return string
     * @throws \Throwable
     */
    public function getHtml()
    {
        $fields=['id','root_status'];
        $filters=['id'=>$this->queue_status_id];
        $sort=[];
        $queue_status_query_manager=new QueueStatusQueryManager($fields,$filters,$sort);
        $queue_root_status_id=$queue_status_query_manager->build()->first()->queue_root_status_id;
        return view('tmfxq::context-menu.show-history-item', [
            'icon' => $this->icon,
            'classname' => $this->classname,
            'caption' => $this->caption,
            'dashboard_id' => $this->dashboard_id,
            'queue_root_status_id' => $queue_root_status_id
        ])->render();
    }

    /**
     * @return string
     * @throws \Throwable
     */
    public function getJs()
    {
        return view('tmfxq::context-menu.show-history-item-js')->render();
    }

    /**
     * @return string
     * @throws \Throwable
     */
    public function getModal()
    {
        return view('queue.history-modal')->render();
    }
}