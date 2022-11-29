<?php
namespace App\traits;

use App\classes\dashboard\DashboardOwnerManager;
use App\classes\queue\DashboardDataDetails;
use App\DashboardV2;
use App\Events\ReloadSubStatusTms;
use App\Events\ReloadTM;
use App\QueueCache;
use App\QueueRootStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

trait TmfXXXQueueCommon
{
    private $days_select_arr=[3,7,10,14,30];
    private $show_mode='tms';
//    private $show_mode='client';
    private $days;

    public function __construct()
    {
        $this->middleware('auth');
        $this->days=$this->days_select_arr[1];
    }

    private function formattedTime($delta)
    {
        $d = intval($delta / (24 * 3600));
        $h = intval($delta % (24 * 3600) / 3600);
        $m = intval($delta % (24 * 3600) % 3600 / 60);
        $s = intval($delta % (24 * 3600) % 3600 % 60);
        return sprintf('%sd %sh %sm', $d, $h, $m);
    }

    public function loadDashboardNotes(Request $request){

        $dashboard=DashboardV2::find($request->id);
        if($dashboard){
            return $dashboard->notes;
        }
        return '';
    }

    public function saveDashboardNotes(Request $request){
        $dashboard=DashboardV2::find($request->id);
        if($dashboard){
            $dashboard->notes=$request->notes;
            $dashboard->save();
            return 'Done';
        }
        return '';
    }

    public function claim(Request $request){
        $dashboard_owner_manager=new DashboardOwnerManager($request->dashboard_id);
        $dashboard_owner_manager->claim(Auth::user()->ID);
        $this->updateQueueCacheEl($request->dashboard_id);
        event(new ReloadSubStatusTms($request->queue_status_id));
        event(new ReloadTM($request->dashboard_id));
        return 'done';
    }

    public function manualUnclaim(Request $request){
        $dashboard_owner_manager=new DashboardOwnerManager($request->id);
        $dashboard_owner_manager->releaseOwnerFromMark(Auth::user()->ID,2);
        $this->updateQueueCacheEl($request->id);
        event(new ReloadSubStatusTms($request->queue_status_id));
        event(new ReloadTM($request->id));
        return 'DONE';
    }

    public function setClaimedByMeSetting(Request $request){
        session(['review-requested-only'=>0]);
        if($request->flag)
            session(['claimed-by-me'=>Auth::user()->ID]);
        else
            session(['claimed-by-me'=>0]);
        return 'DONE';
    }

    public function setReviewRequestedOnlySetting(Request $request){
        session(['claimed-by-me'=>0]);
        if($request->flag)
            session(['review-requested-only'=>1]);
        else
            session(['review-requested-only'=>0]);
        return 'DONE';
    }

    private function updateQueueCacheEl($dashboard_id){
        $queue_cache=QueueCache::where('dashboard_id',$dashboard_id)->first();
        if(!$queue_cache){
            $queue_cache=new QueueCache();
            $queue_cache->dashboard_id=$dashboard_id;
            $queue_cache->save();
        }
        $dashboard_obj=DashboardV2::find($dashboard_id);
        if(session('queue-type-id')==self::RENEWAL_QUEUE)
            $queue_root_status = QueueRootStatus::where('queue_type_id',session('queue-type-id'))
                ->first();
        else
            $queue_root_status = QueueRootStatus::where('queue_type_id',session('queue-type-id'))
                ->where('name', 'Done')
                ->first();
        $dashboard_data_details_obj=new DashboardDataDetails($dashboard_obj);
        $ldd = $dashboard_data_details_obj->getDashboardData();
        $queue_status = $dashboard_data_details_obj->getDashboardQueueStatus($ldd, $queue_root_status);
        $dashboard_data_details_obj->formattedResultFromDataEl($ldd,$queue_status);
    }

}