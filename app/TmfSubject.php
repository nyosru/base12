<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TmfSubject extends Model
{
    protected $table='tmf_subject';

    public $timestamps = false;

    public function tmofferCompanySubjects()
    {
        return $this->hasMany('App\TmofferCompanySubject');
    }

    public function tmfSubjectContacts()
    {
        return $this->hasMany('App\TmfSubjectContact');
    }

    public function groupMeetings()
    {
        return $this->hasMany('App\GroupMeeting');
    }

    public function tmfSubjectSatisfactions()
    {
        return $this->hasMany('App\TmfSubjectSatisfaction');
    }

    public function emailCampaignTmfSubjectRows()
    {
        return $this->hasMany('App\EmailCampaignTmfSubject');
    }

    public function prequalifyRequestRows()
    {
        return $this->hasMany('App\PrequalifyRequest');
    }
}
