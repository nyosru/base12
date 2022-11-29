<?php
namespace App\classes\pqfollowup;

use App\PrequalifyRequest;
use Vinkla\Hashids\Facades\Hashids;

class TemplateTranslator
{
    private $pq_follow_up_emails_seq_obj;

    public function __construct($pq_follow_up_emails_seq_obj)
    {
        $this->pq_follow_up_emails_seq_obj=$pq_follow_up_emails_seq_obj;
    }

    public function get(){
        $hash=Hashids::encode($this->pq_follow_up_emails_seq_obj->id);
        $firstname=$this->pq_follow_up_emails_seq_obj->tmfSubject->first_name;
        $template=$this->pq_follow_up_emails_seq_obj->pqFollowUpEmail->template;
        $template=str_replace('%%%Client_First_Name%%%',$firstname,$template);
        $template=str_replace('%%%hashid%%%',$hash,$template);
        $pixel=sprintf('<img src="https://trademarkfactory.com/p/pqph/%s"/>',$hash);
        $template=str_replace('%%%pixel%%%',$pixel,$template);
        $prequalify_request=PrequalifyRequest::where('tmf_subject_id',$this->pq_follow_up_emails_seq_obj->tmf_subject_id)
            ->orderBy('id','desc')
            ->first();
        if($prequalify_request) {
            $tmoffer=$prequalify_request->tmoffer;
            if($tmoffer) {
                $template=str_replace('%%%confirmationcode%%%',$tmoffer->ConfirmationCode,$template);
                return $template;
            }
        }

        return '';
    }

}