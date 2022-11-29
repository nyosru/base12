<?php
namespace App\classes\queue;


use App\classes\dashboard\DashboardDates;
use App\classes\tmoffer\CompanySubjectInfo;
use App\DashboardTss;
use App\DashboardV2;
use App\LastDashboardOwnerRow;
use App\QueueCache;
use App\QueueFlagSettings;
use App\QueueRootStatus;
use App\QueueStatus;
use App\RequestReviewDetails;
use App\Tmfsales;
use App\Tmoffer;
use Carbon\Carbon;

class DashboardDataDetails
{
    private const The_Day_Template_Is_Run = 1;
    private const Last_Formal_Status_Date = 2;
    private const Filed_Date = 3;
    private const Registration_Date = 4;
    private const Js_Calendar = 5;
    private const Hard_Deadline = 6;

    private const Calendar_Days = 1;
    private const Monday_If_Falls_On_Weekend = 2;
    private const Business_Days_Only = 3;

    private const REGISTRATION_QUEUE=2;
    private const RENEWAL_QUEUE=3;

    private const FILING_QUEUE_DONE=4;
    private const REG_QUEUE_DONE=8;

    private $dashboard_obj;

    public function __construct($dashboard_obj)
    {
        $this->dashboard_obj=$dashboard_obj;
    }

    public static function initByDashboardId($dashboard_id){
        return new self(DashboardV2::find($dashboard_id));
    }

    public function getTmoffer(){
        $tmoffer=Tmoffer::join('tmoffer_tmf_country_trademark','tmoffer.ID','=','tmoffer_tmf_country_trademark.tmoffer_id')
            ->select('tmoffer.*')
            ->where('tmoffer_tmf_country_trademark.tmf_country_trademark_id',$this->dashboard_obj->tmf_country_trademark_id)
            ->where('DateConfirmed', '!=', '0000-00-00')
            ->first();
        if(!$tmoffer)
            $tmoffer=Tmoffer::join('tmoffer_tmf_country_trademark','tmoffer.ID','=','tmoffer_tmf_country_trademark.tmoffer_id')
                ->select('tmoffer.*')
                ->where('tmoffer_tmf_country_trademark.tmf_country_trademark_id',$this->dashboard_obj->tmf_country_trademark_id)
                ->where('is_nobook',1)
                ->first();
        return $tmoffer;
    }

    public function getDashboardData()
    {

//        echo "dashboard_id:{$dashboard_id}<br/>";
        if (!$this->dashboard_obj->tmf_country_trademark_id) {
            echo "dashboard:{$this->dashboard_obj->id} not linked with tms!";
            exit;
        }
        $tmoffer=$this->getTmoffer();

        if ($this->dashboard_obj->formalized_status_modified_at == '0000-00-00 00:00:00')
            $date = new \DateTime($this->dashboard_obj->created_at);
        else {
            $last_dashboard_tss=$this->dashboard_obj->dashboardTsses()->orderBy('id','desc')->first();
            if($last_dashboard_tss)
                $date = new \DateTime($last_dashboard_tss->created_at);
            else
                $date = new \DateTime($this->dashboard_obj->formalized_status_modified_at);
        }

        $time_since_delta = 1000000;
        $today = new \DateTime();
        $diff = $today->getTimestamp() - $date->getTimestamp();

        $pending_in_this_status = $this->formattedTime($diff);
        $pending_in_this_status_delta = $diff;
        $boom_when_by = '';
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
                $time_since_delta = $delta;
            } elseif ($tmoffer->DateConfirmed != '0000-00-00') {
                $time_since_caption = 'BOOM';
                $time_since_caption_icon = '💣';
                $closer = ($tmoffer->Sales ? Tmfsales::where('Login', $tmoffer->Sales)->first() : null);
                if (is_null($closer) && $tmoffer->sales_id)
                    $closer = Tmfsales::find($tmoffer->sales_id);

                $tmoffer_bin = $tmoffer->tmofferBin;
                if ($tmoffer_bin && $tmoffer_bin->need_capture==0) {
                    if ($closer)
                        $boom_when_by = sprintf('%s by %s %s', $tmoffer_bin->modified_at, $closer->FirstName, $closer->LastName);
                    else
                        $boom_when_by = sprintf('%s AUTOBOOM', $tmoffer_bin->modified_at);
                    $delta = time() - strtotime($tmoffer_bin->modified_at);
                    $time_since_formatted = $this->formattedTime($delta);
                    $time_since_delta = $delta;
                } else {
//                    throw new \Exception("tmoffer:{$tmoffer->ID}, payment was not captured!");
                    $boom_when_by = sprintf('%s AUTOBOOM', $tmoffer->DateConfirmed);
                    $delta = time() - strtotime($tmoffer->DateConfirmed);
                    $time_since_formatted = $this->formattedTime($delta);
                    $time_since_delta = $delta;
                }

                $tmf_aftersearch_obj = $tmoffer->tmfAftersearchesRows()
                    ->where('cancelled', '0000-00-00 00:00:00')
                    ->orderBy('id', 'desc')
                    ->first();
                if ($tmf_aftersearch_obj) {
                    $time_since_caption = 'AFTERSEARCH';
                    $time_since_caption_icon = '<i class="fas fa-search-plus"></i>';
//                    $delta = time() - strtotime($tmf_aftersearch_obj->assigned_date);
                    $delta = time() - strtotime($this->dashboard_obj->created_at);
                    $time_since_formatted = $this->formattedTime($delta);
                    $tmfsales = $tmf_aftersearch_obj->tmfsales;
//                    echo "id:{$tmf_aftersearch_obj->id}<br/>";
                    if ($tmfsales)
//                        $boom_when_by=sprintf('%s by %s %s',$tmf_aftersearch_obj->assigned_date,$tmfsales->FirstName,$tmfsales->LastName);
                        $boom_when_by = sprintf('%s by %s %s', $this->dashboard_obj->created_at, $tmfsales->FirstName, $tmfsales->LastName);
                    else
//                        $boom_when_by=sprintf('created %s. UNCLAIMED',$tmf_aftersearch_obj->assigned_date);
                        $boom_when_by = sprintf('created %s. UNCLAIMED', $this->dashboard_obj->created_at);
                    $time_since_delta = $delta;
                }
            } else {
                $time_since_caption = '';
                $time_since_caption_icon = 'N/A';
                $time_since_formatted = 'N/A';
            }

            $last_condition = $tmoffer->tmfConditionTmfsalesTmofferRows()
                ->orderBy('when_date', 'desc')
                ->first();
            if ($last_condition && $last_condition->tmf_condition_id >= 5 && $last_condition->tmf_condition_id <= 7) {
                $tmf_aftersearch_objs = $tmoffer->tmfAftersearchesRows()
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
            } else
                $searching_finished = 0;

        } else {
            $time_since_caption = 'TM created in dashboard';
            $time_since_caption_icon = '<i class="fas fa-tachometer-alt"></i>';
            $delta = time() - \DateTime::createFromFormat('Y-m-d H:i:s', $this->dashboard_obj->created_at)->getTimestamp();
            $time_since_delta = $delta;
            $time_since_formatted = $this->formattedTime($delta);
//            $pending_in_this_status = 'N/A';

            $tmf_company = $this->dashboard_obj->tmfCompany;
            $rep_info = [
                'company' => '',
            ];
            if ($tmf_company->tmf_lawyer_id) {
                $rep_company = TmfCompany::find($tmf_company->tmf_lawyer_id);

                $tmf_company_subject_objs = $rep_company->tmfCompanySubjectRows()
                    ->orderBy('order_position')
                    ->get();
                $rep_info['company'] = sprintf('(%s)', $rep_company->name);
            } else {
                $tmf_company_subject_objs = $tmf_company->tmfCompanySubjectRows()
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
            $searching_finished = 0;
        }
        $tmf_country_trademark = $this->dashboard_obj->tmfCountryTrademark;
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
            $mark = sprintf('<img src="https://trademarkfactory.imgix.net/offerimages/%s" class="img-responsive preview" style="margin: auto;max-width:75px;max-height: 75px;">', $tmf_trademark->tmf_trademark_mark);
        return [
            'mark' => $mark,
            'logo_descr' => $logo_descr,
            'flag' => $flag,
            'country' => $country,
            'client' => $client_data,
            'time_since_delta' => $time_since_delta,
            'time_since_caption' => $time_since_caption,
            'time_since_formatted' => $time_since_formatted,
            'pending_in_this_status' => $pending_in_this_status,
            'pending_in_this_status_delta' => $pending_in_this_status_delta,
            'tmoffer' => $tmoffer,
            'dashboard' => $this->dashboard_obj,
            'searching_finished' => $searching_finished,
            'time_since_caption_icon' => $time_since_caption_icon,
            'boom_when_by' => $boom_when_by
//                'tctt'=>$last_condition
        ];
    }


    public function getDashboardQueueStatus($data, QueueRootStatus $queue_root_status)
    {
        $dashboard_tss_obj = DashboardTss::where('dashboard_id', $this->dashboard_obj->id)
            ->orderBy('id', 'desc')
            ->first();
        if ($dashboard_tss_obj) {
            $csf_id = $dashboard_tss_obj->cipostatus_status_formalized_id;
            $dgs_id = $dashboard_tss_obj->dashboard_global_status_id;
        } else {
            $csf_id = $this->dashboard_obj->cipostatus_status_formalized_id;
            $dgs_id = $this->dashboard_obj->dashboard_global_status_id;
        }

        $queue_status_objs = QueueStatus::where('cipostatus_status_formalized_id', $csf_id)
            ->where('dashboard_global_status_id', $dgs_id)
            ->whereIn('queue_root_status_id', QueueRootStatus::select('id')
                ->where('queue_type_id', $queue_root_status->queue_type_id)
            )
            ->get();
        if ($queue_status_objs->count() > 1) {
            if ($data['searching_finished'])
                return $queue_status_objs[1];
            else
                return $queue_status_objs[0];
        } elseif ($queue_status_objs->count() == 1) {
            return $queue_status_objs[0];
        } else {
            $queue_status_objs = QueueStatus::where('queue_root_status_id', $queue_root_status->id)
                ->where('dashboard_global_status_id', $dgs_id)
                ->get();
            if ($queue_status_objs->count() > 1) {
                if ($data['searching_finished'])
                    return $queue_status_objs[1];
                else
                    return $queue_status_objs[0];
            } elseif ($queue_status_objs->count() == 1) {
                return $queue_status_objs[0];
            } else
                return null;
        }
        return null;
    }

    public function formattedResultFromDataEl($el, $queue_status,$create_new_flags=1)
    {
        $owner = null;
        if ($el['dashboard']->dashboardOwnerRows()->whereNull('released_at')->count()) {
            $dashboard_owner = $el['dashboard']->dashboardOwnerRows()->whereNull('released_at')->orderBy('id', 'desc')->first();
            $owner = $dashboard_owner->tmfsales;
            $time_since_owner_delta = time() - \DateTime::createFromFormat('Y-m-d H:i:s', $dashboard_owner->created_at)->getTimestamp();
        } elseif ($el['dashboard']->dashboardOwnerRows()->whereNotNull('released_at')->count()) {
            $last_record = $el['dashboard']->dashboardOwnerRows()->orderBy('released_at', 'desc')->first();
            $time_since_owner_delta = time() - \DateTime::createFromFormat('Y-m-d H:i:s', $last_record->created_at)->getTimestamp();
        } else {
            $time_since_owner_delta = time() - \DateTime::createFromFormat('Y-m-d H:i:s', $el['dashboard']->created_at)->getTimestamp();
        }

        if ($time_since_owner_delta > $el['pending_in_this_status_delta'])
            $time_since_owner_delta = $el['pending_in_this_status_delta'];
        $time_since_owner = $this->formattedTime($time_since_owner_delta);

        $today = Carbon::now()->format('Y-m-d') . ' 00:00:00';
        $hard_deadline = '&mdash;';
        $hard_deadline_text_class='';
        $hard_deadline_text='';
        $hard_deadline_date = '';
        $hard_deadline_obj = $el['dashboard']->dashboardDeadlineRows()
            ->where('deadline_type_id', 1)
            ->whereNull('deadline_done_at')
            ->orderBy('deadline_date_at')
            ->first();
        if ($hard_deadline_obj) {
            $hd_datetime=\DateTime::createFromFormat('Y-m-d H:i:s', $hard_deadline_obj->deadline_date_at);
            $now = new \DateTime();
            $deadline_delta=intval($now->diff($hd_datetime)->format('%R%a'));
            if($deadline_delta<=7) {
                $hard_deadline_text = $this->getHardDeadlineText($deadline_delta);
                $hard_deadline_text_class='danger';
            }
            $hard_deadline_date = $hard_deadline = $hd_datetime->format('Y-m-d');
        }


        $dashboard_tss = $el['dashboard']->dashboardTsses()
            ->orderBy('id', 'desc')
            ->first();
        if (!$dashboard_tss->warning_at && $create_new_flags) {
            list($dashboard_tss->warning_at, $dashboard_tss->danger_at) = $this->getWarningAndDangerFlagDates(
                $queue_status,
                $dashboard_tss,
                $hard_deadline_date);
            $dashboard_tss->save();
        }

        $flag_bg_class = '';
        if(!in_array($queue_status->queue_root_status_id,[self::FILING_QUEUE_DONE,self::REG_QUEUE_DONE])) {
            $badge_class = 'badge-success';
            if (
                ($today >= $dashboard_tss->warning_at) &&
                ($today < $dashboard_tss->danger_at)
            ) {
                $flag_bg_class = 'bg-warning';
                $badge_class = 'badge-warning';
            }

            if ($today > $dashboard_tss->danger_at) {
                $flag_bg_class = 'bg-danger';
                $badge_class = 'badge-danger';
            }
        }

//        echo "dashboard_id:{$el['dashboard']->id}<br/>";
        $review_requested=LastDashboardOwnerRow::where('dashboard_id',$el['dashboard']->id)
            ->where('release_reason_id',3)
            ->first();
        $fist_icon='';
        if($review_requested) {
            $tmfsales=Tmfsales::find($review_requested->tmfsales_id);
            $request_review_details=RequestReviewDetails::where('dashboard_owner_id',
                $review_requested->id)
                ->first();
            $tooltip=$tmfsales->LongID.': '.
                ($request_review_details ? $request_review_details->description : 'NO MESSAGE');
            $fist_icon = sprintf(' <i class="fas fa-fist-raised" title="%s"></i>',$tooltip);
        }

        switch ($queue_status->queueRootStatus->queue_type_id){
            case self::REGISTRATION_QUEUE:
                $el['time_since_caption']='FILED';
                $el['time_since_caption_icon']='<i class="fas fa-trademark"></i>';
                $cipostatus=$el['dashboard']->cipostatus;
                if($cipostatus && $cipostatus->filed_date!='0000-00-00 00:00:00'){
                    $filed_date=\DateTime::createFromFormat('Y-m-d H:i:s', $cipostatus->filed_date);
                    $el['boom_when_by']=sprintf('FILED at %s',$filed_date->format('Y-m-d'));
                    $delta = time() - $filed_date->getTimestamp();
                    $el['time_since_delta'] = $delta;
                    $el['time_since_formatted'] = $this->formattedTime($delta);
                }
                break;
            case self::RENEWAL_QUEUE:
                $el['time_since_caption']='REGISTERED';
                $el['time_since_caption_icon']='<i class="far fa-registered"></i>';
                $cipostatus=$el['dashboard']->cipostatus;
                if($cipostatus && $cipostatus->registered_date!='0000-00-00'){
                    $el['boom_when_by']=sprintf('REGISTERED at %s',$cipostatus->registered_date);
                    $delta = time() - \DateTime::createFromFormat('Y-m-d', $cipostatus->registered_date)->getTimestamp();
                    $el['time_since_delta'] = $delta;
                    $el['time_since_formatted'] = $this->formattedTime($delta);
                }
                break;
        }

        $result=[
            'dashboard_id' => $el['dashboard']->id,
            'tmfsales_id' => ($owner ? $owner->ID : 0),
            'tmoffer_login' => ($el['tmoffer'] ? $el['tmoffer']->Login : ''),
            'tmoffer_id' => ($el['tmoffer'] ? $el['tmoffer']->ID : ''),
//            'addy_note' => ($el['tmoffer'] ? ThankYouCardSentTextGetter::run($el['tmoffer']->ID) : '[]'),
            'addy_note' => '',
            'trigger' => $el['time_since_caption'],
            'flag_bg_class' => $flag_bg_class,
            'badge_class' => $badge_class,
            'mark' => $el['mark'],
            'logo_descr' => $el['logo_descr'],
            'country' => $el['country'],
            'country_flag' => $el['flag'],
            'card-background' => ($review_requested ? '#ECD0FA':'transparent'),
            'review_requested'=>($review_requested?1:0),
            'owner_login' => ($owner ? $owner->LongID : '<span class="text-danger">IDLE</span>').$fist_icon,
            'owner_text_color_class' => ($owner ? '' : 'text-danger'),
            'hard_deadline' => $hard_deadline,
            'hard_deadline_text'=>$hard_deadline_text,
            'hard_deadline_text_class'=>$hard_deadline_text_class,
            'time_since_delta' => $el['time_since_delta'],
            'time_since_formatted' => $el['time_since_formatted'],
            'time_since_caption_icon' => $el['time_since_caption_icon'],
            'pending_in_this_status_delta' => $el['pending_in_this_status_delta'],
            'pending_in_this_status' => $el['pending_in_this_status'],
            'time_since_owner' => $time_since_owner,
            'client' => $el['client'],
            'boom_when_by' => $el['boom_when_by'],
            'agency_url'=>$this->getAgencyUrl($el['dashboard']),
//            'agency_url'=>'',
            'warning_at'=>$dashboard_tss->warning_at,
            'danger_at'=>$dashboard_tss->danger_at,
        ];
        $this->updateQueueCache($el['dashboard']->id,$result);
        return $result;
    }

    private function getHardDeadlineText($deadline_delta){
        switch ($deadline_delta){
            case 0:
                return 'TODAY';
            case -1:
                return 'YESTERDAY';
            case 1:
                return 'TOMORROW';
            default:
                if($deadline_delta>0)
                    return sprintf('IN %d DAY%s',$deadline_delta,($deadline_delta>1?'S':''));
                else
                    return sprintf('%d DAY%s AGO',abs($deadline_delta),(abs($deadline_delta)>1?'S':''));
        }
    }

    public function getWarningAndDangerFlagDates(QueueStatus $queue_status, DashboardTss $dashboard_tss, $hard_deadline_date)
    {
        $last_formal_status = Carbon::now()->format('Y-m-d');
        $filed_date = $last_formal_status;
        $registered_date = $last_formal_status;
        $dashboard = $dashboard_tss->dashboard;
        if ($dashboard->cipostatus) {
            $cipostatus = $dashboard->cipostatus;
            if ($cipostatus && $cipostatus->LastStatusDate != '0000-00-00 00:00:00') {
                $last_formal_status = \DateTime::createFromFormat('Y-m-d H:i:s', $cipostatus->LastStatusDate)->format('Y-m-d H:i:s');

                if ($cipostatus->registered_date != '0000-00-00') {
//                    echo $cipostatus->registered_date.'<br/>';
                    $registered_date = \DateTime::createFromFormat('Y-m-d', $cipostatus->registered_date)->format('Y-m-d H:i:s');
                }

                if ($cipostatus->filed_date != '0000-00-00 00:00:00')
                    $filed_date = \DateTime::createFromFormat('Y-m-d H:i:s', $cipostatus->filed_date)->format('Y-m-d H:i:s');
            }
        }
        $dashboard_dates = new DashboardDates();
        $dashboard_dates->filed_date = $filed_date;
        $dashboard_dates->last_formal_status_date = $last_formal_status;
        $dashboard_dates->registered_date = $registered_date;
        $dashboard_dates->filed_date = $filed_date;
        $dashboard_dates->hard_deadline_date = $hard_deadline_date;
        $start_date = \DateTime::createFromFormat('Y-m-d H:i:s', $dashboard_tss->created_at);
//        echo "<br/>dashboard_id: $dashboard_tss->dashboard_id<br/>";
//        echo $start_date->format('Y-m-d H:i:s').'<br/>';
//        var_dump($dashboard_dates);
//        echo "<br/>";
        $warning_flag_date = $this->generateFlagDateFromFlagSettings($queue_status->warningFlagSettings, $dashboard_dates, $start_date);
        $danger_flag_date = $this->generateFlagDateFromFlagSettings($queue_status->dangerFlagSettings, $dashboard_dates, $start_date);
        return [$warning_flag_date, $danger_flag_date];
    }

    private function generateFlagDateFromFlagSettings(QueueFlagSettings $queue_flag_settings,
                                                      DashboardDates $dashboard_dates,
                                                      \DateTime $start_date)
    {
//        echo "{$queue_flag_settings->dashboard_relative_start_date_type_id}<br/>";
        switch ($queue_flag_settings->dashboard_relative_start_date_type_id) {
            case self::Last_Formal_Status_Date:
//                var_dump($dashboard_dates);
                $start_date = \DateTime::createFromFormat('Y-m-d H:i:s', $dashboard_dates->last_formal_status_date);
//                dd($start_date);
                break;
            case self::Filed_Date:
                $start_date = \DateTime::createFromFormat('Y-m-d', $dashboard_dates->filed_date);
                break;
            case self::Registration_Date:
                $start_date = \DateTime::createFromFormat('Y-m-d', $dashboard_dates->registered_date);
                break;
            case self::Hard_Deadline:
                if (strlen($dashboard_dates->hard_deadline_date))
                    $start_date = \DateTime::createFromFormat('Y-m-d', $dashboard_dates->hard_deadline_date);
                break;
        }
//        echo $start_date->format('Y-m-d H:i:s').'<br/>';
        $interval_years = \DateInterval::createFromDateString($queue_flag_settings->year . ' years');
        $interval_months = \DateInterval::createFromDateString($queue_flag_settings->month . ' months');
        $interval_days = \DateInterval::createFromDateString($queue_flag_settings->day . ' days');
        $interval_hours = \DateInterval::createFromDateString($queue_flag_settings->hour . ' hours');
        switch ($queue_flag_settings->plus_minus_settings_id) {
            case self::Calendar_Days:
                if ($queue_flag_settings->plus_minus == 1) {
                    $start_date->add($interval_years)
                        ->add($interval_months)
                        ->add($interval_days)
                        ->add($interval_hours);
                }else
                    $start_date->sub($interval_years)
                        ->sub($interval_months)
                        ->sub($interval_days)
                        ->sub($interval_hours);
                break;
            case self::Monday_If_Falls_On_Weekend:
                if ($queue_flag_settings->plus_minus == 1) {
//                    var_dump($start_date);
//                    echo $start_date->format('Y-m-d H:i:s').'<br/>';
                    $start_date->add($interval_years)
                        ->add($interval_months)
                        ->add($interval_days)
                        ->add($interval_hours);
                }else
                    $start_date->sub($interval_years)
                        ->sub($interval_months)
                        ->sub($interval_days)
                        ->sub($interval_hours);
                if ($start_date->format('N') > 5)
                    $start_date->modify('+' . (8 - $start_date->format('N')) . ' days');
                break;
            case self::Business_Days_Only:
                if ($queue_flag_settings->plus_minus == 1)
                    $start_date->modify("+{$queue_flag_settings->day} weekdays");
                else
                    $start_date->modify("-{$queue_flag_settings->day} weekdays");
                break;
        }
        return $start_date->format('Y-m-d H:i:s');
    }


    private function getAgencyUrl(DashboardV2 $dashboard_obj)
    {
        $appno=$dashboard_obj->cipostatus_id;
        if ($dashboard_obj->cipostatus) {
            $agency_url='';
            switch ($dashboard_obj->cipostatus->cipo_uspto) {
                case "CIPO":
                    $agency_url = "http://www.ic.gc.ca/app/opic-cipo/trdmrks/srch/viewTrademark.html?id=$appno-0&lang=eng&status=&fileNumber=$appno&extension=0&startingDocumentIndexOnPage=1";
                    break;
                case "USPTO":
                    $agency_url = sprintf('http://tsdr.uspto.gov/#caseNumber=%s&caseType=SERIAL_NO&searchType=statusSearch', $appno);
                    break;
                case "OHIM":
                    $agency_url = "http://euipo.europa.eu/eSearch/#details/trademarks/" . $appno;
                    break;
                case "APO":
                    $agency_url = "https://search.ipaustralia.gov.au/trademarks/search/view/" . $appno;
                    break;
            }
            return $agency_url;
        }
        return '';
    }


    private function updateQueueCache($dashboard_id,$cache_arr){
        $queue_cache=QueueCache::where('dashboard_id',$dashboard_id)->first();
        if(!$queue_cache){
            $queue_cache=new QueueCache();
            $queue_cache->dashboard_id=$dashboard_id;
        }
        $queue_cache->json=json_encode($cache_arr);
        $queue_cache->save();
        return $queue_cache;
    }

    private function formattedTime($delta)
    {
        $d = intval($delta / (24 * 3600));
        $h = intval($delta % (24 * 3600) / 3600);
        $m = intval($delta % (24 * 3600) % 3600 / 60);
        $s = intval($delta % (24 * 3600) % 3600 % 60);
        return sprintf('%sd %sh %sm', $d, $h, $m);
    }
}