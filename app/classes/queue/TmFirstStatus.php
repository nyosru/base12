<?php
namespace App\classes\queue;


use App\classes\tmoffer\CompanySubjectInfo;
use App\DashboardV2;
use App\TmfAftersearches;
use App\Tmoffer;
use App\TmofferTmfCountryTrademark;

class TmFirstStatus
{
    private $dashboard;

    public function __construct(DashboardV2 $dashboard)
    {
        $this->dashboard=$dashboard;
    }

    public function get(){
        $result=new QueueStatusData();
        $result->setDatetime($this->dashboard->created_at);

        if (!$this->dashboard->tmf_country_trademark_id)
            throw new \Exception(sprintf('"dashboard:%d not linked with tms!"',$this->dashboard->id));

        $tmoffer = Tmoffer::whereIn('ID', TmofferTmfCountryTrademark::select('tmoffer_id')
            ->where('tmf_country_trademark_id', $this->dashboard->tmf_country_trademark_id)
        )
            ->where('is_nobook', 1)
            ->first();

        if(!$tmoffer)
            $tmoffer = Tmoffer::whereIn('ID', TmofferTmfCountryTrademark::select('tmoffer_id')
                ->where('tmf_country_trademark_id', $this->dashboard->tmf_country_trademark_id)
            )
                ->where('DateConfirmed','!=', '0000-00-00')
                ->first();


        if ($tmoffer) {
            $client_info = CompanySubjectInfo::init($tmoffer)->get();

            if (strlen($client_info['company']))
                $client_data = $client_info['company'];
            else
                $client_data = trim((strlen($client_info['gender']) ? $client_info['gender'] . ' ' : '') . $client_info['firstname'] . ' ' . $client_info['lastname']);

            if ($tmoffer->is_nobook) {
                $result->setName('NOBOOK');
                $result->setIcon('🔎');
            } elseif ($tmoffer->DateConfirmed != '0000-00-00') {
                $result->setName('BOOM');
                $result->setIcon('💣');

                $tmf_aftersearch_obj = TmfAftersearches::where('tmoffer_id', $tmoffer->ID)
                    ->where('cancelled', '0000-00-00 00:00:00')
                    ->orderBy('id','desc')
                    ->first();
                if($tmf_aftersearch_obj){
                    $result->setName('AFTERSEARCH');
                    $result->setIcon('<i class="fas fa-search-plus"></i>');
                }
            } else{
                $result->setName('UNKNOWN');
                $result->setIcon('N/A');
            }

        } else {
            $result->setName('TM created in dashboard');
            $result->setIcon('<i class="fas fa-tachometer-alt"></i>');
        }
        return $result;
    }
}