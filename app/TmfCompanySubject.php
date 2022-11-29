<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TmfCompanySubject extends Model
{
    protected $table='tmf_company_subject';

    public $timestamps = false;

    public function tmfCompany()
    {
        return $this->belongsTo('App\TmfCompany');
    }

    public function tmfSubject()
    {
        return $this->belongsTo('App\TmfSubject');
    }


}
