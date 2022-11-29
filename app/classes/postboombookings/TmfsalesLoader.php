<?php
namespace App\classes\postboombookings;


use App\Tmfsales;

class TmfsalesLoader
{
    public function get($include_inactive_closers=0){
        $tmfsales_objs=$this->getClosers($include_inactive_closers);
        $tmfsales_objs->push(Tmfsales::find(1));//Andrei
        $tmfsales_objs->push(Tmfsales::find(76));//Amanda
        $tmfsales_objs->push(Tmfsales::find(114));//Ron
        $tmfsales_objs->push(Tmfsales::find(108));//Mckoi
        $tmfsales_objs->push(Tmfsales::find(117));//Monica
        $tmfsales_objs->push(Tmfsales::find(118));//Mishel
//        $tmfsales_objs->push(Tmfsales::find(53));//VIT
        return $tmfsales_objs;
    }

    private function getClosers($include_inactive_closers){
        $result=Tmfsales::where('sales_calls',1);
        if($include_inactive_closers)
            return $result->get();
        else
            return $result->where('Visible',1)->get();
    }
}