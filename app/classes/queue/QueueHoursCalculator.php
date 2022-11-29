<?php
namespace App\classes\queue;


use App\HoursCalculationMethod;
use Carbon\Carbon;

abstract class QueueHoursCalculator
{
    private function __construct()
    {
    }

    public static function init(HoursCalculationMethod $hours_calculator_method_obj){
        switch ($hours_calculator_method_obj->id){
            case 2: return new QueueHoursCalculatorExcludeLastWeekend();
            case 3: return new QueueHoursCalculatorExcludeAllWeekends();
            default: return new QueueHoursCalculatorIncludeWeekends();
        }
    }

    abstract public function getDiff(\DateTime $from_date,\DateTime $to_date);
}