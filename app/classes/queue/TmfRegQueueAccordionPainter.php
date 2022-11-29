<?php
namespace App\classes\queue;


class TmfRegQueueAccordionPainter extends QueueAccordionPainter
{

    public function run($init_method)
    {
        return view('common-queue.tmf-reg-queue-accordion',compact('init_method'));
    }
}