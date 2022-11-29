<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OutreachEmailTemplate extends Model
{
    protected $table='outreach_email_template';

    public $timestamps = false;

    public function outreachEmailLogs()
    {
        return $this->hasMany('App\OutreachEmailLog');
    }

}
