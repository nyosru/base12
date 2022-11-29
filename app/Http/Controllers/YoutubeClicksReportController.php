<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\YoutubeVideo;
use App\YoutubeVideoVar;
use App\YoutubeVideoClick;

class YoutubeClicksReportController extends Controller
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
//        $objs=YoutubeVideoClick::all();
//        dd($objs[0]->youtubeVideo->video_id);
        return view('youtube-clicks-report.index', compact('months_btns', 'q_btns', 'y_select'));
    }

    public function showReport(Request $request)
    {
//        var_dump($request->from_date);
//        var_dump($request->to_date);
        if ($request->from_date && $request->to_date)
            $objs = YoutubeVideoClick::whereBetween('created_at', [$request->from_date . ' 00:00:00', $request->to_date . ' 23:59:59'])->get();
        elseif ($request->from_date)
            $objs = YoutubeVideoClick::where('created_at', '>=', $request->from_date . ' 00:00:00')->get();
        elseif ($request->to_date)
            $objs = YoutubeVideoClick::where('created_at', '<=', $request->to_date . ' 23:59:59')->get();
        $data = [];

        $total_in_period = 0;
        $total_clicks = 0;
        $used_youtube_video_ids = [];
        foreach ($objs as $obj)
            if (!in_array($obj->youtube_video_id, $used_youtube_video_ids)) {
                $t_clicks = YoutubeVideoClick::where('youtube_video_id', $obj->youtube_video_id)->count();
                $today = date('Y-m-d', strtotime($obj->created_at));
                $ti_clicks= YoutubeVideoClick::whereBetween('created_at', [$today . ' 00:00:00', $today . ' 23:59:59'])
                    ->where('youtube_video_id', $obj->youtube_video_id)
                    ->count();

                $youtube_video_var=YoutubeVideoVar::where([
                    ['youtube_video_id','=',$obj->youtube_video_id],
                    ['youtube_var_id','=',2]
                ])->first();
                if($youtube_video_var)
                    $title=$youtube_video_var->value;
                else
                    $title=$obj->youtubeVideo->title;
                $data[] = [
                    'video-id' => $obj->youtubeVideo->video_id,
                    'title' => $title,
                    'clicks-in-period' =>$ti_clicks,
                    'total-clicks' => $t_clicks
                ];
                $total_clicks += $t_clicks;
                $total_in_period+=$ti_clicks;
                $used_youtube_video_ids[]=$obj->youtube_video_id;
            }
        return view('youtube-clicks-report.result-table',
            compact('data', 'total_in_period', 'total_clicks'));
    }

}
