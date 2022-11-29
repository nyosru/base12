<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PrequalifyRequest extends Model
{
    protected $table='prequalify_request';

    public $timestamps = false;

    public function tmfsales()
    {
        return $this->belongsTo('App\Tmfsales', 'handled_tmfsales_id','ID');
    }

    public function tmfsalesClaimed()
    {
        return $this->belongsTo('App\Tmfsales', 'claimed_tmfsales_id','ID');
    }

    public function tmfSubject()
    {
        return $this->belongsTo('App\TmfSubject');
    }

    public function leadStatus()
    {
        return $this->belongsTo('App\LeadStatus');
    }

    public function emailHistoryRows()
    {
        return $this->hasMany('App\PrequalifyRequestEmailHistory');
    }

    public function tmfBookings()
    {
        return $this->hasMany('App\TmfBooking');
    }

    public function tmoffer()
    {
        return $this->hasOne('App\Tmoffer');
    }

}
