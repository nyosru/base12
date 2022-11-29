<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class YoutubeVideo extends Model
{
    protected $table='youtube_video';

    public function videoClicks()
    {
        return $this->hasMany('App\YoutubeVideoClick');
    }

    public function videoVar()
    {
        return $this->hasMany('App\YoutubeVideoVar');
    }
}
