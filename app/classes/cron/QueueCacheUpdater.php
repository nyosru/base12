<?php
namespace App\classes\cron;


use App\classes\emseq\TemplateTranslator;
use App\classes\queue\DashboardDataDetails;
use App\EmailsSeq;
use App\Mail\OutreachEmail1Sent;
use App\Modules\TMFXQ\Actions\DashboardTssManager;
use App\Modules\TMFXQ\Actions\QueueStatusFinder;
use App\QueueCache;
use App\TmfBooking;
use App\TmfClientTmsrTmoffer;
use App\Tmfsales;
use App\TmfSubjectContact;
use App\Tmoffer;
use App\TmofferCompanySubject;
use Ghattrell\ActiveCampaign\Facades\ActiveCampaign;
use Illuminate\Support\Facades\Mail;

class QueueCacheUpdater
{
    public function __invoke()
    {
        $queue_cache_objs=QueueCache::all();

        foreach ($queue_cache_objs as $queue_cache_obj){
            $dashboard_data_details_obj=new DashboardDataDetails($queue_cache_obj->dashboard);
            $ldd = $dashboard_data_details_obj->getDashboardData();
            $dashboard_tss_manager=new DashboardTssManager();
            $last_dashboard_tss = $dashboard_tss_manager->getLastDashboardTss($queue_cache_obj->dashboard_id);
            if ($last_dashboard_tss) {
                $queue_status = (new QueueStatusFinder())->run(
                    $last_dashboard_tss->cipostatus_status_formalized_id,
                    $last_dashboard_tss->dashboard_global_status_id
                );
                $dashboard_data_details_obj->formattedResultFromDataEl($ldd,$queue_status,0);
            }
        }
    }
}