<?php

namespace App\Modules\Job\Models;

// use Illuminate\Foundation\Auth\User as Authenticatable;
// use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Clients extends Model
{

    // use SoftDeletes;

    // const STATUS_ENABLED = 1;
    // const STATUS_DISABLED = 0;

    const TABLE_NAME = 'job_clients';

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
        'name',
        'phone',
        'phone2',
        'phone2_name',
        'comment'
    ];

    protected $guarded = ['id'];

    /**
     * @var array
     */
    // protected $hidden = ['user_password'];

    // public function contacts()
    // {
    //     return $this->hasMany('App\Modules\ClientCabinet\Models\ProfileContact', 'tmf_subject_id', 'id' );
    //     // return $this->hasMany('App\Modules\ClientCabinet\Models\ProfileContact' );
    // }

    public function scopeShowTable($query)
    {
        $query
            ->select(
                ['id', ...$this->fillable]
            )
            ->orderBy('name');
    }
}
