<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\RedFlagsEbookRequest;
use App\RedFlagsFile;

class SevenRedFlagStatsController extends Controller
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
    public function index(Request $request)
    {
        $objs=$this->getObjs($request);
//        dd($objs[0]->files()->get());
        $result_table=$this->getResultTable($objs);
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
//        $objs=YoutubeVideoClick::all();
//        dd($objs[0]->youtubeVideo->video_id);
        return view('7rf-stats.index', compact('months_btns', 'q_btns', 'y_select','result_table','request'));

    }

    private function getResultTable($objs){
        return view('7rf-stats.result-table',compact('objs'));
    }

    public function rebuildResult(Request $request){
        return $this->getResultTable($this->getObjs($request));
    }

    private function getObjs(Request $request){
        $objs=null;
        if ($request->from_date && $request->to_date)
            $objs = RedFlagsEbookRequest::whereBetween('created_at', [$request->from_date . ' 00:00:00', $request->to_date . ' 23:59:59']);
        elseif ($request->from_date)
            $objs = RedFlagsEbookRequest::where('created_at', '>=', $request->from_date . ' 00:00:00')->get();
        elseif ($request->to_date)
            $objs = RedFlagsEbookRequest::where('created_at', '<=', $request->to_date . ' 23:59:59');
/*        else
            $objs=RedFlagsEbookRequest::all();*/
        if(is_null($objs))
            $objs=RedFlagsEbookRequest::whereNull('tmoffer_id')
                ->whereNull('tmfsales_id')
                ->get();
        else
            $objs=$objs->whereNull('tmoffer_id')
                ->whereNull('tmfsales_id')
                ->get();
//        exit;
        return $objs;
    }

}
