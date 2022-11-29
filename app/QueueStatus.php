<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QueueStatus extends Model
{
    const TABLE_NAME='queue_status';

    protected $table=self::TABLE_NAME;

    public $timestamps = false;

    public function queueRootStatus()
    {
        return $this->belongsTo('App\QueueRootStatus');
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

    public function standartContextMenuItemRows()
    {
        return $this->belongsToMany('App\StandartContextMenuItem');
    }

    public function customContextMenuItemRows()
    {
        return $this->belongsToMany('App\CustomContextMenuItem');
    }
}
