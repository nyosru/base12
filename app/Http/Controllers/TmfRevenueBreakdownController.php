<?php

namespace App\Http\Controllers;

use App\MoneyMlcBoomSource;
use App\MoneyMlcClients;
use App\MoneyMlcClientSource;
use App\MoneyMlcClientType;
use App\MoneyMlcIn;
use App\MoneyMlcPayType;
use Illuminate\Http\Request;
use Auth;

class TmfRevenueBreakdownController extends Controller
{
    private $view_suffix;

    public function __construct()
    {

        $this->middleware(function ($request, $next) {
            if (Auth::user())
                $this->view_suffix = '';
            else
                $this->view_suffix = '-public';

            return $next($request);
        });
    }

    private function getFirstDate()
    {
//        MoneyMlcIn::select('DateReceived')->orderBy('DateReceived')->first();
        return (new \DateTime())->format('Y') . '-01-01';
    }

    private function getLastDate()
    {
//        MoneyMlcIn::select('DateReceived')->orderBy('DateReceived','desc')->first();
        return (new \DateTime())->format('Y-m-d');
    }


    public function index()
    {
//        dd(Auth::user());
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
        for ($i = 2018; $i < 2031; $i++)
            $y_select .= sprintf('<option value="%1$d" %2$s>%1$d</option>', $i, ($i == date('Y') ? 'selected' : ''));
        $y_select .= '</select>';

        $first_date = $this->getFirstDate();
        $last_date = $this->getLastDate();

//        $html=$this->getRawTabHtml('2020-08-01','2020-08-31');

        $pay_type_objs = MoneyMlcPayType::all();
        $filter_modals=view('tmf-revenue-breakdown.filter-modal',[
            'objs'=>$pay_type_objs,
            'filter_modal_name'=>'pay-type-filter-modal',
            'filter_modal_title'=>'Pay Type Filter',
            'filter_class'=>'pay-type-filter-chbx'
        ])->render();

        $clients = MoneyMlcClients::orderBy('Client')->get();

        $client_type_objs = MoneyMlcClientType::all();
        $filter_modals.=view('tmf-revenue-breakdown.filter-modal',[
            'objs'=>$client_type_objs,
            'filter_modal_name'=>'client-type-filter-modal',
            'filter_modal_title'=>'Client Type Filter',
            'filter_class'=>'client-type-filter-chbx'
        ])->render();

        $client_source_objs = MoneyMlcClientSource::all();
        $filter_modals.=view('tmf-revenue-breakdown.filter-modal',[
            'objs'=>$client_source_objs,
            'filter_modal_name'=>'client-source-filter-modal',
            'filter_modal_title'=>'First Sale Source Filter',
            'filter_class'=>'client-source-filter-chbx'
        ])->render();

        $boom_source_objs = MoneyMlcBoomSource::all();
        $filter_modals.=view('tmf-revenue-breakdown.filter-modal',[
            'objs'=>$boom_source_objs,
            'filter_modal_name'=>'boom-source-filter-modal',
            'filter_modal_title'=>'Boom Source Filter',
            'filter_class'=>'boom-source-filter-chbx'
        ])->render();


        $view_suffix = $this->view_suffix;

        $cs_left_column_width = 183;
        $cs_middle_column_width = 579;
        $cs_right_column_width = 442;

        return view('tmf-revenue-breakdown.index',
            compact('months_btns', 'q_btns', 'y_select',
                'first_date', 'last_date', 'pay_type_objs',
                'clients', 'client_type_objs', 'client_source_objs',
                'boom_source_objs', 'view_suffix',
                'cs_left_column_width', 'cs_middle_column_width',
                'cs_right_column_width','filter_modals'
            )
        );
    }

    public function showData(Request $request)
    {
        if ($request->from_date)
            $from_date = $request->from_date;
        else
            $from_date = $request->from_date;

        if ($request->to_date)
            $to_date = $request->to_date;
        else
            $to_date = $this->getLastDate();

        return response()->json([
            'raw-revenues' => $this->getRawTabHtml($from_date, $to_date),
            'pay-type' => $this->getPayTypeTabHtml($from_date, $to_date),
            'client-type' => $this->getClientTypeTabHtml($from_date, $to_date),
            'boom-source' => $this->getBoomSourceTabHtml($from_date, $to_date),
            'client-source' => $this->getClientSourceData($from_date, $to_date)
        ]);
    }

    private function getRawTabHtml($from_date, $to_date)
    {
        $mm_in_objs = MoneyMlcIn::where([
            ['DateReceived', '>=', $from_date],
            ['DateReceived', '<=', $to_date],
        ])
            ->orderBy('DateReceived', 'desc')
            ->get();
        if ($mm_in_objs && $mm_in_objs->count()) {
            return view('tmf-revenue-breakdown.tabs.raw-revenues' . $this->view_suffix,
                compact('mm_in_objs')
            )
                ->render();
        }
        return '<div class="text-center">EMPTY</div>';
    }

    private function getPayTypeTabHtml($from_date, $to_date)
    {
        $mm_in_objs = MoneyMlcIn::where([
            ['DateReceived', '>=', $from_date],
            ['DateReceived', '<=', $to_date],
        ])
            ->orderBy('DateReceived', 'asc')
            ->get();
        $types = MoneyMlcPayType::select('name')->orderBy('id')->get();
        $type_caption='Pay Type';
        $parent_table_name='moneyMlcPayType';
        return $this->getCTBSPTTabHtml($mm_in_objs,$types,$type_caption,$parent_table_name);
    }

    private function getCTBSPTTabHtml($mm_in_objs,$types,$type_caption,$parent_table_name){
        $data = [];
        $data['total'] = [];
        $table_th = [];
        $total_rows = [];
        $total_rows_n = [];
        $total_amount = 0;
        $total_amount_n = 0;
        if ($mm_in_objs && $mm_in_objs->count()) {
            foreach ($mm_in_objs as $mm_in_obj) {

                $client_type_index = $mm_in_obj->$parent_table_name->name;
                $month_index = (new \DateTime($mm_in_obj->DateReceived))->format('M\'y');
                if (!in_array($month_index, $table_th))
                    $table_th[] = $month_index;

                if (!isset($data['total'][$month_index]))
                    $data['total'][$month_index] = [
                        'amount' => 0,
                        'num' => 0
                    ];
                if (!isset($data[$client_type_index])) {
                    $data[$client_type_index] = [];
                    $total_rows[$client_type_index] = 0;
                    $total_rows_n[$client_type_index] = 0;
                }
                if (!isset($data[$client_type_index][$month_index])) {
                    $data[$client_type_index][$month_index] = [
                        'amount' => 0,
                        'num' => 0
                    ];
                }
                $total_amount += $mm_in_obj->GrossAmount;
                $total_rows[$client_type_index] += $mm_in_obj->GrossAmount;
                $data[$client_type_index][$month_index]['amount'] += $mm_in_obj->GrossAmount;
                $data[$client_type_index][$month_index]['num']++;
                $total_rows_n[$client_type_index]++;
                $total_amount_n++;
                $data['total'][$month_index]['amount'] += $mm_in_obj->GrossAmount;
                $data['total'][$month_index]['num']++;
            }

            return view('tmf-revenue-breakdown.tabs.ct-bs-pt' . $this->view_suffix,
                compact('data', 'table_th',
                    'types', 'total_rows',
                    'total_rows_n', 'total_amount', 'total_amount_n','type_caption')
            )
                ->render();
        }
        return '<div class="text-center">EMPTY</div>';

    }


    private function getClientTypeTabHtml($from_date, $to_date)
    {
        $mm_in_objs = MoneyMlcIn::where([
            ['DateReceived', '>=', $from_date],
            ['DateReceived', '<=', $to_date],
        ])
            ->orderBy('DateReceived', 'asc')
            ->get();
        $types = MoneyMlcClientType::select('name')->orderBy('id')->get();
        $type_caption='Client Type';
        $parent_table_name='moneyMlcClientType';
        return $this->getCTBSPTTabHtml($mm_in_objs,$types,$type_caption,$parent_table_name);
    }

    private function getBoomSourceTabHtml($from_date, $to_date)
    {
        $mm_in_objs = MoneyMlcIn::where([
            ['DateReceived', '>=', $from_date],
            ['DateReceived', '<=', $to_date],
        ])
            ->orderBy('DateReceived', 'asc')
            ->get();
        $types = MoneyMlcBoomSource::select('name')->orderBy('id')->get();
        $type_caption='Boom Source';
        $parent_table_name='moneyMlcBoomSource';
        return $this->getCTBSPTTabHtml($mm_in_objs,$types,$type_caption,$parent_table_name);
    }

    private function getFirstReceivedDateByMoneyMlcClientsId($money_mlc_clients_id)
    {
        $obj = MoneyMlcClients::where('money_mlc_clients_id', $money_mlc_clients_id)
            ->orderBy('DateReceived', 'asc')
            ->first();
        return \DateTime::createFromFormat('Y-m-d',$obj->DateReceived);
    }

    private function getClientSourceData($from_date, $to_date)
    {
        $mm_in_objs = MoneyMlcIn::join('money_mlc_clients','money_mlc_in.money_mlc_clients_id','money_mlc_clients.id')
            ->where([
                ['DateReceived', '>=', $from_date],
                ['DateReceived', '<=', $to_date],
            ])
//            ->orderBy('money_mlc_clients.money_mlc_client_source_id', 'asc')
            ->orderBy('DateReceived', 'asc')
            ->get();
        
        $data = [];
        $total_data=[];
        $client_sources = MoneyMlcClientSource::select('name')->orderBy('id')->get();
        foreach ($client_sources as $client_source){
            $client_source_index = $client_source->name;
            if (!isset($data[$client_source_index]))
                $data[$client_source_index] = [];
        }
        $periods=[];
        $u_clients_ids=[];
        if ($mm_in_objs && $mm_in_objs->count()) {
            foreach ($mm_in_objs as $mm_in_obj) {
                $client_source_index = $mm_in_obj->moneyMlcClient->moneyMlcClientSource->name;
                $month_index = (new \DateTime($mm_in_obj->DateReceived))->format('M\'y');
                if(!in_array($month_index,$periods))
                    $periods[]=$month_index;
                if(!isset($u_clients_ids[$month_index]))
                    $u_clients_ids[$month_index]=[];

                if (!isset($data[$client_source_index][$month_index])) {
                    if($this->view_suffix=='-public')
                        $data[$client_source_index][$month_index] = [
                            'n1' => ['count' => 0],
                            'n2' => ['count' => 0],
                            'r1' => ['count' => 0],
                            'r2' => ['count' => 0],
                            'u' => ['count' => 0],
                            'consultation' => ['count' => 0],
                            'others' => ['count' => 0],
                        ];
                    else
                        $data[$client_source_index][$month_index] = [
                            'n1' => ['amount' => 0, 'count' => 0],
                            'n2' => ['amount' => 0, 'count' => 0],
                            'r1' => ['amount' => 0, 'count' => 0],
                            'r2' => ['amount' => 0, 'count' => 0],
                            'u' => ['amount' => 0, 'count' => 0],
                            'consultation' => ['amount' => 0, 'count' => 0],
                            'others' => ['amount' => 0, 'count' => 0],
                        ];
                }

                if (!isset($total_data[$month_index])) {
                    if($this->view_suffix=='-public')
                        $total_data[$month_index] = [
                            'n1' => [ 'count' => 0],
                            'n2' => [ 'count' => 0],
                            'r1' => [ 'count' => 0],
                            'r2' => [ 'count' => 0],
                            'u' => [ 'count' => 0],
                            'uid' => [],
                            'consultation' => [ 'count' => 0],
                            'others' => [ 'count' => 0],
                        ];
                    else
                        $total_data[$month_index] = [
                            'n1' => ['amount' => 0, 'count' => 0],
                            'n2' => ['amount' => 0, 'count' => 0],
                            'r1' => ['amount' => 0, 'count' => 0],
                            'r2' => ['amount' => 0, 'count' => 0],
                            'u' => ['amount' => 0, 'count' => 0],
                            'uid' => [],
                            'consultation' => ['amount' => 0, 'count' => 0],
                            'others' => ['amount' => 0, 'count' => 0],
                        ];
                }

                if ($mm_in_obj->money_mlc_pay_type_id == 4)
                    $data_key = 'consultation';
                else {
                    switch ($mm_in_obj->money_mlc_client_type_id){
                        case 1:
                            $data_key = $this->getIndexCount('n',$mm_in_obj->money_mlc_pay_type_id);
                            break;
                        case 2:
                            $data_key = $this->getIndexCount('r',$mm_in_obj->money_mlc_pay_type_id);
                            break;
                        default:
                            $data_key = 'others';
                            break;
                    }
                }

                if($this->view_suffix!='-public')
                    $data[$client_source_index][$month_index][$data_key]['amount']+=$mm_in_obj->GrossAmount;
                $data[$client_source_index][$month_index][$data_key]['count']++;
                if($this->view_suffix!='-public')
                    $total_data[$month_index][$data_key]['amount']+=$mm_in_obj->GrossAmount;
                if(!in_array($mm_in_obj->money_mlc_clients_id,$u_clients_ids[$month_index]) &&
                !in_array($data_key,['consultation','others'])){
                    $u_clients_ids[$month_index][]=$mm_in_obj->money_mlc_clients_id;
                    $total_data[$month_index]['u']['count']++;
                    $total_data[$month_index]['uid'][]=$mm_in_obj->money_mlc_clients_id;
                }
                $total_data[$month_index][$data_key]['count']++;
            }
        }
        return compact('periods','data','total_data');
    }

    private function getIndexCount($data_key,$pay_type_id){
        switch ($pay_type_id) {
            case 1:
                return $data_key.'1';
            case 2:
                return $data_key.'2';
        }
        return 'others';
    }

    public function saveRrTypes(Request $request){
        $obj=MoneyMlcIn::find($request->id);
        if($obj){
            $obj->money_mlc_pay_type_id=$request->pay_type_id;
            $obj->money_mlc_client_type_id=$request->client_type_id;
            $obj->money_mlc_boom_source_id=$request->boom_source_id;
            $obj->save();
            $money_mlc_client=$obj->moneyMlcClient;
            $money_mlc_client->money_mlc_client_source_id=$request->client_source_id;
            $money_mlc_client->save();
            return 'Saved';
        }
        return '';
    }
}
