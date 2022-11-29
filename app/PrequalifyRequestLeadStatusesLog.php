<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PrequalifyRequestLeadStatusesLog extends Model
{
    protected $table='prequalify_request_lead_statuses_log';

    public $timestamps = false;

    public function tmfsales()
    {
        return $this->belongsTo('App\Tmfsales', 'tmfsales_id','ID');
    }

    public function leadStatus()
    {
        return $this->belongsTo('App\LeadStatus');
    }

    public function prequalifyRequest()
    {
        return $this->belongsTo('App\PrequalifyRequest');
    }

}
