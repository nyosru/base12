<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CustomContextMenuItem extends Model
{
    protected $table='custom_context_menu_item';

    public $timestamps = false;

    public function queueStatusRows()
    {
        return $this->belongsToMany('App\QueueStatus');
    }

}
