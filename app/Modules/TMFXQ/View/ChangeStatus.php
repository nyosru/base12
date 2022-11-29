<?php
namespace App\Modules\TMFXQ\View;


use App\classes\queue\QueuePainter;
use App\classes\tsstranslator\TssTemplateVariablesTranslator;
use App\Modules\TMFXQ\Actions\QueueTypeManager;

class ChangeStatus
{
    private $queue_type_id;

    public function __construct(int $queue_type_id=0)
    {
        $this->queue_type_id=$queue_type_id;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getHtml(){
        $queue_type_manager=new QueueTypeManager();
        $queue_type_rows=$queue_type_manager->getAllRows();
        if($this->queue_type_id==0)
            $this->queue_type_id=$queue_type_rows[0]->id;
        $accordion=$this->getQueueTypeAccordion();
        return view('tmfxq::change-status.modal',[
            'queue_type_rows'=>$queue_type_rows,
            'queue_type_id'=>$this->queue_type_id,
            'accordion'=>$accordion
        ]);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getQueueTypeAccordion(){
        $queue_painter=new QueuePainter();
        return $queue_painter->accordion($this->queue_type_id);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getJs(){
        $countries_tags = TssTemplateVariablesTranslator::getCountriesTags();
        $tmfsales_tags = TssTemplateVariablesTranslator::getTmfsalesTags();

        return view('tmfxq::change-status.js',[
            'show_tss_list'=>1,
            'countries_tags'=>$countries_tags,
            'tmfsales_tags'=>$tmfsales_tags
        ]);
    }
}