<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ContactDataType extends Model
{
    protected $table='contact_data_type';

    public $timestamps = false;

    public function tmfSubjectContacts()
    {
        return $this->hasMany('App\TmfSubjectContact');
    }

}
