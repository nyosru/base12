<?php
namespace App\classes\queue;


use App\DashboardRelativeStartDateType;
use App\PlusMinusSettings;

class FlagSettings
{
    public function html($prefix){
        $relative_start_date_type_objs=DashboardRelativeStartDateType::orderBy('id')->get();
        $plus_minus_settings_objs=PlusMinusSettings::all();

        return view('common-queue.flag-settings',
            compact('prefix','relative_start_date_type_objs','plus_minus_settings_objs'));
    }

    public static function js(){
        return view('common-queue.flag-settings-js');
    }
}