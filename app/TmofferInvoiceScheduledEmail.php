<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TmofferInvoiceScheduledEmail extends Model
{
    protected $table='tmoffer_invoice_scheduled_email';

    public $timestamps = false;

    public function tmfsales(){
        return $this->belongsTo('App\Tmfsales');
    }

}
