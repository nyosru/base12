<?php
namespace App\classes\dashboard\closers;

use App\classes\tmoffer\CompanySubjectInfo;
use App\TmfBooking;
use App\TmfClientTmsrTmoffer;
use App\Tmfsales;
use App\TmfsalesTmofferNotBoomReason;
use App\Tmoffer;
use App\TmofferBin;
use Carbon\Carbon;

class EmptyCallReports
{

    private $tmfsales;

    public function __construct(Tmfsales $tmfsales)
    {
        $this->tmfsales=$tmfsales;
    }

    private static function cmp($a, $b)
    {
        $aa=\DateTime::createFromFormat('M j, Y',$a['date']);
        $bb=\DateTime::createFromFormat('M j, Y',$b['date']);
        if ($aa->format('Y-m-d') == $bb->format('Y-m-d'))
            return 1;
        return ($aa->format('Y-m-d') > $bb->format('Y-m-d') ? -1 : 1);
    }


    public function getData($limit=5){
        $today=Carbon::now();
        $from=new \DateTime('2020-10-01 00:00:00');
        $common_array=$this->getEmptyBoomReports($from,$today);
        $empty_noboom_reports=$this->getEmptyNoBoomReports($from,$today);
        foreach ($empty_noboom_reports as $el)
            $common_array[]=$el;

        $result=[];
        if(count($common_array))
            foreach ($common_array as $tmoffer){
                $tmf_booking=TmfBooking::whereIn('tmf_client_tmsr_tmoffer_id',
                    TmfClientTmsrTmoffer::select('id')->where('tmoffer_id',$tmoffer->ID))
                    ->where('booked_date','!=','0000-00-00 00:00:00')
                    ->orderBy('id','desc')
                    ->first();
//                echo "booked_date:{$tmf_booking->booked_date}<br/>";
                $result[]=[
                    'company_info'=>CompanySubjectInfo::init($tmoffer)->get(),
                    'tmoffer_id'=>$tmoffer->ID,
                    'tmoffer_login'=>$tmoffer->Login,
                    'date'=>\DateTime::createFromFormat('Y-m-d H:i:s',$tmf_booking->booked_date)->format('M j, Y')
                ];
            }
        usort($result,['App\classes\dashboard\closers\EmptyCallReports','cmp']);
        if($limit)
             return array_slice($result, 0, $limit, true);
        else
            return $result;
//        usort($data,['App\classes\dashboard\closers\EmptyCallReports','cmp']);
//        return $data;
    }

    private function getEmptyBoomReports($from_date,$to_date){
        $result=[];
        $tmoffers=Tmoffer::whereIn('ID',TmofferBin::select('tmoffer_id')
            ->whereNull('boom_reason')
            ->where('need_capture',0)
            ->where([
                ['modified_at','>=',$from_date->format('Y-m-d H:i:s')],
                ['modified_at','<=',$to_date->format('Y-m-d H:i:s')],
            ])
        )->where('DateConfirmed','!=','0000-00-00')
        ->where(function ($query) {
                $query->where('sales_id','=',$this->tmfsales->ID)
                    ->orWhere('Sales', '=', $this->tmfsales->Login);
            })
        ->get();
        if($tmoffers && $tmoffers->count())
            foreach ($tmoffers as $tmoffer){
                $tmf_bookings=TmfBooking::whereIn('tmf_client_tmsr_tmoffer_id',
                    TmfClientTmsrTmoffer::select('id')->where('tmoffer_id',$tmoffer->ID))
                    ->get();
                if($tmf_bookings && $tmf_bookings->count())
                    $result[]=$tmoffer;
            }
        return $result;
    }

    private function getEmptyNoBoomReports($from_date,$to_date){
        return Tmoffer::whereIn('ID',TmfClientTmsrTmoffer::select('tmoffer_id')
            ->whereIn('id', TmfBooking::select('tmf_client_tmsr_tmoffer_id')
                ->distinct()
                ->where([
                    ['booked_date','>=',$from_date->format('Y-m-d').' 00:00:00'],
                    ['booked_date','<=',$to_date->format('Y-m-d H:i:s')]
                ])
                ->whereNotIn('tmf_client_tmsr_tmoffer_id',TmfBooking::select('tmf_client_tmsr_tmoffer_id')
                    ->distinct()
                    ->where('booked_date','0000-00-00 00:00:00')
                )
            )
        )->whereNotIn('ID',TmofferBin::select('tmoffer_id')
            ->where('need_capture',0)
            ->where('modified_at','>=',$from_date->format('Y-m-d H:i:s'))
        )->whereNotIn('ID',TmfsalesTmofferNotBoomReason::select('tmoffer_id'))
        ->where(function ($query) {
                $query->where('sales_id','=',$this->tmfsales->ID)
                    ->orWhere('Sales', '=', $this->tmfsales->Login);
            })
            ->get();

    }
}