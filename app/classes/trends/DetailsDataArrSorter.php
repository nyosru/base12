<?php
namespace App\classes\trends;


class DetailsDataArrSorter
{
    public static function run($data_arr){
        usort($data_arr,['\App\classes\trends\DetailsDataArrSorter','cmp']);
        return $data_arr;
    }

    private static function cmp(DashboardDetailsData $a, DashboardDetailsData $b){
        if ($a->value == $b->value)
            return 1;
        return ($a->value < $b->value ? -1 : 1);

    }
}