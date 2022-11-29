<?php

namespace App\Modules\Narod\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ShopKontr extends Model
{
    // use HasFactory;

    protected $fillable = [
        'organizaciya',
        'mol',
        'kodorg',
        'kodmol',
        'saitmol',
        'dogovor',
        'dognom',
        'tiporg',
        'polnnaim',
        'yuradres',
        'inn',
        'kodorganizacii'
    ];

    // protected static function newFactory()
    // {
    //     return \App\Modules\Narod\Database\factories\ShopKontrFactory::new();
    // }
}
