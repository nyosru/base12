<?php

namespace App\Console\Commands;

use App\classes\opsreport\HistorySnapshotLoader;
use App\classes\trends\OpsSnapshotsReloader;
use App\DashboardV2;
use App\OpsSnapshotDashboardV2;
use Illuminate\Console\Command;

class LoadSnapshots extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:loadsnapshots';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Load history snapshots from dashboard. Do not run this command without Vitaly!';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $el=OpsSnapshotDashboardV2::first();
        $data=[];
        $flag=1;
        do{
            $all_objs=OpsSnapshotDashboardV2::where('value',$el->value)
                ->where('dashboard_status_date',$el->dashboard_status_date)
                ->where('ops_snapshot_id',$el->ops_snapshot_id)
                ->where('dashboard_v2_id',$el->dashboard_v2_id)
                ->where('active',$el->active)
                ->get();
            if($all_objs->count()>1)
                $data[]=$all_objs[0]->id;
            $el=OpsSnapshotDashboardV2::where('id',$el->id)->orderBy('id','asc')->first();
            if(!$el)
                $flag=0;
        }while($flag);
        var_dump($data);
        exit;
        $today=\DateTime::createFromFormat('Y-m-d','2021-02-05');
        $date=\DateTime::createFromFormat('Y-m-d','2021-01-10');
        $interval=\DateInterval::createFromDateString('+ 1 day');
        $start=time();
        do{
            $date->add($interval);
            $obj=new HistorySnapshotLoader($date);
            $obj->run();
            echo $date->format('Y-m-d H:i:s')."\r\n";
        }while($date->format('Y-m-d')<$today->format('Y-m-d'));
        echo "DONE:".(time()-$start);
    }
}
