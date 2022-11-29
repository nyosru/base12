<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CartoonCategory extends Model
{
    protected $table='cartoon_category';

    public $timestamps = false;

    public function items()
    {
        return $this->hasMany('App\Cartoon');
    }

}
