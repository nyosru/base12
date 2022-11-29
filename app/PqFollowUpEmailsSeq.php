<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PqFollowUpEmailsSeq extends Model
{
    protected $table='pq_follow_up_emails_seq';

    public $timestamps = false;

    public function pqFollowUpEmail()
    {
        return $this->belongsTo('App\PqFollowUpEmail');
    }

    public function tmfSubject()
    {
        return $this->belongsTo('App\TmfSubject');
    }

}
