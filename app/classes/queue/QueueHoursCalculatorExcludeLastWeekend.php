<?php
namespace App\classes\queue;


use Carbon\Carbon;

class QueueHoursCalculatorExcludeLastWeekend extends QueueHoursCalculator
{
    public function getDiff(\DateTime $from_date, \DateTime $to_date)
    {

        $c_from_date=Carbon::instance($from_date);
        $c_to_date=Carbon::instance($to_date);
        $c_from_date_next_day=$c_from_date->copy()->addDay();
        
//        $hours=0;
        $hrs=0;
        $index=0;
        $exclude_weekends=1;
        while($c_to_date->gt($c_from_date_next_day)){
            if(!$c_to_date->isWeekend() || ($c_to_date->isWeekend() && !$exclude_weekends)) {
                if($index)
                    $hours=$c_to_date->copy()->addDay()->diffInHours($c_to_date);
                else {
                    $hours = 11;
                    $index=1;
                }
//                echo "date:{$c_to_date->format('Y-m-d')} hours:$hours<br/>";
                $hrs+=$hours;
            }
            if($c_to_date->isWeekend() && $exclude_weekends && $c_to_date->weekday()==6)
                $exclude_weekends=0;
            $c_to_date->subDay();
        }
//        echo "date1:{$c_to_date->format('Y-m-d')}<br/>";
        if(!$c_to_date->isWeekend() || ($c_to_date->isWeekend() && !$exclude_weekends))
            $hrs+=6;

        return $hrs*3600;

    }
}