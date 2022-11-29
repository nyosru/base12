<?php
namespace App\classes\queue;


use App\DashboardTssTemplate;

class GlobalStatusTssOptionsGenerator extends TssOptionsGenerator
{

    public function get($status_id)
    {
        $dashboard_tss_template_objs=DashboardTssTemplate::where('dashboard_global_status_id',$status_id)
            ->orderBy('order_f','asc')
            ->get();
        return view('common-queue.tss-options',compact('dashboard_tss_template_objs'));
    }
}