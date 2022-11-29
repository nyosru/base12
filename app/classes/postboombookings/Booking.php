<?php
namespace App\classes\postboombookings;


use App\GroupMeeting;
use App\OeBookingCall;
use App\TmfBooking;

abstract class Booking
{
    protected $title;
    protected $booked_datetime;
    protected $participants;
    protected $booking_obj;

    protected function __construct($booking_obj)
    {
        $this->booking_obj=$booking_obj;
    }

    public static function closersBooking(TmfBooking $booking_obj){
        return new ClosersBooking($booking_obj);
    }

    public static function gmBooking(GroupMeeting $booking_obj){
        return new GmBooking($booking_obj);
    }

    public static function oeSouBooking(GcOeBooking $booking_obj){
        return new OeSouBooking($booking_obj);
    }

    public function getBookingObj(){
        return $this->booking_obj;
    }

    public function getBookingSourceIcon(){
        return '';
    }

    abstract public function getMenu();
    abstract public function getTitle();
    abstract public function getBookedDatetime();
    abstract public function getParticipants();
    abstract public function getBackground();
    abstract public function getBorderColor();
    abstract public function getClient();
    abstract public function getClientInfo();
    abstract public function getBlockClass();
    abstract public function getBookingProps();
    abstract public function getBookingCallIcon();
}