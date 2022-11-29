<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GroupMeeting extends Model
{
    protected $table='group_meeting';

    public $timestamps = false;

    public function tmfSubject()
    {
        return $this->belongsTo('App\TmfSubject');
    }

    public function groupMeetingTmfsales()
    {
        return $this->hasMany('App\GroupMeetingTmfsales');
    }

}
