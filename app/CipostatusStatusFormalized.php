<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CipostatusStatusFormalized extends Model
{
    protected $table='cipostatus_status_formalized';

    public $timestamps = false;

    public function dashboards()
    {
        return $this->hasMany('App\DashboardV2');
    }

    public function opsSnapshotTitleRows()
    {
        return $this->belongsToMany('App\OpsSnapshotTitle');
    }


}
