<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EosMember extends Model
{
    protected $table='eos_member';

    public $timestamps = false;

    public function tmfsalesEosMemberRows()
    {
        return $this->hasMany('App\TmfsalesEosMember');
    }

    public function homepageCategoryGroupAccessRows()
    {
        return $this->hasMany('App\HomepageCategoryGroupAccess');
    }


}
