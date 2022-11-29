<?php
namespace App\classes\trends;


class DatasetMinMax
{
    public static function min($dataset_arr){
        $value=$dataset_arr[0]['min'];
        foreach ($dataset_arr as $el)
            if($el['min']<$value)
                $value=$el['min'];
        return $value;
    }

    public static function max($dataset_arr){
        $value=$dataset_arr[0]['max'];
        foreach ($dataset_arr as $el)
            if($el['max']>$value)
                $value=$el['max'];
        return $value;
    }
}