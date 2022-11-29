<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DashboardReminderTemplate extends Model
{
    protected $table='dashboard_reminder_template';

    public $timestamps = false;

    public function tmfsalesRows()
    {
        return $this->belongsToMany('App\Tmfsales','dashboard_reminder_template_tmfsales','dashboard_reminder_template_id','tmfsales_id');
    }

    public function tmfResourceLevelRows()
    {
        return $this->belongsToMany('App\TmfResourceLevel','dashboard_reminder_template_tmf_resource_level','dashboard_reminder_template_id','tmf_resource_level_id');
    }


}
