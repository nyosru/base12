<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OpsSnapshot extends Model
{
    protected $table='ops_snapshot';

    public $timestamps = false;

    public function opsSnapshotTitle()
    {
        return $this->belongsTo('App\OpsSnapshotTitle');
    }

    public function opsSnapshotCountryPreset()
    {
        return $this->belongsTo('App\OpsSnapshotCountryPreset');
    }

    public function opsSnapshotDashboardV2s()
    {
        return $this->hasMany('App\OpsSnapshotDashboardV2');
    }

}
