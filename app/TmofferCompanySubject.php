<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TmofferCompanySubject extends Model
{
    protected $table='tmoffer_company_subject';

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
