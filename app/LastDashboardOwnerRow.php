<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LastDashboardOwnerRow extends Model
{
    public $table = "last_dashboard_owner_row_view";

    public function requestReviewDetails()
    {
        return $this->hasOne('App\RequestReviewDetails');
    }
}
