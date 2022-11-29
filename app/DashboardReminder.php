<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DashboardReminder extends Model
{
    protected $table='dashboard_reminder';

    public $timestamps = false;

    public function dashboardDeadline()
    {
        return $this->belongsTo('App\DashboardDeadline');
    }

}
