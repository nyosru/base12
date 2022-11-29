<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DashboardDeadlineTemplate extends Model
{
    protected $table='dashboard_deadline_template';

    public $timestamps = false;

    public function dashboardTssTemplate()
    {
        return $this->belongsTo('App\DashboardTssTemplate');
    }

    public function dashboardRelativeStartDateType()
    {
        return $this->belongsTo('App\DashboardRelativeStartDateType');
    }

    public function deadlineAction()
    {
        return $this->belongsTo('App\DeadlineAction');
    }

    public function tmfsales()
    {
        return $this->belongsTo('App\Tmfsales', 'tmfsales_id','ID');
    }

}
