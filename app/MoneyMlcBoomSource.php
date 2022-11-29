<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MoneyMlcBoomSource extends Model
{
    protected $table='money_mlc_boom_source';

    public $timestamps = false;

    public function moneyMlcIn()
    {
        return $this->hasMany('App\MoneyMlcIn');
    }

}
