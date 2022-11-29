<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MoneyMlcClientType extends Model
{
    protected $table='money_mlc_client_type';

    public $timestamps = false;

    public function moneyMlcIn()
    {
        return $this->hasMany('App\MoneyMlcIn');
    }

}
