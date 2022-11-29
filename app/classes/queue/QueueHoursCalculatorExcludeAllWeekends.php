<?php
namespace App\classes\queue;


use Carbon\Carbon;

class QueueHoursCalculatorExcludeAllWeekends extends QueueHoursCalculator
{
    public function getDiff(\DateTime $from_date, \DateTime $to_date)
    {
        $c_from_date=Carbon::instance($from_date);
        $c_to_date=Carbon::instance($to_date);
        $c_to_date_prev_day=$c_to_date->copy()->subDay();

        $hrs=0;
        $index=0;
        while(!$c_from_date->gt($c_to_date_prev_day)){
            if(!$c_from_date->isWeekend()){
                if($index)
                    $hours=$c_from_date->diffInHours($c_from_date->copy()->subDay());
                else {
                    $hours = 6;
                    $index=1;
                }
//                echo "date:{$d->format('Y-m-d')} hours:$hours<br/>";
                $hrs+=$hours;
            }
            $c_from_date->addDay();
        }
//        echo "date1:{$c_from_date->format('Y-m-d')}<br/>";
        if(!$c_from_date->isWeekend())
            $hrs+=11;

        return $hrs*3600;
    }
}