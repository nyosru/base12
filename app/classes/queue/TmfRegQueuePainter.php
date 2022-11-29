<?php
namespace App\classes\queue;


use App\TmfRegQueueStatus;

class TmfRegQueuePainter extends QueuePainter
{

    protected function __construct()
    {
        $this->init_method='tmfRegQueuePainter';
    }

    function accordion()
    {
        return QueueAccordionPainter::tmfRegQueueAccordionPainter()->run($this->init_method);
    }

    function tssOptions($queue_id)
    {
        $tmf_reg_queue_status=TmfRegQueueStatus::find($queue_id);
        if($tmf_reg_queue_status->dashboard_global_status_id==1) {
            $obj = TssOptionsGenerator::cipostatusTssOptionsGenerator();
            $id=$tmf_reg_queue_status->cipostatus_status_formalized_id;
        }else{
            $obj=TssOptionsGenerator::globalStatusTssOptionsGenerator();
            $id=$tmf_reg_queue_status->dashboard_global_status_id;
        }
        return $obj->get($id);
    }

    function applyStatusUrl()
    {
        return '/change-queue-status/apply-new-tmf-reg-queue-status';
    }

    public function tssTemplateId($queue_id)
    {
        $tmf_reg_queue_status=TmfRegQueueStatus::find($queue_id);
        if($tmf_reg_queue_status->dashboard_global_status_id==1) {
            $id = $tmf_reg_queue_status->cipostatus_status_formalized_id;
            $dashboard_tss_template=DashboardTssTemplate::where('cipostatus_status_formalized_id',$id)
                ->orderById()
                ->first();
        }else {
            $id = $tmf_reg_queue_status->dashboard_global_status_id;
            $dashboard_tss_template=DashboardTssTemplate::where('dashboard_global_status_id',$id)
                ->orderById()
                ->first();
        }
        return $dashboard_tss_template->id;
    }

}