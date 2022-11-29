<?php
namespace App\classes\postboombookings;


use App\classes\tmoffer\CompanySubjectInfo;
use App\Tmoffer;
use Carbon\Carbon;

class OeSouBooking extends Booking
{
    protected $tmoffer;

    protected function __construct(GcOeBooking $booking_obj)
    {
        parent::__construct($booking_obj);
//        echo "booking_id:{$booking_obj->id}<br/>";
        $this->tmoffer = Tmoffer::find($booking_obj->getBookingObj()->tmoffer_id);
    }


    public function getMenu()
    {
        return view('post-boom-bookings-calendar.menu.oesou-booking',[
            'tmoffer'=>$this->tmoffer,
            'booking'=>$this->booking_obj
        ])->render();
    }

    public function getTitle()
    {
        return '#'.$this->tmoffer->Login;
    }

    public function getBookedDatetime()
    {
        return new \DateTime($this->booking_obj->getBookingDateTime());
    }

    public function getParticipants()
    {
        $result = [];
        foreach ($this->booking_obj->getTmfsalesBookingCallObjs() as $el)
            $result[] = $el->tmfsales;
        return $result;

    }

    public function getBackground()
    {
        if($this->booking_obj->getBlockClass()=='oe-booking')
            return '#EEEE92';
        else
            return '#ECC4F7';
    }

    public function getBorderColor()
    {
        $now = Carbon::now();
        if ($this->booking_obj->getBookingDateTime() >= $now->format('Y-m-d H:i:s'))
            return BookingItemBorderColor::futureCall();

        return '#808080';

    }

    public function getClient()
    {
        $client_info=CompanySubjectInfo::init($this->tmoffer)->get();
        if($client_info['company']==$client_info['firstname'].' '.$client_info['lastname'])
            return $client_info['company'];
        else
            if(strlen($client_info['company']))
                return sprintf('%s (%s %s)',
                    $client_info['company'],
                    $client_info['firstname'],
                    $client_info['lastname']
                );
            else
                return $client_info['firstname'].' '.$client_info['lastname'];
    }

    public function getClientInfo()
    {
        return CompanySubjectInfo::init($this->tmoffer)->get();
    }

    public function getBlockClass()
    {
        return $this->booking_obj->getBlockClass();
    }

    public function getBookingProps()
    {
        $result = [];
        foreach ($this->booking_obj->getTmfsalesBookingCallObjs() as $el)
            $result[] = $el->tmfsales->ID;
        return $result;

    }

    public function getBookingCallIcon()
    {
        return $this->booking_obj->getBookingClassIcon();
    }
}