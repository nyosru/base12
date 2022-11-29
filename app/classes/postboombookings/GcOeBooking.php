<?php

namespace App\classes\postboombookings;


use App\GroupMeeting;
use App\OeBookingCall;

abstract class GcOeBooking
{
    protected $booking_obj;

    protected function __construct($booking_obj)
    {
        $this->booking_obj=$booking_obj;
    }

    public static function initGcBooking(GroupMeeting $booking_obj){
        return new GcBooking($booking_obj);
    }

    public static function initOeBooking(OeBookingCall $booking_obj){
        return new OeBooking($booking_obj);
    }

    public function getBookingObj(){
        return $this->booking_obj;
    }

    abstract public function getBookingDateTime();
    abstract public function getZoomUrl();
    abstract public function getTmfsalesBookingCallObjs();
    abstract public function getBlockClass();
    abstract public function getBookingClassIcon();
    abstract public function getTemplate();
    abstract public function getBookingType();
    abstract public function getPageLink();
    abstract public function getClientFirstName();
    abstract public function getCancelLink();
    abstract public function getRebookLink();
}