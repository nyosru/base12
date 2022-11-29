<?php
namespace App\Http\Controllers;

use App\classes\cron\QueueCacheUpdater;
use App\classes\prequalifyrequests\PqCsvGenerator;
use App\classes\queue\AdditionalMenuItems;
use App\classes\queue\DashboardDataDetails;
use App\classes\queue\QueueTmHistory;
use App\classes\tmoffer\ExpeditedPayInFullEmail;
use App\DashboardOwner;
use App\DashboardTss;
use App\DashboardV2;
use App\Events\MyEvent;
use App\LastDashboardOwnerRow;
use App\Modules\TMFXQ\Actions\QueueStatusFinder;
use App\Modules\TMFXQ\Actions\TmsNumUserClearedByDate;
use App\Modules\TMFXQ\classes\context_menu\ViewInDashboardContextMenuItem;
use App\Modules\TMFXQ\Managers\QueueStatusQueryManager;
use App\Modules\TMFXQ\Models\QueueStatusChangeLog;
use App\PrequalifyRequest;
use App\QueueCache;
use App\QueueRootStatus;
use App\QueueStatus;
use App\TmfFilingQueueRootStatus;
use App\TmfFilingQueueStatus;
use App\TmfRegQueueRootStatus;
use App\TmfRegQueueStatus;
use App\Tmoffer;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class TestController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
//        $this->days=$this->days_select_arr[1];
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {

        $queue_status_change_log=QueueStatusChangeLog::selectRaw('count(id) as count_id')
            ->groupByRaw('date_format(created_at,"%Y-%m-%d")')
            ->groupBy('tmfsales_id')
            ->orderByRaw('count(id) desc')
            ->first();
        dd($queue_status_change_log->count_id);
        dd(Carbon::today());
        echo Carbon::tomorrow()->format('Y-m-d H:i:s');
//        $obj=new QueueStatusFinder($dashboard_id);
//        dd($obj->run()->queueRootStatus->name);
/*        $user='vitaly';
        $password='9xgamKeCPn7A';

        $auth = base64_encode("$user:$password");

        $postdata = http_build_query(
            array(
                'notification' => 1,
                'message' => '<p>asdasd asd asdasda</p><p>aaddd ffff sss</p><p>sssdafdsfasdfadsf</p>'
            )
        );

        $context = stream_context_create([
            "ssl"=>[
                "verify_peer"=>false,
                "verify_peer_name"=>false,
            ],
            'http' => [
                'header' => "Authorization: Basic $auth"."\r\nContent-type: application/x-www-form-urlencoded",
                'method' => 'POST',
                'content' =>$postdata
            ]
        ]);
//$homepage = file_get_contents("https://in.trademarkfactory.com/queue-request-review/2/15335", false, $context );
        $response = file_get_contents("http://localhost:8000/queue-request-review/2/15329", false, $context );
        echo $response;*/
    }
}
