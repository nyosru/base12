<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TmfsalesTmofferNotBoomReason extends Model
{
    protected $table='tmfsales_tmoffer_not_boom_reason';

    public $timestamps = false;

    public function notBoomReason()
    {
        return $this->belongsTo('App\NotBoomReason');
    }

}
