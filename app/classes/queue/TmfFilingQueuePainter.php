<?php
namespace App\classes\queue;


use App\DashboardTssTemplate;
use App\TmfFilingQueueStatus;

class TmfFilingQueuePainter extends QueuePainter
{

    protected function __construct()
    {
        $this->init_method='tmfFilingQueuePainter';
    }

    function accordion()
    {
        return QueueAccordionPainter::tmfFilingQueueAccordionPainter()->run($this->init_method);
    }

    function tssOptions($queue_id)
    {
        $tmf_filing_queue_status=TmfFilingQueueStatus::find($queue_id);
        if($tmf_filing_queue_status->dashboard_global_status_id==1) {
            $obj = TssOptionsGenerator::cipostatusTssOptionsGenerator();
            $id=$tmf_filing_queue_status->cipostatus_status_formalized_id;
        }else{
            $obj=TssOptionsGenerator::globalStatusTssOptionsGenerator();
            $id=$tmf_filing_queue_status->dashboard_global_status_id;
        }
        return $obj->get($id);

    }

    function applyStatusUrl()
    {
        return '/change-queue-status/apply-new-tmf-filing-queue-status';
    }

    public function tssTemplateId($queue_id)
    {
        $tmf_filing_queue_status=TmfFilingQueueStatus::find($queue_id);
        if($tmf_filing_queue_status->dashboard_global_status_id==1) {
            $id = $tmf_filing_queue_status->cipostatus_status_formalized_id;
            $dashboard_tss_template=DashboardTssTemplate::where('cipostatus_status_formalized_id',$id)
                ->orderById()
                ->first();
        }else{
            $id = $tmf_filing_queue_status->dashboard_global_status_id;
            $dashboard_tss_template=DashboardTssTemplate::where('dashboard_global_status_id',$id)
                ->orderById()
                ->first();
        }
        return $dashboard_tss_template->id;
    }
}