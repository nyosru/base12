<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TmfCountryTrademark extends Model
{
    protected $table='tmf_country_trademark';

    public $timestamps = false;

    public function tmofferTmfCountryTrademarks()
    {
        return $this->hasMany('App\TmofferTmfCountryTrademark');
    }

    public function tmfTrademark()
    {
        return $this->belongsTo('App\TmfTrademark', 'tmf_trademark_id');
    }

    public function tmfCountry()
    {
        return $this->belongsTo('App\TmfCountry', 'tmf_country_id');
    }

    public function dashboards()
    {
        return $this->hasMany('App\DashboardV2');
    }

}
