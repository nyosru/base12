<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    protected $table='faq';

    public $timestamps = false;

    public function category()
    {
        return $this->belongsTo('App\FaqCategory','faq_category_id');
    }

}
