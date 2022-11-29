<?php
namespace App\classes\clientipdataset;
//use App\classes\clientipdataset\ClientIpDataSet;
use App\BlockIp;
use App\TmfBooking;
use App\TmfClientTmsrTmoffer;
use App\Tmoffer;
use App\TmofferTmfCountryTrademark;

class SelfCheckoutClientIpDataSet extends ClientIpDataSet
{

    protected function initTmofferObj()
    {
        return Tmoffer::select('client_ip')
            ->where('sales_id','=','0')
            ->where('Sales','=','')
            ->where([
                ['created_date','>=',$this->filter->from_date.' 00:00:00'],
                ['created_date','<=',$this->filter->to_date.' 23:59:59'],
            ])
            ->whereIn('ID',TmofferTmfCountryTrademark::select('tmoffer_id'))
/*            ->where([
                ['how_find_out_us','!=', 'Direct-to-Booking Google Ad'],
                ['how_find_out_us','!=', 'PATlive'],
            ])*/
            ->where('how_find_out_us','not like', '%Direct-to-Booking Google Ad%')
            ->where('how_find_out_us','not like', '%PATlive%')
            ->whereNotIn('client_ip', BlockIp::select('ip'))
            ->whereNotIn('ID',
                TmfClientTmsrTmoffer::select('tmoffer_id')
                    ->whereIn('id',
                        TmfBooking::select('tmf_client_tmsr_tmoffer_id')
                    )
            )->whereNull('gparams');
    }
}