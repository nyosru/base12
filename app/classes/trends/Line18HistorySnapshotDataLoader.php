<?php
namespace App\classes\trends;


use App\DashboardTss;
use App\DashboardV2;
use App\TmfCountryTrademark;

class Line18HistorySnapshotDataLoader extends Line1HistorySnapshotDataLoader
{
    
    protected function initData()
    {
        $this->calculateDashboardIds(6);
    }
}