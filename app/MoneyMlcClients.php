<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MoneyMlcClients extends Model
{
    protected $table='money_mlc_clients';

    public $timestamps = false;

    protected $primaryKey='ID';

    public function moneyMlcClientSource()
    {
        return $this->belongsTo('App\MoneyMlcClientSource');
    }
}
