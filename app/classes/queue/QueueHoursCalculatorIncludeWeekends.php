<?php
namespace App\classes\queue;


class QueueHoursCalculatorIncludeWeekends extends QueueHoursCalculator
{
    public function getDiff(\DateTime $from_date, \DateTime $to_date)
    {
        return $to_date->getTimestamp()-$from_date->getTimestamp();
    }
}