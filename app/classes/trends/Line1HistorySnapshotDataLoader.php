<?php
namespace App\classes\trends;


use App\DashboardTss;
use App\DashboardV2;
use App\TmfCountryTrademark;

class Line1HistorySnapshotDataLoader extends HistorySnapshotDataLoader
{
    
    protected function initData()
    {
        $this->dashboard_details_data=[];
        $this->calculateDashboardIds(375);
    }

    protected function calculateDashboardIds($cipostatus_status_formalized_id){
        if($cipostatus_status_formalized_id==375)
            $local_dashboard_objs=DashboardV2::where('cipostatus_status_formalized_id',
                $cipostatus_status_formalized_id)
                ->where([
                    ['created_at','>=',$this->from_date->format('Y-m-d H:i:s')],
                    ['created_at','<=',$this->to_date->format('Y-m-d H:i:s')]
                ])
                ->where([
                    ['dashboard_global_status_id',1],
                    ['ready_status',1],
//                    ['dashboard_in_timings_type_id',1],
                ])
                ->whereNull('deleted_at')
                ->whereIn('tmf_country_trademark_id',
                    TmfCountryTrademark::select('id')->whereIn('tmf_country_id',$this->countries))
                ->get();
        else
            $local_dashboard_objs=DashboardV2::where('cipostatus_status_formalized_id',
                $cipostatus_status_formalized_id)
                ->where([
                    ['formalized_status_modified_at','>=',$this->from_date->format('Y-m-d H:i:s')],
                    ['formalized_status_modified_at','<=',$this->to_date->format('Y-m-d H:i:s')]
                ])
                ->where([
                    ['dashboard_global_status_id',1],
                    ['ready_status',1],
//                    ['dashboard_in_timings_type_id',1],
                ])
                ->whereNull('deleted_at')
                ->whereIn('tmf_country_trademark_id',
                    TmfCountryTrademark::select('id')->whereIn('tmf_country_id',$this->countries))
                ->get();

        $this->dashboard_ids=[];
        foreach ($local_dashboard_objs as $el) {
            if($el->dashboard_in_timings_type_id==1)
                $this->dashboard_ids[] = $el->id;
            $dashboard_details_data=new DashboardDetailsData();
            $dashboard_details_data->dashboard_id=$el->id;
            $dashboard_details_data->dashboard_tm=$this->getDashboardTM($el);
            if($cipostatus_status_formalized_id==375)
                $dashboard_details_data->date=new \DateTime($el->created_at);
            else
                $dashboard_details_data->date=new \DateTime($el->formalized_status_modified_at);
            $this->dashboard_details_data[]=$dashboard_details_data;
        }

        if(count($this->dashboard_ids))
            $dasboard_ids_from_tss=DashboardTss::select('dashboard_id')
                ->distinct()
                ->whereNotIn('dashboard_id',$this->dashboard_ids)
                ->whereIn('dashboard_id',
                    DashboardV2::select('id')
//                        ->where('dashboard_in_timings_type_id',1)
                        ->whereIn('tmf_country_trademark_id',
                            TmfCountryTrademark::select('id')
                                ->whereIn('tmf_country_id',$this->countries)
                        )
                )
                ->where('cipostatus_status_formalized_id',$cipostatus_status_formalized_id)
                ->where([
                    ['created_at','>=',$this->from_date->format('Y-m-d H:i:s')],
                    ['created_at','<=',$this->to_date->format('Y-m-d H:i:s')]
                ])
                ->get();
        else
            $dasboard_ids_from_tss=DashboardTss::select('dashboard_id')
                ->distinct()
                ->whereIn('dashboard_id',
                    DashboardV2::select('id')
//                        ->where('dashboard_in_timings_type_id',1)
                        ->whereIn('tmf_country_trademark_id',
                            TmfCountryTrademark::select('id')->whereIn('tmf_country_id',$this->countries)
                        )
                )
                ->where('cipostatus_status_formalized_id',$cipostatus_status_formalized_id)
                ->where([
                    ['created_at','>=',$this->from_date->format('Y-m-d H:i:s')],
                    ['created_at','<=',$this->to_date->format('Y-m-d H:i:s')]
                ])
                ->get();

        foreach ($dasboard_ids_from_tss as $el) {
            $dashboard_obj=DashboardV2::find($el->dashboard_id);
            if($dashboard_obj->dashboard_in_timings_type_id==1)
                $this->dashboard_ids[] = $el->dashboard_id;
            $dashboard_details_data=new DashboardDetailsData();
            $dashboard_details_data->dashboard_id=$el->dashboard_id;
            $dashboard_details_data->dashboard_tm=$this->getDashboardTM($el->dashboard);
            $dashboard_tss=DashboardTss::where('dashboard_id',$el->dashboard_id)
                ->where('cipostatus_status_formalized_id',$cipostatus_status_formalized_id)
                ->where([
                    ['created_at','>=',$this->from_date->format('Y-m-d H:i:s')],
                    ['created_at','<=',$this->to_date->format('Y-m-d H:i:s')]
                ])
                ->orderBy('id','desc')
                ->first();

            $dashboard_details_data->date=new \DateTime($dashboard_tss->created_at);
            $this->dashboard_details_data[]=$dashboard_details_data;
        }

        $this->value=count($this->dashboard_ids);
    }

    public function showDetails()
    {
        return view('ops-trends.details.line1',[
            'dashboard_details_data'=>$this->dashboard_details_data,
            'dashboard_in_timings_type_objs'=>$this->dashboard_in_timings_type_objs
        ]);
    }
}