<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HomepageCategoryGroupAccess extends Model
{
    protected $table='homepage_category_group_access';

    public $timestamps = false;

    public function eosMember()
    {
        return $this->belongsTo('App\EosMember');
    }

    public function homepageCategory()
    {
        return $this->belongsTo('App\HomepageCategory');
    }

    public function homepageCategoryAccessType()
    {
        return $this->belongsTo('App\HomepageCategoryAccessType');
    }

}
