<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OutreachEmailLog extends Model
{
    protected $table='outreach_email_log';

    public $timestamps = false;

    public function outreachTemplate()
    {
        return $this->belongsTo('App\OutreachEmailTemplate', 'outreach_email_template_id');
    }


}
