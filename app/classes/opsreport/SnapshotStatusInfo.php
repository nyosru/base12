<?php

namespace App\classes\opsreport;


use App\DashboardV2;
use App\TmfCountryTrademark;

class SnapshotStatusInfo
{
    private $dashboard_objs;
    private $cipostatus_status_formalized_ids;
    private $counties;

    public function __construct($cipostatus_status_formalized_ids, $countries)
    {
        $this->counties = $countries;
        $this->cipostatus_status_formalized_ids = $cipostatus_status_formalized_ids;
        $this->dashboard_objs = DashboardV2::whereIn('cipostatus_status_formalized_id', $cipostatus_status_formalized_ids)
            ->where([
                ['dashboard_global_status_id', 1],
                ['ready_status', 1],
            ])
            ->whereNull('deleted_at')
            ->whereIn('tmf_country_trademark_id', TmfCountryTrademark::select('id')->whereIn('tmf_country_id', $countries));
    }

    public function getNumber()
    {
        return (clone $this->dashboard_objs)->where('dashboard_in_timings_type_id',1)->count();
    }

    public function getUnfilteredNumber()
    {
        return $this->dashboard_objs->count();
    }

    public function getIds()
    {
        return (clone $this->dashboard_objs)->select('id')->get()->toArray();
    }

    public function getAverageDays()
    {
        $diff_arr = [];
        $today = new \DateTime();
        foreach ($this->dashboard_objs->get() as $el)
            if ($el->dashboard_in_timings_type_id == 1) {
                if ($el->formalized_status_modified_at == '0000-00-00 00:00:00')
                    $date = new \DateTime($el->created_at);
                else
                    $date = new \DateTime($el->formalized_status_modified_at);
//            echo "today:{$today->format('Y-m-d H:i:s')} date:{$date->format('Y-m-d H:i:s')}<br/>";
//            echo "today_ts:{$today->getTimestamp()} date_ts:{$date->getTimestamp()}<br/>";
                $diff = $today->getTimestamp() - $date->getTimestamp();
//            echo $diff.'<br/>';
                $diff_arr[] = round($diff / (24 * 3600), 2);
            }
//        dd($diff_arr);
        if (count($diff_arr))
            return round(array_sum($diff_arr) / count($diff_arr), 2);
        else
            return 'N/A';
    }
}