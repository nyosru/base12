<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OeBookingCall extends Model
{
    protected $table='oe_booking_call';

    public $timestamps = false;

    public function tmfsalesOeBookingCalls()
    {
        return $this->hasMany('App\TmfsalesOeBookingCall');
    }


}
