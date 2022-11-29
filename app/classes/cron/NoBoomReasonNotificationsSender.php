<?php
namespace App\classes\cron;

use App\classes\tmoffer\CompanySubjectInfo;
use App\Tmf18botTmfsales;
use App\TmfBooking;
use App\TmfClientTmsrTmoffer;
use App\TmfsalesTmofferNotBoomReason;
use App\Tmoffer;
use App\TmofferBin;
use App\TmofferInvoiceScheduledEmail;
use App\Tmfsales;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Telegram\Bot\Api;

class NoBoomReasonNotificationsSender
{
    public function __invoke()
    {
        $start_date=new \DateTime('2020-11-15 00:00:00');
        $tmoffers=$this->get4Sending(clone $start_date);
/*        echo count($tmoffers)."<br/>";
        foreach ($tmoffers as $tmoffer)
            echo $tmoffer->Login.'<br/>';
        exit;*/
        $data=[];
        foreach ($tmoffers as $tmoffer)
            $tmf_booking=TmfBooking::whereIn('tmf_client_tmsr_tmoffer_id',
                TmfClientTmsrTmoffer::select('id')->where('tmoffer_id',$tmoffer->ID)
                )
                ->orderBy('id','desc')
                ->first();
//        dd()
//        echo "tmoffer_id:{$tmoffer->ID} tmf_booking_id:{$tmf_booking->id}<br/>";
            $tmfsales=$this->getSales($tmoffer);
            if($tmfsales && $tmf_booking->booked_date<Carbon::now()->format('Y-m-d H:i:s')){
            if(!isset($data[$tmfsales->ID]))
                $data[$tmfsales->ID]=[];
            $data[$tmfsales->ID][]=$tmoffer;

/*            $obj = Tmf18botTmfsales::where('tmfsales_id', $tmfsales->ID)->first();
            if($obj){
                $config = app('config')->get('telegram');
                $telegram = new Api($config['token']);
                $telegram->sendMessage([
                    'chat_id' => $obj->chat_id,
                    'parse_mode' => 'HTML',
                    'text' => $this->getMessage($tmoffer,$tmfsales)
                ]);
            }*/

        }
//        dd($data);
        if(count($data))
            foreach ($data as $tmfsales_id=>$el_arr){
                $tmfsales=Tmfsales::find($tmfsales_id);
                $message=[];
                $message[]=sprintf('Hey %s,',$tmfsales->FirstName);
                if(count($el_arr))
                    $message[]='Please provide the details and the No-BOOM reason for your call with ';
                else
                    $message[]='Please provide the details and the No-BOOM reasons for your calls with:';

                foreach ($el_arr as $tmoffer){
                    $client=$this->getClient($tmoffer);
                    $link=sprintf('https://in.trademarkfactory.com/bookings-calendar/call-report/%s',$tmoffer->Login);
                    $message[]=PHP_EOL.sprintf('<a href="%s" target="_blank">%s</a>',$link,$client);
                }
                $this->sendMessage($tmfsales_id,$message);
            }
    }

    private function sendMessage($tmfsales_id,$message){
//        $tmfsales_id=53;
        $obj = Tmf18botTmfsales::where('tmfsales_id', $tmfsales_id)->first();
        if($obj) {
            $config = app('config')->get('telegram');
            $telegram = new Api($config['token']);
            $telegram->sendMessage([
                'chat_id' => $obj->chat_id,
                'parse_mode' => 'HTML',
                'text' => implode(PHP_EOL, $message)
            ]);
        }
    }

    private function getSales($tmoffer){
        $tmf_booking=TmfBooking::whereIn('tmf_client_tmsr_tmoffer_id',TmfClientTmsrTmoffer::select('id')
            ->where('tmoffer_id',$tmoffer->ID)
        )->where('booked_date','!=','0000-00-00 00:00:00')
         ->orderBy('id','desc')
         ->first();
        if($tmf_booking)
            return Tmfsales::find($tmf_booking->sales_id);
        return null;
    }


    private function getMessage($tmoffer,$tmfsales){
        $message=[];
        $message[]=sprintf('Hey %s,',$tmfsales->FirstName);
        $message[]='Congrats on your recent BOOM. Please don\'t forget to provide the details about your call with '.$this->getClient($tmoffer).': ';
        $message[]=sprintf('https://in.trademarkfactory.com/bookings-calendar/enter-boom-reason/%s',$tmoffer->Login);
        return implode(PHP_EOL,$message);
    }

    private function getClient($tmoffer)
    {
        $client_info=CompanySubjectInfo::init($tmoffer)->get();
        return $client_info['firstname'].' '.$client_info['lastname'];
    }


    private function get4Sending(\DateTime $date){

        return Tmoffer::whereIn('ID',TmfClientTmsrTmoffer::select('tmoffer_id')
            ->whereIn('id', TmfBooking::select('tmf_client_tmsr_tmoffer_id')
                ->distinct()
                ->where([
                    ['booked_date','>=',$date->format('Y-m-d').' 00:00:00'],
                    ['booked_date','<=',Carbon::now()->format('Y-m-d H:i:s')]
                ])
                ->whereNotIn('tmf_client_tmsr_tmoffer_id',TmfBooking::select('tmf_client_tmsr_tmoffer_id')
                    ->distinct()
                    ->where('booked_date','0000-00-00 00:00:00')
                )
            )
        )->whereNotIn('ID',TmofferBin::select('tmoffer_id')
                            ->where('need_capture',0)
                            ->where('modified_at','>=',$date->format('Y-m-d H:i:s'))
        )->whereNotIn('ID',TmfsalesTmofferNotBoomReason::select('tmoffer_id'))
         ->get();

/*        $tmoffers=Tmoffer::whereIn('ID',TmofferBin::select('tmoffer_id')
                                        ->whereNull('boom_reason')
                                        ->where('need_capture',0)
                                        ->where('modified_at','>=',$date->format('Y-m-d H:i:s'))
        )->where('DateConfirmed','!=','0000-00-00')
            ->get();
        if($tmoffers && $tmoffers->count())
            foreach ($tmoffers as $tmoffer){
                $tmf_bookings=TmfBooking::whereIn('tmf_client_tmsr_tmoffer_id',
                    TmfClientTmsrTmoffer::select('id')->where('tmoffer_id',$tmoffer->ID))
                    ->get();
                if($tmf_bookings && $tmf_bookings->count())
                    $result[]=$tmoffer;
            }
        return $result;*/
    }
}