<?php
namespace App\Modules\TMFXQ\View\context_menu;


use App\classes\queue\AdditionalMenuItems;

abstract class ContextMenu
{
    /**
     * @var int
     */
    protected $dashboard_id;

    /**
     * @var int
     */
    protected $queue_status_id;

    /**
     * @var array
     */
    protected $context_menu_items;

    /**
     * ContextMenu constructor.
     * @param int $dashboard_id
     * @param int $queue_status_id
     */
    public function __construct(int $dashboard_id, int $queue_status_id)
    {
        $this->dashboard_id=$dashboard_id;
        $this->queue_status_id=$queue_status_id;
    }

    public function getHtml(){
        $items=[];
        foreach ($this->context_menu_items as $context_menu_item)
            $items[]=$context_menu_item->getHtml();
        $additional_menu_items=(new AdditionalMenuItems($this->queue_status_id,$this->dashboard_id))->get();
        foreach ($additional_menu_items as $additional_menu_item){
            $items[]=view('tmfxq::context-menu.url-item',[
                'url'=>$additional_menu_item->url,
                'icon'=>$additional_menu_item->icon,
                'caption'=>$additional_menu_item->name
            ])->render();
        }
        return view('tmfxq::context-menu.index',compact('items'));
    }

    public function getJs($selector){
        $html='';
        foreach ($this->context_menu_items as $context_menu_item)
            $html.=$context_menu_item->getJs();
        return view('tmfxq::context-menu.init-js',compact('selector'))
            ->render().$html;
    }

    public function getModals(){
        $html='';
        foreach ($this->context_menu_items as $context_menu_item)
            $html.=$context_menu_item->getModal();
        return $html;
    }

}