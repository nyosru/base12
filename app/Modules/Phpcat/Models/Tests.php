<?php

namespace App\Modules\Phpcat\Models;

use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tests extends Model
{
    use SoftDeletes;

    protected $table = 'phpcat-tests';
    protected $fillable = [];

    protected $dates = ['deleted_at'];

}
