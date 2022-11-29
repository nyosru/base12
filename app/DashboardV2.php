<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DashboardV2 extends Model
{
    const TABLE_NAME='dashboard_v2';

    protected $table=self::TABLE_NAME;

    public $timestamps = false;

    public function dashboardTsses()
    {
        return $this->hasMany('App\DashboardTss','dashboard_id','id');
    }

    public function dashboardDeadlineRows()
    {
        return $this->hasMany('App\DashboardDeadline','dashboard_id','id');
    }

    public function cipostatusStatusFormalized()
    {
        return $this->belongsTo('App\CipostatusStatusFormalized');
    }

    public function tmfCountryTrademark()
    {
        return $this->belongsTo('App\TmfCountryTrademark');
    }

    public function tmfCompany()
    {
        return $this->belongsTo('App\TmfCompany');
    }

    public function tmfSubject()
    {
        return $this->belongsTo('App\TmfSubject');
    }

    public function dashboardInTimingsType()
    {
        return $this->belongsTo('App\DashboardInTimingsType');
    }

    public function dashboardGlobalStatus()
    {
        return $this->belongsTo('App\DashboardGlobalStatus');
    }

    public function opsSnapshotDashboardV2Rows()
    {
        return $this->hasMany('App\OpsSnapshotDashboardV2');
    }

    public function dashboardOwnerRows()
    {
        return $this->hasMany('App\DashboardOwner','dashboard_id','id');
    }

    public function cipostatus()
    {
        return $this->belongsTo('App\Cipostatus','cipostatus_id','AppNo');
    }

}
