<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HomepageCategoryAccessType extends Model
{
    protected $table='homepage_category_access_type';

    public $timestamps = false;

    public function homepageCategoryAccessTmfsalesRows()
    {
        return $this->hasMany('App\HomepageCategoryAccessTmfsales');
    }

    public function homepageCategoryGroupAccessRows()
    {
        return $this->hasMany('App\HomepageCategoryGroupAccess');
    }

}
