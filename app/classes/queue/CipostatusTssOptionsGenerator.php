<?php
namespace App\classes\queue;


use App\DashboardTssTemplate;

class CipostatusTssOptionsGenerator extends TssOptionsGenerator
{

    public function get($status_id)
    {
        $dashboard_tss_template_objs=DashboardTssTemplate::where('cipostatus_status_formalized_id',$status_id)
            ->orderBy('order_f','asc')
            ->get();
//        echo "status_id:$status_id<br/>";
//        dd($dashboard_tss_template_objs);
        return view('common-queue.tss-options',compact('dashboard_tss_template_objs'));

    }
}