<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QueueType extends Model
{
    const TABLE_NAME='queue_type';

    protected $table=self::TABLE_NAME;

    public $timestamps = false;
}
