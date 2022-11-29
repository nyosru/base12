<?php
namespace App\classes\queue;


use App\DashboardOwner;
use App\DashboardTss;
use App\DashboardV2;
use App\QueueStatus;
use Carbon\Carbon;

class QueueTmHistory
{
    protected $dashboard;
    protected $queue_root_status_id;

    public function __construct($dashboard_id,$queue_root_status_id)
    {
        $this->dashboard=DashboardV2::find($dashboard_id);
        $this->queue_root_status_id=$queue_root_status_id;
    }

    protected function getQueueStatus(DashboardTss $dashboard_tss)
    {
        if($dashboard_tss->dashboard_global_status_id==1){
            $obj=QueueStatus::where('dashboard_global_status_id',$dashboard_tss->dashboard_global_status_id)
                ->where('cipostatus_status_formalized_id',$dashboard_tss->cipostatus_status_formalized_id)
                ->where('queue_root_status_id',$this->queue_root_status_id)
                ->first();
        }else
            $obj=QueueStatus::where('dashboard_global_status_id',$dashboard_tss->dashboard_global_status_id)
                ->where('queue_root_status_id',$this->queue_root_status_id)
                ->first();
        return $obj;
    }
    /**
     * Returns array of statuses for dashboard mark
     * throws Exception if dashboard row does not have linked mark
     *
     * @return array
     * @throws \Exception
     */
    public function get()
    {
        $result=[];
        $result[]=[
            'status'=>(new TmFirstStatus($this->dashboard))->get(),
            'owners-history'=>null
        ];

        $dashboard_tss_objs=$this->dashboard->dashboardTsses()->orderBy('created_at')->get();
        $last_index=$dashboard_tss_objs->count()-1;
        foreach ($dashboard_tss_objs as $index=>$dashboard_tss){
            $new_status=new QueueStatusData();
            $new_status->setIcon('<i class="fas fa-arrow-circle-right"></i>');
            $queue_status=$this->getQueueStatus($dashboard_tss);
            if($queue_status) {
                $new_status->setName($queue_status->name);
                $new_status->setDatetime($dashboard_tss->created_at);
                $from_date=Carbon::createFromFormat('Y-m-d H:i:s',$dashboard_tss->created_at);
                if($index<$last_index)
                    $to_date=Carbon::createFromFormat('Y-m-d H:i:s',$dashboard_tss_objs[$index+1]->created_at);
                else
                    $to_date=null;

                $result[]=[
                    'status'=>$new_status,
                    'owners-history'=>$this->getDashboardOwners($this->dashboard->id,$from_date,$to_date)
                ];
            }
        }
        return $result;
    }

    protected function getDashboardOwners($dashboard_id,Carbon $from_date,Carbon $to_date=null){
        return DashboardOwner::where('dashboard_id',$dashboard_id)
            ->where(function ($query) use ($from_date,$to_date) {
                $query->where('created_at','>=',$from_date->format('Y-m-d H:i:s'));
                if(!is_null($to_date))
                    $query->where('released_at','<=',$to_date->format('Y-m-d H:i:s'));
            })
            ->get();

    }
}