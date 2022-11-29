<?php

namespace App\Modules\Narod\Models;

use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\Factories\HasFactory;

class ShopOst extends Model
{
    // use HasFactory;

    protected $fillable = [];
    
    // protected static function newFactory()
    // {
    //     return \App\Modules\Narod\Database\factories\ShopOstFactory::new();
    // }

    public function setPrice3Attribute($value)
    {
      $this->attributes['cena3'] = round(str_replace(',','.',$value),2);
    }

}
