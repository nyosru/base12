<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QueueStatusStandartContextMenuItem extends Model
{
    protected $table='queue_status_standart_context_menu_item';

    public $timestamps = false;

    public function queueStatus()
    {
        return $this->belongsTo('App\QueueStatus');
    }

    public function standartContextMenuItem()
    {
        return $this->belongsTo('App\StandartContextMenuItem');
    }
}
