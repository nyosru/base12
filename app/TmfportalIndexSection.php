<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TmfportalIndexSection extends Model
{
    protected $table='tmfportal_index_section';
    public $timestamps = false;

    public function tmfResourceLevelIndexItem()
    {
        return $this->hasMany('App\TmfResourceLevelIndexItem');
    }

}
