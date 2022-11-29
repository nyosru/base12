<?php

namespace App\Modules\Narod\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ShopFir extends Model
{
    // use HasFactory;

    protected $fillable = [
        'organizaciya',
        'kodorganizacii',
        'banksceta',
        'kodbanksceta',
        'polnnaim',
        'inn',
        'kpp',
        'yuradres',
        'bankscet',
        'bankrasc',
        'adresbankarasc',
        'korrscetbankarasc',
        'telefon',
        'bikbankarasc',
        'pecatka',
    ];
    
    // protected static function newFactory()
    // {
    //     return \App\Modules\Narod\Database\factories\ShopFirFactory::new();
    // }
}
