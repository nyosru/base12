<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TmofferTmfCountryTrademark extends Model
{
    protected $table='tmoffer_tmf_country_trademark';

    public $timestamps = false;

    public function tmfTrademarks()
    {
        return $this->belongsToMany('App\TmfTrademark','tmf_country_trademark','tmoffer_tmf_country_trademark_id','tmf_trademark_id');
    }

    public function tmfCountryTrademark()
    {
        return $this->belongsTo('App\TmfCountryTrademark', 'tmf_country_trademark_id');
    }

    public function tmoffer()
    {
        return $this->belongsTo('App\Tmoffer', 'tmoffer_id','ID');
    }

    public function tmfPackages()
    {
        return $this->belongsTo('App\TmfPackages', 'tmf_packages_id','id');
    }

    public function regYesNoStatus()
    {
        return $this->belongsTo('App\RegYesNoStatus', 'reg_yes_no_status_id','id');
    }

}
