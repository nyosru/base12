<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TmfsalesAvailabilityLog extends Model
{
    protected $table='tmfsales_availability_log';

    public $timestamps = false;

    public function tmfsales()
    {
        return $this->belongsTo('App\Tmfsales', 'tmfsales_id','ID');
    }

}
