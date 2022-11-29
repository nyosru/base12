<?php
namespace App\classes\cron;

use App\classes\tmoffer\CompanySubjectInfo;
use App\Mail\OutreachEmail1Sent;
use App\Tmf18botTmfsales;
use App\TmfBooking;
use App\TmfClientTmsrTmoffer;
use App\Tmoffer;
use App\TmofferInvoiceScheduledEmail;
use App\Tmfsales;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Telegram\Bot\Api;

class CloseableMessageSender
{
    public function __invoke()
    {
        $date=new \DateTime();
//        $date=\DateTime::createFromFormat('Y-m-d','2021-02-18');
        $tmoffers=$this->get4Sending(clone $date);
        foreach ($tmoffers as $tmoffer){
            $tmf_booking=$this->getTmofferBooking($tmoffer);
            $obj = Tmf18botTmfsales::where('tmfsales_id', $tmf_booking->sales_id)->first();
//            $obj = Tmf18botTmfsales::where('tmfsales_id', 53)->first();
            if($obj){
                $config = app('config')->get('telegram');
                $telegram = new Api($config['token']);
                $telegram->sendMessage([
                    'chat_id' => $obj->chat_id,
                    'parse_mode' => 'HTML',
                    'text' => $this->getMessage($tmoffer,$tmf_booking->sales_id)
                ]);
            }
        }
    }


    private function getMessage($tmoffer,$tmfsales_id){
        $tmfsales=Tmfsales::find($tmfsales_id);
//        $tmfsales=Tmfsales::find(53);
        $client=$this->getClient($tmoffer);
        $message=[];
        $message[]=sprintf('Hey %s:',$tmfsales->FirstName);
        $message[]=sprintf('You might want to follow up with %s about his trademarks.',
            $client);
        $shopping_cart_link=sprintf('https://trademarkfactory.com/shopping-cart/%s&donttrack=1',$tmoffer->Login);
        $message[]=sprintf('<a href="%s">Open Shopping Cart</a>',$shopping_cart_link);
        $reminder_in_days=[30,14,7];
        foreach ($reminder_in_days as $el)
            $message[]=sprintf('<a href="https://in.trademarkfactory.com/closeable-reminder/%s/%d">Remind Again in %d days</a>',
                $tmoffer->Login,
                $el,$el);
        $message[]=sprintf('<a href="https://in.trademarkfactory.com/closeable-reminder/%s/-1">Mark Uncloseable and Stop Reminding</a>',
            $tmoffer->Login);
        return implode(PHP_EOL,$message);
    }

    private function getClient($tmoffer)
    {
        $client_info=CompanySubjectInfo::init($tmoffer)->get();
        return $client_info['firstname'].' '.$client_info['lastname'].
            sprintf(' (%s, %s)',$client_info['email'],$client_info['phone']);
    }


    private function getTmofferBooking($tmoffer){
        return TmfBooking::whereIn('tmf_client_tmsr_tmoffer_id',TmfClientTmsrTmoffer::select('id')->where('tmoffer_id',$tmoffer->ID))
            ->orderBy('id','desc')
            ->first();
    }

    private function get4Sending(\DateTime $date){
        return Tmoffer::where(DB::raw('DATE_FORMAT(closeable_notification_at,"%Y-%m-%d")'),$date->format('Y-m-d'))
            ->where('DateConfirmed','0000-00-00')
            ->whereIn('closeable',[0,1])
            ->get();
    }
}