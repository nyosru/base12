<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QueueCache extends Model
{
    protected $table='queue_cache';

    public $timestamps = false;

    public function dashboard()
    {
        return $this->belongsTo('App\DashboardV2','dashboard_id','id');
    }
}
