<?php
namespace App\classes\trends;


use App\classes\opsreport\HistorySnapshotStatusInfo;
use App\DashboardV2;
use App\OpsSnapshot;
use App\OpsSnapshotDashboardV2;
use Illuminate\Support\Facades\DB;

class Line5HistorySnapshotDataLoader extends HistorySnapshotDataLoader
{

    protected function initData()
    {
        $this->calculateValue(29);
    }

    public function loadHistoryValue(){
        $cipostatus_status_formalized_id=378;
        $date=clone $this->from_date;
        $numbers=[];
        $interval=\DateInterval::createFromDateString('+ 1 day');
        do{
            $to_date=new \DateTime((clone $date)->format('Y-m-d').' 23:59:59');
            $obj=new HistorySnapshotStatusInfo([$cipostatus_status_formalized_id],$this->countries,$to_date);
            $numbers[]=$obj->getNumber();
            $this->dashboard_ids=array_merge($this->dashboard_ids,$obj->getIds());
            $this->dashboard_details_data=array_merge($this->dashboard_details_data,$obj->getDashboardDetailsData());
            $date->add($interval);
        }while($date->format('Y-m-d')<=$this->to_date->format('Y-m-d'));
        if(count($numbers))
            $this->value=round(array_sum($numbers)/count($numbers),2);
        else
            $this->value=0;
    }

    protected function calculateValue($ops_snapshot_title_id){
        $ops_snapshot_obj=OpsSnapshot::select(DB::raw('round(AVG(value),2) as avg_value'))
            ->where('value','>','-1')
            ->where('ops_snapshot_title_id',$ops_snapshot_title_id)
            ->where('ops_snapshot_country_preset_id',$this->ops_snapshot_country_preset->id)
            ->where([
                ['snapshot_date','>=',$this->from_date->format('Y-m-d')],
                ['snapshot_date','<=',$this->to_date->format('Y-m-d')],
            ])
            ->first();

        if($ops_snapshot_obj)
            $this->value=$ops_snapshot_obj->avg_value;
        else
            $this->value=0;
    }

    protected function reloadDashboardDetailsData($ops_snapshot_title_id){
        $this->dashboard_details_data=[];
        $objs=OpsSnapshotDashboardV2::whereIn('ops_snapshot_id',
            OpsSnapshot::select('id')
                ->where('value','>','-1')
                ->where('ops_snapshot_title_id',$ops_snapshot_title_id)
                ->where('ops_snapshot_country_preset_id',$this->ops_snapshot_country_preset->id)
                ->where([
                    ['snapshot_date','>=',$this->from_date->format('Y-m-d')],
                    ['snapshot_date','<=',$this->to_date->format('Y-m-d')],
                ])
        )->get();
        if($objs && $objs->count())
            foreach ($objs as $obj) {
                $dashboard_details_data = new DashboardDetailsData();
                $dashboard_details_data->dashboard_id = $obj->dashboard_v2_id;
                $dashboard_details_data->dashboard_tm = $this->getDashboardTM($obj->dashboard);
                $dashboard_details_data->date = new \DateTime($obj->dashboard_status_date);
                $dashboard_details_data->current_date = new \DateTime($obj->opsSnapshot->snapshot_date);
                $dashboard_details_data->value = $obj->value;
                $this->dashboard_details_data[] = $dashboard_details_data;
            }
    }

    public function showDetails()
    {
        $ops_snapshot_title_id=29;
        $this->reloadDashboardDetailsData($ops_snapshot_title_id);
        $data=[];
        foreach ($this->dashboard_details_data as $el){
            $date_text=$el->current_date->format('Y-m-d');
            if(!isset($data[$date_text]))
                $data[$date_text]=[];
            $data[$date_text][]=$el;
        }
        $table_header_template='ops-trends.details.line5-header';
        $dashboard_in_timings_type_objs=$this->dashboard_in_timings_type_objs;
        return view('ops-trends.details.line5',
            compact('data','table_header_template','dashboard_in_timings_type_objs'));
    }
}