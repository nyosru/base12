<?php
namespace App\classes\opsreport;


use App\classes\trends\HistorySnapshotDataLoader;
use App\classes\trends\OpsSnapshotsReloader;
use App\DashboardV2;
use App\OpsSnapshot;
use App\OpsSnapshotCountryPreset;
use App\OpsSnapshotDashboardV2;
use App\OpsSnapshotTitle;

class HistorySnapshotLoader
{
    private $date;

    public function __construct(\DateTime $date)
    {
        $this->date=$date;
    }

    public function run(){
        $ops_snapshot_title_objs=OpsSnapshotTitle::whereIn('id',[29,30,31,32,33,34,38,39,40,43])->get();
//        $ops_snapshot_title_objs=OpsSnapshotTitle::whereIn('id',[43])->get();
        $ops_snapshot_country_preset_objs=OpsSnapshotCountryPreset::all();
        $from_date=new \DateTime($this->date->format('Y-m-d').' 00:00:00');
        $to_date=new \DateTime($this->date->format('Y-m-d').' 23:59:59');
        foreach ($ops_snapshot_country_preset_objs as $ops_snapshot_country_preset_obj) {
//            $countries=$ops_snapshot_country_preset_obj->tmfCountries()->pluck('tmf_country.id')->toArray();
            foreach ($ops_snapshot_title_objs as $ops_snapshot_title_obj) {
//                if($ops_snapshot_title_obj->code=='line5') {
                    $static_method = $ops_snapshot_title_obj->code . 'DataLoader';
                    $obj = HistorySnapshotDataLoader::$static_method($ops_snapshot_country_preset_obj, $from_date, $to_date);
                    $obj->loadHistoryValue();
                    $value = $obj->getValue();
                    $ops_snapshot = $this->saveSnapshot($this->date, $value, $ops_snapshot_title_obj->id, $ops_snapshot_country_preset_obj->id);
                    $this->saveOpsSnapshotDashboardV2($obj->getDashboardDetailsData(),$ops_snapshot->id);
//                }
            }
        }
    }

    private function saveOpsSnapshotDashboardV2($dashboard_details_data,$ops_snapshot_id){
        foreach ($dashboard_details_data as $el){
            $obj=new OpsSnapshotDashboardV2();
            $obj->ops_snapshot_id=$ops_snapshot_id;
            $obj->dashboard_v2_id=$el->dashboard_id;
            $obj->dashboard_status_date=$el->date->format('Y-m-d');
            if(strlen($el->value))
                $obj->value=$el->value;
            else
                $obj->value=-1;
            $dashboard=DashboardV2::find($el->dashboard_id);
            if($dashboard->dashboard_in_timings_type_id==1)
                $active=1;
            else
                $active=0;
            $obj->active=($dashboard->dashboard_in_timings_type_id==1?1:0);
            $obj->save();
            (new OpsSnapshotsReloader($dashboard->id))->run($active);
        }
    }

    private function saveSnapshot(\DateTime $date,$value,$ops_snapshot_title_id,$ops_snapshot_country_preset_id){
        $ops_snapshot=new OpsSnapshot();
        $ops_snapshot->snapshot_date=$date->format('Y-m-d H:i:s');
        $ops_snapshot->value=$value;
        $ops_snapshot->ops_snapshot_title_id=$ops_snapshot_title_id;
        $ops_snapshot->ops_snapshot_country_preset_id=$ops_snapshot_country_preset_id;
        $ops_snapshot->save();
        return $ops_snapshot;
    }
}