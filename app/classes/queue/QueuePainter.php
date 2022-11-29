<?php
namespace App\classes\queue;


use App\DashboardTssTemplate;
use App\QueueStatus;

class QueuePainter
{
//    protected $init_method;


/*    public static function tmfFilingQueuePainter(){
        return new TmfFilingQueuePainter();
    }
    public static function tmfRegQueuePainter(){
        return new TmfRegQueuePainter();
    }*/

    public function accordion($queue_type_id){
        return (new QueueAccordionPainter($queue_type_id))->run();
    }

    public function tssOptions($queue_id){
        $queue_status=QueueStatus::find($queue_id);
        if($queue_status->dashboard_global_status_id==1) {
            $obj = TssOptionsGenerator::cipostatusTssOptionsGenerator();
            $id=$queue_status->cipostatus_status_formalized_id;
        }else{
            $obj=TssOptionsGenerator::globalStatusTssOptionsGenerator();
            $id=$queue_status->dashboard_global_status_id;
        }
        return $obj->get($id);
    }

    public function tssTemplateId($queue_id){
        $queue_status=QueueStatus::find($queue_id);
        if($queue_status->dashboard_global_status_id==1) {
            $id = $queue_status->cipostatus_status_formalized_id;
            $dashboard_tss_template=DashboardTssTemplate::where('cipostatus_status_formalized_id',$id)
                ->orderById()
                ->first();
        }else {
            $id = $queue_status->dashboard_global_status_id;
            $dashboard_tss_template=DashboardTssTemplate::where('dashboard_global_status_id',$id)
                ->orderById()
                ->first();
        }
        return $dashboard_tss_template->id;
    }

    public function applyStatusUrl(){
        return '/change-queue-status/apply-new-queue-status';
    }
}