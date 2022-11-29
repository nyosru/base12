<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TmfClientTmsrTmoffer extends Model
{
    protected $table='tmf_client_tmsr_tmoffer';

    public function tmoffer(){
        return $this->hasOne('App\Tmoffer','tmoffer_id','ID');
    }

    public function tmfBookings()
    {
        return $this->hasMany('App\TmfBooking');
    }

}
