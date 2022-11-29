<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cipostatus extends Model
{
    protected $table='cipostatus';

    public $timestamps = false;

    public function applicationCovers()
    {
        return $this->belongsTo('App\ApplicationCovers');
    }

}
