<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QueueFlagSettings extends Model
{
    protected $table='queue_flag_settings';

    public $timestamps = false;

    public function dashboardRelativeStartDateType()
    {
        return $this->belongsTo('App\DashboardRelativeStartDateType');
    }

    public function plusMinusSettings()
    {
        return $this->belongsTo('App\PlusMinusSettings');
    }
}
