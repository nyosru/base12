<?php
namespace App\classes\bookingstat;

class FromToDates
{
    private $from_date;
    private $to_date;

    public function __construct()
    {
        $this->from_date=null;
        $this->to_date=null;
    }

    public function getFromDate(){
        return $this->from_date;
    }

    public function getToDate(){
        return $this->to_date;
    }

    public function setFromDate(\DateTime $from_date){
        $this->from_date=$from_date;
    }

    public function setToDate(\DateTime $to_date){
        $this->to_date=$to_date;
    }
}