<?php
namespace App\classes\trends;


class MonthsTrendPeriods extends TrendPeriods
{

    protected function getStartEndPeriod(\DateTime $date)
    {
        $month_days=$date->format('t');

        $interval_endmonth=\DateInterval::createFromDateString(sprintf('+ %d days',$month_days-$date->format('d')));
        $end_month=(clone $date)->add($interval_endmonth);

        $interval_startmonth=\DateInterval::createFromDateString(sprintf('- %d days',$date->format('d')-1));
        $start_month=(clone $date)->add($interval_startmonth);
        return [
            'from'=>$start_month,
            'to'=>$end_month
        ];
    }

    protected function initIntervalAndDetalization()
    {
        $this->detalization='Months';
        $this->interval=\DateInterval::createFromDateString('- 1 month');
    }
}