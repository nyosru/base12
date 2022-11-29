<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class YoutubeVideoClick extends Model
{
    protected $table='youtube_video_click';

    public function youtubeVideo()
    {
        return $this->belongsTo('App\YoutubeVideo', 'youtube_video_id');
    }
}
