<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TmfResourceLevel extends Model
{
    protected $table='tmf_resource_level';

    public function tmfResourceLevelIndexItem()
    {
        return $this->hasMany('App\TmfResourceLevelIndexItem');
    }
}
