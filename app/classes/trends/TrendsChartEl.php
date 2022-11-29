<?php
namespace App\classes\trends;


use App\OpsSnapshotTitle;

class TrendsChartEl
{
    private $ops_snapshot_title_obj;
    private $index;

    private function __construct(OpsSnapshotTitle $ops_snapshot_title_obj)
    {
        $this->ops_snapshot_title_obj=$ops_snapshot_title_obj;
    }

    private function setIndex($index){
        $this->index=$index;
    }

    public function getCaption(){
        return $this->ops_snapshot_title_obj->name;
    }

    public function getOpsSnapshotTitleId(){
        return $this->ops_snapshot_title_obj->id;
    }

    public static function initAvgDaysTrendsChartEl(OpsSnapshotTitle $ops_snapshot_title_obj){
        $obj=new self($ops_snapshot_title_obj);
        $obj->setIndex('avg_days');
        return $obj;
    }

    public static function initAvgNumsTrendsChartEl(OpsSnapshotTitle $ops_snapshot_title_obj){
        $obj=new self($ops_snapshot_title_obj);
        $obj->setIndex('avg_nums');
        return $obj;
    }

    public function getValue($ops_snapshot_loader_data){
        $val=$ops_snapshot_loader_data->{$this->index};
        return (is_null($val)?0:round($val,2));
    }
}