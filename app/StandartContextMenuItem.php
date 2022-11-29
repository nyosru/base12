<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StandartContextMenuItem extends Model
{
    protected $table='standart_context_menu_item';

    public $timestamps = false;

    public function queueStatusRows()
    {
        return $this->belongsToMany('App\QueueStatus');
    }

}
