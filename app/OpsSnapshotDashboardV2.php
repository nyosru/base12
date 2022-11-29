<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OpsSnapshotDashboardV2 extends Model
{
    protected $table='ops_snapshot_dashboard_v2';

    public $timestamps = false;

    public function opsSnapshot()
    {
        return $this->belongsTo('App\OpsSnapshot');
    }

    public function dashboard()
    {
        return $this->belongsTo('App\DashboardV2','dashboard_v2_id','id');
    }
}
