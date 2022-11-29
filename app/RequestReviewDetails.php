<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RequestReviewDetails extends Model
{
    protected $table='request_review_details';

    public $timestamps = false;

    public function dashboardOwner()
    {
        return $this->belongsTo('App\DashboardOwner');
    }

}
