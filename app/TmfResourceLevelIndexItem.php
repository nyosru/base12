<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TmfResourceLevelIndexItem extends Model
{
    protected $table='tmf_resource_level_index_item';
    public $timestamps = false;

    public function tmfResourceLevel()
    {
        return $this->belongsTo('App\TmfResourceLevel', 'tmf_resource_level_id');
    }

    public function tmfportalIndexSection()
    {
        return $this->belongsTo('App\TmfportalIndexSection', 'tmfportal_index_section_id');
    }

}
