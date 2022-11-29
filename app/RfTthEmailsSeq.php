<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RfTthEmailsSeq extends Model
{
    protected $table='rftth_emails_seq';

    public $timestamps = false;

    public function tmfSubject()
    {
        return $this->belongsTo('App\TmfSubject');
    }

    public function rfTthEmail()
    {
        return $this->belongsTo('App\RfTthEmail','rftth_email_id','id');
    }


}
