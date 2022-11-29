<?php

namespace App\Modules\Job\Models;

// use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{

    use SoftDeletes;

    // const STATUS_ENABLED = 1;
    // const STATUS_DISABLED = 0;

    const TABLE_NAME = 'job_contract';

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
        'start_date',
        'price',
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

    /**
     * получаем текущие контракты с привязкой платежей
     */
    public function scopeGetLive($query)
    {

        $query

            ->addSelect(
                // 'job_client_id',
                // 'job_jobs_id',
                'job_contract.start_date',
                'price',
                'job_contract.status',
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








            ->leftJoin('job_pays as p', function ($join) {
                $join
                    // ->where('c.id', '=', self::TABLE_NAME.'.job_jobs_id')
                    ->on('p.job_client_id', '=', 'c.id');
            })
            ->addSelect(
                // 'p.date as lastpay_date',
                'p.amount as lastpay_amount'
            )
            ->selectRaw('MAX( p.date ) as lastpay_date2')
            ->selectRaw(' DATEDIFF ( NOW() , MAX( p.date ) ) as diff_pay ')
            // ->orderBy('p.date','desc')


            ->groupBy('j.id')
            ->orderBy('job_contract.start_date')

            // ->innerJoin('tmoffer_company_subject', function ($join) {
            //     $join
            //         ->on('tmoffer_company_subject.tmf_company_id', '=', self::TABLE_NAME.'.id');
            // })

            // ->groupBy(self::TABLE_NAME . '.id')

            // ->count()

        ;
    }


    public function scopeShowTable($query)
    {

        $query

            ->addSelect(
                // 'job_client_id',
                // 'job_jobs_id',
                'job_contract.start_date',
                'price',
                'job_contract.status',
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
