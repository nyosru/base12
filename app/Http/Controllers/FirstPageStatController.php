<?php

namespace App\Http\Controllers;

use App\classes\clientipdataset\ClientIpDataSet;
use App\classes\clientipdataset\ClientIpDatasetFilter;
use App\classes\ClientIpFirstPage;
use App\TmfBooking;
use App\TmfClientTmsrTmoffer;
use App\Tmoffer;
use App\BlockIp;
use Illuminate\Http\Request;

class FirstPageStatController extends Controller
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
        return '2020-06-12';
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

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
        $filter=new ClientIpDatasetFilter();
        $filter->from_date=$first_date;
        $filter->to_date=$last_date;
        $filter->no_boom=$filter->no_show=$filter->boom=1;
        $client_type='both';
        $data = $this->getFirstPageData($filter,$client_type);

        $result_table=$this->resultTable($this->handleFirstPageData($data));

        return view('first-page-stat.index',
            compact('months_btns', 'q_btns', 'y_select','result_table','first_date','last_date'));

    }

    private function resultTable($data,$render=1){
        if($render)
            return view('first-page-stat.result-table',compact('data'))->render();
        else
            return view('first-page-stat.result-table',compact('data'));
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

        $filter=new ClientIpDatasetFilter();
        $filter->from_date=$from_date;
        $filter->to_date=$to_date;
        $filter->no_boom=$request->no_boom;
        $filter->no_show=$request->no_show;
        $filter->boom=$request->boom;
        $client_type=$request->client_type;
        $data = $this->getFirstPageData($filter,$client_type);
//        var_dump($data);exit;
        return $this->resultTable($this->handleFirstPageData($data),0);
    }

    private function getFirstPageData(ClientIpDatasetFilter $filter,$client_type)
    {
        $data = [];
        $datasets=[];
        switch ($client_type){
            case 'both':
                $datasets=[ClientIpDataSet::initSelfCheckoutIps($filter),ClientIpDataSet::initBookedIps($filter)];
                break;
            case 'self-checkout':
                $datasets=[ClientIpDataSet::initSelfCheckoutIps($filter)];
                break;
            case 'booked':
                $datasets=[ClientIpDataSet::initBookedIps($filter)];
                break;
        }
        $ips=[];
        foreach ($datasets as $dataset)
            $ips=array_merge($ips,$dataset->get());
        $ips=array_unique($ips);
        foreach ($ips as $ip) {
            $cfp_data = (new ClientIpFirstPage($ip))->get();
            $data[] = [
                'md5' => md5(json_encode($cfp_data)),
                'data' => $cfp_data
            ];
        }

        return $data;
    }

    private static function cmp($a, $b)
    {
        if ($a['count'] == $b['count'])
            return 1;
        return ($a['count'] < $b['count'] ? 1 : -1);
    }

    private function hasGparamsInBooking($tmoffer_id)
    {
        $booking = TmfBooking::whereIn('tmf_client_tmsr_tmoffer_id',
            TmfClientTmsrTmoffer::select('id')->where('tmoffer_id', $tmoffer_id))
            ->where('sales_id', '!=', '0')
            ->orderBy('id', 'desc')
            ->first();
        if ($booking && !is_null($booking->gparams))
            return true;
        return false;
    }

    private function handleFirstPageData($data)
    {
        $result = [];

        foreach ($data as $el) {
            if (!isset($result[$el['md5']]))
                $result[$el['md5']] = [
                    'data' => $el['data'],
                    'count' => 0,
                ];
            $result[$el['md5']]['count']++;
        }
//        dd($result);
        usort($result,[__CLASS__,'cmp']);
        return $result;
    }

}
