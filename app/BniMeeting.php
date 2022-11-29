<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BniMeeting extends Model
{
    protected $table='bni_meeting';

    public function bni()
    {
        return $this->belongsTo('App\Bni', 'bni_id');
    }

}
