<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TmfCountry extends Model
{
    protected $table='tmf_country';

    public $timestamps = false;

    public function tmfCountryTrademarks()
    {
        return $this->hasMany('App\TmfCountryTrademark');
    }

}
