<?php

namespace App\Http\Controllers;

use App\classes\opsreport\SnapshotStatusInfo;
use App\classes\tmoffer\CompanySubjectInfo;
use App\DashboardV2;
use App\TmfAftersearches;
use App\TmfCompany;
use App\TmfCompanySubject;
use App\TmfConditionTmfsalesTmoffer;
use App\TmfCountry;
use App\TmfCountryTrademark;
use App\Tmfsales;
use App\Tmoffer;
use App\TmofferBin;
use App\TmofferTmfCountryTrademark;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TmFilingQueueController extends Controller
{
    private $column_width = 300;
    private $bg_arr=['#EEEEEE','#FAEACB','#FCFCFC','#F7DBD7','#FFCBD0','#FDEACA','#F9E0E3','#CCDAE5','#ACC5E8','#FDF6DC'];

    private $tctt_legend=[
        390=>'#FAEACB',
        402=>'#F7DBD7',
        391=>'#FDF6DC',
        392=>'#F9E0E3',
        397=>'#CCDAE5',
    ];
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
        $data = $this->prepeareData();
        return view('tm-filing-queue.index', [
            'data' => $data,
            'column_width' => $this->column_width,
            'bg_arr'=>$this->bg_arr,
            'tctt_legend'=>$this->tctt_legend
        ]);
    }

    public function prepeareData()
    {

        $all_countries=$this->getAllCountriesIds();
        $first_two=$this->getInitialSearchInProgressData(new SnapshotStatusInfo([375], $all_countries));
        $interval=\DateInterval::createFromDateString('7 days');
        $datetime7d=Carbon::now()->sub($interval)->format('Y-m-d').' 23:59:59';
//        echo $datetime7d.'<br/>';
        $data = [
            'Initial Search in Progress' => ['values'=>$first_two[0],'acceptable-delays'=>[18,36],'bg'=>'#d8eefd'],
            'Search Review in Progress' => ['values'=>$first_two[1],'acceptable-delays'=>[24,36],'bg'=>'#c9d4f8'],
            'Client to Book Saving Call' => ['values'=>$this->getDataBySSi(new SnapshotStatusInfo([399], $all_countries)),'acceptable-delays'=>[24,72],'bg'=>'#c0ddc5'],
            'Client to Move Forward' => ['values'=>$this->getDataBySSi(new SnapshotStatusInfo([390], $all_countries)),'acceptable-delays'=>[48,168],'bg'=>'#f7f6b8'],
            'Conventional Priority Hold' => ['values'=>$this->getDataBySSi(new SnapshotStatusInfo([402], $all_countries)),'acceptable-delays'=>[2880,3600],'bg'=>'#ceb3d2'],
            'Drafting TM Application' => ['values'=>$this->getDataBySSi(new SnapshotStatusInfo([376], $all_countries)),'acceptable-delays'=>[48,72],'bg'=>'#f4bc73'],
            'Waiting for Сlient to Approve Draft' => ['values'=>$this->getDataBySSi(new SnapshotStatusInfo([391], $all_countries)),'acceptable-delays'=>[48,96],'bg'=>'#f995f5'],
            'Waiting for Сlient to Pay Govt. Fees' => ['values'=>$this->getDataBySSi(new SnapshotStatusInfo([392], $all_countries)),'acceptable-delays'=>[24,72],'bg'=>'#c8f6cf'],
            'Waiting for Сlient to Provide Info' => ['values'=>$this->getDataBySSi(new SnapshotStatusInfo([397], $all_countries)),'acceptable-delays'=>[48,96],'bg'=>'#cf95f9'],
//            'Waiting for Govt. Fees' => [],
//            'Waiting for client to approve tm app.'=>$this->getDataBySSi(new SnapshotStatusInfo([391,392,397], $all_countries)),
            'Ready to File TM App.' => ['values'=>$this->getDataBySSi(new SnapshotStatusInfo([400], $all_countries)),'acceptable-delays'=>[24, 48],'bg'=>'#fba846'],
            'Sent to Foreign Associate' => ['values'=>$this->getDataBySSi(new SnapshotStatusInfo([401], $all_countries)),'acceptable-delays'=>[48, 72],'bg'=>'#77ffd4'],
            'TM App. Filed [7 days]' => ['values'=>$this->getDataByDashboardIds(DashboardV2::whereIn('cipostatus_status_formalized_id', [1])
                ->where([
                    ['dashboard_global_status_id', 1],
                    ['ready_status', 1],
                ])
                ->whereNull('deleted_at')
                ->whereIn('tmf_country_trademark_id', TmfCountryTrademark::select('id')->whereIn('tmf_country_id', $all_countries))
                ->where('formalized_status_modified_at','>=', $datetime7d)
                ->select('id')
                ->get()
                ->toArray()
            ),'acceptable-delays'=>[],'bg'=>'#'],
            'DUMP: Future, Refund, No Sale [7 days]' => ['values'=>$this->getDataByDashboardIds(DashboardV2::whereIn('cipostatus_status_formalized_id', [375,376])
                ->where([
                    ['dashboard_global_status_id','!=', 1],
                ])
                ->whereNull('deleted_at')
                ->whereIn('tmf_country_trademark_id', TmfCountryTrademark::select('id')->whereIn('tmf_country_id', $all_countries))
                ->where('formalized_status_modified_at','>=', $datetime7d)
                ->select('id')
                ->get()
                ->toArray()
            ),'acceptable-delays'=>[],'bg'=>'#']
        ];
        return $data;
    }

    private function getAllCountriesIds()
    {
        $objs = TmfCountry::select('id')->get();
        $data = [];
        foreach ($objs as $el)
            $data[] = $el->id;
        return $data;
    }

    private function getDataBySSi(SnapshotStatusInfo $ssi){
        return $this->getDataByDashboardIds($ssi->getIds());
    }
    private function getDataByDashboardIds($dashboard_ids){
        $data = [];
        foreach ($dashboard_ids as $el) {
            $tmf_data = $this->getDashboardData($el['id']);
            $data[]=$tmf_data;
        }
        return $data;
    }


    private function getInitialSearchInProgressData(SnapshotStatusInfo $ssi)
    {
        $data = [[], []];
        $dashboard_ids = $ssi->getIds();
        foreach ($dashboard_ids as $el) {
            $tmf_data = $this->getDashboardData($el['id']);
            $data[$tmf_data['searching_finished']][]=$tmf_data;
        }
        return $data;
    }

    private function getDashboardData($dashboard_id)
    {

//        echo "dashboard_id:{$dashboard_id}<br/>";
        $dashboard_obj = DashboardV2::find($dashboard_id);
//        dd($dashboard_obj);

        if (!$dashboard_obj->tmf_country_trademark_id) {
            echo "dashboard:{$dashboard_id} not linked with tms!";
            exit;
        }

        $tmoffer = Tmoffer::whereIn('ID', TmofferTmfCountryTrademark::select('tmoffer_id')
            ->where('tmf_country_trademark_id', $dashboard_obj->tmf_country_trademark_id)
        )
            ->where('is_nobook', 1)
            ->first();

        if(!$tmoffer)
            $tmoffer = Tmoffer::whereIn('ID', TmofferTmfCountryTrademark::select('tmoffer_id')
                ->where('tmf_country_trademark_id', $dashboard_obj->tmf_country_trademark_id)
            )
                ->where('DateConfirmed','!=', '0000-00-00')
                ->first();


        if($dashboard_obj->formalized_status_modified_at=='0000-00-00 00:00:00')
            $date=new \DateTime($dashboard_obj->created_at);
        else
            $date=new \DateTime($dashboard_obj->formalized_status_modified_at);

        $time_since_delta=1000000;
        $today=new \DateTime();
        $diff=$today->getTimestamp()-$date->getTimestamp();
        $pending_in_this_status=$this->formattedTime($diff);
        $pending_in_this_status_delta=$diff;
        $boom_when_by='';
        if ($tmoffer) {
            $client_info = CompanySubjectInfo::init($tmoffer)->get();

            if (strlen($client_info['company']))
                $client_data = $client_info['company'];
            else
                $client_data = trim((strlen($client_info['gender']) ? $client_info['gender'] . ' ' : '') . $client_info['firstname'] . ' ' . $client_info['lastname']);

            if ($tmoffer->is_nobook) {
                $time_since_caption = 'NOBOOK';
                $time_since_caption_icon = '🔎';
                $delta = time() - strtotime($tmoffer->created_date);
                $time_since_formatted = $this->formattedTime($delta);
                $time_since_delta=$delta;
            } elseif ($tmoffer->DateConfirmed != '0000-00-00') {
                $time_since_caption = 'BOOM';
                $time_since_caption_icon ='💣';
                $closer=($tmoffer->Sales?Tmfsales::where('Login',$tmoffer->Sales)->first():null);
                if(is_null($closer) && $tmoffer->sales_id)
                    $closer=Tmfsales::find($tmoffer->sales_id);

                $tmoffer_bin = TmofferBin::where('tmoffer_id', $tmoffer->ID)->where('need_capture', 0)->first();
                if ($tmoffer_bin) {
                    if($closer)
                        $boom_when_by=sprintf('%s by %s %s',$tmoffer_bin->modified_at,$closer->FirstName,$closer->LastName);
                    else
                        $boom_when_by=sprintf('%s AUTOBOOM',$tmoffer_bin->modified_at);
                    $delta = time() - strtotime($tmoffer_bin->modified_at);
                    $time_since_formatted = $this->formattedTime($delta);
                    $time_since_delta=$delta;
                }
                else {
                    throw new \Exception("tmoffer:{$tmoffer->ID}, payment was not captured!");
                }

                $tmf_aftersearch_obj = TmfAftersearches::where('tmoffer_id', $tmoffer->ID)
                    ->where('cancelled', '0000-00-00 00:00:00')
                    ->orderBy('id','desc')
                    ->first();
                if($tmf_aftersearch_obj){
                    $time_since_caption = 'AFTERSEARCH';
                    $time_since_caption_icon='<i class="fas fa-search-plus"></i>';
                    $delta = time() - strtotime($tmf_aftersearch_obj->assigned_date);
                    $time_since_formatted = $this->formattedTime($delta);
                    $tmfsales=Tmfsales::find($tmf_aftersearch_obj->tmfsales_id);
//                    echo "id:{$tmf_aftersearch_obj->id}<br/>";
                    if($tmfsales)
                        $boom_when_by=sprintf('%s by %s %s',$tmf_aftersearch_obj->assigned_date,$tmfsales->FirstName,$tmfsales->LastName);
                    else
                        $boom_when_by=sprintf('created %s. UNCLAIMED',$tmf_aftersearch_obj->assigned_date);
                    $time_since_delta=$delta;
                }
            } else{
                $time_since_caption = '';
                $time_since_caption_icon ='N/A';
                $time_since_formatted = 'N/A';
            }

            $last_condition = TmfConditionTmfsalesTmoffer::where('tmoffer_id', $tmoffer->ID)
                ->orderBy('when_date', 'desc')
                ->first();
            if($last_condition && $last_condition->tmf_condition_id>=5 && $last_condition->tmf_condition_id<=7) {
                $tmf_aftersearch_objs = TmfAftersearches::where('tmoffer_id', $tmoffer->ID)
                    ->where('cancelled', '0000-00-00 00:00:00')
                    ->get();
//                if($tmoffer->ID==498377)
//                    dd($tmf_aftersearch_objs);
                $searching_finished = 1;
                if ($tmf_aftersearch_objs && $tmf_aftersearch_objs->count()) {
                    foreach ($tmf_aftersearch_objs as $tmf_aftersearch_obj)
                        if ($tmf_aftersearch_obj->prepared_date == '0000-00-00 00:00:00') {
                            $searching_finished = 0;
                            break;
                        }
                }
            }else
                $searching_finished = 0;

        } else {
            $time_since_caption = '';
            $time_since_caption_icon ='N/A';
            $time_since_formatted = 'N/A';
            $pending_in_this_status = 'N/A';

            $tmf_company = $dashboard_obj->tmfCompany;
            $rep_info = [
                'company' => '',
            ];
            if ($tmf_company->tmf_lawyer_id) {
                $rep_company = TmfCompany::find($tmf_company->tmf_lawyer_id);

                $tmf_company_subject_objs = TmfCompanySubject::where('tmf_company_id', $rep_company->id)
                    ->orderBy('order_position')
                    ->get();
                $rep_info['company'] = sprintf('(%s)', $rep_company->name);
            } else {
                $tmf_company_subject_objs = TmfCompanySubject::where('tmf_company_id', $tmf_company->id)
                    ->orderBy('order_position')
                    ->get();
            }
            if ($tmf_company_subject_objs && $tmf_company_subject_objs->count())
                foreach ($tmf_company_subject_objs as $index => $tmf_company_subject) {
                    $tmf_subject = $tmf_company_subject->tmfSubject;
                    if (!$index && !strlen($rep_info['company'])) {
                        $rep_info['company'] = trim(($tmf_subject->gender ? $tmf_subject->gender . ' ' : '') . $tmf_subject->first_name . ' ' . $tmf_subject->last_name);
                        break;
                    }
                }
            $client_data = $rep_info['company'];
            $searching_finished=0;
        }
        $tmf_country_trademark = $dashboard_obj->tmfCountryTrademark;
        $flag = sprintf('<img src="https://trademarkfactory.imgix.net/img/countries/%s" style="max-width: 20px;max-height:13px;margin-bottom: 3px;">', $tmf_country_trademark->tmfCountry->tmf_country_flag);
        $country = $tmf_country_trademark->tmfCountry->tmf_country_name;
        $tmf_trademark = $tmf_country_trademark->tmfTrademark;
        $tm_type = $tmf_trademark->tmf_trademark_type_id;
        $tm_id = $tmf_trademark->id;
        $tm_country_id = $tmf_country_trademark->tmfCountry->id;
        $logo_descr = ($tm_type == 1 ? $tmf_trademark->logo_descr : '');
        if ($tmf_trademark->tmf_trademark_type_id == 2)
            $mark = $tmf_trademark->tmf_trademark_mark;
        else
            $mark = sprintf('<img src="https://trademarkfactory.imgix.net/offerimages/%s" class="img-responsive" style="margin: auto;max-width:75px;max-height: 75px;">', $tmf_trademark->tmf_trademark_mark);
        return [
            'mark' => $mark,
            'flag' => $flag,
            'country' => $country,
            'client' => $client_data,
            'time_since_delta'=>$time_since_delta,
            'time_since_caption' => $time_since_caption,
            'time_since_formatted' => $time_since_formatted,
            'pending_in_this_status' => $pending_in_this_status,
            'pending_in_this_status_delta'=>$pending_in_this_status_delta,
            'tmoffer' => $tmoffer,
            'dashboard' => $dashboard_obj,
            'searching_finished'=>$searching_finished,
            'time_since_caption_icon'=>$time_since_caption_icon,
            'boom_when_by'=>$boom_when_by
//                'tctt'=>$last_condition
        ];
    }

    private function formattedTime($delta)
    {
        $d = intval($delta / (24 * 3600));
        $h = intval($delta % (24 * 3600) / 3600);
        $m = intval($delta % (24 * 3600) % 3600 / 60);
        $s = intval($delta % (24 * 3600) % 3600 % 60);
        return sprintf('%sd %sh %sm', $d, $h, $m);
    }

    public function loadDashboardNotes(Request $request){
        $dashboard=DashboardV2::find($request->id);
        if($dashboard){
            return $dashboard->notes;
        }
        return '';
    }

    public function saveDashboardNotes(Request $request){
        $dashboard=DashboardV2::find($request->id);
        if($dashboard){
            $dashboard->notes=$request->notes;
            $dashboard->save();
            return 'Done';
        }
        return '';
    }

}
