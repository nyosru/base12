<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmailCampaignTmfSubject extends Model
{
    protected $table='email_campaign_tmf_subject';

    public $timestamps = false;

    public function emailCampaign()
    {
        return $this->belongsTo('App\EmailCampaign');
    }

    public function tmfSubject()
    {
        return $this->belongsTo('App\TmfSubject');
    }

}
