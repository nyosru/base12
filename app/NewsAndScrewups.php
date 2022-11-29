<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NewsAndScrewups extends Model
{
    protected $table='news_and_screwups';

    public $timestamps = false;


    public function newsAndScrewupsCategory()
    {
        return $this->belongsTo('App\NewsAndScrewupsCategory');
    }

}
