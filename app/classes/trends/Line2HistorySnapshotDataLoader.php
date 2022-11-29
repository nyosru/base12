<?php
namespace App\classes\trends;


use App\DashboardTss;
use App\DashboardV2;
use App\TmfCountryTrademark;
use Illuminate\Support\Facades\DB;

class Line2HistorySnapshotDataLoader extends HistorySnapshotDataLoader
{

    protected function initData()
    {
        $cipostatus_status_formalized_id=375;
        $dashboard_tss=DashboardTss::whereIn('dashboard_id',
            DashboardV2::select('id')
//                ->where('dashboard_in_timings_type_id',1)
                ->whereIn('tmf_country_trademark_id',
                    TmfCountryTrademark::select('id')->whereIn('tmf_country_id',$this->countries)
                )
        )
            ->where(DB::raw('getPrevDashboardTssCipostatusStatusFormalizedId(id)'),'=',$cipostatus_status_formalized_id)
            ->where([
                ['created_at','>=',$this->from_date->format('Y-m-d H:i:s')],
                ['created_at','<=',$this->to_date->format('Y-m-d H:i:s')]
            ])
            ->get();

        $days=[];
        foreach ($dashboard_tss as $el){
//            if(!in_array($el->dashboard_id,$this->dashboard_ids))
            $dashboard_obj=DashboardV2::find($el->dashboard_id);
            if($dashboard_obj->dashboard_in_timings_type_id==1)
                $this->dashboard_ids[]=$el->dashboard_id;
            $dashboard_details_data=new DashboardDetailsData();
            $dashboard_details_data->dashboard_id=$el->dashboard_id;
            $dashboard_details_data->dashboard_tm=$this->getDashboardTM($el->dashboard);
            $dashboard_tss=DashboardTss::where('dashboard_id',$el->dashboard_id)
                ->where(DB::raw('getPrevDashboardTssCipostatusStatusFormalizedId(id)'),'=',$cipostatus_status_formalized_id)
                ->where([
                    ['created_at','>=',$this->from_date->format('Y-m-d H:i:s')],
                    ['created_at','<=',$this->to_date->format('Y-m-d H:i:s')]
                ])
                ->orderBy('id','desc')
                ->first();
            if($dashboard_tss)
                $dashboard_details_data->date=new \DateTime($dashboard_tss->created_at);
            else
                $dashboard_details_data->date='N/A';

            $prev_dashboard_tss=$this->getPrevDashboardTss($el);
//            echo "dashboard_tss_id:{$el->id}<br/>";

            if($prev_dashboard_tss){
//                dd($prev_dashboard_tss->toArray());
                $last_date=new \DateTime($el->created_at);
                $prev_date=new \DateTime($prev_dashboard_tss->created_at);
                $diff=$last_date->getTimestamp()-$prev_date->getTimestamp();
                $local_days=round($diff/(24 * 3600),2);
                if($dashboard_obj->dashboard_in_timings_type_id==1)
                    $days[]=$local_days;
                $dashboard_details_data->value=$local_days;
            }else
                $dashboard_details_data->value='N/A';
            $this->dashboard_details_data[]=$dashboard_details_data;
//            exit;
        }
//        dd($this->dashboard_ids);
//        dd($days);
        if(count($days))
            $this->value=round(array_sum($days)/count($days),2);
        else
            $this->value=0;
    }

    private function getPrevDashboardTss($dashboard_tss){
        return DashboardTss::where('dashboard_id',$dashboard_tss->dashboard_id)
            ->where('id','<',$dashboard_tss->id)
            ->orderBy('id','desc')
            ->first();
    }

    public function showDetails()
    {
        return view('ops-trends.details.line2',[
            'dashboard_details_data'=>$this->dashboard_details_data,
            'dashboard_in_timings_type_objs'=>$this->dashboard_in_timings_type_objs
        ]);
    }
}