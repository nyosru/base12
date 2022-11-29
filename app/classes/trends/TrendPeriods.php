<?php
namespace App\classes\trends;


abstract class TrendPeriods
{
    protected $last;
    protected $detalization;
    protected $interval;
    protected $periods;

    protected function __construct($last)
    {
        $this->last=$last;
        $this->initIntervalAndDetalization();
        $this->calculatePeriods();
    }

    public function getPeriods(){
        return $this->periods;
    }

    public function getLast(){
        return $this->last;
    }

    public function getDetalization(){
        return $this->detalization;
    }

    public function getInterval(){
        return $this->interval;
    }

    protected function calculatePeriods()
    {
        $today=new \DateTime();
        for($i=0;$i<$this->last;$i++){
            if($i)
                $today->add($this->interval);
            $this->periods[]=$this->getStartEndPeriod($today);
        }
        $this->periods=array_reverse($this->periods);
    }

    abstract protected function getStartEndPeriod(\DateTime $date);
    abstract protected function initIntervalAndDetalization();

    public static function init($last,$detalization){
        switch ($detalization){
            case 'Weeks': return new WeeksTrendPeriods($last);
            case 'Months': return new MonthsTrendPeriods($last);
            case 'Years': return new YearsTrendPeriods($last);
            case 'Quarters': return new QuartersTrendPeriods($last);
            default: return new \Exception('Wrong detalization code!');
        }
    }
}