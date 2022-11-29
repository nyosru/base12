<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QueueRootStatus extends Model
{
    const TABLE_NAME='queue_root_status';

    protected $table=self::TABLE_NAME;

    public $timestamps = false;

    public function queueType()
    {
        return $this->belongsTo('App\QueueType');
    }

    public function queueStatusRows()
    {
        return $this->hasMany('App\QueueStatus');
    }

}
