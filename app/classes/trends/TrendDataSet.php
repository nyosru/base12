<?php
namespace App\classes\trends;


class TrendDataSet
{
    private $snapshot_loader_obj;
    private $data;
    private $trend_obj;

    public function __construct(TrendPeriods $obj,$ops_snapshot_title_id)
    {
        $this->snapshot_loader_obj=new SnapshotDataLoader($ops_snapshot_title_id);
        $this->trend_obj=$obj;
        $this->loadData();
    }

    private function loadData(){
        $this->data=[
            'avg_nums'=>[],
            'avg_days'=>[]
        ];
        foreach ($this->trend_obj->getPeriods() as $period) {
            $index=$period['from']->format('Y-m-d').'-'.$period['to']->format('Y-m-d');
            $objs=$this->snapshot_loader_obj->run($period['from'],$period['to']);
            if($objs && $objs->count()){
                $this->data['avg_nums'][$index] = $objs->avg_nums;
                $this->data['avg_days'][$index] = $objs->avg_days;
            }else{
                $this->data['avg_nums'][$index] = 0;
                $this->data['avg_days'][$index] = 0;
            }
        }
    }

    public function getNumsData(){
        $this->data['avg_nums'];
    }

    public function getDaysData(){
        $this->data['avg_days'];
    }
}