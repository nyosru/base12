<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TmfCompany extends Model
{
    protected $table='tmf_company';

    public $timestamps = false;

    public function tmofferCompanySubjects()
    {
        return $this->hasMany('App\TmofferCompanySubject');
    }

    public function country()
    {
        return $this->belongsTo('App\Country');
    }

    public function tmfState()
    {
        return $this->belongsTo('App\TmfState');
    }

    public function tmfPersonType()
    {
        return $this->belongsTo('App\TmfPersonType');
    }

    public function tmfSubjects()
    {
        return $this->belongsToMany('App\TmfSubject','tmf_company_subject','tmf_company_id','tmf_subject_id');
    }

    public function dashboards()
    {
        return $this->hasMany('App\DashboardV2');
    }

    public function tmfCompanySubjectRows()
    {
        return $this->hasMany('App\TmfCompanySubject');
    }

    public function opsSnapshotCountryPresets()
    {
        return $this->belongsToMany('App\OpsSnapshotCountryPreset');
    }

}
