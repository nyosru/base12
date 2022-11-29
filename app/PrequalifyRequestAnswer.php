<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PrequalifyRequestAnswer extends Model
{
    protected $table='prequalify_request_answer';

    public $timestamps = false;

    public function prequalifyQuestionOption()
    {
        return $this->belongsTo('App\PrequalifyQuestionOption');
    }

    public function prequalifyRequest()
    {
        return $this->belongsTo('App\PrequalifyRequest');
    }
}
