<?php

namespace App\Modules\TMFXQ\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\TMFXQ\Actions\DashboardTssManager;
use App\Modules\TMFXQ\Actions\DashboardV2Manager;
use App\Modules\TMFXQ\Actions\QueueCacheManager;
use App\Modules\TMFXQ\Actions\QueueRandomCheckerAllTimeLeader;
use App\Modules\TMFXQ\Actions\QueueRandomCheckerDayLeader;
use App\Modules\TMFXQ\Actions\QueueStatusChangeLogCreator;
use App\Modules\TMFXQ\Actions\QueueStatusFinder;
use App\Modules\TMFXQ\Actions\TmsNumUserClearedByDate;
use App\Modules\TMFXQ\View\ChangeStatus;
use App\Modules\TMFXQ\View\context_menu\QueueRandomCheckContextMenu;
use App\QueueRootStatus;
use App\QueueStatus;
use App\QueueType;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class QueueRandomCheckController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        $queue_cache_manager=new QueueCacheManager();
        $queue_cache_obj=$queue_cache_manager->getRandomRow();
        $dashboard_id=$queue_cache_manager->getDashboardId($queue_cache_obj);
        try {
            $dashboard_tss_manager=new DashboardTssManager();
            $last_dashboard_tss = $dashboard_tss_manager->getLastDashboardTss($dashboard_id);
            if ($last_dashboard_tss) {
                $queue_status_data = (new QueueStatusFinder())->run(
                    $last_dashboard_tss->cipostatus_status_formalized_id,
                    $last_dashboard_tss->dashboard_global_status_id
                );

                $tss_description = $dashboard_tss_manager->getFilteredTssDescription($last_dashboard_tss);

                $dashboard_tss_id = $dashboard_tss_manager->getTssId($last_dashboard_tss);

                $tm_data=$queue_cache_manager->getJson($queue_cache_obj);

                $context_menu=new QueueRandomCheckContextMenu($dashboard_id,$queue_status_data->id);

                $change_status=new ChangeStatus($queue_status_data->type);

                $today=Carbon::today();
                $tomorrow=Carbon::tomorrow();
                $tmfsales_id=Auth::user()->ID;
                $tms_cleared_today=(new TmsNumUserClearedByDate($today,$tomorrow,$tmfsales_id))->run();

                $current_tmfsales_id=$tmfsales_id;
                $today_leader_info=(new QueueRandomCheckerDayLeader($today))->run();
//                dd($today_leader_info);
                $all_time_record=(new QueueRandomCheckerAllTimeLeader())->run();

                return view('tmfxq::random-check.index',
                    compact('queue_status_data',
                        'tss_description',
                        'dashboard_tss_id',
                        'dashboard_id',
                        'tm_data',
                        'context_menu',
                        'change_status',
                        'tms_cleared_today',
                    'today_leader_info',
                    'current_tmfsales_id',
                    'all_time_record'
                    )
                );
            } else
                return $this->returnErrorMessage("dashboard_id: $dashboard_id does not have tss!");
        }catch (\Throwable $e){
            Log::error($e);
            return $this->returnErrorMessage("dashboard_id:$dashboard_id<br/>".$e->getMessage());
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function loadTmData(Request $request){
        $queue_cache_manager=new QueueCacheManager();
        $json=$queue_cache_manager->getJsonByDashboardId($request->dashboard_id);
        $tm_data=json_decode($json,true);
        return response()->json($tm_data);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|string
     * @throws \Throwable
     */
    public function loadQueueStatus(Request $request){
        $dashboard_tss_manager=new DashboardTssManager();
        $last_dashboard_tss = $dashboard_tss_manager->getLastDashboardTss($request->dashboard_id);
        if ($last_dashboard_tss) {
            $queue_status_data = (new QueueStatusFinder())->run(
                $last_dashboard_tss->cipostatus_status_formalized_id,
                $last_dashboard_tss->dashboard_global_status_id
            );
            $result=[
                'current_queue_status_id'=>$queue_status_data->id,
                'current_queue_root_status_id'=>$queue_status_data->queueRootStatus->id,
                'html'=>view('tmfxq::random-check.queue-status-block',
                    compact('queue_status_data'))
                    ->render()
            ];
            return response()->json($result);
        }
        return '';
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|string
     */
    public function loadContextMenu(Request $request){
        $dashboard_tss_manager=new DashboardTssManager();
        $last_dashboard_tss = $dashboard_tss_manager->getLastDashboardTss($request->dashboard_id);
        if ($last_dashboard_tss) {
            $queue_status_data = (new QueueStatusFinder())->run(
                $last_dashboard_tss->cipostatus_status_formalized_id,
                $last_dashboard_tss->dashboard_global_status_id
            );
            $context_menu=new QueueRandomCheckContextMenu($request->dashboard_id,$queue_status_data->id);
            return $context_menu->getHtml();
        }
        return '';
    }


    /**
     * @param Request $request
     * @return string
     */
    public function loadTss(Request $request){
        $dashboard_tss_manager=new DashboardTssManager();
        $last_dashboard_tss = $dashboard_tss_manager->getLastDashboardTss($request->dashboard_id);
        return $dashboard_tss_manager->getFilteredTssDescription($last_dashboard_tss);
    }

    /**
     * @param Request $request
     * @return string
     */
    public function saveAllGoodCondition(Request $request){
        $dashboard_manager=new DashboardV2Manager();
        $dashboard_manager->saveAllGoodCondition(
            $request->dashboard_id,
            Auth::user()->ID,
            $request->status
        );
        $queue_status_change_log_creator=new QueueStatusChangeLogCreator(
            $request->dashboard_id,
            Auth::user()->ID,
            $request->queue_status_id,
            $request->queue_status_id
        );
        $queue_status_change_log_creator->run();
        return 'Done';
    }

    private function returnErrorMessage($message){
        return response($message,500);
    }

    /**
     * @param Request $request
     * @return string
     */
    public function newStatusNote(Request $request){
        $queue_type=QueueType::find($request->queue_type_id);
        $queue_root_status=QueueRootStatus::find($request->queue_root_status_id);
        $queue_status=QueueStatus::find($request->queue_status_id);
        $status=sprintf('%s > %s > %s',
            $queue_type->name,
            $queue_root_status->name,
            $queue_status->name
        );
        $dashboard_manager=new DashboardV2Manager();
        $dashboard_manager->addChangedStatusNote(
            $request->dashboard_id,
            Auth::user()->ID,
            $status
        );

        $queue_status_change_log_creator=new QueueStatusChangeLogCreator(
            $request->dashboard_id,
            Auth::user()->ID,
            $request->current_queue_status_id,
            $request->queue_status_id
        );
        $queue_status_change_log_creator->run();
        return 'Done';
    }
}
