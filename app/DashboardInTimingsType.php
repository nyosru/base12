<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DashboardInTimingsType extends Model
{
    protected $table='dashboard_in_timings_type';

    public $timestamps = false;


    public function dashboards()
    {
        return $this->hasMany('App\DashboardV2');
    }

}
