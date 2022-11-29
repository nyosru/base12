<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cartoon extends Model
{
    protected $table='cartoon';

    public $timestamps = false;

    public function category()
    {
        return $this->belongsTo('App\CartoonCategory','cartoon_category_id');
    }
}
