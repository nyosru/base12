<?php
namespace App\classes\dashboard\closers;

use App\classes\tmoffer\CompanySubjectInfo;
use App\Tmfsales;
use App\Tmoffer;
use App\TmofferBin;

class LatestBooms
{

    private $tmfsales;

    public function __construct(Tmfsales $tmfsales)
    {
        $this->tmfsales=$tmfsales;
    }

    public function getData($limit=5){
        if($limit)
            $tmoffers=Tmoffer::where('DateConfirmed','!=','0000-00-00')
                ->where(function ($query) {
                    $query->where('sales_id','=',$this->tmfsales->ID)
                        ->orWhere('Sales', '=', $this->tmfsales->Login);
                })
                ->whereIn('ID',TmofferBin::select('tmoffer_id')->where('need_capture',0))
                ->orderBy('DateConfirmed','desc')
                ->limit($limit)
                ->get();
        else
            $tmoffers=Tmoffer::where('DateConfirmed','!=','0000-00-00')
                ->where(function ($query) {
                    $query->where('sales_id','=',$this->tmfsales->ID)
                        ->orWhere('Sales', '=', $this->tmfsales->Login);
                })
                ->whereIn('ID',TmofferBin::select('tmoffer_id')->where('need_capture',0))
                ->orderBy('DateConfirmed','desc')
                ->get();
        $result=[];
        if($tmoffers && $tmoffers->count())
            foreach ($tmoffers as $tmoffer){
                $tmoffer_bin=TmofferBin::where('tmoffer_id',$tmoffer->ID)->first();
                $amount=array_sum(json_decode($tmoffer_bin->amount,true));
                $result[]=[
                    'company_info'=>CompanySubjectInfo::init($tmoffer)->get(),
                    'selected_currency'=>$tmoffer_bin->selected_currency,
                    'amount'=>round($amount*(1+$tmoffer_bin->gst+$tmoffer_bin->pst),2),
                    'tmoffer_id'=>$tmoffer->ID,
                    'tmoffer_login'=>$tmoffer->Login,
                    'date'=>\DateTime::createFromFormat('Y-m-d',$tmoffer->DateConfirmed)->format('M j, Y')
                ];
            }
        return $result;
    }

    public function getTotalBooms(){
        return Tmoffer::where('DateConfirmed','!=','0000-00-00')
            ->where(function ($query) {
                $query->where('sales_id','=',$this->tmfsales->ID)
                    ->orWhere('Sales', '=', $this->tmfsales->Login);
            })
            ->whereIn('ID',TmofferBin::select('tmoffer_id')->where('need_capture',0))
            ->count();
    }
}