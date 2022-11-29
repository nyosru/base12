<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TmfState extends Model
{
    protected $table='tmf_state';

    public $timestamps = false;

    public function tmfCompanies()
    {
        return $this->hasMany('App\TmfCompany');
    }

}
