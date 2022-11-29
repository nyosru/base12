<?php

namespace App\Http\Controllers;

use App\classes\askstat\VisitorStat;
use Illuminate\Http\Request;
use App\VisitorLog;
//use App\classes\askstat\VisitorStat;

class AskStat extends Controller
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

        $tree=$this->generateTree($this->getFirstVisitorsDate(),date('Y-m-d'));
        $jstree_json=json_encode($tree);
//        $objs=YoutubeVideoClick::all();
//        dd($objs[0]->youtubeVideo->video_id);
        return view('ask-stat.index', compact('months_btns', 'q_btns', 'y_select','jstree_json'));
    }

    private function getFirstVisitorsDate(){
        return VisitorLog::orderBy('created_at','asc')->first()->created_at->format('Y-m-d');
    }

    public function rebuildTree(Request $request){
        if(!$request->from_date)
            $request->from_date=$this->getFirstVisitorsDate();
        return json_encode($this->generateTree($request->from_date,$request->to_date));
    }

    private function generateTree($from_date,$to_date){
//        $total_visits_data=VisitorStat::init('App\classes\askstat\TotalVisits',1)->get($from_date,$to_date);
//        $from_pages=['/advisors/youtube'];
        $from_pages=[];
        $ask_visits_data=VisitorStat::init('App\classes\askstat\AskVisits',1)
            ->setFromPages($from_pages)
            ->get($from_date,$to_date);
        $parent_id='ask_visits';
        $result=[
            'text'=>'Ask Visits: '.$ask_visits_data[0],
            'id'=>$parent_id,
            'icon'=>false,
            'state'=>['opened'=>true,'disabled'=>false,'selected'=>true],
            //'parent'=>'#',
            'a_attr'=>['style'=>'border:1px solid black;padding:10px;margin-bottom:5px;background-color:#83BBE5'],
            'children'=>[],
        ];

        $seven_red_flags_data=VisitorStat::init('App\classes\askstat\SevenRedFlagsSqueezeVisits',$ask_visits_data[0])
            ->setFromPages($from_pages)
            ->get($from_date,$to_date);
        $id='7-red-flags-squeeze-visits';
        $result['children'][]=[
            'text'=>sprintf('7 Red Flags Squeeze Visits: %d (%s%%)',$seven_red_flags_data[0],$seven_red_flags_data[1]),
            'id'=>$id,
            'icon'=>false,
            'state'=>['opened'=>true,'disabled'=>false,'selected'=>false],
            //'parent'=>$parent_id,
            'a_attr'=>['style'=>'border:1px solid black;padding:10px;margin-bottom:5px;background-color:#83BBE5'],
            'children'=>[$this->sevenRedFlagsOptIns($seven_red_flags_data,$from_date,$to_date,$id)],
        ];

        $guaranteed_lp_data=VisitorStat::init('App\classes\askstat\GuaranteedResultLpVisits',$ask_visits_data[0])->get($from_date,$to_date);
        $id='guaranteed-result-lp-visit';
        $result['children'][]=[
            'text'=>sprintf('Guaranteed Result LP Visit: %d (%s%%)',$guaranteed_lp_data[0],$guaranteed_lp_data[1]),
            'id'=>$id,
            'icon'=>false,
            'state'=>['opened'=>true,'disabled'=>false,'selected'=>false],
            'children'=>$this->getGuaranteedResultChildren($guaranteed_lp_data,$from_date,$to_date),
            'a_attr'=>['style'=>'border:1px solid black;padding:10px;margin-bottom:5px;background-color:#83BBE5'],
        ];

        $resources_data=VisitorStat::init('App\classes\askstat\ResourcesVisits',$ask_visits_data[0])->get($from_date,$to_date);
        $id='resources-visits';
        $result['children'][]=[
            'text'=>sprintf('Resources Visits: %d (%s%%)',$resources_data[0],$resources_data[1]),
            'id'=>$id,
            'icon'=>false,
            'state'=>['opened'=>true,'disabled'=>false,'selected'=>false],
            //'parent'=>$parent_id,
            'a_attr'=>['style'=>'border:1px solid black;padding:10px;margin-bottom:5px;background-color:#83BBE5'],
        ];

        $abandoned_data=VisitorStat::init('App\classes\askstat\AbandonedAsk',$ask_visits_data[0])->get($from_date,$to_date);
        $id='abandoned-ask';
        $result['children'][]=[
            'text'=>sprintf('Abandoned: %d (%s%%)',$abandoned_data[0],$abandoned_data[1]),
            'id'=>$id,
            'icon'=>false,
            'state'=>['opened'=>true,'disabled'=>false,'selected'=>false],
            //'parent'=>$parent_id,
            'a_attr'=>['style'=>'border:1px solid black;padding:10px;margin-bottom:5px;background-color:#C92D39'],
        ];

        return $result;
    }

    private function getGuaranteedResultChildren($guaranteed_lp_data,$from_date,$to_date){
        $result=[];
        $result[]=$this->getGrStatBlock(
            $guaranteed_lp_data,
            $from_date,
            $to_date,
            'curious-cathy',
            'Curious Cathy Lp Visits:',
            'App\classes\askstat\LpVisitsFromGuaranteeResultLp',
            ['/business-idea.php'],
            'guaranteed-result-idea'
        );
        $result[]=$this->getGrStatBlock(
            $guaranteed_lp_data,
            $from_date,
            $to_date,
            'startup-sam',
            'Startup Sam Lp Visits:',
            'App\classes\askstat\LpVisitsFromGuaranteeResultLp',
            ['/startup.php'],
            'guaranteed-result-startup'
        );
        $result[]=$this->getGrStatBlock(
            $guaranteed_lp_data,
            $from_date,
            $to_date,
            'monetizing-mike',
            'Monetizing Mike Lp Visits:',
            'App\classes\askstat\LpVisitsFromGuaranteeResultLp',
            ['/monetizing.php'],
            'guaranteed-result-monetizing'
        );
        $result[]=$this->getGrStatBlock(
            $guaranteed_lp_data,
            $from_date,
            $to_date,
            'growing-greg',
            'Growing Greg Lp Visits:',
            'App\classes\askstat\LpVisitsFromGuaranteeResultLp',
            ['/growing.php'],
            'guaranteed-result-growing'
        );
        $result[]=$this->getGrStatBlock(
            $guaranteed_lp_data,
            $from_date,
            $to_date,
            'established-eddie',
            'Established Eddie Lp Visits:',
            'App\classes\askstat\LpVisitsFromGuaranteeResultLp',
            ['/established.php'],
            'guaranteed-result-expanding'
        );
        $abandoned=$this->getGrStatBlock(
            $guaranteed_lp_data,
            $from_date,
            $to_date,
            'abandoned-guaranteed-resulte-lp',
            'Abandoned:',
            'App\classes\askstat\AbandonedGrLp',
            [
                '/guaranteed-result.php',
            ]
        );
        $abandoned['a_attr']=['style'=>'border:1px solid black;padding:10px;margin-bottom:5px;background-color:#C92D39'];
        $result[]=$abandoned;
        return $result;
    }

    private function getGrStatBlock($guaranteed_lp_data,$from_date,$to_date,$id,$caption,$classname,$pages,$from_page=''){
        $data=VisitorStat::init($classname,$guaranteed_lp_data[0])
            ->setPages($pages)
            ->get($from_date,$to_date);
        $result=[
            'text'=>sprintf('%s %d (%s%%)',$caption,$data[0],$data[1]),
            'id'=>$id,
            'icon'=>false,
            'state'=>['opened'=>true,'disabled'=>false,'selected'=>false],
            'children'=>[],
            //'parent'=>$parent_id,
            'a_attr'=>['style'=>'border:1px solid black;padding:10px;margin-bottom:5px;background-color:#83BBE5'],
        ];
        if(strlen($from_page))
            $result['children']=[
                $this->getCheckoutFromGrChild($data,$from_date,$to_date,$pages,$id,$from_page),
                $this->getBookingsFromGrChild($data,$from_date,$to_date,$pages,$id,$from_page)
            ];
        return $result;
    }

    private function getCheckoutFromGrChild($data,$from_date,$to_date,$pages,$id,$from_page){
        $data=VisitorStat::init('App\classes\askstat\CheckoutVisitsFromGrLp',$data[0])
            ->setPages($pages)
            ->setFromPage($from_page)
            ->get($from_date,$to_date);
        $result=[
            'text'=>sprintf('Checkout Visits: %d (%s%%)',$data[0],$data[1]),
            'id'=>$id.'-checkout',
            'icon'=>false,
            'state'=>['opened'=>true,'disabled'=>false,'selected'=>false],
            'children'=>[],
            //'parent'=>$parent_id,
            'a_attr'=>['style'=>'border:1px solid black;padding:10px;margin-bottom:5px;background-color:#83BBE5'],
        ];
        return $result;
    }

    private function getBookingsFromGrChild($data,$from_date,$to_date,$pages,$id,$from_page){
        $data=VisitorStat::init('App\classes\askstat\BookingsFromGrLp',$data[0])
            ->setPages($pages)
            ->setFromPage($from_page)
            ->get($from_date,$to_date);
        $result=[
            'text'=>sprintf('Bookings from LP: %d (%s%%)',$data[0],$data[1]),
            'id'=>$id.'-bookings',
            'icon'=>false,
            'state'=>['opened'=>true,'disabled'=>false,'selected'=>false],
            'children'=>[],
            //'parent'=>$parent_id,
            'a_attr'=>['style'=>'border:1px solid black;padding:10px;margin-bottom:5px;background-color:#EF8D22'],
        ];
        return $result;
    }


    private function sevenRedFlagsOptIns($parent_data,$from_date,$to_date,$parent_id){
        $data=VisitorStat::init('App\classes\askstat\SevenRedFlagsOptInsVisits',$parent_data[0])->get($from_date,$to_date);
        $id='7-red-flags-opt-ins';
        if(!$from_date)
            $f_date='2000-01-01';
        else
            $f_date=$from_date;
        if(!$to_date)
            $t_date='2100-01-01';
        else
            $t_date=$to_date;
        $link=sprintf('<a href="7rf-stats/%s/%s" id="7rf-stats-link" target="_blank">Stats</a>',$f_date,$t_date);
        return [
            'text'=>sprintf('7 Red Flags Opt-Ins: %d (%s%%) %s',$data[0],$data[1],$link),
            'id'=>$id,
            'icon'=>false,
            'state'=>['opened'=>true,'disabled'=>false,'selected'=>false],
            //'parent'=>$parent_id,
            'a_attr'=>['style'=>'border:1px solid black;padding:10px;margin-bottom:5px;background-color:#F5B5C8'],
            'children'=>[$this->sevenRedFlagsDownloads($data,$from_date,$to_date,$id)]
        ];
    }

    private function sevenRedFlagsDownloads($parent_data,$from_date,$to_date,$parent_id){
        $data=VisitorStat::init('App\classes\askstat\SevenRedFlagsDownloads',$parent_data[0])->get($from_date,$to_date);
        $id='7-red-flags-downloads';
        return [
            'text'=>sprintf('7 Red Flags Downloads: %d (%s%%)',$data[0],$data[1]),
            'id'=>$id,
            'icon'=>false,
            'state'=>['opened'=>true,'disabled'=>false,'selected'=>false],
            //'parent'=>$parent_id,
            'a_attr'=>['style'=>'border:1px solid black;padding:10px;margin-bottom:5px;background-color:#834187'],
            'children'=>[$this->sevenRedFlagsLpVisits($data,$from_date,$to_date,$id)]
        ];
    }

    private function sevenRedFlagsLpVisits($parent_data,$from_date,$to_date,$parent_id){
        $data=VisitorStat::init('App\classes\askstat\SevenRedFlagsLpVisits',$parent_data[0])->get($from_date,$to_date);
        $id='7-red-flags-lp-visits';
        return [
            'text'=>sprintf('7 Red Flags LP Visits: %d (%s%%)',$data[0],$data[1]),
            'id'=>$id,
            'icon'=>false,
            'state'=>['opened'=>true,'disabled'=>false,'selected'=>false],
            //'parent'=>$parent_id,
            'a_attr'=>['style'=>'border:1px solid black;padding:10px;margin-bottom:5px;background-color:#83BBE5'],
            'children'=>[
                $this->checkoutVisitsFromSevenRedFlagsLp($data,$from_date,$to_date),
                $this->bookingsFromSevenRedFlagsLp($data,$from_date,$to_date)
            ]
        ];
    }

    private function checkoutVisitsFromSevenRedFlagsLp($parent_data,$from_date,$to_date){
        $data=VisitorStat::init('App\classes\askstat\CheckoutVisitsFromSevenRedFlagsLp',$parent_data[0])->get($from_date,$to_date);
        $id='checkout-visits-from-7-red-flags-lp';
        return [
            'text'=>sprintf('Checkout Visits: %d (%s%%)',$data[0],$data[1]),
            'id'=>$id,
            'icon'=>false,
            'state'=>['opened'=>true,'disabled'=>false,'selected'=>false],
            //'parent'=>$parent_id,
            'a_attr'=>['style'=>'border:1px solid black;padding:10px;margin-bottom:5px;background-color:#83BBE5'],
            'children'=>[]
        ];
    }

    private function bookingsFromSevenRedFlagsLp($parent_data,$from_date,$to_date){
        $data=VisitorStat::init('App\classes\askstat\BookingsFromSevenRedFlagsLp',$parent_data[0])->get($from_date,$to_date);
        $id='bookings-from-7-red-flags-lp';
        return [
            'text'=>sprintf('Bookings from LP: %d (%s%%)',$data[0],$data[1]),
            'id'=>$id,
            'icon'=>false,
            'state'=>['opened'=>true,'disabled'=>false,'selected'=>false],
            //'parent'=>$parent_id,
            'a_attr'=>['style'=>'border:1px solid black;padding:10px;margin-bottom:5px;background-color:#EF8D22'],
            'children'=>[]
        ];

    }

}
