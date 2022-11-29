<?php
namespace App\classes\opsreport;


use App\classes\trends\DashboardDetailsData;
use App\DashboardTss;
use App\DashboardV2;
use App\TmfCountryTrademark;
use Illuminate\Support\Facades\DB;

class HistorySnapshotStatusInfo
{
    private $dashboard_ids;
    protected $dashboard_details_data=[];
    private $days;

    public function __construct($cipostatus_status_formalized_ids,$countries,\DateTime $to_date)
    {

//        $test_dids=[13951,13952];
        if(in_array(375,$cipostatus_status_formalized_ids))
            $local_dashboard_objs=DashboardV2::whereIn('cipostatus_status_formalized_id',$cipostatus_status_formalized_ids)
                ->where([
                    ['created_at','<=',$to_date->format('Y-m-d H:i:s')],
                ])
                ->where([
                    ['dashboard_global_status_id',1],
                    ['ready_status',1],
                ])
                ->whereNull('deleted_at')
                ->whereIn('tmf_country_trademark_id',TmfCountryTrademark::select('id')->whereIn('tmf_country_id',$countries))
                ->get();
        else
            $local_dashboard_objs=DashboardV2::whereIn('cipostatus_status_formalized_id',$cipostatus_status_formalized_ids)
            ->where([
                ['formalized_status_modified_at','<=',$to_date->format('Y-m-d H:i:s')],
            ])
            ->where([
                ['dashboard_global_status_id',1],
                ['ready_status',1],
            ])
//                ->whereNotIn('id',$test_dids)
            ->whereNull('deleted_at')
            ->whereIn('tmf_country_trademark_id',TmfCountryTrademark::select('id')->whereIn('tmf_country_id',$countries))
            ->get();

        $this->dashboard_ids=[];
        $this->dashboard_details_data=[];
        foreach ($local_dashboard_objs as $el) {
            if(in_array(375,$cipostatus_status_formalized_ids))
                $date=new \DateTime($el->created_at);
            else {
                $dashboard_tss=DashboardTss::where('dashboard_id',$el->id)
                    ->whereIn('cipostatus_status_formalized_id',$cipostatus_status_formalized_ids)
                    ->orderBy('id','asc')
                    ->first();
                if($dashboard_tss) {
                    if($dashboard_tss->created_at<=$to_date->format('Y-m-d H:i:s'))
                        $date = new \DateTime($dashboard_tss->created_at);
                    else
                        continue;
                }else
                    $date = new \DateTime($el->formalized_status_modified_at);
            }
            $this->dashboard_ids[] = $el->id;
            $diff=$to_date->getTimestamp()-$date->getTimestamp();
            $local_days=round($diff/(24 * 3600),2);
            $this->days[]=$local_days;

//            $this->dashboard_ids[]=$el->dashboard_id;
            $dashboard_details_data=new DashboardDetailsData();
            $dashboard_details_data->dashboard_id=$el->id;
            $dashboard_details_data->dashboard_tm=$this->getDashboardTM($el);
            $dashboard_details_data->date=new \DateTime($el->formalized_status_modified_at);
            $dashboard_details_data->current_date=$to_date;
            $dashboard_details_data->value=$local_days;
            $this->dashboard_details_data[]=$dashboard_details_data;
        }

//        if($to_date->format('Y-m-d')=='2020-08-23')
//            dd($this->dashboard_ids);

        if(count($this->dashboard_ids))
            $dasboard_ids_from_tss=DashboardTss::select('dashboard_id')
                ->distinct()
                ->whereNotIn('dashboard_id',$this->dashboard_ids)
//                ->whereNotIn('dashboard_id',$test_dids)
                ->whereIn('dashboard_id',DashboardV2::select('id')->whereIn('tmf_country_trademark_id',TmfCountryTrademark::select('id')->whereIn('tmf_country_id',$countries)))
                ->whereIn('cipostatus_status_formalized_id',$cipostatus_status_formalized_ids)
                ->where('created_at','<=',$to_date->format('Y-m-d H:i:s'))
                ->where(DB::raw('getNextDashboardTssCreatedAt(id)'),'>',$to_date->format('Y-m-d H:i:s'))
                ->get();
        else
            $dasboard_ids_from_tss=DashboardTss::select('dashboard_id')
                ->distinct()
//                ->whereNotIn('dashboard_id',$test_dids)
                ->whereIn('dashboard_id',DashboardV2::select('id')->whereIn('tmf_country_trademark_id',TmfCountryTrademark::select('id')->whereIn('tmf_country_id',$countries)))
                ->whereIn('cipostatus_status_formalized_id',$cipostatus_status_formalized_ids)
                ->where('created_at','<=',$to_date->format('Y-m-d H:i:s'))
                ->where(DB::raw('getNextDashboardTssCreatedAt(id)'),'>',$to_date->format('Y-m-d H:i:s'))
                ->get();

        foreach ($dasboard_ids_from_tss as $el) {
            $dashboard_tss=DashboardTss::where('dashboard_id',$el->dashboard_id)
                ->whereIn('cipostatus_status_formalized_id',$cipostatus_status_formalized_ids)
                ->orderBy('id','asc')
                ->first();
            $date=new \DateTime($dashboard_tss->created_at);
            $diff=$to_date->getTimestamp()-$date->getTimestamp();
            if($diff<0)
                continue;

            $dashboard_details_data=new DashboardDetailsData();
            $dashboard_details_data->dashboard_id=$el->dashboard_id;
            $dashboard_details_data->dashboard_tm=$this->getDashboardTM($el->dashboard);
            $dashboard_details_data->date=new \DateTime($dashboard_tss->created_at);
            $dashboard_details_data->current_date=$to_date;
            $local_days=round($diff/(24 * 3600),2);
            $dashboard_details_data->value=$local_days;
            $this->days[]=$local_days;
            $this->dashboard_ids[] = $el->dashboard_id;
            $this->dashboard_details_data[]=$dashboard_details_data;
        }
    }

    public function getNumber(){
        return count($this->dashboard_ids);
    }

    public function getAvgDays(){
        if($this->days)
            return array_sum($this->days)/count($this->days);
        return -1;
    }

    public function getIds(){
        return $this->dashboard_ids;
    }

    public function getDashboardDetailsData(){
        return $this->dashboard_details_data;
    }

    protected function getDashboardTM($dashboard_obj)
    {
        $tmf_trademark = $dashboard_obj->tmfCountryTrademark->tmfTrademark;
        $tmf_country = $dashboard_obj->tmfCountryTrademark->tmfCountry;
        $mark = $tmf_trademark->tmf_trademark_mark;
        if ($tmf_trademark->tmf_trademark_type_id == 1)
            $mark=sprintf('<img src="https://trademarkfactory.imgix.net/offerimages/%s" style="max-width: 100px;max-height: 75px;"/>',$mark);
        return sprintf('<img src="https://trademarkfactory.imgix.net/img/countries/%s" style="width: 20px;height: 12px;"> %s',$tmf_country->tmf_country_flag,$mark);
    }


    /*    public function getAverageDays(){
            $diff_arr=[];
            $today=new \DateTime();
            foreach ($this->dashboard_objs->get() as $el){
                if($el->formalized_status_modified_at=='0000-00-00 00:00:00')
                    $date=new \DateTime($el->created_at);
                else
                    $date=new \DateTime($el->formalized_status_modified_at);
                $diff=$today->getTimestamp()-$date->getTimestamp();
                $diff_arr[]=round($diff/(24 * 3600),2);
            }
            if(count($diff_arr))
                return round(array_sum($diff_arr)/count($diff_arr),2);
            else
                return 'N/A';
        }*/
}