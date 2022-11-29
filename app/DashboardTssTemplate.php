<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DashboardTssTemplate extends Model
{
    protected $table='dashboard_tss_template';

    public $timestamps = false;


    public function cipostatusStatusFormalized()
    {
        return $this->belongsTo('App\CipostatusStatusFormalized');
    }

    public function dashboardGlobalStatus()
    {
        return $this->belongsTo('App\DashboardGlobalStatus');
    }

    public function dashboardDeadlineTemplateRows()
    {
        return $this->hasMany('App\DashboardDeadlineTemplate');
    }

}
