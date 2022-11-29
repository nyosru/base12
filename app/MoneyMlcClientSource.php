<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MoneyMlcClientSource extends Model
{
    protected $table='money_mlc_client_source';

    public $timestamps = false;

    public function moneyMlcClients()
    {
        return $this->hasMany('App\MoneyMlcClients');
    }

}
