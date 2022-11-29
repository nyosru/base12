<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TmfTrademark extends Model
{
    protected $table='tmf_trademark';

    public $timestamps = false;

    public function tmfCountryTrademarks()
    {
        return $this->hasMany('App\TmfCountryTrademark');
    }

}
