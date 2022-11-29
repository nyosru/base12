<?php
namespace App\classes\postboombookings;


use App\classes\tmoffer\CompanySubjectInfo;
use App\TmfBooking;
use App\TmfClientTmsrTmoffer;
use App\Tmfsales;
use App\TmfsalesTmofferNotBoomReason;
use App\Tmoffer;
use App\TmofferBin;
use App\TmofferTmfCountryTrademark;
use Carbon\Carbon;

class ClosersBooking extends Booking
{
    protected $tmoffer;

    protected function __construct($booking_obj){
        parent::__construct($booking_obj);
//        echo "booking_id:{$booking_obj->id}<br/>";
        $this->tmoffer=Tmoffer::whereIn('ID',
                TmfClientTmsrTmoffer::select('tmoffer_id')
                    ->where('id',$booking_obj->tmf_client_tmsr_tmoffer_id)
            )->first();
    }

    public function getMenu()
    {
        return view('post-boom-bookings-calendar.menu.closers-booking',[
            'tmoffer'=>$this->tmoffer,
            'booking'=>$this->booking_obj
        ])->render();
    }

    public function getTitle()
    {
        if($this->tmoffer->DateConfirmed=='0000-00-00')
            return $this->getClientName();
        else
            return '#'.$this->tmoffer->Login;

    }

    public function getBookedDatetime()
    {
        return new \DateTime($this->booking_obj->booked_date);
    }

    public function getParticipants()
    {
        $tmfsales=Tmfsales::find($this->booking_obj->sales_id);
        if($this->booking_obj->sales_confirmed_at=='0000-00-00 00:00:00')
            $tmfsales->LongID='<span class="text-danger">***  '.$tmfsales->LongID.' ***</span>';
        return [$tmfsales];
    }

    public function getBookingSourceIcon(){
        if(stripos($this->tmoffer->how_find_out_us,'youtube')!==false)
            return 'https://trademarkfactory.imgix.net/img/booking-calendar-youtube-14-7.png';
//            return 'https://trademarkfactory.imgix.net/img/yt2.jpg';
        elseif($this->tmoffer->how_find_out_us=='Direct-to-Booking Google Ad')
//            return 'https://trademarkfactory.imgix.net/img/ga.jpg';
            return 'https://trademarkfactory.imgix.net/img/booking-calendar-adwords-14-7.png';
        elseif(strpos($this->tmoffer->how_find_out_us,'FB')!==false)
            return 'https://trademarkfactory.imgix.net/img/booking-calendar-fb-14-7.png';
//            return 'https://trademarkfactory.imgix.net/img/fb-icon.png';
        return '';
    }



    public function getBackground()
    {
        if($this->tmoffer->DateConfirmed=='0000-00-00')
            return $this->tmoffer->prequalify_request_id?'#ffdeb4':'#ffffff';
        else
            return '#90ee90';
    }

    public function getClient()
    {
//        echo "tmoffer_id:{$this->tmoffer->ID}<br/>";
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

    private function getClientName()
    {
//        echo "tmoffer_id:{$this->tmoffer->ID}<br/>";
        $client_info=CompanySubjectInfo::init($this->tmoffer)->get();
        return $client_info['firstname'].' '.$client_info['lastname'];
    }



    private function getCallType()
    {
        $now=Carbon::now();

        if($this->booking_obj->booked_date>=$now->format('Y-m-d H:i:s'))
            return 'future-call';

        $tmoffer_bin=TmofferBin::where('tmoffer_id',$this->tmoffer->ID)->first();
        if($tmoffer_bin && !$tmoffer_bin->need_capture)
            return 'boom';
        else{
            $obj=TmfsalesTmofferNotBoomReason::where('tmoffer_id',$this->tmoffer->ID)->first();
            if($obj)
                switch ($obj->not_boom_reason_id){
                    case 79: return 'no-show';
                    case 85: return 'follow-up-scheduled';
                    default: return 'other-no-boom-reasons';
                }
        }
        return 'no-reason-entered';
    }

    public function getClientInfo()
    {
        return CompanySubjectInfo::init($this->tmoffer)->get();
    }

    public function getBlockClass()
    {
        return 'closing-call';
    }

    public function getBorderColor(){
        $now=Carbon::now();

        if($this->booking_obj->booked_date>=$now->format('Y-m-d H:i:s'))
            return BookingItemBorderColor::futureCall();

        $tmoffer_bin=TmofferBin::where('tmoffer_id',$this->tmoffer->ID)->first();
        if($tmoffer_bin && !$tmoffer_bin->need_capture)
            return BookingItemBorderColor::boom();
        else{
            $obj=TmfsalesTmofferNotBoomReason::where('tmoffer_id',$this->tmoffer->ID)->first();
            if($obj)
                switch ($obj->not_boom_reason_id){
                    case 79: return BookingItemBorderColor::noShow();
                    case 85: return BookingItemBorderColor::followUpScheduled();
                    default: return BookingItemBorderColor::otherReason();
                }
        }
        return '#808080';

    }

    private function getBookingFrom(){
        if(!is_null($this->tmoffer->how_find_out_us)){
            if (stripos('youtube', $this->tmoffer->how_find_out_us) !== false)
                return 'yt';
            elseif ($this->tmoffer->how_find_out_us == 'Direct-to-Booking Google Ad')
                return 'ga';
            elseif (strpos($this->tmoffer->how_find_out_us, 'FB')!==false)
                return 'fb';
        }
        return '';
    }

    public function getBookingProps()
    {
        return [
            'call_type'=>$this->getCallType(),
            'closeable'=>$this->tmoffer->closeable,
            'booking_from'=>$this->getBookingFrom(),
            'closer'=>$this->booking_obj->sales_id,
            'booking_type'=>($this->tmoffer->prequalify_request_id?'pq':'direct')
        ];
    }

    public function getBookingCallIcon()
    {
        switch ($this->booking_obj->who_will_call) {
            case 'ZOOM':
                $url='https://trademarkfactory.imgix.net/img/zoom-icon.png';
                break;
            case 'CLIENT':
                $url='https://trademarkfactory.imgix.net/img/incoming-call.png';
                break;
            default:
                $url='https://trademarkfactory.imgix.net/img/outgoing-call.png';
        }
        return sprintf('<img src="%s" class="booking-slot-icon"/>',$url);
    }
}