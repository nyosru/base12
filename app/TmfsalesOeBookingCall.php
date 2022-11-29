<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TmfsalesOeBookingCall extends Model
{
    protected $table='tmfsales_oe_booking_call';

    public $timestamps = false;

    public function tmfsales()
    {
        return $this->belongsTo('App\Tmfsales', 'tmfsales_id','ID');
    }

    public function oeBookingCall()
    {
        return $this->belongsTo('App\OeBookingCall');
    }


}
