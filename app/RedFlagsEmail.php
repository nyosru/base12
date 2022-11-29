<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RedFlagsEmail extends Model
{
    protected $table='red_flags_email';

    public $timestamps = false;

    public function redFlagsEmailsSeqs()
    {
        return $this->hasMany('App\RedFlagsEmailsSeq');
    }
}
