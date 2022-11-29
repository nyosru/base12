<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DashboardTss extends Model
{
    const TABLE_NAME='dashboard_tss';

    protected $table=self::TABLE_NAME;

    public $timestamps = false;

    public function dashboard()
    {
        return $this->belongsTo('App\DashboardV2','dashboard_id','id');
    }

    public function cipostatusStatusFormalized()
    {
        return $this->belongsTo(CipostatusStatusFormalized::class,'cipostatus_status_formalized_id','id');
    }

    public function dashboardGlobalStatus()
    {
        return $this->belongsTo(DashboardGlobalStatus::class);
    }

    public function tmfsales()
    {
        return $this->belongsTo(Tmfsales::class,'tmfsales_id','ID');
    }
}
