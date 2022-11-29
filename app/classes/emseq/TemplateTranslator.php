<?php
namespace App\classes\emseq;

use Vinkla\Hashids\Facades\Hashids;

class TemplateTranslator
{
    private $email_seq_obj;

    public function __construct($email_seq_obj)
    {
        $this->email_seq_obj=$email_seq_obj;
    }

    public function get(){
        $hash=Hashids::encode($this->email_seq_obj->id);
        $tmf_subject=$this->email_seq_obj->tmfSubject;

        $firstname=$tmf_subject->first_name;
        $template=$this->email_seq_obj->emailsSeqTemplate->template;
        $template=str_replace('%%%firstname%%%',$firstname,$template);
        $template=str_replace('%%%hashid%%%',$hash,$template);
        $pixel=sprintf('<img src="https://trademarkfactory.com/p/emseqph/%s"/>',$hash);
        $template=str_replace('%%%pixel%%%',$pixel,$template);
        return $template;
    }

}