<?php

namespace App\classes\postboombookings;


use App\classes\tmoffer\CompanySubjectInfo;
use App\Tmoffer;
use App\TmofferCompanySubject;
use Carbon\Carbon;

class GmBooking extends Booking
{
    protected $tmf_subject;
    protected $tmoffer;

    protected function __construct($booking_obj)
    {
        parent::__construct($booking_obj);
//        echo "booking_id:{$booking_obj->id}<br/>";
        $this->tmf_subject = $this->booking_obj->tmfSubject;
        $this->tmoffer = $this->getTmoffer();
    }

    private function getTmoffer()
    {
        if ($this->booking_obj->tmoffer_id)
            return Tmoffer::find($this->booking_obj->tmoffer_id);

        $tmoffer_company_subject = TmofferCompanySubject::where('tmf_subject_id', $this->booking_obj->tmf_subject_id)
            ->orderBy('id', 'desc')
            ->first();
        if ($tmoffer_company_subject)
            return Tmoffer::find($tmoffer_company_subject->tmoffer_id);

        return null;
    }


    public function getMenu()
    {
        return view('post-boom-bookings-calendar.menu.gm-booking', [
            'tmoffer' => $this->tmoffer,
            'booking' => $this->booking_obj
        ])->render();

    }

    public function getTitle()
    {
        if($this->tmoffer)
            return '#'.$this->tmoffer->Login;
        return $this->tmf_subject->first_name . ' ' . $this->tmf_subject->last_name;
    }

    public function getBookedDatetime()
    {
        return new \DateTime($this->booking_obj->meeting_at);
    }

    public function getParticipants()
    {
        $result = [];
        foreach ($this->booking_obj->groupMeetingTmfsales as $el)
            $result[] = $el->tmfsales;
        return $result;
    }

    public function getBackground()
    {
        return '#C0DFF6';
    }

    public function getBorderColor()
    {
        $now = Carbon::now();
        if ($this->booking_obj->meeting_at >= $now->format('Y-m-d H:i:s'))
            return BookingItemBorderColor::futureCall();

        return '#808080';
    }

    public function getClient()
    {
        if ($this->tmoffer) {
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
        }

        return $this->tmf_subject->first_name . ' ' . $this->tmf_subject->last_name;

    }

    public function getClientInfo()
    {
        if ($this->tmoffer)
            return CompanySubjectInfo::init($this->tmoffer)->get();
        else {
            $client_info = [
                'tmf-subject-id' => $this->tmf_subject->id,
                'firstname' => $this->tmf_subject->first_name,
                'lastname' => $this->tmf_subject->last_name,
                'gender' => $this->tmf_subject->gender,
                'company' => '',
                'phone' => '',
                'email' => '',
                'skype' => '',
                'whatsapp' => '',
                'company_country' => '',
                'company_state' => '',
                'company_city' => '',
                'company_address' => '',
                'company_zipcode' => '',
                'company_biztype' => '',
                'company_incorp' => '',
            ];
            $tmf_subject_contacts = $this->tmf_subject->tmfSubjectContacts;
            foreach ($tmf_subject_contacts as $tmf_subject_contact)
                $client_info[$tmf_subject_contact->contactDataType->contact_data_type] = $tmf_subject_contact->contact;
            return $client_info;
        }
    }

    public function getBlockClass()
    {
        return 'group-call';
    }

    public function getBookingProps()
    {
        $result = [];

        foreach ($this->booking_obj->groupMeetingTmfsales as $el)
            $result[] = $el->tmfsales->ID;

        return $result;
    }

    public function getBookingCallIcon()
    {
        if($this->booking_obj->zoom_id || $this->booking_obj->zoom_url)
            $url='https://trademarkfactory.imgix.net/img/zoom-icon.png';
        else
            $url='https://trademarkfactory.imgix.net/img/outgoing-call.png';
        return sprintf('<img src="%s" class="booking-slot-icon"/>',$url);
    }
}