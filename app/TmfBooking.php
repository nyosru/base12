<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TmfBooking extends Model
{
    protected $table='tmf_booking';

    public $timestamps = false;

    public function sdr()
    {
        return $this->belongsTo('App\Tmfsales', 'sdr_id','ID');
    }

    public function closer()
    {
        return $this->belongsTo('App\Tmfsales', 'sales_id','ID');
    }

    public function tmfClientTmsrTmoffer()
    {
        return $this->belongsTo('App\TmfClientTmsrTmoffer');
    }

}
