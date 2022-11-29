<?php

namespace App\Modules\Phpcat\Models;

use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class News extends Model
{
    // use HasFactory;
    use SoftDeletes;

    protected $table = 'phpcat-news';
    protected $fillable = [];

    protected $dates = ['deleted_at'];

    // protected static function newFactory()
    // {
    //     return \App\Modules\Phpcat\Database\factories\NewsFactory::new();
    // }
}
