<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CustomContextMenuItemQueueStatus extends Model
{
    protected $table='custom_context_menu_item_queue_status';

    public $timestamps = false;

    public function queueStatus()
    {
        return $this->belongsTo('App\QueueStatus');
    }

    public function customContextMenuItem()
    {
        return $this->belongsTo('App\CustomContextMenuItem');
    }
}
