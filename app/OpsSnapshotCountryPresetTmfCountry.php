<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OpsSnapshotCountryPresetTmfCountry extends Model
{
    protected $table='ops_snapshot_country_preset_tmf_country';

    public $timestamps = false;

    public function opsSnapshotCountryPreset()
    {
        return $this->belongsTo('App\OpsSnapshotCountryPreset');
    }

    public function tmfCountry()
    {
        return $this->belongsTo('App\TmfCountry');
    }
}
