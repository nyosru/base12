<?php
namespace App\Modules\TMFXQ\View\context_menu;


use App\Modules\TMFXQ\Managers\DashboardTssQueryManager;

class EditFlagValuesMenuItem extends ContextMenuItem
{

    public function __construct(int $dashboard_id, int $queue_status_id=0){
        parent::__construct($dashboard_id,$queue_status_id);
        $this->icon='<i class="fas fa-flag"></i>';
        $this->classname='edit-flags-values-link';
        $this->caption='Change Flags';
    }

    /**
     * @return string
     * @throws \Throwable
     */
    public function getHtml()
    {
        $filter=['dashboard_id'=>$this->dashboard_id];
        $sort=['id'=>'desc'];
        $last_dashboard_tss = (new DashboardTssQueryManager([], $filter, $sort))->build()->first();
        $danger_at=$last_dashboard_tss->danger_at;
        $warning_at=$last_dashboard_tss->warning_at;

            return view('tmfxq::context-menu.edit-flags-values-item',[
                    'icon'=>$this->icon,
                    'classname'=>$this->classname,
                    'caption'=>$this->caption,
                    'dashboard_id'=>$this->dashboard_id,
                    'queue_status_id'=>$this->queue_status_id,
                'danger_at'=>$danger_at,
                'warning_at'=>$warning_at
                ])->render();
    }

    /**
     * @return string
     * @throws \Throwable
     */
    public function getJs()
    {
        return view('tmfxq::context-menu.edit-flags-values-item-js')->render();
    }

    /**
     * @return string
     * @throws \Throwable
     */
    public function getModal()
    {
        return view('queue.edit-flags-values-modal')->render();
    }
}