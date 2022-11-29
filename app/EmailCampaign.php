<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmailCampaign extends Model
{
    protected $table='email_campaign';

    public $timestamps = false;

    public function emailCampaignTmfSubjectRows()
    {
        return $this->hasMany('App\EmailCampaignTmfSubject');
    }

}
