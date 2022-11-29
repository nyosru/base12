<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OpsSnapshotTitleGroup extends Model
{
    protected $table='ops_snapshot_title_group';

    public $timestamps = false;

    public function opsSnapshotTitleRows()
    {
        return $this->hasMany('App\OpsSnapshotTitle');
    }

}
