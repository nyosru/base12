<?php
namespace App\classes\bookingstat;


use Carbon\Carbon;

class Periods
{
    private $from_to_dates;
    private $period_type;

    private $current_period;
    private $first_period;
    private $first_date;
    private $index;


    public function __construct(FromToDates $from_to_dates,$period_type)
    {
        $this->from_to_dates=$from_to_dates;
        $this->first_date=$this->from_to_dates->getFromDate();
        $this->period_type=$this->filterPeriodType($period_type);
        $this->index=0;
        $this->current_period=new FromToDates();
        $this->current_period->setFromDate($from_to_dates->getFromDate());
        $this->current_period->setToDate($from_to_dates->getFromDate());
    }

    private function filterPeriodType($period_type){
        switch ($period_type){
            case PeriodType::DAYS:
            case PeriodType::WEEKS:
            case PeriodType::MONTHS:
                return $period_type;
            case PeriodType::QUARTERS:
                $this->first_date=$this->getCurrentQuarterStartDate();
                return $period_type;
            default:
                return PeriodType::DAYS;
        }
    }

    private function getCurrentQuarterStartDate()
    {
        $today=Carbon::now();
        $m = $today->format('m');
        $y = $today->format('Y');
        $quarter = ceil($m / 3);
        $mm=($quarter * 3 - 2);
        $start_date = \DateTime::createFromFormat('Y-m-d',sprintf('%s-%s-01', $y, ($mm>9?$mm:"0$mm")));
        return $start_date;
    }


    public function current()
    {
        return $this->current_period;
    }

    /**
     * Move forward to next element
     * @return void Any returned value is ignored.
     */
    public function next()
    {
        $end_date=$this->getEndDate();
        if($this->index) {
            $this->current_period->setFromDate($this->current_period->getToDate());
            $this->current_period->setToDate($end_date);
        }else{
            $this->current_period->setFromDate($this->first_date);
            $this->current_period->setToDate($end_date);
            $this->index=1;
            $this->first_period=clone $this->current_period;
        }
    }

    private function getEndDate()
    {
        $today=new \DateTime();
        $start_date=$this->current_period->getFromDate();
        switch ($this->period_type) {
            case PeriodType::DAYS:
                $interval=\DateInterval::createFromDateString('1 day');
                $end_date=(clone $start_date)->add($interval);
                break;
            case PeriodType::WEEKS:
                if ($this->index) {
                    $w = $start_date->format('w');
                    $interval=\DateInterval::createFromDateString((7 - $w) . ' days');
                    $end_date=(clone $start_date)->add($interval);
                } else {
                    $interval=\DateInterval::createFromDateString('7 days');
                    $end_date = (clone $start_date)->add($interval);
                    if ($end_date->format('Y-m-d') > $today->format('Y-m-d')) {
                        $interval=\DateInterval::createFromDateString('1 day');
                        $end_date=$today->add($interval);
                    }
                }
                break;
            case PeriodType::MONTHS:
                if ($this->index) {
                    $endofmonth=\DateTime::createFromFormat('Y-m-d',$start_date->format('Y-m-t'));
                    $interval=\DateInterval::createFromDateString('1 day');
                    $end_date=$endofmonth->add($interval);
                } else {
                    $interval=\DateInterval::createFromDateString('1 month');
                    $end_date = (clone $start_date)->add($interval);
                    if ($end_date->format('Y-m-d') > $today->format('Y-m-d')) {
                        $interval=\DateInterval::createFromDateString('1 day');
                        $end_date=$today->add($interval);
                    }
                }
                
                break;
            case PeriodType::QUARTERS:
                $interval=\DateInterval::createFromDateString('3 months');
                if ($this->index) {
                    $current_year = $start_date->format('Y');
                    $q = ceil($start_date->format('n') / 3);
                    $starq = "$current_year-" . (($q - 1) * 3 + 1) . "-01";
                    $end_date = \DateTime::createFromFormat('Y-m-d',$starq)->add($interval);
                } else {
                    $end_date = (clone $start_date)->add($interval);
                    if ($end_date->format('Y-m-d') > $today->format('Y-m-d')) {
                        $interval=\DateInterval::createFromDateString('1 day');
                        $end_date=$today->add($interval);
                    }
                }
                break;
        }
        return $end_date;
    }



    /**
     * Checks if current position is valid
     * @return boolean The return value will be casted to boolean and then evaluated.
     * Returns true on success or false on failure.
     */
    public function valid()
    {
        echo "cp:".$this->current_period->getToDate()->format('Y-m-d')."<br/>";
        echo "ed:".$this->from_to_dates->getToDate()->format('Y-m-d');
        return $this->current_period->getToDate()->format('Y-m-d')<$this->from_to_dates->getToDate()->format('Y-m-d');
    }

    /**
     * Back to first date
     * @return void Any returned value is ignored.
     */
    public function rewind()
    {
        $this->first_date=$this->first_period->getFromDate();
        $this->index=0;
    }
}