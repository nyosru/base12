<?php
namespace App\classes\trends;


use App\DashboardTss;
use App\DashboardV2;
use App\TmfCountryTrademark;
use App\Tmoffer;
use App\TmofferBin;
use App\TmofferTmfCountryTrademark;
use Illuminate\Support\Facades\DB;

class Line4HistorySnapshotDataLoader extends HistorySnapshotDataLoader
{

    protected function initData()
    {
        $cipostatus_status_formalized_id=1;
        $dashboard_tss=DashboardTss::whereIn('dashboard_id',
            DashboardV2::select('id')
//                ->where('dashboard_in_timings_type_id',1)
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
                ->where('cipostatus_status_formalized_id',$cipostatus_status_formalized_id)
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


            $prev_dashboard_tss=$this->getPrevDashboardTss($el,375);
            $filed_searching=0;
            if($prev_dashboard_tss){
                $last_date=new \DateTime($el->created_at);
                $prev_date=new \DateTime($prev_dashboard_tss->created_at);
                $filed_searching=$last_date->getTimestamp()-$prev_date->getTimestamp();
            }

            $tmoffer_bin=$this->getTmofferBin($el);
            if($tmoffer_bin){
                $last_date=new \DateTime($el->created_at);
                $prev_date=new \DateTime($tmoffer_bin->modified_at);
                $filed_purchased=$last_date->getTimestamp()-$prev_date->getTimestamp();
                $diff=($filed_purchased>$filed_searching?$filed_searching:$filed_purchased);
            }else
                $diff=$filed_searching;


            $local_days=round($diff/(24 * 3600),2);
            if($dashboard_obj->dashboard_in_timings_type_id==1)
                $days[]=$local_days;
            $dashboard_details_data->value=$local_days;
            $this->dashboard_details_data[]=$dashboard_details_data;
        }
        if(count($days))
            $this->value=round(array_sum($days)/count($days),2);
        else
            $this->value=0;
    }

    private function getPrevDashboardTss($dashboard_tss,$cipostatus_status_formalized_id){
        return DashboardTss::where('dashboard_id',$dashboard_tss->dashboard_id)
            ->where('id','<',$dashboard_tss->id)
            ->where('cipostatus_status_formalized_id',$cipostatus_status_formalized_id)
            ->orderBy('id','desc')
            ->first();
    }

    private function getTmofferBin($dashboard_tss){
        return TmofferBin::whereIn('tmoffer_id',
            TmofferTmfCountryTrademark::select('tmoffer_id')
                ->whereIn('tmf_country_trademark_id',DashboardV2::select('tmf_country_trademark_id')->where('id',$dashboard_tss->dashboard_id))
        )->first();
    }

    public function showDetails()
    {
        $table_header_template='ops-trends.details.line4-header';
        return view('ops-trends.details.line4',[
            'dashboard_details_data'=>$this->dashboard_details_data,
            'table_header_template'=>$table_header_template,
            'dashboard_in_timings_type_objs'=>$this->dashboard_in_timings_type_objs
        ]);
        return '';
    }

}