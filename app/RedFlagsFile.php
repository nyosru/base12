<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RedFlagsFile extends Model
{
    protected $table='red_flags_file';

    public function requests(){
        return $this->belongsToMany('App\RedFlagsEbookRequest',
            'red_flags_ebook_request_file',
            'red_flags_file_id',
            'red_flags_ebook_request_id');
    }

}
