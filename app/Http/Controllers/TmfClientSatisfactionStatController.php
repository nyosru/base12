<?php

namespace App\Http\Controllers;

use App\TmfSubjectSatisfaction;
use Illuminate\Http\Request;

class TmfClientSatisfactionStatController extends Controller
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

    private function getFirstDate(){
        return '2020-09-04';
    }


    public function index(){
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
        for ($i = 2020; $i < 2031; $i++)
            $y_select .= sprintf('<option value="%1$d" %2$s>%1$d</option>', $i, ($i == date('Y') ? 'selected' : ''));
        $y_select .= '</select>';

        $first_date = $this->getFirstDate();
        $last_date = (new \DateTime())->format('Y-m-d');
        $data=$this->getTSData($first_date,$last_date);
        $result_table=$this->resultTable($data,1);
        return view('tmf-client-satisfaction-stat.index',compact('months_btns','q_btns', 'y_select','result_table','first_date','last_date'));
    }

    private function resultTable($data,$render=1){
        if($render)
            return view('tmf-client-satisfaction-stat.result-table',compact('data'))->render();
        else
            return view('tmf-client-satisfaction-stat.result-table',compact('data'));
    }

    public function showStat(Request $request){
        if($request->from_date)
            $from_date=$request->from_date;
        else
            $from_date=$this->getFirstDate();

        if($request->to_date)
            $to_date=$request->to_date;
        else
            $to_date=(new \DateTime())->format('Y-m-d');

//        var_dump($data);exit;
        $data=$this->getTSData($from_date,$to_date);
        return $this->resultTable($data,0);
    }

    private function getTSData($from_date,$to_date){
        return TmfSubjectSatisfaction::where([
            ['created_at','>=',$from_date.' 00:00:00'],
            ['created_at','<=',$to_date.' 23:59:59']
        ])->get();
    }

}
