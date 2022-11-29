<?php
namespace App\classes\tenthings;

use Vinkla\Hashids\Facades\Hashids;

class TemplateTranslator
{
    private $ten_things_emails_seq_obj;

    public function __construct($ten_things_emails_seq_obj)
    {
        $this->ten_things_emails_seq_obj=$ten_things_emails_seq_obj;
    }

    public function get(){
        $hash=Hashids::encode($this->ten_things_emails_seq_obj->id);
        $firstname=$this->ten_things_emails_seq_obj->tenThingsEbookRequest->firstname;
        $template=$this->ten_things_emails_seq_obj->tenThingsEmail->template;
        $template=str_replace('%%%firstname%%%',$firstname,$template);
        $template=str_replace('%%%ttconfirmationcodehashid%%%',$hash,$template);
        $pixel=sprintf('<img src="https://trademarkfactory.com/p/tthph/%s"/>',$hash);
        $template=str_replace('%%%pixel%%%',$pixel,$template);
        return $template;
    }

}