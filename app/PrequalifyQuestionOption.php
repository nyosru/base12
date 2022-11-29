<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PrequalifyQuestionOption extends Model
{
    protected $table='prequalify_question_option';

    public $timestamps = false;

    public function prequalifyQuestion()
    {
        return $this->belongsTo('App\PrequalifyQuestion');
    }
}
