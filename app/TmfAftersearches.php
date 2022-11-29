<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TmfAftersearches extends Model
{
    protected $table='tmf_aftersearches';

    public $timestamps = false;

    public function tmfsales()
    {
        return $this->belongsTo('App\Tmfsales', 'tmfsales_id','ID');
    }

}
