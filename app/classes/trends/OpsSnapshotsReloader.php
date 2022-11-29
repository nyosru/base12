<?php
namespace App\classes\trends;


use App\OpsSnapshot;
use App\OpsSnapshotDashboardV2;
use Illuminate\Support\Facades\DB;

class OpsSnapshotsReloader
{
    private $dashboard_id;

    public function __construct($dashboard_id)
    {
        $this->dashboard_id=$dashboard_id;
    }

    public function run($active_flag){
        $objs=OpsSnapshotDashboardV2::where('dashboard_v2_id',$this->dashboard_id)->get();
        foreach ($objs as $obj){
            $ops_snapshot=$obj->opsSnapshot;
            $obj->active=$active_flag;
            $obj->save();
            $this->recalculateOpsSnapshotValue($ops_snapshot);
        }
    }

    private function recalculateOpsSnapshotValue(OpsSnapshot $ops_snapshot){
        $obj=OpsSnapshotDashboardV2::select(DB::raw('round(AVG(value),2) as avg_value'))
            ->where('ops_snapshot_id',$ops_snapshot->id)
            ->where('value','>',-1)
            ->where('active',1)
            ->first();

        if($obj && $obj->avg_value) {
            $ops_snapshot->value = $obj->avg_value;
            $ops_snapshot->save();
        }
    }
}