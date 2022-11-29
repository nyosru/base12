<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MoneyMlcCategory extends Model
{
    protected $table='money_mlc_category';

    public $timestamps = false;

    public function parentCategory()
    {
        return $this->belongsTo('App\MoneyMlcCategory','parent_id','id');
    }


}
