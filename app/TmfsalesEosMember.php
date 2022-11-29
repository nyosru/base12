<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TmfsalesEosMember extends Model
{
    protected $table='tmfsales_eos_member';

    public $timestamps = false;

    public function tmfsales()
    {
        return $this->belongsTo('App\Tmfsales', 'tmfsales_id','ID');
    }

    public function eosMember()
    {
        return $this->belongsTo('App\EosMember');
    }

}
