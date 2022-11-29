<?php
namespace App\classes\trends;


use App\OpsSnapshot;
use Illuminate\Support\Facades\DB;

class SnapshotDataLoader
{
    private $ops_snapshot_title_id;
    private $data;

    public function __construct($ops_snapshot_title_id)
    {
        $this->ops_snapshot_title_id=$ops_snapshot_title_id;
    }

    public function run(\DateTime $from_date, \DateTime $to_date){
        $this->data=OpsSnapshot::select(DB::raw('sum(num)/count(id) as avg_nums, sum(avg_days)/count(id) as avg_days'))
            ->where('ops_snapshot_title_id',$this->ops_snapshot_title_id)
            ->where([
                ['snapshot_date','>=',$from_date->format('Y-m-d')],
                ['snapshot_date','<=',$to_date->format('Y-m-d')],
            ])->first();
        return $this;
    }

    public function getData(){
        return $this->data;
    }
}