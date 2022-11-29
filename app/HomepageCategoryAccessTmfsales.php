<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HomepageCategoryAccessTmfsales extends Model
{
    protected $table='homepage_category_access_tmfsales';

    public $timestamps = false;

    public function tmfsales()
    {
        return $this->belongsTo('App\Tmfsales', 'tmfsales_id','ID');
    }

    public function homepageCategory()
    {
        return $this->belongsTo('App\HomepageCategory');
    }

    public function homepageCategoryAccessType()
    {
        return $this->belongsTo('App\HomepageCategoryAccessType');
    }

}
