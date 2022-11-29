<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NewsAndScrewupsCategory extends Model
{
    protected $table='news_and_screwups_category';

    public $timestamps = false;

    public function items()
    {
        return $this->hasMany('App\NewsAndScrewups');
    }


}
