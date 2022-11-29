<?php
namespace App\classes\queue;


use App\classes\dashboard\DashboardOwnerManager;
use App\DashboardV2;
use App\Events\ReloadSubStatusTms;
use App\QueueStatus;
use App\RequestReviewDetails;
use App\Tmfsales;
use Carbon\Carbon;
use Telegram\Bot\Api;

class ReviewRequester
{
    private const REVIEW_REQUESTED=3;

    private $queue_status;
    private $dashboard;
    private $tmfsales;

    public function __construct($tmfsales_id,$queue_status_id,$dashboard_id)
    {
        $this->tmfsales=Tmfsales::find($tmfsales_id);
        $this->queue_status=QueueStatus::find($queue_status_id);
        $this->dashboard=DashboardV2::find($dashboard_id);
    }

    private function releaseOwnerFromMark(){
        $dashboard_owner_manager=new DashboardOwnerManager($this->dashboard->id);
        return $dashboard_owner_manager->releaseOwnerFromMark($this->tmfsales->ID,self::REVIEW_REQUESTED);
    }

    private function prepareAndSendNotification($dashboard_owner_id,$message){
        $suffix='';
        if($message && strlen($message)) {
            $suffix = PHP_EOL . sprintf('—"%s"', $message);
            $this->saveRequestReviewDetails($dashboard_owner_id,$message);
            $note=sprintf('%s %s requested review: "%s"',
                Carbon::now()->format('Y-m-d H:i:s'),
                $this->tmfsales->LongID,
                $message);
            $this->addDashboardNote($this->dashboard,$note);
        }
        $this->sendMessageToTelegram($suffix);
    }

    private function sendMessageToTelegram($suffix){
        $tmf_trademark = $this->dashboard->tmfCountryTrademark->tmfTrademark;
        $tmf_country = $this->dashboard->tmfCountryTrademark->tmfCountry;
        $mark = ($tmf_trademark->tmf_trademark_type_id == 1 ? $tmf_trademark->logo_descr : $tmf_trademark->tmf_trademark_mark);
        $config = app('config')->get('telegram');
        $telegram = new Api($config['token']);
        $dashboard_link='https://trademarkfactory.com/mlcclients/dashboard-trademarks-details.php?id='.$this->dashboard->id;
        $queue_status_link=sprintf('https://in.trademarkfactory.com/queue/mark/%d/%d',
            $this->queue_status->id,
            $this->dashboard->id);
        $dismiss_request_link=sprintf('https://in.trademarkfactory.com/queue/dismiss-request/%d/%d',
            $this->queue_status->id,
            $this->dashboard->id);
        $telegram->sendMessage([
            'chat_id' => $this->queue_status->queueRootStatus->queueType->telegram_chat_id,
            'parse_mode' => 'HTML',
            'text' => sprintf('%s %s requested review for <b>%s</b> in %s%s' . PHP_EOL .'[<i>%s</i>]%s'.
                PHP_EOL.'<a href="%s">Open in Dashboard</a> | <a href="%s">Open in Queue</a> | <a href="%s">Dismiss Request</a>',
                $this->tmfsales->FirstName,
                $this->tmfsales->LastName,
                $mark,
                ($tmf_country->article_the ? 'the ' : ''),
                $tmf_country->tmf_country_name_short,
                $this->queue_status->name,
                $suffix,
                $dashboard_link,
                $queue_status_link,
                $dismiss_request_link)
        ]);
    }

    private function saveRequestReviewDetails($dashboard_owner_id,$message){
        $request_review_details=new RequestReviewDetails();
        $request_review_details->dashboard_owner_id=$dashboard_owner_id;
        $request_review_details->description=$message;
        $request_review_details->created_at=Carbon::now()->format('Y-m-d H:i:s');
        $request_review_details->save();
    }

    private function addDashboardNote(DashboardV2 $dashboard_obj,$note){
        $dashboard_obj->notes.="\r\n\r\n".$note;
        $dashboard_obj->save();
    }

    public function run($message,$send_notification){
        $dashboard_owner=$this->releaseOwnerFromMark();
        if($dashboard_owner){
            if($send_notification)
                $this->prepareAndSendNotification($dashboard_owner->id,$message);
            (new CacheElUpdater($this->queue_status,$this->dashboard))->run();
            event(new ReloadSubStatusTms($this->queue_status->id));
        }
    }
}