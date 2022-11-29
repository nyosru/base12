<?php
namespace App\classes\cron;


use App\classes\opsreport\HistorySnapshotLoader;
use App\classes\opsreport\SnapshotStatusInfo;
use App\OpsSnapshot;
use App\OpsSnapshotCountryPreset;
use App\OpsSnapshotTitle;
use App\TmfCountry;

class OpsSnapshotLoader
{
    public function __invoke()
    {
        $date=new \DateTime();
        (new HistorySnapshotLoader($date))->run();
    }
}