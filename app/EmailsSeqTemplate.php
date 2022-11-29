<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmailsSeqTemplate extends Model
{
    protected $table='emails_seq_template';

    public $timestamps = false;

    public function emailsSeqs()
    {
        return $this->hasMany('App\EmailsSeq');
    }

    public function emailsSeqGroup()
    {
        return $this->belongsTo('App\EmailsSeqGroup','emails_seq_group_id','id');
    }

}
