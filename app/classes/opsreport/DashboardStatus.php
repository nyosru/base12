<?php

namespace App\classes\opsreport;


class DashboardStatus
{
    public $cipostatus_status_formalized_ids=[];
    public $dashboard_global_status_ids=[];

    public function __construct($cipostatus_status_formalized_ids,$dashboard_global_status_ids)
    {
        $this->cipostatus_status_formalized_ids=$cipostatus_status_formalized_ids;
        $this->dashboard_global_status_ids=$dashboard_global_status_ids;
    }

    public static function init($cipostatus_status_formalized_ids,$dashboard_global_status_ids){
        return new self($cipostatus_status_formalized_ids,$dashboard_global_status_ids);
    }
}