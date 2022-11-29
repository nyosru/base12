<?php
namespace App\classes\queue;


use App\classes\tsstranslator\TssTemplateVariablesTranslator;

class ChangeStatus
{
    private $show_tss_list;
    private $queue_painter;

    public function __construct($show_tss_list)
    {
        $this->show_tss_list=$show_tss_list;
        $this->queue_painter=new QueuePainter();
    }

    public function getModals($queue_type_id){
        return view('common-queue.modals',[
            'show_tss_list'=>$this->show_tss_list,
            'queue_painter'=>$this->queue_painter,
            'queue_type_id'=>$queue_type_id
        ]);
    }

    public function getJs(){
        $countries_tags = TssTemplateVariablesTranslator::getCountriesTags();
        $tmfsales_tags = TssTemplateVariablesTranslator::getTmfsalesTags();

        return view('common-queue.change-status-js',[
            'show_tss_list'=>$this->show_tss_list,
            'countries_tags'=>$countries_tags,
            'tmfsales_tags'=>$tmfsales_tags,
            'queue_painter'=>$this->queue_painter
        ]);
    }
}