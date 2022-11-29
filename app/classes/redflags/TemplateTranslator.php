<?php
namespace App\classes\redflags;

use Vinkla\Hashids\Facades\Hashids;

class TemplateTranslator
{
    private $red_flags_emails_seq_obj;

    public function __construct($red_flags_emails_seq_obj)
    {
        $this->red_flags_emails_seq_obj=$red_flags_emails_seq_obj;
    }

    public function get(){
        $hash=Hashids::encode($this->red_flags_emails_seq_obj->id);
        $firstname=$this->red_flags_emails_seq_obj->redFlagsEbookRequest->firstname;
        $template=$this->red_flags_emails_seq_obj->redFlagsEmail->template;
        $template=str_replace('%%%firstname%%%',$firstname,$template);
        $template=str_replace('%%%rfconfirmationcodehashid%%%',$hash,$template);
        $pixel=sprintf('<img src="https://trademarkfactory.com/p/rfph/%s"/>',$hash);
        $template=str_replace('%%%pixel%%%',$pixel,$template);
        return $template;
    }

}