<?php

namespace App\Http\Controllers;

use App\classes\askstat\WelcomeAskStat;
use Illuminate\Http\Request;
use App\VisitorLog;
use App\BlockIp;

class WelcomeAskStatController extends Controller
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

        $from_page=[
            'Direct-to-Booking Google Ad',
            '/advisors/g1',
            'Instagram',
            '/advisors/ig',
            'Organic YouTube',
            '/advisors/youtube'
        ];

        if (isset($_SERVER["HTTP_CF_CONNECTING_IP"]))
            $_SERVER['REMOTE_ADDR'] = $_SERVER["HTTP_CF_CONNECTING_IP"];

        $block_ip=BlockIp::where('ip',$_SERVER['REMOTE_ADDR'])->first();
        if(!$block_ip){
            $block_ip=new BlockIp();
            $block_ip->ip=$_SERVER['REMOTE_ADDR'];
            $block_ip->save();
        }

        $welcome_ask1_data=WelcomeAskStat::init($this->getFirstVisitorsDate(),date('Y-m-d'),'welcome-ask1.php',$from_page)->get();
        $welcome_ask2_data=WelcomeAskStat::init($this->getFirstVisitorsDate(),date('Y-m-d'),'welcome-ask2.php',$from_page)->get();
        $welcome_ask3_data=WelcomeAskStat::init($this->getFirstVisitorsDate(),date('Y-m-d'),'welcome-ask3.php',$from_page)->get();
        $welcome_ask4_data=WelcomeAskStat::init($this->getFirstVisitorsDate(),date('Y-m-d'),'welcome-ask4.php',$from_page)->get();
        $welcome_ask5_data=WelcomeAskStat::init($this->getFirstVisitorsDate(),date('Y-m-d'),'welcome-ask5.php',$from_page)->get();
        $welcome_ask6_data=WelcomeAskStat::init($this->getFirstVisitorsDate(),date('Y-m-d'),'welcome-ask6.php',$from_page)->get();
        $welcome_ask7_data=WelcomeAskStat::init($this->getFirstVisitorsDate(),date('Y-m-d'),'welcome-ask7.php',$from_page)->get();
        $welcome_ask8_data=WelcomeAskStat::init($this->getFirstVisitorsDate(),date('Y-m-d'),'welcome-ask8.php',$from_page)->get();
        $welcome_ask9_data=WelcomeAskStat::init($this->getFirstVisitorsDate(),date('Y-m-d'),'welcome-ask9.php',$from_page)->get();
        $welcome_ask10_data=WelcomeAskStat::init($this->getFirstVisitorsDate(),date('Y-m-d'),'welcome-ask10.php',$from_page)->get();
        $welcome_ask11_data=WelcomeAskStat::init($this->getFirstVisitorsDate(),date('Y-m-d'),'welcome-ask11.php',$from_page)->get();
        $welcome_ask12_data=WelcomeAskStat::init($this->getFirstVisitorsDate(),date('Y-m-d'),'welcome-ask12.php',$from_page)->get();
//        dd($welcome_ask2_data);
        $results=$this->showWelcomeAskStat($welcome_ask1_data,
            $welcome_ask2_data,
            $welcome_ask3_data,
            $welcome_ask4_data,
            $welcome_ask5_data,
            $welcome_ask6_data,
            $welcome_ask7_data,
            $welcome_ask8_data,
            $welcome_ask9_data,
            $welcome_ask10_data,
            $welcome_ask11_data,
            $welcome_ask12_data
            );
        return view('welcome-ask-stat.index',
            compact('months_btns', 'q_btns', 'y_select','results'));
    }

    public function reloadResults(Request $request){
        if(!$request->from_date)
            $request->from_date=$this->getFirstVisitorsDate();
        if($request->from_page) {
            $from_pages=json_decode($request->from_page,true);
            $from_page_arr=[];
            if(count($from_pages)) {
                foreach ($from_pages as $el)
                    switch ($el) {
                        case 'google':
                            $from_page_arr = array_merge($from_page_arr,
                                [
                                    'Direct-to-Booking Google Ad',
                                    '/advisors/g1',
                                ]);
                            break;
                        case 'youtube':
                            $from_page_arr = array_merge($from_page_arr,
                                [
                                    'Organic YouTube',
                                    '/advisors/youtube'
                                ]);
                            break;
                        case 'others':
                            $from_page_arr = array_merge($from_page_arr,
                                [
                                    'Instagram',
                                    '/advisors/ig',
                                ]);
                    }
                $welcome_ask1_data = WelcomeAskStat::init($request->from_date, $request->to_date, 'welcome-ask1.php', $from_page_arr,$request->show_tmf_visitors)->get();
                $welcome_ask2_data = WelcomeAskStat::init($request->from_date, $request->to_date, 'welcome-ask2.php', $from_page_arr,$request->show_tmf_visitors)->get();
                $welcome_ask3_data = WelcomeAskStat::init($request->from_date, $request->to_date, 'welcome-ask3.php', $from_page_arr,$request->show_tmf_visitors)->get();
                $welcome_ask4_data = WelcomeAskStat::init($request->from_date, $request->to_date, 'welcome-ask4.php', $from_page_arr,$request->show_tmf_visitors)->get();
                $welcome_ask5_data = WelcomeAskStat::init($request->from_date, $request->to_date, 'welcome-ask5.php', $from_page_arr,$request->show_tmf_visitors)->get();
                $welcome_ask6_data = WelcomeAskStat::init($request->from_date, $request->to_date, 'welcome-ask6.php', $from_page_arr,$request->show_tmf_visitors)->get();
                $welcome_ask7_data = WelcomeAskStat::init($request->from_date, $request->to_date, 'welcome-ask7.php', $from_page_arr,$request->show_tmf_visitors)->get();
                $welcome_ask8_data = WelcomeAskStat::init($request->from_date, $request->to_date, 'welcome-ask8.php', $from_page_arr,$request->show_tmf_visitors)->get();
                $welcome_ask9_data = WelcomeAskStat::init($request->from_date, $request->to_date, 'welcome-ask9.php', $from_page_arr,$request->show_tmf_visitors)->get();
                $welcome_ask10_data = WelcomeAskStat::init($request->from_date, $request->to_date, 'welcome-ask10.php', $from_page_arr,$request->show_tmf_visitors)->get();
                $welcome_ask11_data = WelcomeAskStat::init($request->from_date, $request->to_date, 'welcome-ask11.php', $from_page_arr,$request->show_tmf_visitors)->get();
                $welcome_ask12_data = WelcomeAskStat::init($request->from_date, $request->to_date, 'welcome-ask12.php', $from_page_arr,$request->show_tmf_visitors)->get();
                return $this->showWelcomeAskStat($welcome_ask1_data,
                    $welcome_ask2_data,
                    $welcome_ask3_data,
                    $welcome_ask4_data,
                    $welcome_ask5_data,
                    $welcome_ask6_data,
                    $welcome_ask7_data,
                    $welcome_ask8_data,
                    $welcome_ask9_data,
                    $welcome_ask10_data,
                    $welcome_ask11_data,
                    $welcome_ask12_data
                );
            }else
                return '';
        }else
            return '';
    }


    private function showWelcomeAskStat($welcome_ask1_data,
                                        $welcome_ask2_data,
                                        $welcome_ask3_data,
                                        $welcome_ask4_data,
                                        $welcome_ask5_data,
                                        $welcome_ask6_data,
                                        $welcome_ask7_data,
                                        $welcome_ask8_data,
                                        $welcome_ask9_data,
                                        $welcome_ask10_data,
                                        $welcome_ask11_data,
                                        $welcome_ask12_data
    ){
        return view('welcome-ask-stat.results',
            compact('welcome_ask1_data',
                'welcome_ask2_data',
                'welcome_ask3_data',
                'welcome_ask4_data',
                'welcome_ask5_data',
                'welcome_ask6_data',
                'welcome_ask7_data',
                'welcome_ask8_data',
                'welcome_ask9_data',
                'welcome_ask10_data',
                'welcome_ask11_data',
                'welcome_ask12_data'
                )
        );
    }

    private function getFirstVisitorsDate(){
        return VisitorLog::orderBy('created_at','asc')->first()->created_at->format('Y-m-d');
    }

}
