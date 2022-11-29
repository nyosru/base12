<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TmfPersonType extends Model
{
    protected $table='tmf_person_type';

    public $timestamps = false;

    public function tmfCompanies()
    {
        return $this->hasMany('App\TmfCompany');
    }

}
