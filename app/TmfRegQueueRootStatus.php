<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TmfRegQueueRootStatus extends Model
{
    protected $table='tmf_reg_queue_root_status';

    public $timestamps = false;

    public function tmfRegQueueStatusRows()
    {
        return $this->hasMany('App\TmfRegQueueStatus');
    }

}
