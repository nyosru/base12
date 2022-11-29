<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MoneyMlcPayType extends Model
{
    protected $table='money_mlc_pay_type';

    public $timestamps = false;

    public function moneyMlcIn()
    {
        return $this->hasMany('App\MoneyMlcIn');
    }

}
