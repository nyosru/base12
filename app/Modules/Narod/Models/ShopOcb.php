<?php

namespace App\Modules\Narod\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ShopOcb extends Model
{
    use HasFactory;

    protected $fillable = [];
    
    protected static function newFactory()
    {
        return \App\Modules\Narod\Database\factories\ShopOcbFactory::new();
    }
}
