<?php

namespace App\classes\clientipdataset;
//use App\classes\clientipdataset\ClientIpDataSet;

use App\BlockIp;
use App\TmfBooking;
use App\TmfClientTmsrTmoffer;
use App\TmfsalesTmofferNotBoomReason;
use App\Tmoffer;
use App\TmofferTmfCountryTrademark;

class BookedClientIpDataSet extends ClientIpDataSet
{

    protected function getNoShowData()
    {
        if($this->filter->no_show==0)
            return [];

        return $this->dataToArr($this->initTmofferObj()
            ->whereIn('ID',TmfsalesTmofferNotBoomReason::select('tmoffer_id')->where('not_boom_reason_id',79))
            ->get()
            ->toArray());
    }


    protected function initTmofferObj()
    {
        return Tmoffer::select('client_ip')
            ->where([
                ['created_date','>=',$this->filter->from_date.' 00:00:00'],
                ['created_date','<=',$this->filter->to_date.' 23:59:59'],
            ])
//            ->whereIn('ID',TmofferTmfCountryTrademark::select('tmoffer_id'))
            ->where('how_find_out_us','not like', '%Direct-to-Booking Google Ad%')
            ->where('how_find_out_us','not like', '%PATlive%')
            ->whereNotIn('client_ip', BlockIp::select('ip'))
            ->whereIn('ID',
                TmfClientTmsrTmoffer::select('tmoffer_id')
                    ->whereIn('id',
                        TmfBooking::select('tmf_client_tmsr_tmoffer_id')->whereNull('gparams')
                    )
            )->whereNull('gparams');

    }
}