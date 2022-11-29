<?php

namespace App\Http\Controllers;

use App\ConfirmedTmoffers;
use App\TmfState;
use App\Tmoffer;
use App\TmofferCompanySubject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TmfClientsByCountriesController extends Controller
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

    public function index(){


//        dd($us_cities);
//        dd($us_states);

        $months_btns = '';
        $y = date('Y');
        for ($i = 1; $i < 13; $i++) {
            $from = sprintf('%s-01', ($i > 9 ? $i : '0' . $i));
            $to = date('m-d', strtotime($y . '-' . $from . ' + 1 month - 1 day'));
            $months_btns .= sprintf('<button class="btn btn-sm btn-info month-btn" style="margin-right: 7px;color:white" data-from="%s" data-to="%s">%s</button>',
                $from, $to, $i);
        }

        $q_btns = '';
        for ($i = 1; $i < 5; $i++) {
            $first_q_month = $i * 3 - 2;
            $last_q_month = $i * 3;
            $start = sprintf('%s-01', ($first_q_month > 9 ? $first_q_month : '0' . $first_q_month));
            $end = sprintf('%s-01', ($last_q_month > 9 ? $last_q_month : '0' . $last_q_month));
            $to = date('m-d', strtotime($y . '-' . $end . ' + 1 month - 1 day'));
            $q_btns .= sprintf('<button class="btn btn-sm btn-info q-btn" style="margin-right: 7px;color:white" data-from="%s" data-to="%s">Q%s</button>',
                $start, $to, $i);
        }

        $y_select = '<select id="s-year" class="form-control" style="width: auto;display: inline-block">';
        for ($i = 2014; $i <= date('Y'); $i++)
            $y_select .= sprintf('<option value="%1$d" %2$s>%1$d</option>', $i, ($i == date('Y') ? 'selected' : ''));
        $y_select .= '</select>';

        $result=$this->getResultFromDates(date('Y').'-01-01',date('Y-m-d'));

        return view('tmf-clients-by-countries.index',
            compact('months_btns', 'q_btns', 'y_select','result'));
    }

    private function getResultFromDates($from_date,$to_date){
        $result_countries=[];
        $us_states=[];
        $us_cities=[];
        $can_states=[];
        $can_cities=[];
        $inc=0;
        $used_companies=[];
        try {
            $tmoffers = ConfirmedTmoffers::where([
                ['DateConfirmed','>=',$from_date],
                ['DateConfirmed','<=',$to_date]
            ])->get();
        }catch (\Exception $e){
            echo $e->getMessage();exit;
        }
        foreach ($tmoffers as $tmoffer){
            $tmoffer_company_subject=TmofferCompanySubject::where('tmoffer_id',$tmoffer->ID)->first();
            if($tmoffer_company_subject) {
                if (!$tmoffer_company_subject->tmf_company_id) {
                    echo "tmoffer_id:{$tmoffer->ID} does not have company!<br/>";
                    exit;
                }else{
                    if(!isset($used_companies[$tmoffer_company_subject->tmfCompany->id]))
                        $used_companies[$tmoffer_company_subject->tmfCompany->id]=0;
                    else
                        continue;
                    $used_companies[$tmoffer_company_subject->tmfCompany->id]++;
                    if($tmoffer_company_subject->tmfCompany->country->id==2){
                        if(!isset($us_states[$tmoffer_company_subject->tmfCompany->tmf_state_id]))
                            $us_states[$tmoffer_company_subject->tmfCompany->tmf_state_id]=0;
                        $us_states[$tmoffer_company_subject->tmfCompany->tmf_state_id]++;
                        if(!isset($us_cities[$tmoffer_company_subject->tmfCompany->tmf_state_id]))
                            $us_cities[$tmoffer_company_subject->tmfCompany->tmf_state_id]=[];
                        $city=strtolower($tmoffer_company_subject->tmfCompany->city);
                        if(!isset($us_cities[$tmoffer_company_subject->tmfCompany->tmf_state_id][$city]))
                            $us_cities[$tmoffer_company_subject->tmfCompany->tmf_state_id][$city]=0;
                        $us_cities[$tmoffer_company_subject->tmfCompany->tmf_state_id][$city]++;
                    }
                    elseif($tmoffer_company_subject->tmfCompany->country->id==1){
                        if(!isset($can_states[$tmoffer_company_subject->tmfCompany->tmf_state_id]))
                            $can_states[$tmoffer_company_subject->tmfCompany->tmf_state_id]=0;
                        $can_states[$tmoffer_company_subject->tmfCompany->tmf_state_id]++;
                        if(!isset($can_cities[$tmoffer_company_subject->tmfCompany->tmf_state_id]))
                            $can_cities[$tmoffer_company_subject->tmfCompany->tmf_state_id]=[];
                        $city=strtolower($tmoffer_company_subject->tmfCompany->city);
                        if(!isset($can_cities[$tmoffer_company_subject->tmfCompany->tmf_state_id][$city]))
                            $can_cities[$tmoffer_company_subject->tmfCompany->tmf_state_id][$city]=0;
                        $can_cities[$tmoffer_company_subject->tmfCompany->tmf_state_id][$city]++;
                    }
                    $country_name=$tmoffer_company_subject->tmfCompany->country->Name;
                }
            }else {
                $country_name='Canada';
                $state_id=52;
                if(!isset($can_states[$state_id]))
                    $can_states[$state_id]=0;
                $can_states[$state_id]++;
                if(!isset($can_cities[$state_id]))
                    $can_cities[$state_id]=[];
                $city=strtolower('North Vancouver');
                if(!isset($can_cities[$state_id][$city]))
                    $can_cities[$state_id][$city]=0;
                $can_cities[$state_id][$city]++;
            }
            if(!isset($result_countries[$country_name]))
                $result_countries[$country_name]=0;
            $result_countries[$country_name]++;
        }

//        dd($tmoffers);
//        exit;

        /*        do{
                    $tmoffer=Tmoffer::where('DateConfirmed','!=','0000-00-00')
                        ->orderBy('ID','asc')
                        ->offset($inc)
                        ->first();
                    $inc++;
                    if($tmoffer){
                        $tmoffer_company_subject=TmofferCompanySubject::where('tmoffer_id',$tmoffer->ID)->first();
                        if($tmoffer_company_subject) {
                            if (!$tmoffer_company_subject->tmf_company_id) {
                                echo "tmoffer_id:{$tmoffer->ID} does not have company!<br/>";
                                exit;
                            }else{
                                if(!isset($used_companies[$tmoffer_company_subject->tmfCompany->id]))
                                    $used_companies[$tmoffer_company_subject->tmfCompany->id]=0;
                                else
                                    continue;
                                $used_companies[$tmoffer_company_subject->tmfCompany->id]++;
                                if($tmoffer_company_subject->tmfCompany->country->id==2){
                                    if(!isset($us_states[$tmoffer_company_subject->tmfCompany->tmf_state_id]))
                                        $us_states[$tmoffer_company_subject->tmfCompany->tmf_state_id]=0;
                                    $us_states[$tmoffer_company_subject->tmfCompany->tmf_state_id]++;
                                    if(!isset($us_cities[$tmoffer_company_subject->tmfCompany->tmf_state_id]))
                                        $us_cities[$tmoffer_company_subject->tmfCompany->tmf_state_id]=[];
                                    $city=strtolower($tmoffer_company_subject->tmfCompany->city);
                                    if(!isset($us_cities[$tmoffer_company_subject->tmfCompany->tmf_state_id][$city]))
                                        $us_cities[$tmoffer_company_subject->tmfCompany->tmf_state_id][$city]=0;
                                    $us_cities[$tmoffer_company_subject->tmfCompany->tmf_state_id][$city]++;
                                }elseif($tmoffer_company_subject->tmfCompany->country->id==1){
                                    if(!isset($can_states[$tmoffer_company_subject->tmfCompany->tmf_state_id]))
                                        $can_states[$tmoffer_company_subject->tmfCompany->tmf_state_id]=0;
                                    $can_states[$tmoffer_company_subject->tmfCompany->tmf_state_id]++;
                                    if(!isset($can_cities[$tmoffer_company_subject->tmfCompany->tmf_state_id]))
                                        $can_cities[$tmoffer_company_subject->tmfCompany->tmf_state_id]=[];
                                    $city=strtolower($tmoffer_company_subject->tmfCompany->city);
                                    if(!isset($can_cities[$tmoffer_company_subject->tmfCompany->tmf_state_id][$city]))
                                        $can_cities[$tmoffer_company_subject->tmfCompany->tmf_state_id][$city]=0;
                                    $can_cities[$tmoffer_company_subject->tmfCompany->tmf_state_id][$city]++;
                                }
                                $country_name=$tmoffer_company_subject->tmfCompany->country->Name;
                            }
                        }else {
                            $country_name='Canada';
                            $state_id=52;
                            if(!isset($can_states[$state_id]))
                                $can_states[$state_id]=0;
                            $can_states[$state_id]++;
                            if(!isset($can_cities[$state_id]))
                                $can_cities[$state_id]=[];
                            $city=strtolower('North Vancouver');
                            if(!isset($can_cities[$state_id][$city]))
                                $can_cities[$state_id][$city]=0;
                            $can_cities[$state_id][$city]++;
                        }
                        if(!isset($result_countries[$country_name]))
                            $result_countries[$country_name]=0;
                        $result_countries[$country_name]++;
                    }else
                        break;
                }while(1);*/

        arsort($result_countries);
//        dd($result_countries);
        arsort($us_states);
        arsort($can_states);
//        dd($can_states);
        arsort($can_cities);
        arsort($us_cities);
        foreach ($can_cities as $key=>$el)
            arsort($can_cities[$key]);
        foreach ($us_cities as $key=>$el)
            arsort($us_cities[$key]);

//        dd($can_cities);

        $parent_id='countries';
        $result=[];
        $index=0;
        $total=0;
        foreach($result_countries as $rc_key=>$rc_val){
            $total+=$rc_val;
            $result[$index]=[
                'text'=>$rc_key.': '.$rc_val,
                'id'=>$rc_key,
                'icon'=>false,
                'state'=>['opened'=>false,'disabled'=>false,'selected'=>true],
                //'parent'=>'#',
                'a_attr'=>['style'=>'border:1px solid black;padding:10px;margin-bottom:5px;background-color:#83BBE5'],
                'children'=>[],
            ];
            if($rc_key=='United States of America'){
                $state_index=0;
                foreach($us_states as $state_id=>$us_val){
                    $result[$index]['children'][$state_index]=[
                        'text'=>(strlen($state_id)?TmfState::find($state_id)->tmf_state_name:'UNKNOWN').': '.$us_val,
                        'id'=>md5('us'.(strlen($state_id)?$state_id:'stateNA')),
                        'icon'=>false,
                        'state'=>['opened'=>false,'disabled'=>false,'selected'=>false],
                        //'parent'=>$parent_id,
                        'a_attr'=>['style'=>'border:1px solid black;padding:10px;margin-bottom:5px;background-color:lightblue'],
                        'children'=>[],
                    ];
                    if(isset($us_cities[$state_id])){
                        foreach($us_cities[$state_id] as $uc_key=>$uc_val){
                            $result[$index]['children'][$state_index]['children'][]=[
                                'text'=>(strlen($uc_key)?ucwords($uc_key):'UNKNOWN').': '.$uc_val,
                                'id'=>md5('uck'.(strlen($uc_key)?$uc_key:'cityNA').uniqid()),
                                'icon'=>false,
                                'state'=>['opened'=>false,'disabled'=>false,'selected'=>false],
                                //'parent'=>$parent_id,
                                'a_attr'=>['style'=>'border:1px solid black;padding:10px;margin-bottom:5px;background-color:#F5B5C8'],
                                'children'=>[]
                            ];
                        }
                    }
                    $state_index++;
                }
            }elseif($rc_key=='Canada'){
                $state_index=0;
                foreach($can_states as $state_id=>$can_val){
                    $result[$index]['children'][$state_index]=[
                        'text'=>(strlen($state_id)?TmfState::find($state_id)->tmf_state_name:'UNKNOWN').': '.$can_val,
                        'id'=>md5('can'.(strlen($state_id)?$state_id:'stateNA')),
                        'icon'=>false,
                        'state'=>['opened'=>false,'disabled'=>false,'selected'=>false],
                        //'parent'=>$parent_id,
                        'a_attr'=>['style'=>'border:1px solid black;padding:10px;margin-bottom:5px;background-color:lightblue'],
                        'children'=>[],
                    ];
                    if(isset($can_cities[$state_id])){
                        foreach($can_cities[$state_id] as $cc_key=>$cc_val){
                            $result[$index]['children'][$state_index]['children'][]=[
                                'text'=>(strlen($cc_key)?ucwords($cc_key):'UNKNOWN').': '.$cc_val,
                                'id'=>md5('cck'.(strlen($cc_key)?$cc_key:'cityNA').uniqid()),
                                'icon'=>false,
                                'state'=>['opened'=>false,'disabled'=>false,'selected'=>false],
                                //'parent'=>$parent_id,
                                'a_attr'=>['style'=>'border:1px solid black;padding:10px;margin-bottom:5px;background-color:#F5B5C8'],
                                'children'=>[]
                            ];
                        }
                    }
                    $state_index++;
                }
            }
            $index++;
        }
        return [
            'text'=>'Total clients: '.$total,
            'id'=>'total clients',
            'icon'=>false,
            'state'=>['opened'=>true,'disabled'=>false,'selected'=>true],
            //'parent'=>'#',
            'a_attr'=>['style'=>'border:1px solid black;padding:10px;margin-bottom:5px;background-color:transparent'],
            'children'=>$result,
        ];
    }

    public function showData(Request $request){
        if(!$request->from_date){
            $tmoffer=Tmoffer::where('DateConfirmed','!=','0000-00-00')
                ->orderBy('DateConfirmed','asc')
                ->first();
            $request->from_date=$tmoffer->DateConfirmed;
        }
        if(!$request->to_date){
            $tmoffer=Tmoffer::where('DateConfirmed','!=','0000-00-00')
                ->orderBy('DateConfirmed','desc')
                ->first();
            $request->to_date=$tmoffer->DateConfirmed;
        }
        return response()->json($this->getResultFromDates($request->from_date,$request->to_date));
    }

}
