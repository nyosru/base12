<?php

namespace App\traits;

use App\TmfCountryTrademark;
trait OpsStatTrait
{
    private function getTrademark(TmfCountryTrademark $tmf_country_trademark_obj,$dashboard_id){
        $tmf_trademark=$tmf_country_trademark_obj->tmfTrademark;
        $tmf_country=$tmf_country_trademark_obj->tmfCountry;
        $mark=$tmf_trademark->tmf_trademark_mark;
        if($tmf_trademark->tmf_trademark_type_id==1)
            $mark=sprintf('<img src="https://trademarkfactory.imgix.net/offerimages/%s" style="max-width: 75px;max-height: 75px"/>',$mark);
        $country_flag=sprintf('<img src="https://trademarkfactory.imgix.net/img/countries/%s" style="max-width: 20px;max-height: 12px">',
            $tmf_country->tmf_country_flag);
        return sprintf('<a href="https://trademarkfactory.com/mlcclients/dashboard-trademarks-details.php?id=%d" target="_blank">%s %s</a>',$dashboard_id,$country_flag,$mark);

    }
}