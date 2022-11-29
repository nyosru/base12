<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GroupMeetingTmfsales extends Model
{
    protected $table='group_meeting_tmfsales';

    public $timestamps = false;

    public function tmfsales()
    {
        return $this->belongsTo('App\Tmfsales', 'tmfsales_id','ID');
    }

    public function groupMeeting()
    {
        return $this->belongsTo('App\GroupMeeting');
    }
}
