<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Hash;

class Tmfsales extends Authenticatable
{
    protected $table='tmfsales';

    protected $primaryKey='ID';

    /**
	* Get the password for the user.
	*
	* @return string
    */
    public function getAuthPassword()
    {
	    return Hash::make($this->passw);
    }

    public function tmfsalesEosMemberRows()
    {
        return $this->hasMany('App\TmfsalesEosMember');
    }

}
