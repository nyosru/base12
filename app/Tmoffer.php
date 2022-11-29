<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tmoffer extends Model
{
    protected $table='tmoffer';
    protected $primaryKey = 'ID';
    public $timestamps = false;

    public function tmfClientTmsrTmoffer(){
        return $this->hasOne('App\TmfClientTmsrTmoffer');
    }

    public function prequalifyRequest(){
        return $this->hasOne('App\PrequalifyRequest');
    }

    public function tmofferBin()
    {
        return $this->hasOne('App\TmofferBin');
    }

    public function tmfsalesTmofferNotBoomReason()
    {
        return $this->hasOne('App\TmfsalesTmofferNotBoomReason');
    }

    public function tmofferTmfCountryTrademarkRows()
    {
        return $this->hasMany('App\TmofferTmfCountryTrademark','tmoffer_id','ID');
    }

    public function tmfConditionTmfsalesTmofferRows()
    {
        return $this->hasMany('App\TmfConditionTmfsalesTmoffer','tmoffer_id','ID');
    }

    public function tmfAftersearchesRows()
    {
        return $this->hasMany('App\TmfAftersearches','tmoffer_id','ID');
    }

    public function tmofferCompanySubjectRows()
    {
        return $this->hasMany('App\TmofferCompanySubject','tmoffer_id','ID');
    }


}
