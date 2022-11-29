<?php
namespace App\Modules\TMFXQ\View\context_menu;


use App\QueueCache;

class ViewTmOfficePageContextMenuItem extends ContextMenuItem
{

    public function __construct(int $dashboard_id, int $queue_status_id=0){
        parent::__construct($dashboard_id,$queue_status_id);
        $this->icon='<i class="fas fa-binoculars"></i>';
        $this->classname='view-tm-office-page';
        $this->caption='View TM Office Page';
    }

    /**
     * @return string
     * @throws \Throwable
     */
    public function getHtml()
    {
        $queue_cache=QueueCache::where('dashboard_id',$this->dashboard_id)->first();
        $dashboard_details=json_decode($queue_cache->json,true);
        if(strlen($dashboard_details['agency_url']))
            return view('tmfxq::context-menu.view-tm-office-page-item',[
                    'icon'=>$this->icon,
                    'classname'=>$this->classname,
                    'caption'=>$this->caption,
                    'agency_url'=>$dashboard_details['agency_url']
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