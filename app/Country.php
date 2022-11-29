<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    protected $table='Country';

    public $timestamps = false;

    public function tmfCompanies()
    {
        return $this->hasMany('App\TmfCompany');
    }

}
