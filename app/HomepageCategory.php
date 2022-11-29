<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HomepageCategory extends Model
{
    protected $table='homepage_category';

    public $timestamps = false;

    public function tmfsales()
    {
        return $this->belongsTo('App\Tmfsales', 'tmfsales_id','ID');
    }

    public function homepageCategoryItems()
    {
        return $this->hasMany('App\HomepageItem');
    }

    public function homepageCategoryAccessTmfsalesRows()
    {
        return $this->hasMany('App\HomepageCategoryAccessTmfsales');
    }

    public function homepageCategoryGroupAccessRows()
    {
        return $this->hasMany('App\HomepageCategoryGroupAccess');
    }

}
