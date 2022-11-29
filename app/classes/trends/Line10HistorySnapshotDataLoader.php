<?php
namespace App\classes\trends;


use App\classes\opsreport\HistorySnapshotStatusInfo;

class Line10HistorySnapshotDataLoader extends Line7HistorySnapshotDataLoader
{

    protected function initData()
    {
        $this->calculateValue(34);
    }

    public function loadHistoryValue(){
        $cipostatus_status_formalized_id=381;
        $date=clone $this->from_date;
        $days=[];
        $interval=\DateInterval::createFromDateString('+ 1 day');
        do{
            $to_date=new \DateTime((clone $date)->format('Y-m-d').' 23:59:59');
            $obj=new HistorySnapshotStatusInfo([$cipostatus_status_formalized_id],$this->countries,$to_date);
            $result_days=$obj->getAvgDays();
            $days[]=$result_days;
//            echo "date:".$to_date->format('Y-m-d')." days:$result_days<br/>";
            $this->dashboard_ids=array_merge($this->dashboard_ids,$obj->getIds());
            $this->dashboard_details_data=array_merge($this->dashboard_details_data,$obj->getDashboardDetailsData());
            $date->add($interval);
        }while($date->format('Y-m-d')<=$this->to_date->format('Y-m-d'));
//        var_dump($days);
        if(count($days))
            $this->value=round(array_sum($days)/count($days),2);
        else
            $this->value=0;
//        echo "value:{$this->value}";
    }

    public function showDetails()
    {
        $ops_snapshot_title_id=34;
        $this->reloadDashboardDetailsData($ops_snapshot_title_id);
        $data=[];
        foreach ($this->dashboard_details_data as $el){
            $date_text=$el->current_date->format('Y-m-d');
            if(!isset($data[$date_text]))
                $data[$date_text]=[];
            $data[$date_text][]=$el;
        }
//        echo '<pre>';
//        var_dump($data);
//        exit;
        $table_header_template='ops-trends.details.line8-header';
        $dashboard_in_timings_type_objs=$this->dashboard_in_timings_type_objs;
        return view('ops-trends.details.line5',
            compact('data','table_header_template','dashboard_in_timings_type_objs'));
    }

}