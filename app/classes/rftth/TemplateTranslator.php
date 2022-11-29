<?php
namespace App\classes\rftth;

use Vinkla\Hashids\Facades\Hashids;

class TemplateTranslator
{
    private $rftth_emails_seq_obj;

    public function __construct($rftth_emails_seq_obj)
    {
        $this->rftth_emails_seq_obj=$rftth_emails_seq_obj;
    }

    public function get(){
        $hash=Hashids::encode($this->rftth_emails_seq_obj->id);
        $tmf_subject=$this->rftth_emails_seq_obj->tmfSubject;

        $firstname=$tmf_subject->first_name;
        $template=$this->rftth_emails_seq_obj->rfTthEmail->template;
        $template=str_replace('%%%firstname%%%',$firstname,$template);
        $template=str_replace('%%%hashid%%%',$hash,$template);
        $pixel=sprintf('<img src="https://trademarkfactory.com/p/rftthph/%s"/>',$hash);
        $template=str_replace('%%%pixel%%%',$pixel,$template);
        return $template;
    }

}