<?php
namespace App\classes\tsstranslator;


use App\classes\common\TSW;
use App\DashboardV2;
use App\TmfCompanySubject;
use App\TmfCountry;
use App\Tmfsales;
use App\TmfSubjectContact;
use App\TmofferCompanySubject;
use App\TmofferTmfCountryTrademark;

class TssTemplateVariablesTranslator
{
    private $dashboard;
    private $tss_context;

    public function __construct(DashboardV2 $dashboard)
    {
        $this->dashboard=$dashboard;
        $this->tss_context=new TssContext();
    }

    public static function getCountriesTags(){
        $result=[];
        $tmf_countries=TmfCountry::all();
        foreach ($tmf_countries as $el)
                $result[]=strtolower($el->tmf_country_code);
        return $result;
    }

    public static function getTmfsalesTags(){
        $result=[];
        $tmfsales=Tmfsales::all();
        foreach ($tmfsales as $el)
                $result[]=strtolower($el->Login);
        return $result;
    }

    public static function initByDashboardId($dashboard_id){
        return new self(DashboardV2::find($dashboard_id));
    }


    public function createVariablesValue(){
        $result=[];
        $this->initParams();
        $this->tss_context->rewind();
        while($this->tss_context->valid()){
            $key=$this->tss_context->key();
            $el=$this->tss_context->current();
            $result[$key]=$el;
            $this->tss_context->next();
        }
//        var_dump($result);
        return $result;
    }

    private function getStyleByPackageInfo($package_info)
    {
        return "
                display: inline-block;
                margin-bottom: 0;
                text-align: center;
                vertical-align: middle;
                background-image: none;
                border: 1px solid transparent;
                white-space: nowrap;
                padding: 6px 12px;
                font-size: 10px;
                line-height: 1.42857143;
                border-radius: 4px;
                -webkit-user-select: none;
                -moz-user-select: none;
                -ms-user-select: none;
                user-select: none;
                color: " . $package_info->button_text_color . ";
                background-color: " . $package_info->button_gradient_from . ";
                border-color: " . $package_info->button_gradient_to . ";
                font-weight: bold;
                text-shadow: 1px 1px 0px " . $package_info->button_text_shadow . ";
                box-shadow: inset 0px 1px 0px 0px " . $package_info->button_box_shadow . ";
                background: -webkit-gradient(linear, left top, left bottom, color-stop(0.05, " . $package_info->button_gradient_from . "), color-stop(1, " . $package_info->button_gradient_to . "));
                -moz-box-shadow: inset 0px 1px 0px 0px " . $package_info->button_text_shadow . ";
                -webkit-box-shadow: inset 0px 1px 0px 0px " . $package_info->button_box_shadow . ";
                background: -moz-linear-gradient(center top, " . $package_info->button_gradient_from . " 5%, " . $package_info->button_gradient_to . " 100%);
                filter: progid:DXImageTransform.Microsoft.gradient(startColorstr=\"" . $package_info->button_gradient_from . "\", endColorstr=\"" . $package_info->button_gradient_to . "\");
            ";
    }


    private function initTmofferVars(){
        $tmoffer_company_subject=TmofferCompanySubject::where('tmf_company_id',$this->dashboard->tmf_company_id)
            ->first();
        $tmoffer_tmf_country_trademark=null;
        if($tmoffer_company_subject)
            $tmoffer_tmf_country_trademark=TmofferTmfCountryTrademark::where('tmf_country_trademark_id',$this->dashboard->tmf_country_trademark_id)
                ->where('tmoffer_id',$tmoffer_company_subject->tmoffer_id)
                ->first();
        if($tmoffer_tmf_country_trademark){
//            echo $tmoffer_tmf_country_trademark->getId()."<br/>";
            $tmoffer=$tmoffer_tmf_country_trademark->tmoffer;
            $tmf_packages=$tmoffer_tmf_country_trademark->tmfPackages;
            if($tmf_packages){
                $style = $this->getStyleByPackageInfo($tmf_packages);
                $package_button = "<div style='$style'>" . $tmf_packages->title . "</div>";
                $package_title=ucwords(strtolower($tmf_packages->title),'-');
            }else {
                $package_button = "<div>N/A</div>";
                $package_title='N/A';
            }
            $this->tss_context->setValue('TM_TMF_Package_IMG',$package_button);
            $this->tss_context->setValue('TM_TMF_Package',$package_title);
            $this->tss_context->setValue('TM_Searchreport_Code',$tmoffer->Code);
            $link=sprintf('https://trademarkfactory.com/report/%s',$tmoffer->Login);
            $this->tss_context->setValue('TM_Searchreport_URL',$link);
            if($tmoffer_tmf_country_trademark->reg_yes_no_status)
                switch($tmoffer_tmf_country_trademark->regYesNoStatus->percent){
                    //                case "registrable":
                    //                case 'registrable_100_plus':
                    case '100+':
                        $this->tss_context->setValue('TM_TMF_Guarantee','100%+');
                        $this->tss_context->setValue('TM_TMF_Guarantee_IMG','<img src="/img/moneybackplus-report.png" />');
                        break;
                    //                case "problematicDO":
                    //                case "registrable_100":
                    case "100":
                        $this->tss_context->setValue('TM_TMF_Guarantee','100%');
                        $this->tss_context->setValue('TM_TMF_Guarantee_IMG','<img src="/img/moneyback100-report.png" />');
                        break;
                    //                case "problematicNO":
                    case "50":
                        $this->tss_context->setValue('TM_TMF_Guarantee','50%');
                        $this->tss_context->setValue('TM_TMF_Guarantee_IMG','<img src="/img/moneyback50-report.png" />');
                        break;
                    //                case "unregistrable":
                    case "0":
                        $this->tss_context->setValue('TM_TMF_Guarantee','0%');
                        $this->tss_context->setValue('TM_TMF_Guarantee_IMG','<img src="/img/moneyback0-report.png" />');
                        break;
                }
            else{
                $this->tss_context->setValue('TM_TMF_Guarantee','N/A');
                $this->tss_context->setValue('TM_TMF_Guarantee_IMG','N/A');
            }
        }
    }

    private function getTmfSubjectContact($tmf_subject_id,$contact_data_type_id){
        $tmf_subject_contact=TmfSubjectContact::where('tmf_subject_id',$tmf_subject_id)
            ->where('contact_data_type_id',$contact_data_type_id)
            ->first();
        if($tmf_subject_contact)
            return $tmf_subject_contact->contact;
        return '';
    }

    private function initParams(){
        $this->initTmofferVars();
        if($this->dashboard->tmf_subject_id)
            $tmf_subject=$this->dashboard->tmfSubject;
        else {
            $tmf_company_subject=TmfCompanySubject::where('tmf_company_id',$this->dashboard->tmf_company_id)
                ->orderBy('order_position','asc')
                ->first();
            $tmf_subject = $tmf_company_subject->tmfSubject;
        }

        $tsw_process_id=4;
        $cipostatus_status_formalized=$this->dashboard->cipostatusStatusFormalized;
        switch ($cipostatus_status_formalized->status_order){
            case 3://filed
                $tsw_process_id=4;
                break;
            case 5://filed
                $tsw_process_id=5;
                break;
            case 7://filed
                $tsw_process_id=6;
                break;
            case 8:
                if($cipostatus_status_formalized->id==6)
                    $tsw_process_id=7;
                break;
        }

//        echo "tsw_process_id:$tsw_process_id<br/>";
        $this->tss_context->setValue('tmf-satisfaction-widget',TSW::initProcess($tsw_process_id)->show($tmf_subject->id));
        $this->tss_context->setValue('Client_Email',$this->getTmfSubjectContact($tmf_subject->id,1));
        $this->tss_context->setValue('Client_Phone',$this->getTmfSubjectContact($tmf_subject->id,4));
        $this->tss_context->setValue('Client_FirstName',$tmf_subject->first_name);
        $this->tss_context->setValue('Client_LastName',$tmf_subject->last_name);

        $tmf_country_trademark=$this->dashboard->tmfCountryTrademark;
        $tmf_trademark=$tmf_country_trademark->tmfTrademark;
        $tmf_country=$tmf_country_trademark->tmfCountry;

        $this->tss_context->setValue('TM_Office',$tmf_country->tmf_country_TrademarkOffice);
        $this->tss_context->setValue('Today',date('M d, Y'));
        $this->tss_context->setValue('Today_Full',date('F d, Y'));
        $this->tss_context->setValue('Today_MY',date('F \o\f Y'));

        if($tmf_trademark->tmf_trademark_type_id==2)
            $this->tss_context->setValue('TM','<span class="tm">'.$tmf_trademark->tmf_trademark_mark.'</span>');
        else
            $this->tss_context->setValue('TM',sprintf('<img src="https://trademarkfactory.imgix.net/offerimages/%s" style="max-width: 75px;max-height: 75px;">',$tmf_trademark->tmf_trademark_mark));

        $this->tss_context->setValue('Country',$tmf_country->tmf_country_name);
        $this->tss_context->setValue('TM_URL_TMF','TM_URL_TMF');
        if($this->dashboard->cipostatus_id){

            $this->tss_context->setValue('AppNo',$this->dashboard->cipostatus_id);
            $cipostatus=$this->dashboard->cipostatus;
            if($cipostatus) {
                switch ($cipostatus->cipo_uspto) {
                    case "CIPO":
                        $this->tss_context->setValue('TM_URL_Office',"http://www.ic.gc.ca/app/opic-cipo/trdmrks/srch/viewTrademark.html?id={$this->dashboard->cipostatus_id}-0&lang=eng&status=&fileNumber={$this->dashboard->cipostatus_id}&extension=0&startingDocumentIndexOnPage=1");
                        break;
                    case "USPTO":
                        $this->tss_context->setValue('TM_URL_Office',"http://tsdr.uspto.gov/#caseNumber=" . $this->dashboard->cipostatus_id . "&caseType=SERIAL_NO&searchType=statusSearch");
                        break;
                    case "OHIM":
                        $this->tss_context->setValue('TM_Office','EUIPO');
                        $this->tss_context->setValue('TM_URL_Office',"http://euipo.europa.eu/eSearch/#details/trademarks/" . $this->dashboard->cipostatus_id);
                        break;
                    case "APO":
                        $this->tss_context->setValue('TM_URL_Office',"https://search.ipaustralia.gov.au/trademarks/search/view/" . $this->dashboard->cipostatus_id);
                        break;
                }

                if($cipostatus->filed_date!='0000-00-00 00:00:00') {
                    $filed_date=\DateTime::createFromFormat('Y-m-d H:i:s',$cipostatus->filed_date);
                    $this->tss_context->setValue('TM_Filed_Date', $filed_date->format('M d, Y'));
                    $this->tss_context->setValue('TM_Filed_Date_Full', $filed_date->format('F d, Y'));
                    $this->tss_context->setValue('TM_Filed_Date_MY', $filed_date->format('F \o\f Y'));
                }else{
                    $this->tss_context->setValue('TM_Filed_Date', 'N/A');
                    $this->tss_context->setValue('TM_Filed_Date_Full', 'N/A');
                    $this->tss_context->setValue('TM_Filed_Date_MY', 'N/A');
                }
                if($cipostatus->LastStatusDate!='0000-00-00 00:00:00') {
                    $last_status_date=\DateTime::createFromFormat('Y-m-d H:i:s',$cipostatus->LastStatusDate);
                    $this->tss_context->setValue('TM_Last_Status_Date_Full', $last_status_date->format('F d, Y'));
                    $this->tss_context->setValue('TM_Last_Status_Date', $last_status_date->format('M d, Y'));
                    $this->tss_context->setValue('TM_Last_Status_Date_MY', $last_status_date->format('F \o\f Y'));
                }else{
                    $this->tss_context->setValue('TM_Last_Status_Date_Full', 'N/A');
                    $this->tss_context->setValue('TM_Last_Status_Date', 'N/A');
                    $this->tss_context->setValue('TM_Last_Status_Date_MY', 'N/A');
                }
                $this->tss_context->setValue('TM_Last_Status',$cipostatus->LastStatus);
                $this->tss_context->setValue('RegAppNo',$cipostatus->RegNo);
                $this->tss_context->setValue('TM_Owner',$cipostatus->TMOwner);
                if($cipostatus->registered_date!='0000-00-00') {
                    $reg_date=\DateTime::createFromFormat('Y-m-d',$cipostatus->registered_date);
                    $this->tss_context->setValue('TM_Reg_Date',$reg_date->format('M d, Y'));
                    $this->tss_context->setValue('TM_Reg_Date_Full',$reg_date->format('F d, Y'));
                    $this->tss_context->setValue('TM_Reg_Date_MY',$reg_date->format('F \o\f Y'));
                }

                switch($cipostatus->applicationCovers->ac_name){
                    case 'Goods':
                        $this->tss_context->setValue('G_and_S','products');
                        $this->tss_context->setValue('G_or_S','products');
                        break;
                    case 'Services':
                        $this->tss_context->setValue('G_and_S','services');
                        $this->tss_context->setValue('G_or_S','services');
                        break;
                    case 'Goods & Services':
                        $this->tss_context->setValue('G_and_S','products and services');
                        $this->tss_context->setValue('G_or_S','products or services');
                        break;
                }
            }
        }
    }

    public function replaceText($text){
        $this->initParams();
        $this->tss_context->rewind();
        while($this->tss_context->valid()){
            $key=$this->tss_context->key();
            $value=$this->tss_context->current();

            $text = str_replace('%%%' . $key . '%%%', $value, $text);
            $this->tss_context->next();
        }
        return $text;
    }

}