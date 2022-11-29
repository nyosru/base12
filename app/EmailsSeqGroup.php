<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmailsSeqGroup extends Model
{
    protected $table='emails_seq_group';

    public $timestamps = false;

    public function emailsSeqTemplates()
    {
        return $this->hasMany('App\EmailsSeqTemplate');
    }

}
