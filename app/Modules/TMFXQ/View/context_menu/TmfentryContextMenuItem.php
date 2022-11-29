<?php
namespace App\Modules\TMFXQ\View\context_menu;


use App\QueueCache;

class TmfentryContextMenuItem extends ContextMenuItem
{

    public function __construct(int $dashboard_id, int $queue_status_id=0){
        parent::__construct($dashboard_id,$queue_status_id);
        $this->icon='<i class="fas fa-book"></i>';
        $this->classname='tmfentry-link';
        $this->caption='TMF ENTRY';
    }

    /**
     * @return string
     * @throws \Throwable
     */
    public function getHtml()
    {
        $queue_cache=QueueCache::where('dashboard_id',$this->dashboard_id)->first();
        $dashboard_details=json_decode($queue_cache->json,true);
        if(strlen($dashboard_details['tmoffer_login']))
            return view('tmfxq::context-menu.tmfentry-item',[
                    'icon'=>$this->icon,
                    'classname'=>$this->classname,
                    'caption'=>$this->caption,
                    'tmoffer_login'=>$dashboard_details['tmoffer_login']
                ])->render();
        else
            return '';
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