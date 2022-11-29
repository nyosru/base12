<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LeadStatus extends Model
{
    protected $table='lead_status';

    public $timestamps = false;

    public function requalifyRequestRows()
    {
        return $this->hasMany('App\PrequalifyRequest');
    }


}
