<?php
namespace App\classes\bookingstat;

abstract class Stat
{
    protected $from_date;
    protected $to_date;

    protected function __construct(\DateTime $from_date,\DateTime $to_date)
    {
        $this->from_date=$from_date;
        $this->to_date=$to_date;
    }

    public static function closerBookings(\DateTime $from_date,\DateTime $to_date){
        return new CloserBookingsStat($from_date,$to_date);
    }

    public static function groupCalls(\DateTime $from_date,\DateTime $to_date){
        return new GroupBookingsStat($from_date,$to_date);
    }

    public static function oeSouCalls(\DateTime $from_date,\DateTime $to_date){
        return new OeSouBookingsStat($from_date,$to_date);
    }

    abstract public function get();

}