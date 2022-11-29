<?php

namespace App\Http\Controllers;

use App\classes\dashboard\DashboardDates;
use App\classes\dashboard\DashboardOwnerManager;
use App\classes\queue\AdditionalMenuItems;
use App\classes\queue\ChangeStatus;
use App\classes\queue\DashboardDataDetails;
use App\classes\queue\QueueHoursCalculator;
use App\classes\queue\QueuePainter;
use App\classes\queue\QueueTmHistory;
use App\classes\ThankYouCardSentTextGetter;
use App\classes\tmoffer\CompanySubjectInfo;
use App\DashboardDeadline;
use App\DashboardOwner;
use App\DashboardTss;
use App\DashboardV2;
use App\Events\ReloadSubStatusTms;
use App\Events\ReloadTM;
use App\LastDashboardOwnerRow;
use App\QueueCache;
use App\QueueFlagSettings;
use App\QueueRootStatus;
use App\QueueStatus;
use App\QueueType;
use App\RequestReviewDetails;
use App\TmfAftersearches;
use App\TmfCompany;
use App\TmfCompanySubject;
use App\TmfConditionTmfsalesTmoffer;
use App\TmfCountryTrademark;
use App\TmfFilingQueueRootStatus;
use App\TmfFilingQueueStatus;
use App\Tmfsales;
use App\TmfSubject;
use App\TmfTrademark;
use App\Tmoffer;
use App\TmofferBin;
use App\TmofferTmfCountryTrademark;
use App\traits\TmfXXXQueueCommon;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Telegram\Bot\Api;


class QueueController extends Controller
{
    use TmfXXXQueueCommon;

    private const QUEUE_STATUS_TM_FILED=19;
    private const QUEUE_STATUS_CLIENT_TO_REPLACE_TM=20;
    private const QUEUE_STATUS_CONVENTIONAL_PRIORITY_GRACE_PERIOD=23;
    private const QUEUE_STATUS_NO_SALE=21;
    private const QUEUE_STATUS_REFUND_ISSUED=22;
    private const QUEUE_STATUS_PROBLEMATIC=24;
    private const QUEUE_STATUS_REGISTERED=41;
    private const QUEUE_STATUS_ABANDONED=85;
    private const QUEUE_STATUS_REFUSED=86;

    private const QUEUE_ROOT_STATUS_WAITING=11;

    private const RENEWAL_QUEUE=3;

    public function index()
    {
        $queue_type_objs = QueueType::all();
        $change_status_obj = new ChangeStatus(true);
        return view('queue.index', [
            'left_nav_bar' => view('queue.left-nav-bar', compact('queue_type_objs'))->render(),
            'change_status_obj' => $change_status_obj,
            'queue_type_objs' => $queue_type_objs
        ]);
    }

    public function showMark(Request $request){
        $queue_status=QueueStatus::find($request->queue_status_id);
        session(['queue-type-id' => $queue_status->queueRootStatus->queue_type_id]);
        $queue_type_objs = QueueType::all();
        $change_status_obj = new ChangeStatus(true);
        return view('queue.index', [
            'left_nav_bar' => view('queue.left-nav-bar', compact('queue_type_objs'))->render(),
            'change_status_obj' => $change_status_obj,
            'queue_type_objs' => $queue_type_objs,
            'action'=>'open-mark',
            'dashboard_id'=>$request->dashboard_id,
            'queue_root_status_id'=>$queue_status->queue_root_status_id,
            'queue_status_id'=>$queue_status->id
        ]);
    }

    public function dismissRequest(Request $request){
        $queue_status=QueueStatus::find($request->queue_status_id);
        session(['queue-type-id' => $queue_status->queueRootStatus->queue_type_id]);
        $this->dismissRequestReview($request->queue_status_id,$request->dashboard_id);
        $redirect_path=sprintf('/queue/mark/%d/%d',$request->queue_status_id,$request->dashboard_id);
        return redirect($redirect_path);
    }

    public function loadRootStatuses(Request $request)
    {
        session(['queue-type-id' => $request->id]);
        $queue_root_status_objs = QueueRootStatus::where('queue_type_id', $request->id)
            ->orderBy('place_id', 'asc')
            ->get();
        $status_type = 'root-status';
        return view('queue.root-statuses-list', [
            'days_select_arr' => $this->days_select_arr,
            'selected_day' => $this->days,
            'queue_root_status_objs' => $queue_root_status_objs,
            'status_type' => $status_type
        ]);
    }

    public function loadSubStatusTms(Request $request)
    {
        $queue_status = QueueStatus::find($request->id);
        if ($queue_status) {
            if ($request->days)
                $this->days = $request->days;
            if ($request->group_by_client) {
                $this->show_mode = 'client';
                return $this->subStatusTms($queue_status);
            } else {
                $this->show_mode = 'tms';
                return $this->resultTms($request, $queue_status);
            }
        }
        return '';
    }

    private function resultTms(Request $request, QueueStatus $queue_status){
        $dashboard_ids=json_decode($request->dashboard_ids,true);
        $result=[];
        if(json_last_error()==JSON_ERROR_NONE) {
            $queue_cache_objs=QueueCache::whereIn('dashboard_id',$dashboard_ids)->get();
            if($queue_cache_objs->count()!=count($dashboard_ids)) {
                $dashboard_objs = DashboardV2::whereIn('id', $dashboard_ids)->get();
                foreach ($dashboard_objs as $dashboard_obj) {
                    $dashboard_data_details_obj=new DashboardDataDetails($dashboard_obj);
                    $el = $dashboard_data_details_obj->getDashboardData();
                    $result[] = $dashboard_data_details_obj->formattedResultFromDataEl($el, $queue_status);
                }
            }else
                foreach ($queue_cache_objs as $el)
                    $result[]=json_decode($el->json,true);

        }
        return response()->json($result);
    }

    public function reloadSubStatuses(Request $request)
    {
        $el = QueueRootStatus::find($request->id);
        if ($el)
            return view('queue.sub-statuses-list', compact('el'));
        return '';
    }

    public function loadSubStatusNumbers(Request $request)
    {
        $queue_status = QueueStatus::find($request->id);
        if ($queue_status) {
            if ($request->days)
                $this->days = $request->days;
            $data = $this->getDashboardObjsForSubStatusData($queue_status);
            $result = [
                'badge-success' => 0,
                'badge-warning' => 0,
                'badge-danger' => 0
            ];
            $today = Carbon::now()->format('Y-m-d') . ' 00:00:00';
            foreach ($data as $el) {
//                echo "dashboard_id:{$el->id}<br/>";
                $dashboard_tss = DashboardTss::where('dashboard_id', $el->id)
                    ->orderBy('id', 'desc')
                    ->first();
                if (!$dashboard_tss->warning_at) {
                    $dashboard_data_details=new DashboardDataDetails($el);
                    $hard_deadline_date = '';
                    $hard_deadline_obj = DashboardDeadline::where('dashboard_id', $el->id)
                        ->where('deadline_type_id', 1)
                        ->whereNull('deadline_done_at')
                        ->orderBy('deadline_date_at')
                        ->first();
                    if ($hard_deadline_obj)
                        $hard_deadline_date = \DateTime::createFromFormat('Y-m-d H:i:s', $hard_deadline_obj->deadline_date_at)->format('Y-m-d');

//                echo "dashboard_id:{$el['dashboard']->id}<br/>";

                    list($dashboard_tss->warning_at, $dashboard_tss->danger_at) = $dashboard_data_details->getWarningAndDangerFlagDates(
                        $queue_status,
                        $dashboard_tss,
                        $hard_deadline_date);
                    $dashboard_tss->save();
                }

                $index = 'badge-success';
                if (
                    ($today >= $dashboard_tss->warning_at) &&
                    ($today < $dashboard_tss->danger_at)
                )
                    $index = 'badge-warning';
                elseif ($today > $dashboard_tss->danger_at)
                    $index = 'badge-danger';
                $result[$index]++;

            }
            return response()->json([
                'dashboard_ids'=>$data->pluck('id')->toArray(),
                'id' => $request->id,
                'root_id' => $queue_status->queue_root_status_id,
                'total' => count($data),
                'html' => view('queue.badges', compact('result'))->render()
            ]);
        }
        return response()->json([
            'id' => $request->id,
            'root_id' => ($queue_status ? $queue_status->queue_root_status_id : 0),
            'total' => 0,
            'html' => ''
        ]);
    }

    private function tmsDataArr(QueueStatus $queue_status, $data)
    {
        $result = [];
        foreach ($data as $el) {
            $dashboard_data_details_obj=new DashboardDataDetails($el['dashboard']);
            $result[] = $dashboard_data_details_obj->formattedResultFromDataEl($el, $queue_status);
        }
        return $result;
    }


    public function loadDashboardDetails(Request $request){
        $queue_status=QueueStatus::find($request->queue_status_id);
        $dashboard_obj=DashboardV2::find($request->dashboard_id);
        $dashboard_details=new DashboardDataDetails($dashboard_obj);
        $el=$dashboard_details->getDashboardData();
        return response()->json($dashboard_details->formattedResultFromDataEl($el,$queue_status));
    }

    private function tmsList(QueueStatus $queue_status, $data)
    {
        switch ($this->show_mode) {
            case 'tms':
                return response()->json($this->tmsDataArr($queue_status, $data));
//                return view('queue.tms-list');
            case 'client':
                $original_data = $data;
                $data = [];
                foreach ($original_data as $od_el) {
                    if (!isset($data[$od_el['client']]))
                        $data[$od_el['client']] = [
                            'badge-success' => 0,
                            'badge-warning' => 0,
                            'badge-danger' => 0,
                            'data' => []
                        ];
                    $dashboard_data_details_obj=new DashboardDataDetails($od_el['dashboard']);
                    $formatted_data = $dashboard_data_details_obj->formattedResultFromDataEl($od_el, $queue_status);
                    $data[$od_el['client']][$formatted_data['badge_class']]++;
                    $data[$od_el['client']]['data'][] = $formatted_data;
                }
                return response()->json($data);
        }

    }

    private function tmsListOld(TmfFilingQueueStatus $tmf_filing_queue_status, $data)
    {
        switch ($this->show_mode) {
            case 'tms':
                return view('queue.tms-list', compact('tmf_filing_queue_status', 'data'));
            case 'client':
                $original_data = $data;
                $data = [];
                foreach ($original_data as $od_el) {
                    if (!isset($data[$od_el['client']]))
                        $data[$od_el['client']] = [];
                    $data[$od_el['client']][] = $od_el;
                }
                return view('queue.client-tms-list', compact('tmf_filing_queue_status', 'data'));
        }

    }

    private function getDashboardObjsForSubStatusData(QueueStatus $queue_status){
        if ($queue_status->removable)
            $dashboard_objs=$this->getDashboardObjsForStandartSubStatusTms($queue_status);
        else
            $dashboard_objs =$this->getDashboardObjsForCustomSubStatusTms($queue_status);
        return $dashboard_objs;
    }

    private function getSubStatusData(QueueStatus $queue_status)
    {
        $dashboard_objs=$this->getDashboardObjsForSubStatusData($queue_status);
        $data = [];
        foreach ($dashboard_objs as $dashboard_obj) {
            $dashboard_details_obj=new DashboardDataDetails($dashboard_obj);
            $data[] = $dashboard_details_obj->getDashboardData();
        }
        return $data;
    }

    private function subStatusTms(QueueStatus $queue_status)
    {
        return $this->tmsList($queue_status, $this->getSubStatusData($queue_status));
    }

    private function getDashboardObjsForStandartSubStatusTms(QueueStatus $queue_status){
        $dashboard_objs = DashboardV2::where('cipostatus_status_formalized_id',
            $queue_status->cipostatus_status_formalized_id)
            ->where([
                ['dashboard_global_status_id', $queue_status->dashboard_global_status_id],
                ['ready_status', 1],
            ])
            ->whereNull('deleted_at');
        if (session('claimed-by-me'))
            $dashboard_objs = $dashboard_objs->whereIn('id', DashboardOwner::select('dashboard_id')
                ->distinct()
                ->where('tmfsales_id', session('claimed-by-me'))->whereNull('released_at')
            );
        if (session('review-requested-only'))
            $dashboard_objs = $dashboard_objs->whereIn('id', LastDashboardOwnerRow::select('dashboard_id')
                ->where('release_reason_id', 3)
            );


        return $dashboard_objs->get();
    }

    private function getDashboardObjsForCustomSubStatusTms(QueueStatus $queue_status){
        $interval = \DateInterval::createFromDateString($this->days . ' days');
        $datetime_xd = Carbon::now()->sub($interval)->format('Y-m-d') . ' 23:59:59';

        switch ($queue_status->id) {
            case self::QUEUE_STATUS_TM_FILED:
            case self::QUEUE_STATUS_CLIENT_TO_REPLACE_TM:
            case self::QUEUE_STATUS_CONVENTIONAL_PRIORITY_GRACE_PERIOD:

            case self::QUEUE_STATUS_ABANDONED:
            case self::QUEUE_STATUS_REFUSED:
                $dashboard_objs = DashboardV2::where('cipostatus_status_formalized_id',
                    $queue_status->cipostatus_status_formalized_id)
                    ->where([
                        ['dashboard_global_status_id', $queue_status->dashboard_global_status_id],
                        ['ready_status', 1],
                    ])
                    ->whereNull('deleted_at')
                    ->where('formalized_status_modified_at', '>=', $datetime_xd);
                if (session('claimed-by-me'))
                    $dashboard_objs = $dashboard_objs->whereIn('id', DashboardOwner::select('dashboard_id')
                        ->distinct()
                        ->where('tmfsales_id', session('claimed-by-me'))->whereNull('released_at')
                    );
                if (session('review-requested-only'))
                    $dashboard_objs = $dashboard_objs->whereIn('id', LastDashboardOwnerRow::select('dashboard_id')
                        ->where('release_reason_id', 3)
                    );
                break;

            case self::QUEUE_STATUS_REGISTERED:

                $dashboard_objs = DashboardV2::whereIn('cipostatus_status_formalized_id',
                    QueueStatus::select('cipostatus_status_formalized_id')
                        ->distinct()
                        ->where('id',self::QUEUE_STATUS_REGISTERED)
                        ->orWhere('queue_root_status_id',self::QUEUE_ROOT_STATUS_WAITING))
                    ->where([
                        ['dashboard_global_status_id', $queue_status->dashboard_global_status_id],
                        ['ready_status', 1],
                    ])
                    ->whereNull('deleted_at')
                    ->where('formalized_status_modified_at', '>=', $datetime_xd);
                if (session('claimed-by-me'))
                    $dashboard_objs = $dashboard_objs->whereIn('id', DashboardOwner::select('dashboard_id')
                        ->distinct()
                        ->where('tmfsales_id', session('claimed-by-me'))->whereNull('released_at')
                    );
                if (session('review-requested-only'))
                    $dashboard_objs = $dashboard_objs->whereIn('id', LastDashboardOwnerRow::select('dashboard_id')
                        ->where('release_reason_id', 3)
                    );
                break;

            case self::QUEUE_STATUS_NO_SALE:
            case self::QUEUE_STATUS_REFUND_ISSUED:
            case self::QUEUE_STATUS_PROBLEMATIC:
                $dashboard_objs = DashboardV2::where([
                    ['dashboard_global_status_id', $queue_status->dashboard_global_status_id],
                    ['ready_status', 1],
                ])
                    ->whereNull('deleted_at')
                    ->where('formalized_status_modified_at', '>=', $datetime_xd);
                if (session('claimed-by-me'))
                    $dashboard_objs = $dashboard_objs->whereIn('id', DashboardOwner::select('dashboard_id')
                        ->distinct()
                        ->where('tmfsales_id', session('claimed-by-me'))->whereNull('released_at')
                    );
                if (session('review-requested-only'))
                    $dashboard_objs = $dashboard_objs->whereIn('id', LastDashboardOwnerRow::select('dashboard_id')
                        ->where('release_reason_id', 3)
                    );
                break;
        }
        return $dashboard_objs->get();
    }

    public function search(Request $request)
    {
        $dashboard_objs = DashboardV2::where('ready_status', 1)
            ->whereNull('deleted_at');
        if ($request->client_fn) {
            $tmf_subject_objs = TmfSubject::select('id')->where(function ($query) use ($request) {
                $query->where('first_name', 'like', '%' . $request->client_fn . '%')
                    ->orWhere('last_name', 'like', '%' . $request->client_fn . '%')
                    ->orWhereRaw('concat(first_name," ",last_name) like "%' . $request->client_fn . '%"');
            });
            $dashboard_objs = $dashboard_objs->where(function ($query) use ($request, $tmf_subject_objs) {
                $query->whereIn('tmf_company_id',
                    TmfCompanySubject::select('tmf_company_id')->whereIn('tmf_subject_id', $tmf_subject_objs))
                    ->orWhereIn('tmf_company_id', TmfCompany::select('id')->where('name', 'like', '%' . $request->client_fn . '%'));
            });
        }

        if ($request->tm) {
            $tmf_country_trademark_objs = TmfCountryTrademark::select('id')
                ->whereIn('tmf_trademark_id',
                    TmfTrademark::select('id')->where('tmf_trademark_mark', 'like', '%' . $request->tm . '%')
                );
            $dashboard_objs = $dashboard_objs->whereIn('tmf_country_trademark_id', $tmf_country_trademark_objs);
        }
        if (session('claimed-by-me'))
            $dashboard_objs = $dashboard_objs->whereIn('id', DashboardOwner::select('dashboard_id')
                ->distinct()
                ->where('tmfsales_id', session('claimed-by-me'))
            );
        if (session('review-requested-only'))
            $dashboard_objs = $dashboard_objs->whereIn('id', LastDashboardOwnerRow::select('dashboard_id')
                ->where('release_reason_id', 3)
            );
        $dashboard_objs = $dashboard_objs->get();
        $data = [];
        if($request->queue_type_id==self::RENEWAL_QUEUE)
            $queue_root_status = QueueRootStatus::where('queue_type_id', $request->queue_type_id)
                ->first();
        else
            $queue_root_status = QueueRootStatus::where('queue_type_id', $request->queue_type_id)
                ->where('name', 'Done')
                ->first();
        foreach ($dashboard_objs as $dashboard_obj) {
            $dashboard_data_details_obj=new DashboardDataDetails($dashboard_obj);
            $ldd = $dashboard_data_details_obj->getDashboardData();
            $queue_status = $dashboard_data_details_obj->getDashboardQueueStatus($ldd, $queue_root_status);
//            $dd=$ldd;
            $ldd['current-status'] = $queue_status;
            $data[] = $ldd;
        }
//        echo '<pre>';
//        var_dump($data);
//        exit;
        $show_not_in_queue = $request->show_not_in_queue;
        $interval = \DateInterval::createFromDateString(($request->done_status_days?$request->done_status_days:0) . ' days');
        $datetime_xd = Carbon::now()->sub($interval)->format('Y-m-d') . ' 23:59:59';
        $done_ids = QueueStatus::select('id')->where('queue_root_status_id', $queue_root_status->id)->pluck('id')->toArray();
        return view('queue.search-results',
            compact('data',
                'show_not_in_queue',
                'datetime_xd', 'done_ids'));
    }

    public function requestReview(Request $request)
    {
        $dashboard_owner_manager=new DashboardOwnerManager($request->id);
        $dashboard_owner = $dashboard_owner_manager->releaseOwnerFromMark(Auth::user()->ID,3);
        if ($dashboard_owner) {
            if ($request->notification) {
                $tmfsales = Auth::user();
                $dashboard = DashboardV2::find($request->id);
                $tmf_trademark = $dashboard->tmfCountryTrademark->tmfTrademark;
                $tmf_country = $dashboard->tmfCountryTrademark->tmfCountry;
                $mark = ($tmf_trademark->tmf_trademark_type_id == 1 ? $tmf_trademark->logo_descr : $tmf_trademark->tmf_trademark_mark);
                $config = app('config')->get('telegram');
                $telegram = new Api($config['token']);
                $queue_status = QueueStatus::find($request->current_queue_status_id);
                $suffix='';
                if($request->message && strlen($request->message)) {
                    $suffix = PHP_EOL . sprintf('—"%s"', $request->message);
                    $this->saveRequestReviewDetails($dashboard_owner->id,$request->message);
                    $note=sprintf('%s %s requested review: "%s"',
                        Carbon::now()->format('Y-m-d H:i:s'),
                        $tmfsales->LongID,
                        $request->message);
                    $this->addDashboardNote($dashboard,$note);
                }
                $dashboard_link='https://trademarkfactory.com/mlcclients/dashboard-trademarks-details.php?id='.$request->id;
                $queue_status_link=sprintf('https://in.trademarkfactory.com/queue/mark/%d/%d',
                    $request->current_queue_status_id,
                    $request->id);
                $dismiss_request_link=sprintf('https://in.trademarkfactory.com/queue/dismiss-request/%d/%d',
                    $request->current_queue_status_id,
                    $request->id);
                $telegram->sendMessage([
                    'chat_id' => $queue_status->queueRootStatus->queueType->telegram_chat_id,
                    'parse_mode' => 'HTML',
                    'text' => sprintf('%s %s requested review for <b>%s</b> in %s%s' . PHP_EOL .'[<i>%s</i>]%s'.
                        PHP_EOL.'<a href="%s">Open in Dashboard</a> | <a href="%s">Open in Queue</a> | <a href="%s">Dismiss Request</a>',
                        $tmfsales->FirstName,
                        $tmfsales->LastName,
                        $mark,
                        ($tmf_country->article_the ? 'the ' : ''),
                        $tmf_country->tmf_country_name_short,
                        $queue_status->name,
                        $suffix,
                        $dashboard_link,
                        $queue_status_link,
                        $dismiss_request_link)
                ]);
            }
            $this->updateQueueCacheEl($request->id);
            event(new ReloadSubStatusTms($request->current_queue_status_id));
            event(new ReloadTM($request->id));
            return 'DONE';
        }
    }

    private function dismissRequestReview($queue_status_id,$dashboard_id){
        $dashboard_owner=DashboardOwner::where('dashboard_id',$dashboard_id)
            ->where('release_reason_id',3)
            ->orderBy('id','desc')
            ->first();
        if($dashboard_owner) {
            $dashboard_owner->delete();
            $this->updateQueueCacheEl($dashboard_id);
            event(new ReloadSubStatusTms($queue_status_id));
            event(new ReloadTM($dashboard_id));
            return 'done';
        }
        return '';
    }

    public function removeRequestReview(Request $request){
        return $this->dismissRequestReview($request->queue_status_id,$request->dashboard_id);
    }

    private function addDashboardNote(DashboardV2 $dashboard_obj,$note){
        $dashboard_obj->notes.="\r\n\r\n".$note;
        $dashboard_obj->save();
    }

    private function saveRequestReviewDetails($dashboard_owner_id,$message){
        $request_review_details=new RequestReviewDetails();
        $request_review_details->dashboard_owner_id=$dashboard_owner_id;
        $request_review_details->description=$message;
        $request_review_details->created_at=Carbon::now()->format('Y-m-d H:i:s');
        $request_review_details->save();
    }


    public function loadHistory(Request $request)
    {
        $data = (new QueueTmHistory($request->id, $request->queue_root_status_id))->get();
        return view('common-queue.tm-history', compact('data'));
    }

    public function changeFlagsValues(Request $request){
        $dashboard_tss_obj = DashboardTss::where('dashboard_id', $request->dashboard_id)
            ->orderBy('id', 'desc')
            ->first();
        if($dashboard_tss_obj){
            $dashboard_tss_obj->warning_at=$request->warning_at.':00';
            $dashboard_tss_obj->danger_at=$request->danger_at.':00';
            $dashboard_tss_obj->save();
            return 'done';
        }
        return '';
    }

    public function loadAdditionalMenuItems(Request $request){
        $obj=new AdditionalMenuItems($request->queue_status_id,$request->dashboard_id);
        return response()->json($obj->get());
    }

    public function loadTss(Request $request){
        $dashboard_tss=DashboardTss::where('dashboard_id',$request->dashboard_id)
            ->orderBy('id','desc')
            ->first();
        if($dashboard_tss) {
            $arr = explode('<div class="tsw"',$dashboard_tss->description);
            return str_replace('%%%tmf-satisfaction-widget%%%','',$arr[0]);
        }else
            return '';
    }
}
