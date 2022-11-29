<?php
namespace App\classes\trends;


class YearsTrendPeriods extends TrendPeriods
{

    protected function getStartEndPeriod(\DateTime $date)
    {
        return [
            'from'=>new \DateTime($date->format('Y').'-01-01'),
            'to'=>new \DateTime($date->format('Y').'-12-31')
        ];
    }

    protected function initIntervalAndDetalization()
    {
        $this->detalization='Years';
        $this->interval=\DateInterval::createFromDateString('- 1 year');
    }
}