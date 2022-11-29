<?php
namespace App\classes\queue;


use App\QueueStatus;

class AdditionalMenuItems
{
    private $queue_status_id;
    private $dashboard_id;

    public function __construct($queue_status_id,$dashboard_id)
    {
        $this->queue_status_id=$queue_status_id;
        $this->dashboard_id=$dashboard_id;
    }

    public function get(){
        $queue_status=QueueStatus::find($this->queue_status_id);
        $result=$this->generateStandartContextMenuItems($queue_status);
        foreach ($queue_status->customContextMenuItemRows as $el){
            $obj=new ContextMenuItem();
            $obj->icon=$el->icon;
            $obj->name=$el->name;
            $obj->url=$el->url;
            $result[]=$obj;
        }
        return $result;
    }

    private function generateStandartContextMenuItems(QueueStatus $queue_status){
        $obj=new StandartContextMenuItemsGenerator($queue_status->standartContextMenuItemRows,$this->dashboard_id);
        return $obj->get();
    }
}