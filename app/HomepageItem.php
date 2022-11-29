<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HomepageItem extends Model
{
    protected $table='homepage_item';

    public $timestamps = false;

    public function tmfsales()
    {
        return $this->belongsTo('App\Tmfsales', 'tmfsales_id','ID');
    }

    public function homepageCategory()
    {
        return $this->belongsTo('App\HomepageCategory');
    }

}
