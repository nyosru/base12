<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TmfSatisfactionProcess extends Model
{
    protected $table='tmf_satisfaction_process';

    public $timestamps = false;

    public function tmfSubjectSatisfactions()
    {
        return $this->hasMany('App\TmfSubjectSatisfaction');
    }

}
