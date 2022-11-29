<?php

namespace App\Http\Controllers;

use App\classes\opsreport\DashboardStatus;
use App\classes\opsreport\PeriodDataLoader;
use App\DashboardGlobalStatus;
use App\DashboardInTimingsType;
use App\DashboardTss;
use App\DashboardV2;
use App\TmfCountry;
use App\traits\OpsStatTrait;
use Illuminate\Http\Request;

class OpsPeriodController extends Controller
{
    use OpsStatTrait;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    private function fromDate($date)
    {
        $from_date = (clone $date)->sub(\DateInterval::createFromDateString('1 week'));
        return new \DateTime($from_date->format('Y-m-d') . ' 00:00:00');
    }

    private function toDate()
    {
        $to_date = new \DateTime();
        return new \DateTime($to_date->format('Y-m-d') . ' 23:59:59');
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

        $to_date = $this->toDate();
        $from_date = $this->fromDate($to_date);

        $result_table = $this->getResultTable($this->loadData($from_date, $to_date, $this->getAllCountriesIds()));
        $other_countries = $this->getOtherCountriesIds();

        return view('ops-period.index', compact('months_btns', 'q_btns', 'y_select', 'result_table', 'other_countries', 'from_date', 'to_date'));
    }

    private function getAllCountriesIds()
    {
        $objs = TmfCountry::select('id')->get();
        $data = [];
        foreach ($objs as $el)
            $data[] = $el->id;
        return $data;
    }

    private function loadData($from_date, $to_date, $countries)
    {

//        dd($all_global_statuses_ids);
        $data = [];

        $data[] = ['caption' => 'New TMs with <i>Searching</i> Status this Period', 'obj' => PeriodDataLoader::statusPeriodData($from_date, $to_date, $countries, [375]), 'border-top' => 0, 'font-style' => 'normal'];
        $data[] = ['caption' => '<span class="ml-3 mr-3">&mdash;</span>Still Searching', 'obj' => PeriodDataLoader::stillStatusPeriodData($from_date, $to_date, $countries, [375]), 'border-top' => 0, 'font-style' => 'italic'];
        $data[] = ['caption' => '<span class="ml-3 mr-3">&mdash;</span>No Longer Searching', 'obj' => PeriodDataLoader::noLongerStatusPeriodData($from_date, $to_date, $countries, [375]), 'border-top' => 0, 'font-style' => 'italic'];


        $data[] = ['caption' => 'No Longer <i>Searching</i> since this Period', 'obj' => PeriodDataLoader::noLongerSinceStatusPeriodData($from_date, $to_date, $countries, [375]), 'border-top' => 0, 'font-style' => 'normal'];
        $data[] = ['caption' => '<span class="ml-3 mr-3">&mdash;</span>Drafting', 'obj' => PeriodDataLoader::noLongerSinceStatusPeriodData($from_date, $to_date, $countries, [375], DashboardStatus::init([376], [1])), 'border-top' => 0, 'font-style' => 'italic'];
        $data[] = ['caption' => '<span class="ml-3 mr-3">&mdash;</span>Filed', 'obj' => PeriodDataLoader::noLongerSinceStatusPeriodData($from_date, $to_date, $countries, [375], DashboardStatus::init([1], [1])), 'border-top' => 0, 'font-style' => 'italic'];
        $data[] = ['caption' => '<span class="ml-3 mr-3">&mdash;</span>Waiting For Client Input', 'obj' => PeriodDataLoader::noLongerSinceStatusPeriodData($from_date, $to_date, $countries, [375], DashboardStatus::init([397, 391, 392, 390], [1])), 'border-top' => 0, 'font-style' => 'italic'];
        $data[] = ['caption' => '<span class="ml-3 mr-3">&mdash;</span>Future TM', 'obj' => PeriodDataLoader::noLongerSinceStatusPeriodData($from_date, $to_date, $countries, [375], DashboardStatus::init([], [5])), 'border-top' => 0, 'font-style' => 'italic'];
        $data[] = ['caption' => '<span class="ml-3 mr-3">&mdash;</span>Refund', 'obj' => PeriodDataLoader::noLongerSinceStatusPeriodData($from_date, $to_date, $countries, [375], DashboardStatus::init([], [8])), 'border-top' => 0, 'font-style' => 'italic'];
        $data[] = ['caption' => '<span class="ml-3 mr-3">&mdash;</span>Abandoned / Unresponsive etc.', 'obj' => PeriodDataLoader::noLongerSinceStatusPeriodData($from_date, $to_date, $countries, [375], DashboardStatus::init([], [2, 3, 4, 7, 9, 10])), 'border-top' => 0, 'font-style' => 'italic'];

        $data[] = ['caption' => 'Newly <i>Filed</i> this Period', 'obj' => PeriodDataLoader::statusPeriodData($from_date, $to_date, $countries, [1]), 'border-top' => 0, 'font-style' => 'normal'];

        $data[] = ['caption' => 'New <i>Minor OAs</i> Received This Period', 'obj' => PeriodDataLoader::statusPeriodData($from_date, $to_date, $countries, [378]), 'border-top' => 1, 'font-style' => 'normal'];
        $data[] = ['caption' => '<span class="ml-3 mr-3">&mdash;</span>Still Minor OA', 'obj' => PeriodDataLoader::stillStatusPeriodData($from_date, $to_date, $countries, [378]), 'border-top' => 0, 'font-style' => 'italic'];
        $data[] = ['caption' => '<span class="ml-3 mr-3">&mdash;</span>No Longer Minor OA', 'obj' => PeriodDataLoader::noLongerStatusPeriodData($from_date, $to_date, $countries, [378]), 'border-top' => 0, 'font-style' => 'italic'];

        $data[] = ['caption' => 'No Longer <i>Minor OA</i> Since This Period', 'obj' => PeriodDataLoader::noLongerSinceStatusPeriodData($from_date, $to_date, $countries, [378]), 'border-top' => 0, 'font-style' => 'normal'];
        $data[] = ['caption' => '<span class="ml-3 mr-3">&mdash;</span>ROA Submitted & Awaiting Review', 'obj' => PeriodDataLoader::noLongerSinceStatusPeriodData($from_date, $to_date, $countries, [378], DashboardStatus::init([383], [])), 'border-top' => 0, 'font-style' => 'italic'];
        $data[] = ['caption' => '<span class="ml-3 mr-3">&mdash;</span>Suspended', 'obj' => PeriodDataLoader::noLongerSinceStatusPeriodData($from_date, $to_date, $countries, [378], DashboardStatus::init([377], [])), 'border-top' => 0, 'font-style' => 'italic'];
        $data[] = ['caption' => '<span class="ml-3 mr-3">&mdash;</span>Waiting for Client', 'obj' => PeriodDataLoader::noLongerSinceStatusPeriodData($from_date, $to_date, $countries, [378], DashboardStatus::init([394, 393], [])), 'border-top' => 0, 'font-style' => 'italic'];

        $data[] = ['caption' => 'New <i>Major OAs</i> Received This Period', 'obj' => PeriodDataLoader::statusPeriodData($from_date, $to_date, $countries, [381]), 'border-top' => 0, 'font-style' => 'normal'];
        $data[] = ['caption' => '<span class="ml-3 mr-3">&mdash;</span>Still Major OA', 'obj' => PeriodDataLoader::stillStatusPeriodData($from_date, $to_date, $countries, [381]), 'border-top' => 0, 'font-style' => 'italic'];
        $data[] = ['caption' => '<span class="ml-3 mr-3">&mdash;</span>No Longer Major OA', 'obj' => PeriodDataLoader::noLongerStatusPeriodData($from_date, $to_date, $countries, [381]), 'border-top' => 0, 'font-style' => 'italic'];

        $data[] = ['caption' => 'No Longer <i>Major OA</i> Since This Period', 'obj' => PeriodDataLoader::noLongerSinceStatusPeriodData($from_date, $to_date, $countries, [381]), 'border-top' => 0, 'font-style' => 'normal'];
        $data[] = ['caption' => '<span class="ml-3 mr-3">&mdash;</span>ROA Submitted & Awaiting Review', 'obj' => PeriodDataLoader::noLongerSinceStatusPeriodData($from_date, $to_date, $countries, [381], DashboardStatus::init([383], [])), 'border-top' => 0, 'font-style' => 'italic'];
        $data[] = ['caption' => '<span class="ml-3 mr-3">&mdash;</span>Suspended', 'obj' => PeriodDataLoader::noLongerSinceStatusPeriodData($from_date, $to_date, $countries, [381], DashboardStatus::init([377], [])), 'border-top' => 0, 'font-style' => 'italic'];
        $data[] = ['caption' => '<span class="ml-3 mr-3">&mdash;</span>Waiting for Client', 'obj' => PeriodDataLoader::noLongerSinceStatusPeriodData($from_date, $to_date, $countries, [381], DashboardStatus::init([394, 393], [])), 'border-top' => 0, 'font-style' => 'italic'];

        $data[] = ['caption' => 'Newly <i>Published</i> this Period', 'obj' => PeriodDataLoader::statusPeriodData($from_date, $to_date, $countries, [4]), 'border-top' => 1, 'font-style' => 'normal'];
        $data[] = ['caption' => 'Newly <i>Proposed Opposition</i> this Period', 'obj' => PeriodDataLoader::statusPeriodData($from_date, $to_date, $countries, [379]), 'border-top' => 0, 'font-style' => 'normal'];
        $data[] = ['caption' => 'Newly <i>Opposed</i> this Period', 'obj' => PeriodDataLoader::statusPeriodData($from_date, $to_date, $countries, [380]), 'border-top' => 0, 'font-style' => 'normal'];

        $data[] = ['caption' => 'Newly <i>Allowed</i> this Period', 'obj' => PeriodDataLoader::statusPeriodData($from_date, $to_date, $countries, [5]), 'border-top' => 1, 'font-style' => 'normal'];

        $data[] = ['caption' => 'New <i>Post-Allowance OAs</i> Received This Period', 'obj' => PeriodDataLoader::statusPeriodData($from_date, $to_date, $countries, [384]), 'border-top' => 0, 'font-style' => 'normal'];
        $data[] = ['caption' => '<span class="ml-3 mr-3">&mdash;</span>Still Post-Allowance OA', 'obj' => PeriodDataLoader::stillStatusPeriodData($from_date, $to_date, $countries, [384]), 'border-top' => 0, 'font-style' => 'italic'];
        $data[] = ['caption' => '<span class="ml-3 mr-3">&mdash;</span>No Longer Post-Allowance OA', 'obj' => PeriodDataLoader::noLongerStatusPeriodData($from_date, $to_date, $countries, [384]), 'border-top' => 0, 'font-style' => 'italic'];

        $data[] = ['caption' => 'No Longer <i>Post-Allowance OA</i> Since This Period', 'obj' => PeriodDataLoader::noLongerSinceStatusPeriodData($from_date, $to_date, $countries, [384]), 'border-top' => 0, 'font-style' => 'normal'];
        $data[] = ['caption' => '<span class="ml-3 mr-3">&mdash;</span> Feed Paid / ROA Submitted & Awaiting Review', 'obj' => PeriodDataLoader::noLongerSinceStatusPeriodData($from_date, $to_date, $countries, [384], DashboardStatus::init([398, 385], [])), 'border-top' => 0, 'font-style' => 'italic'];
        $data[] = ['caption' => '<span class="ml-3 mr-3">&mdash;</span> Waiting for Client', 'obj' => PeriodDataLoader::noLongerSinceStatusPeriodData($from_date, $to_date, $countries, [384], DashboardStatus::init([395, 396], [])), 'border-top' => 0, 'font-style' => 'italic'];

        $data[] = ['caption' => 'Newly <i>Registered</i> this Period', 'obj' => PeriodDataLoader::statusPeriodData($from_date, $to_date, $countries, [6]), 'border-top' => 1, 'font-style' => 'normal'];

        return $data;
    }


    private function getOtherCountriesIds()
    {
        $objs = TmfCountry::select('id')->whereNotIn('id', [8, 9])->get();
        $data = [];
        foreach ($objs as $el)
            $data[] = $el->id;
        return $data;
    }

    private function getResultTable($data)
    {
        return view('ops-period.result-table', compact('data'))->render();
    }

    public function loadingDetails(Request $request)
    {
        $ids = json_decode($request->ids, true);
        $today = new \DateTime();
        if (json_last_error() == JSON_ERROR_NONE) {
            $dashboard_objs = DashboardV2::whereIn('id', $ids)->get();
            $data = [];
            foreach ($dashboard_objs as $dashboard_obj) {

                if ($dashboard_obj->formalized_status_modified_at == '0000-00-00 00:00:00')
                    $date = new \DateTime($dashboard_obj->created_at);
                else
                    $date = new \DateTime($dashboard_obj->formalized_status_modified_at);
                $diff = $today->getTimestamp() - $date->getTimestamp();

                $prev_status_data = $this->getDashboardPrevStatusData($dashboard_obj->id, $dashboard_obj->cipostatus_status_formalized_id);
                $data[] = [
                    'id' => $dashboard_obj->id,
                    'trademark' => $this->getTrademark($dashboard_obj->tmfCountryTrademark, $dashboard_obj->id),
                    'client' => $dashboard_obj->tmfCompany->name,
                    'status' => $dashboard_obj->cipostatusStatusFormalized->status,
                    'days-till-now' => round($diff / (24 * 3600), 2),
                    'in-trends' => $dashboard_obj->dashboard_in_timings_type_id,
                    'prev-status' => $prev_status_data['status'],
                    'prev-status-days' => $prev_status_data['days-till-new']
                ];
            }

            $dashboard_in_timings_type_objs = DashboardInTimingsType::orderBy('id')->get();
            return view('ops-period.details-table', compact('data', 'dashboard_in_timings_type_objs'));
        }
        return '';
    }

    private function getDashboardPrevStatusData($dashboard_id, $current_status_id)
    {
        $current_tss = DashboardTss::where('dashboard_id', $dashboard_id)
            ->where('cipostatus_status_formalized_id', $current_status_id)
            ->orderBy('id', 'desc')
            ->first();
        if ($current_tss) {
            $prev_tss = DashboardTss::where('dashboard_id', $dashboard_id)
                ->where('id', '<', $current_tss->id)
                ->orderBy('id', 'desc')
                ->first();
            if ($prev_tss) {
                $prev_status_date = new \DateTime($prev_tss->created_at);
                $current_status_date = new \DateTime($current_tss->created_at);
                $diff = $current_status_date->getTimestamp() - $prev_status_date->getTimestamp();
                return [
                    'status' => $prev_tss->cipostatusStatusFormalized->status,
                    'days-till-new' => round($diff / (24 * 3600), 2)
                ];
            }
        }
        return [
            'status' => 'N/A',
            'days-till-new' => 'N/A'
        ];
    }

    public function reloadTable(Request $request)
    {
        $countries = json_decode($request->countries);
        if (json_last_error() == JSON_ERROR_NONE) {
            if ($request->to_date)
                $to_date = new \DateTime($request->to_date . ' 23:59:59');
            else
                $to_date = $this->toDate();
            if ($request->from_date)
                $from_date = new \DateTime($request->from_date . ' 00:00:00');
            else
                $from_date = $this->fromDate($to_date);

            return $result_table = $this->getResultTable($this->loadData($from_date, $to_date, $countries));
        }
        return '';

    }

}
