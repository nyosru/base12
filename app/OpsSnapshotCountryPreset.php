<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OpsSnapshotCountryPreset extends Model
{
    protected $table='ops_snapshot_country_preset';

    public $timestamps = false;

    public function tmfCountries()
    {
        return $this->belongsToMany('App\TmfCountry');
    }

}
