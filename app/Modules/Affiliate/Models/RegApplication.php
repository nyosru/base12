<?php

namespace App\Modules\Affiliate\Models;

use Illuminate\Database\Eloquent\Model;

class RegApplication extends Model
{
    const TABLE_NAME = 'aff_reg_application';

    const STATUS_PENDING = 0;
    const STATUS_APPROVED = 1;
    const STATUS_DECLINED = 2;

    /**
     * @var array
     */
    public $timestamps = false;

    /**
     * @var array
     */
    static $statuses = [
        self::STATUS_PENDING, self::STATUS_APPROVED, self::STATUS_DECLINED,
    ];

    /**
     * @var string
     */
    protected $table = self::TABLE_NAME;

    /**
     * @var array
     */
    protected $fillable = [
        'aff_profile_id', 'text', 'status'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function profile()
    {
        return $this->belongsTo(Profile::class, 'aff_profile_id', 'id');
    }

    public static function boot()
    {
        parent::boot();

        static::creating(function (RegApplication $model) {
            $model->created_at = $model->freshTimestamp();
        });
    }
}
