<?php
namespace App\Modules\TMFXQ\View\context_menu;


class DashboardNotesMenuItem extends ContextMenuItem
{

    public function __construct(int $dashboard_id, int $queue_status_id=0){
        parent::__construct($dashboard_id,$queue_status_id);
        $this->icon='<i class="fas fa-sticky-note"></i>';
        $this->classname='dashboard-notes-link';
        $this->caption='Notes';
    }

    /**
     * @return string
     * @throws \Throwable
     */
    public function getHtml()
    {
            return view('tmfxq::context-menu.non-url-item',[
                    'icon'=>$this->icon,
                    'classname'=>$this->classname,
                    'caption'=>$this->caption,
                    'dashboard_id'=>$this->dashboard_id,
                    'queue_status_id'=>$this->queue_status_id
                ])->render();
    }

    /**
     * @return string
     * @throws \Throwable
     */
    public function getJs()
    {
        return view('tmfxq::context-menu.dashboard-notes-item-js')->render();
    }

    /**
     * @return string
     * @throws \Throwable
     */
    public function getModal()
    {
        return view('post-boom-bookings-calendar.notes-modal')->render();
    }
}