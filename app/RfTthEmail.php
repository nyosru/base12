<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RfTthEmail extends Model
{
    protected $table='rftth_email';

    public $timestamps = false;

    public function rfTthEmailsSeqs()
    {
        return $this->hasMany('App\RfTthEmailsSeq');
    }
}
