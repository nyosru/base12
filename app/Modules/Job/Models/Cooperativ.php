<?php

namespace App\Modules\Job\Models;

// use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Cooperativ extends Model
{
    use SoftDeletes;
    // const STATUS_ENABLED = 1;
    // const STATUS_DISABLED = 0;

    const TABLE_NAME = 'job_cooperativ';

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
        'adress',
        'comment',
    ];

    // protected $fillable = [
    //     'title', 'description', 'url', 'author',
    // ];

    protected $guarded = ['id'];

    // /**
    //  * @var array
    //  */
    // // protected $hidden = ['user_password'];

    // public function contacts()
    // {
    //     // return $this->hasMany('App\Modules\ClientCabinet\Models\ProfileContact', 'foreign_key', 'local_key' );
    //     // return $this->hasMany('App\Modules\ClientCabinet\Models\ProfileContact', 'id', 'tmf_subject_id' );
    //     return $this->hasMany('App\Modules\ClientCabinet\Models\ProfileContact', 'tmf_subject_id', 'id' );
    //     // return $this->hasMany('App\Modules\ClientCabinet\Models\ProfileContact' );
    // }

}
