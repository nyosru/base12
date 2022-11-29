<?php

namespace App\classes\pqfollowup;


use App\PqFollowUpEmail;
use App\PqFollowUpEmailsSeq;
use App\PrequalifyRequest;
use App\TmfEvent;
use App\Tmfsales;

class PqFollowUpEmailsSeqCreator
{
    public function run(PrequalifyRequest $prequalify_request_obj)
    {
        if ($prequalify_request_obj->lead_status_id == 9) {
            $this->createFlowchart($prequalify_request_obj->tmoffer->ID);
        } else {
            $pq_follow_up_email_objs = PqFollowUpEmail::where('lead_status_id', $prequalify_request_obj->lead_status_id)
                ->orderBy('id', 'asc')
                ->get();
            if ($pq_follow_up_email_objs && $pq_follow_up_email_objs->count())
                $this->createPqFollowUpEmailSeq($pq_follow_up_email_objs, $prequalify_request_obj->tmf_subject_id);
        }

    }

    private function createPqFollowUpEmailSeq($pq_follow_up_email_objs, $tmf_subject_id)
    {
        $pq_follow_up_emails_seq_objs = PqFollowUpEmailsSeq::where('tmf_subject_id', $tmf_subject_id);
        if ($pq_follow_up_emails_seq_objs->count() == 0) {
            $today = new \DateTime();
            foreach ($pq_follow_up_email_objs as $pq_follow_up_email_obj) {
                $interval = \DateInterval::createFromDateString($pq_follow_up_email_obj->tth_interval);
                $today->add($interval);
                $pq_follow_up_emails_seq = new PqFollowUpEmailsSeq();
                $pq_follow_up_emails_seq->tmf_subject_id=$tmf_subject_id;
                $pq_follow_up_emails_seq->pq_follow_up_email_id=$pq_follow_up_email_obj->id;
                $pq_follow_up_emails_seq->scheduled_at=$today->format('Y-m-d H:i:s');
                $pq_follow_up_emails_seq->save();
            }
        }
    }

    private function createFlowchart($tmoffer_id)
    {

        $tmfsales=Tmfsales::find(1);
        $auth = base64_encode($tmfsales->Login.":".$tmfsales->passw);
        $arrContextOptions=array(
            "ssl"=>array(
                "verify_peer"=>false,
                "verify_peer_name"=>false,
            ),
            "http" => [
                "header" => "Authorization: Basic $auth"
            ]
        );
        $url=sprintf('https://trademarkfactory.com/mlcclients/run-flowchart-from-client-paid-after-consultation-call.php?tmoffer_id=%d',$tmoffer_id);
        file_get_contents($url,false,stream_context_create($arrContextOptions));
        $this->changeEventTime($tmoffer_id);
    }

    private function changeEventTime($tmoffer_id){
        $tmf_event=TmfEvent::where('tmf_event_table','tmoffer')
            ->where('tmf_event_table_index_field_value',$tmoffer_id)
            ->where('tmf_event_disable',0)
            ->orderBy('id','desc')
            ->first();
        if($tmf_event){
            $today = new \DateTime();
            $interval = \DateInterval::createFromDateString('1 minute');
            $today->add($interval);
            $tmf_event->tmf_event_datetime=$today->format('Y-m-d H:i:s');
            $tmf_event->save();
        }
    }
}