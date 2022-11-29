<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class YoutubeVar extends Model
{
    protected $table='youtube_var';

    public function videoVar()
    {
        return $this->hasMany('App\YoutubeVideoVar');
    }

}
