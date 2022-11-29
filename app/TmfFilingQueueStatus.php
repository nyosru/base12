<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TmfFilingQueueStatus extends Model
{
    protected $table='tmf_filing_queue_status';

    public $timestamps = false;

    public function tmfFilingQueueRootStatus()
    {
        return $this->belongsTo('App\TmfFilingQueueRootStatus');
    }

    public function cipostatusStatusFormalized()
    {
        return $this->belongsTo('App\CipostatusStatusFormalized');
    }

    public function dashboardGlobalStatus()
    {
        return $this->belongsTo('App\DashboardGlobalStatus');
    }

    public function hoursCalculationMethod()
    {
        return $this->belongsTo('App\HoursCalculationMethod');
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
