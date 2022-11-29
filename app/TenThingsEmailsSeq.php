<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TenThingsEmailsSeq extends Model
{
    protected $table='ten_things_emails_seq';

    public $timestamps = false;

    public function tenThingsEbookRequest()
    {
        return $this->belongsTo('App\TenThingsEbookRequest');
    }

    public function tenThingsEmail()
    {
        return $this->belongsTo('App\TenThingsEmail');
    }
}
