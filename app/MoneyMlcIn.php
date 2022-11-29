<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MoneyMlcIn extends Model
{
    protected $table='money_mlc_in';

    public $timestamps = false;

    protected $primaryKey='ID';

    public function moneyMlcBoomSource()
    {
        return $this->belongsTo('App\MoneyMlcBoomSource');
    }

    public function moneyMlcClientType()
    {
        return $this->belongsTo('App\MoneyMlcClientType');
    }

    public function moneyMlcPayType()
    {
        return $this->belongsTo('App\MoneyMlcPayType');
    }

    public function moneyMlcClient()
    {
        return $this->belongsTo('App\MoneyMlcClients','money_mlc_clients_id','ID');
    }

}
