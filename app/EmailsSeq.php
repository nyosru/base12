<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmailsSeq extends Model
{
    protected $table='emails_seq';

    public $timestamps = false;

    public function tmfSubject()
    {
        return $this->belongsTo('App\TmfSubject');
    }

    public function emailsSeqTemplate()
    {
        return $this->belongsTo('App\EmailsSeqTemplate','emails_seq_template_id','id');
    }


}
