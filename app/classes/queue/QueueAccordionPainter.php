<?php
namespace App\classes\queue;


class QueueAccordionPainter
{
    private $queue_type_id;

    public function __construct($queue_type_id)
    {
        $this->queue_type_id=$queue_type_id;
    }

/*    public static function tmfFilingQueueAccordionPainter(){
        return new TmfFilingQueueAccordionPainter();
    }

    public static function tmfRegQueueAccordionPainter(){
        return new TmfRegQueueAccordionPainter();
    }*/

    public function run(){
        return view('common-queue.queue-accordion',['queue_type_id'=>$this->queue_type_id]);
    }
}