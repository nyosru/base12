<?php
namespace App\classes\bookingstat;


use App\Offer;

class DataFilter
{
    public $dates;
    public $offer_ids;
    public $from_arr;
    public $occ_boom_hrs=72;

    public function __construct()
    {
        $this->dates=new FromToDates();
        $this->offer_ids=Offer::select('id')->get()->pluck('id')->toArray();
        $this->from_arr=[];
    }
}