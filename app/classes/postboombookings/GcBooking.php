<?php
namespace App\classes\postboombookings;


use App\classes\tmoffer\CompanySubjectInfo;
use App\Tmoffer;
use App\TmofferTmfCountryTrademark;
use Hashids\Hashids;

class GcBooking extends GcOeBooking
{

    private $oe_sou;

    protected function __construct($booking_obj)
    {
        parent::__construct($booking_obj);
        $tmoffer_tmf_country_trademark=TmofferTmfCountryTrademark::where('tmoffer_id',$this->booking_obj->tmoffer_id)
            ->whereNotNull('sou_sent_at')
            ->where('sou_sent_at','<=',$booking_obj->meeting_at)
            ->orderBy('id','asc')
//            ->dump();exit;
            ->first();
        if($tmoffer_tmf_country_trademark)
            $this->oe_sou='sou';
        else
            $this->oe_sou='oe';
    }


    public function getBookingDateTime()
    {
        return $this->booking_obj->meeting_at;
    }

    public function getZoomUrl()
    {
        if($this->booking_obj->zoom_url)
            return $this->booking_obj->zoom_url;
        if($this->booking_obj->zoom_id)
            return 'http://zoom.com/j/'.$this->booking_obj->zoom_id;
        return '';
    }

    public function getTmfsalesBookingCallObjs()
    {
        return $this->booking_obj->groupMeetingTmfsales;
    }

    public function getBlockClass()
    {
        return $this->oe_sou.'-booking';
    }

    public function getBookingClassIcon()
    {
        if($this->booking_obj->zoom_id || $this->booking_obj->zoom_url)
            $url='https://trademarkfactory.imgix.net/img/zoom-icon.png';
        else
            $url='https://trademarkfactory.imgix.net/img/outgoing-call.png';
        return sprintf('<img src="%s" class="booking-slot-icon"/>',$url);
    }

    public function getTemplate()
    {
        return $this->oe_sou.'-booking';
    }

    public function getBookingType()
    {
        return 'gc';
    }

    public function getPageLink()
    {
        $tmoffer=Tmoffer::find($this->booking_obj->tmoffer_id);

        $tmoffer_tmf_country_trademark=TmofferTmfCountryTrademark::where('tmoffer_id',$this->booking_obj->tmoffer_id)
            ->whereNotNull('sou_sent_at')
            ->where('sou_sent_at','<=',$this->booking_obj->meeting_at)
            ->orderBy('id','asc')
            ->first();

        if($tmoffer_tmf_country_trademark)
            return sprintf('https://trademarkfactory.com/sou/%s/%d&donttrack=1',
                $tmoffer->Login,
                $tmoffer_tmf_country_trademark->id);

        $tmoffer_tmf_country_trademark=TmofferTmfCountryTrademark::where('tmoffer_id',$this->booking_obj->tmoffer_id)
            ->whereNotNull('oe_sent_at')
            ->orderBy('id','asc')
            ->first();
        if($tmoffer_tmf_country_trademark)
            return sprintf('https://trademarkfactory.com/oe/%s/%d&donttrack=1',
                $tmoffer->Login,
                $tmoffer_tmf_country_trademark->id);

        $tmoffer_tmf_country_trademark=TmofferTmfCountryTrademark::where('tmoffer_id',$this->booking_obj->tmoffer_id)
            ->where('selected_flag',1)
            ->where('search_only',0)
            ->orderBy('id','asc')
            ->first();

        if($tmoffer_tmf_country_trademark)
            return sprintf('https://trademarkfactory.com/sou/%s/%d&donttrack=1',
                $tmoffer->Login,
                $tmoffer_tmf_country_trademark->id);

        return '#';
    }

    public function getClientFirstName()
    {
        if($this->booking_obj->tmoffer_id){
            $client_info=CompanySubjectInfo::init(Tmoffer::find($this->booking_obj->tmoffer_id))->get();
            return $client_info['firstname'];
        }elseif ($this->booking_obj->tmf_subject_id)
            return $this->booking_obj->tmfSubject->first_name;
        return '';
    }

    public function getCancelLink()
    {
        return sprintf('https://trademarkfactory.com/cancel-meeting/%s',(new Hashids())->encode($this->booking_obj->id));
    }

    public function getRebookLink()
    {
        $tmfsales_fns=[];
        foreach ($this->booking_obj->groupMeetingTmfsales as $el)
            $tmfsales_fns[]=strtolower($el->tmfsales->FirstName);
        return sprintf('https://trademarkfactory.com/call/%s',implode('-',$tmfsales_fns));

    }
}