<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tmf18botTmfsales extends Model
{
    protected $table='tmf18bot_tmfsales';

    public $timestamps = false;

    public function tmfsales()
    {
        return $this->belongsTo('App\Tmfsales');
    }


}
