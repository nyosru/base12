<?php

namespace App\Http\Controllers;

use App\TmfConditionTmfsalesTmoffer;
use App\TmofferBin;
use Illuminate\Http\Request;

class SearcherStatController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    private function formattedTime($delta)
    {
        $d = intval($delta / (24 * 3600));
        $h = intval($delta % (24 * 3600) / 3600);
        $m = intval($delta % (24 * 3600) % 3600 / 60);
        $s = intval($delta % (24 * 3600) % 3600 % 60);
        return sprintf('%sd %sh %sm %ss', $d, $h, $m, $s);
    }


    public function index()
    {
        $tmoffer_bin_objs=TmofferBin::where('need_capture',0)->where('modified_at','>=','2020-12-01 00:00:00')->get();
        $min_val=0;
        $max_val=0;
        $average=0;
        $delta_data=[];

        $boom_data=[];
        $release_data=[];
        $pub_data=[];
        for($i=0;$i<25;$i++){
            $boom_data[$i]=0;
            $release_data[$i]=0;
            $pub_data[$i]=0;
        }

        foreach($tmoffer_bin_objs as $index=>$tmoffer_bin_obj){
            $boom_data[intval(\DateTime::createFromFormat('Y-m-d H:i:s',$tmoffer_bin_obj->modified_at)->format('H'))]++;
            $end_action_id=5;
            $end_info=TmfConditionTmfsalesTmoffer::where('tmf_condition_id',$end_action_id)->where('tmfsales_id',71)->where('tmoffer_id',$tmoffer_bin_obj->tmoffer_id)->first();
            if($end_info)
                $release_data[intval(\DateTime::createFromFormat('Y-m-d H:i:s',$end_info->when_date)->format('H'))]++;
            $pub_info=TmfConditionTmfsalesTmoffer::where('tmf_condition_id',7)->where('tmoffer_id',$tmoffer_bin_obj->tmoffer_id)->first();
            if($pub_info)
                $pub_data[intval(\DateTime::createFromFormat('Y-m-d H:i:s',$pub_info->when_date)->format('H'))]++;
        }

        echo '<table style="border-collapse: collapse">';
        echo '<tr><th style="border:1px solid black;">Period</th><th  style="border:1px solid black;">Booms,%</th><th  style="border:1px solid black;">Releases,%</th><th  style="border:1px solid black;">Published,%</th></tr>';
        for($i=0;$i<24;$i++){
            echo '<tr>';
            echo "<td style=\"border:1px solid black;\">$i - ".($i+1)."</td>";
            echo "<td style=\"border:1px solid black;\">".round($boom_data[$i]*100/array_sum($boom_data),2)."</td>";
            echo "<td style=\"border:1px solid black;\">".round($release_data[$i]*100/array_sum($release_data),2)."</td>";
            echo "<td style=\"border:1px solid black;\">".round($pub_data[$i]*100/array_sum($pub_data),2)."</td>";
            echo '</tr>';
        }
        echo '</table>';
        echo "<hr/>";

        $delta_count=[
            '36'=>0,
            '24'=>0,
            '18'=>0,
            '12'=>0,
            '8'=>0,
            '6'=>0,
            '4'=>0,
            '2'=>0,
        ];
        $dc_keys=array_keys($delta_count);
        foreach($tmoffer_bin_objs as $index=>$tmoffer_bin_obj){

            $end_action_id=5;
            $end_info=TmfConditionTmfsalesTmoffer::where('tmf_condition_id',$end_action_id)->where('tmfsales_id',71)->where('tmoffer_id',$tmoffer_bin_obj->tmoffer_id)->first();
//            $end_info=TmfConditionTmfsalesTmoffer::where('tmf_condition_id',$end_action_id)->where('tmoffer_id',$tmoffer_bin_obj->tmoffer_id)->first();
//            $tmf_aftersearches=TmfAftersearches::where('tmoffer_id',$tmoffer_bin_obj->tmoffer_id)->first();
            if($end_info /*&& !$tmf_aftersearches*/){
                $delta = strtotime($end_info->when_date) - strtotime($tmoffer_bin_obj->modified_at);
//                echo "tmoffer_id:{$tmoffer_bin_obj->tmoffer_id} delta:".$this->formattedTime($delta).'<br/>';
//                if($delta<0)
//                    echo "tmoffer_id:{$tmoffer_bin_obj->tmoffer_id}<br/>";
                /*        if($index==0)
                            $min_val=$max_val=$delta;
                        else{
                            if($delta>$max_val)
                                $max_val=$delta;
                            if($delta<$min_val)
                                $min_val=$delta;
                        }*/
                if($delta>0)
                    $delta_data[]=$delta;

                for($k=0;$k<count($delta_count);$k++){
                    if($delta<intval($dc_keys[$k])*3600)
                        $delta_count[$dc_keys[$k]]++;
                }
            }
        }

        sort($delta_data);
        $min=$this->formattedTime($delta_data[0]);
        $max=$this->formattedTime($delta_data[count($delta_data)-1]);
        $average=$this->formattedTime(array_sum($delta_data)/count($delta_data));
        echo "min: $min<br/>max: $max<br/>average: $average<br/>";
        foreach ($delta_count as $key=>$dc_data){
            echo "searches less than {$key}hrs: ".round(100*$dc_data/count($delta_data),2)."%<br/>";
        }

    }
}
