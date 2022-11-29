<?php
namespace App\classes\postboombookings;


use App\classes\tmoffer\CompanySubjectInfo;
use App\Tmoffer;
use App\TmofferTmfCountryTrademark;
use Hashids\Hashids;

class OeBooking extends GcOeBooking
{

    private $tmoffer;

    protected function __construct($booking_obj){
        parent::__construct($booking_obj);
        $this->tmoffer=Tmoffer::find($this->booking_obj->tmoffer_id);
    }

    public function getBookingDateTime()
    {
        return $this->booking_obj->datetime_pst;
    }

    public function getZoomUrl()
    {
        return $this->booking_obj->zoom_url;
    }

    public function getTmfsalesBookingCallObjs()
    {
        return $this->booking_obj->tmfsalesOeBookingCalls;
    }

    public function getBlockClass()
    {
        return 'oe-booking';
    }

    public function getBookingClassIcon()
    {
        $url='https://trademarkfactory.imgix.net/img/zoom-icon.png';
        return sprintf('<img src="%s" class="booking-slot-icon"/>',$url);
    }

    public function getTemplate()
    {
        return 'oe-booking';
    }

    public function getBookingType()
    {
        return 'oe';
    }

    public function getPageLink()
    {

        $tmoffer_tmf_country_trademark=TmofferTmfCountryTrademark::where('tmoffer_id',$this->booking_obj->tmoffer_id)
            ->whereNotNull('oe_sent_at')
            ->orderBy('id','asc')
            ->first();
        if($tmoffer_tmf_country_trademark)
            return sprintf('https://trademarkfactory.com/ready/%s/%s&donttrack=1',
                $this->tmoffer->Login,
                $tmoffer_tmf_country_trademark->id);

        $tmoffer_tmf_country_trademark=TmofferTmfCountryTrademark::where('tmoffer_id',$this->booking_obj->tmoffer_id)
            ->where('selected_flag',1)
            ->where('search_only',0)
            ->orderBy('id','asc')
            ->first();

        if($tmoffer_tmf_country_trademark)
            return sprintf('https://trademarkfactory.com/ready/%s/%s&donttrack=1',
                $this->tmoffer->Login,
                $tmoffer_tmf_country_trademark->id);

        return '';
    }

    public function getClientFirstName()
    {
        $client_info=CompanySubjectInfo::init($this->tmoffer)->get();
        return $client_info['firstname'];
    }

    public function getCancelLink()
    {
        return sprintf('https://trademarkfactory.com/cancel-zoomcall/%s',(new Hashids())->encode($this->booking_obj->id));
    }

    public function getRebookLink()
    {
        $tmfsales=$this->booking_obj->tmfsalesOeBookingCalls[0]->tmfsales;
        return sprintf('https://trademarkfactory.com/zoom-%s&code=%s',
            strtolower($tmfsales->FirstName),
            $this->tmoffer->ConfirmationCode);
    }

}