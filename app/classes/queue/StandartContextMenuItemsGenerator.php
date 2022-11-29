<?php
namespace App\classes\queue;


use App\DashboardV2;
use App\StandartContextMenuItem;
use App\TmofferTmfCountryTrademark;

class StandartContextMenuItemsGenerator
{
    private const OEGS=1;

    private $standart_context_menu_item_rows;
    private $dashboard_id;
    private $tmoffer=null;
    private $tmoffer_tmf_country_trademark=null;

    public function __construct($standart_context_menu_item_rows,$dashboard_id)
    {
        $this->standart_context_menu_item_rows=$standart_context_menu_item_rows;
        $this->dashboard_id=$dashboard_id;
        $dashboard=DashboardV2::find($dashboard_id);
        $this->tmoffer=(new DashboardDataDetails($dashboard))->getTmoffer();
        if($this->tmoffer)
            $this->tmoffer_tmf_country_trademark=TmofferTmfCountryTrademark::where('tmf_country_trademark_id',
                $dashboard->tmf_country_trademark_id)
                ->where('tmoffer_id',$this->tmoffer->ID)
                ->first();
    }

    public function get(){
        $result=[];
        foreach ($this->standart_context_menu_item_rows as $standart_context_menu_item) {
            switch ($standart_context_menu_item->id) {
                case self::OEGS:
                    $obj = new ContextMenuItem();
                    if($this->tmoffer && $this->tmoffer_tmf_country_trademark) {
                        $obj->icon = $standart_context_menu_item->icon;
                        $obj->name = $standart_context_menu_item->name;
                        $obj->url = $this->generateOeGsLink();
                    }else{
                        $obj->icon = '<i class="fas fa-exclamation-triangle text-danger"></i>';
                        $obj->name = 'THIS MARK DOES NOT HAVE LINKED TMOFFER!!!';
                        $obj->url = '#';
                    }
                    $result[] = $obj;
                    break;
            }
        }
        return $result;
    }

    private function generateOeGsLink(){
        return sprintf('https://trademarkfactory.com/ready/%s/%d&donttrack=1',
            $this->tmoffer->Login,
            $this->tmoffer_tmf_country_trademark->id);
    }
}