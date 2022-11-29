<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TmfSubjectSatisfaction extends Model
{
    protected $table='tmf_subject_satisfaction';

    public $timestamps = false;

    public function tmfSubject()
    {
        return $this->belongsTo('App\TmfSubject');
    }

    public function tmfSatisfactionIconScore()
    {
        return $this->belongsTo('App\TmfSatisfactionIconScore');
    }

    public function tmfSatisfactionProcess()
    {
        return $this->belongsTo('App\TmfSatisfactionProcess');
    }


}
