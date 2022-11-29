<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TmfFilingQueueRootStatus extends Model
{
    protected $table='tmf_filing_queue_root_status';

    public $timestamps = false;

    public function tmfFilingQueueStatusRows()
    {
        return $this->hasMany('App\TmfFilingQueueStatus');
    }

}
