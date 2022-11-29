<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TmfSubjectContact extends Model
{
    protected $table='tmf_subject_contact';

    public $timestamps = false;

    public function tmfSubject()
    {
        return $this->belongsTo('App\TmfSubject');
    }

    public function contactDataType()
    {
        return $this->belongsTo('App\ContactDataType');
    }

}
