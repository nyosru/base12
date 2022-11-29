<?php
namespace App\classes\dashboard;


use App\DashboardOwner;
use Carbon\Carbon;

class DashboardOwnerManager
{
    private $dashboard_id;

    public function __construct($dashboard_id)
    {
        $this->dashboard_id=$dashboard_id;
    }

    private function createDashboardOwner($tmfsales_id){
        $dashboard_owner=new DashboardOwner();
        $dashboard_owner->tmfsales_id=$tmfsales_id;
        $dashboard_owner->dashboard_id=$this->dashboard_id;
        $dashboard_owner->created_at=Carbon::now()->format('Y-m-d H:i:s');
        $dashboard_owner->save();
        return $dashboard_owner;
    }

    public function releaseOwnerFromMark($tmfsales_id,$release_reason_id){
        $dashboard_owner=DashboardOwner::where('dashboard_id',$this->dashboard_id)
            ->where('tmfsales_id',$tmfsales_id)
            ->whereNull('released_at')
            ->orderBy('id','desc')
            ->first();
        if(!$dashboard_owner)
            $dashboard_owner=$this->createDashboardOwner($tmfsales_id);
        $dashboard_owner->released_at=Carbon::now()->format('Y-m-d H:i:s');
        $dashboard_owner->release_reason_id=$release_reason_id;
        $dashboard_owner->save();
        return $dashboard_owner;
    }

    public function forceReleaseOwnerFromMark($release_reason_id){
        $dashboard_owner=DashboardOwner::where('dashboard_id',$this->dashboard_id)
            ->whereNull('released_at')
            ->orderBy('id','desc')
            ->first();
        if($dashboard_owner){
            $dashboard_owner->released_at=Carbon::now()->format('Y-m-d H:i:s');
            $dashboard_owner->release_reason_id=$release_reason_id;
            $dashboard_owner->save();
            return $dashboard_owner;
        }
        return null;
    }

    public function claim($tmfsales_id){
        $this->forceReleaseOwnerFromMark(4);
        return $this->createDashboardOwner($tmfsales_id);
    }


}