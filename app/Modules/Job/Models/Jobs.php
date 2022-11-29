<?php

namespace App\Modules\Job\Models;

// use Illuminate\Foundation\Auth\User as Authenticatable;
// use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Jobs extends Model
{
    // use SoftDeletes;
    // const STATUS_ENABLED = 1;
    // const STATUS_DISABLED = 0;

    const TABLE_NAME = 'job_jobs';

    // protected $rememberTokenName = false;
    // off > created_at and updated_at
    // public $timestamps = false;

    /**
     * @var string
     */
    protected $table = self::TABLE_NAME;

    /**
     * @var array
     */
    protected $fillable = [
        'kooperativ',
        'nomer',
        'comment',
        'status',
    ];


    protected $guarded = ['id'];

    public function scopeShowTable($query)
    {
        $query
            ->select(
                [ 'id', ...$this->fillable ]
            )
            ->orderBy('kooperativ')
            ->orderBy('nomer')
            ;
    }
}
