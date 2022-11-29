<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RedFlagsEmailsSeq extends Model
{
    protected $table='red_flags_emails_seq';

    public $timestamps = false;

    public function redFlagsEbookRequest()
    {
        return $this->belongsTo('App\RedFlagsEbookRequest');
    }

    public function redFlagsEmail()
    {
        return $this->belongsTo('App\RedFlagsEmail');
    }

}
