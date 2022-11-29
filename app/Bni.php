<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bni extends Model
{
    protected $table='bni';

    public function bniMeetings()
    {
        return $this->hasMany('App\BniMeeting');
    }

}
