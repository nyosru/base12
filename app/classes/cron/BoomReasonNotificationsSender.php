<?php
namespace App\classes\cron;

use App\classes\tmoffer\CompanySubjectInfo;
use App\Tmf18botTmfsales;
use App\TmfBooking;
use App\TmfClientTmsrTmoffer;
use App\Tmoffer;
use App\TmofferBin;
use App\TmofferInvoiceScheduledEmail;
use App\Tmfsales;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Telegram\Bot\Api;

class BoomReasonNotificationsSender
{
    public function __invoke()
    {
        $start_date=new \DateTime('2020-10-01 00:00:00');
        $tmoffers=$this->get4Sending(clone $start_date);
//        echo count($tmoffers)."<br/>";
//        foreach ($tmoffers as $tmoffer)
//            echo $tmoffer->Login.'<br/>';
//        exit;
        $data=[];
        foreach ($tmoffers as $tmoffer)
            if($tmfsales=$this->getSales($tmoffer)){
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
        if(count($data))
            foreach ($data as $tmfsales_id=>$el_arr){
                $tmfsales=Tmfsales::find($tmfsales_id);
                $message=[];
                $message[]=sprintf('Hey %s,',$tmfsales->FirstName);
                $message[]=sprintf('Congrats on your recent BOOM%1$s. Please don\'t forget to provide the details about your call%1$s with:',count($el_arr)>1?'s':'');
                foreach ($el_arr as $tmoffer){
                    $client=$this->getClient($tmoffer);
                    $link=sprintf('https://in.trademarkfactory.com/bookings-calendar/enter-boom-reason/%s',$tmoffer->Login);
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
        if($tmoffer->sales_id)
            return Tmfsales::find($tmoffer->sales_id);
        elseif(strlen($tmoffer->Sales))
            return Tmfsales::where('Login',$tmoffer->Sales)->first();
        return null;
    }


    private function getMessage($tmoffer,$tmfsales){
        $message=[];
        $message[]=sprintf('Hey %s,',$tmfsales->FirstName);
        $message[]='Congrats on your recent BOOM. Please don\'t forget to provide the details about your call with '.$this->getClient($tmoffer).': ';
        $message[]=sprintf('https://in.trademarkfactory.com/bookings-calendar/call-report/%s',$tmoffer->Login);
        return implode(PHP_EOL,$message);
    }

    private function getClient($tmoffer)
    {
        $client_info=CompanySubjectInfo::init($tmoffer)->get();
        return $client_info['firstname'].' '.$client_info['lastname'];
    }


    private function get4Sending(\DateTime $date){
        $result=[];
        $tmoffers=Tmoffer::whereIn('ID',TmofferBin::select('tmoffer_id')
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
        return $result;
    }
}