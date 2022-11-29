<?php

namespace App\classes\trends;


class WeeksTrendPeriods extends TrendPeriods
{

    protected function getStartEndPeriod(\DateTime $date){
        $current_weeknum=$date->format('w');

        $interval_endweek=\DateInterval::createFromDateString(sprintf('+ %d days',6-$current_weeknum));
        $end_weekdate=(clone $date)->add($interval_endweek);

        $interval_startweek=\DateInterval::createFromDateString(sprintf('- %d days',$current_weeknum));
        $start_weekdate=(clone $date)->add($interval_startweek);
        return [
            'from'=>$start_weekdate,
            'to'=>$end_weekdate
        ];
    }

    protected function initIntervalAndDetalization()
    {
        $this->detalization='Weeks';
        $this->interval=\DateInterval::createFromDateString('- 1 week');
    }
}