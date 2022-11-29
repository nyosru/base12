<?php

namespace App\Modules\Job\Models;

// use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Pays extends Model
{

    use SoftDeletes;

    // const STATUS_ENABLED = 1;
    // const STATUS_DISABLED = 0;

    const TABLE_NAME = 'job_pays';

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
        'job_client_id',
        'job_jobs_id',
        'date',
        'amount',
        'comment',
        'status'
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

            ->addSelect(
                // 'job_client_id',
                // 'job_jobs_id',
                'job_pays.date',
                'amount',
                // 'job_pays.status'
            )

            // ->Join('job_clients', function ($join) use ($user) {
            ->leftJoin('job_clients as c', function ($join) {
                $join
                    // ->where('c.id', '=', self::TABLE_NAME.'.job_jobs_id')
                    ->on('c.id', '=', self::TABLE_NAME . '.job_client_id');
            })
            ->addSelect(
                'c.id as client_id',
                'c.name as client_head'
            )

            ->leftJoin('job_jobs as j', function ($join) {
                $join
                    // ->where('c.id', '=', self::TABLE_NAME.'.job_jobs_id')
                    ->on('j.id', '=', self::TABLE_NAME . '.job_jobs_id');
            })
            ->addSelect(
                'j.id as job_id',
                'j.kooperativ as job_kooperative',
                'j.nomer as job_nomer'
            )

            // ->innerJoin('tmoffer_company_subject', function ($join) {
            //     $join
            //         ->on('tmoffer_company_subject.tmf_company_id', '=', self::TABLE_NAME.'.id');
            // })

            // ->groupBy(self::TABLE_NAME . '.id')


            // ->count()

        ;
    }

    public function getObjectAttribute()
    {
        return "{$this->job_kooperative} #{$this->job_nomer}";
    }
}
