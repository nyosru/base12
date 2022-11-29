<?php
namespace App\classes\queue;


class TmfFilingQueueAccordionPainter extends QueueAccordionPainter
{
    public function run($init_method)
    {
        return view('common-queue.tmf-filing-queue-accordion',compact('init_method'));
    }
}