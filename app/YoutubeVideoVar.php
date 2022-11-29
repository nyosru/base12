<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class YoutubeVideoVar extends Model
{
    protected $table='youtube_video_var';

    public function youtubeVideo()
    {
        return $this->belongsTo('App\YoutubeVideo', 'youtube_video_id');
    }

    public function youtubeVar()
    {
        return $this->belongsTo('App\YoutubeVar', 'youtube_var_id');
    }

}
