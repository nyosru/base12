<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TmfRegQueueStatus extends Model
{
    protected $table='tmf_reg_queue_status';

    public $timestamps = false;

    public function tmfRegQueueRootStatus()
    {
        return $this->belongsTo('App\TmfRegQueueRootStatus');
    }

    public function cipostatusStatusFormalized()
    {
        return $this->belongsTo('App\CipostatusStatusFormalized');
    }

    public function dashboardGlobalStatus()
    {
        return $this->belongsTo('App\DashboardGlobalStatus');
    }

    public function warningFlagSettings()
    {
        return $this->belongsTo('App\QueueFlagSettings', 'warning_flag_settings_id','id');
    }

    public function dangerFlagSettings()
    {
        return $this->belongsTo('App\QueueFlagSettings', 'danger_flag_settings_id','id');
    }

    public function queueStatusType()
    {
        return $this->belongsTo('App\QueueStatusType');
    }

}
