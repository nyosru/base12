<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TmfSatisfactionIconScore extends Model
{
    protected $table='tmf_satisfaction_icon_score';

    public $timestamps = false;

    public function tmfSubjectSatisfactions()
    {
        return $this->hasMany('App\TmfSubjectSatisfaction');
    }

}
