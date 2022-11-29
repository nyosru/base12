<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PrequalifyRequestEmailHistory extends Model
{
    protected $table='prequalify_request_email_history';

    public $timestamps = false;

    public function prequalifyRequest()
    {
        return $this->belongsTo('App\PrequalifyRequest');
    }

    public function prequalifyRequestEmailType()
    {
        return $this->belongsTo('App\PrequalifyRequestEmailType');
    }

    public function fromTmfsales()
    {
        return $this->belongsTo('App\Tmfsales', 'from_tmfsales_id','ID');
    }

    public function sentTmfsales()
    {
        return $this->belongsTo('App\Tmfsales', 'sent_tmfsales_id','ID');
    }


}
