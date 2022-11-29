<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TmofferBin extends Model
{
    protected $table='tmoffer_bin';

    public $timestamps = false;

    public function tmoffer()
    {
        return $this->hasOne('App\Tmoffer');
    }

}
