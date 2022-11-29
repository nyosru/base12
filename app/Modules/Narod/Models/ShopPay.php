<?php

namespace App\Modules\Narod\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ShopPay extends Model
{
    // use HasFactory;

    protected $fillable = [
        'firma',
        'paishhik',
        'paishhikkod',
        'paishhiksocset',
        'proekt',
        'pasport',
        'dokument',
        'debet',
        'kredit',
        'status',
        'telefon',
    ];

    // protected static function newFactory()
    // {
    //     return \App\Modules\Narod\Database\factories\ShopPayFactory::new();
    // }
}
