<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DashboardOwner extends Model
{
    protected $table='dashboard_owner';

    public $timestamps = false;

    public function dashboard()
    {
        return $this->belongsTo('App\DashboardV2','dashboard_id','id');
    }

    public function tmfsales()
    {
        return $this->belongsTo('App\Tmfsales', 'tmfsales_id','ID');
    }

    public function requestReviewDetails()
    {
        return $this->hasOne('App\RequestReviewDetails');
    }


}
