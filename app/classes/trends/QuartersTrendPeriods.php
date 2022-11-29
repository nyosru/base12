<?php
namespace App\classes\trends;


class QuartersTrendPeriods extends TrendPeriods
{

    protected function getStartEndPeriod(\DateTime $date)
    {
        $current_quarter=intval(($date->format('m')-1)/3)+1;
        return [
            'from'=>$this->getQFirstDate($date->format('Y'),$current_quarter),
            'to'=>$this->getQLastDate($date->format('Y'),$current_quarter)
        ];
    }

    private function getQFirstDate($year,$quarter){
        $q=($quarter-1)*3+1;
        $date_str=sprintf('%s-%d-01',$year,($q>9?'':'0').$q);
        return new \DateTime($date_str);
    }

    private function getQLastDate($year,$quarter){
        if($quarter==4)
            $next_qfirst_date=$this->getQFirstDate($year+1,1);
        else
            $next_qfirst_date=$this->getQFirstDate($year,$quarter+1);
        $interval=\DateInterval::createFromDateString('- 1 day');
        return $next_qfirst_date->add($interval);
    }

    protected function initIntervalAndDetalization()
    {
        $this->detalization='Quarters';
        $this->interval=\DateInterval::createFromDateString('- 3 months');

    }
}