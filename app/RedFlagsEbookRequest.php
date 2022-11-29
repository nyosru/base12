<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RedFlagsEbookRequest extends Model
{
    protected $table='red_flags_ebook_request';

    public function files(){
        return $this->belongsToMany('App\RedFlagsFile',
            'red_flags_ebook_request_file',
            'red_flags_ebook_request_id',
            'red_flags_file_id');
    }

    public function redFlagsEmailsSeqs()
    {
        return $this->hasMany('App\RedFlagsEmailsSeq');
    }
}
