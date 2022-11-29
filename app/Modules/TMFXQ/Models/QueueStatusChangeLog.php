<?php

namespace App\Modules\TMFXQ\Models;

use Illuminate\Database\Eloquent\Model;

class QueueStatusChangeLog extends Model
{
    const TABLE_NAME='queue_status_change_log';

    protected $table=self::TABLE_NAME;

    public $timestamps = false;

    public function dashboard()
    {
        return $this->belongsTo('App\DashboardV2','dashboard_id','id');
    }

    public function tmfsales()
    {
        return $this->belongsTo('App\Tmfsales','tmfsales_id','ID');
    }

    public function oldQueueStatus()
    {
        return $this->belongsTo('App\QueueStatus','old_queue_status_id','id');
    }

    public function newQueueStatus()
    {
        return $this->belongsTo('App\QueueStatus','new_queue_status_id','id');
    }

    public static function boot()
    {
        parent::boot();

        static::creating(function (QueueStatusChangeLog $model) {
            $model->created_at = $model->freshTimestamp();
        });
    }

}
