<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FaqCategory extends Model
{
    protected $table='faq_category';

    public $timestamps = false;

    public function items()
    {
        return $this->hasMany('App\Faq');
    }
}
