<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OpsSnapshotTitle extends Model
{
    protected $table='ops_snapshot_title';

    public $timestamps = false;

    public function cipostatusStatusFormalizedRows()
    {
        return $this->belongsToMany('App\CipostatusStatusFormalized');
    }

    public function opsSnapshotTitleGroup()
    {
        return $this->belongsTo('App\OpsSnapshotTitleGroup');
    }


}
