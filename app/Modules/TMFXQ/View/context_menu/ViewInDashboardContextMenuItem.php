<?php
namespace App\Modules\TMFXQ\View\context_menu;


class ViewInDashboardContextMenuItem extends ContextMenuItem
{

    public function __construct(int $dashboard_id, int $queue_status_id=0){
        parent::__construct($dashboard_id,$queue_status_id);
        $this->icon='<i class="fas fa-tachometer-alt"></i>';
        $this->classname='view-in-dashboard-link';
        $this->caption='View in Dashboard';
    }

    /**
     * @return string
     * @throws \Throwable
     */
    public function getHtml()
    {
        return view('tmfxq::context-menu.view-in-dashboard-item',[
                'icon'=>$this->icon,
                'classname'=>$this->classname,
                'caption'=>$this->caption,
                'dashboard_id'=>$this->dashboard_id
            ])->render();
    }

    /**
     * @return string
     */
    public function getJs()
    {
        return '';
    }

    /**
     * @return string
     */
    public function getModal()
    {
        return '';
    }
}