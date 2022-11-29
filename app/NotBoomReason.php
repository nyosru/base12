<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NotBoomReason extends Model
{
    protected $table='not_boom_reason';

    public $timestamps = false;

    public function tmfsalesTmofferNotBoomReasonRows()
    {
        return $this->hasMany('App\TmfsalesTmofferNotBoomReason');
    }


}
