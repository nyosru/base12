<?php
namespace App\Modules\TMFXQ\Actions;

use App\DashboardTss;
use App\DashboardV2;
use App\Modules\TMFXQ\Managers\DashboardTssQueryManager;
use App\Tmfsales;
use Carbon\Carbon;

class DashboardV2Manager
{
    public function saveAllGoodCondition(int $dashboard_id, int $tmfsales_id,string $status){
        $dashboard=DashboardV2::find($dashboard_id);
        $tmfsales=Tmfsales::find($tmfsales_id);

        $notes="\r\n\r\n";
        $notes.=sprintf('%s %s: Confirmed status as %s',
            Carbon::now()->format('Y-m-d H:i:s'),
            $tmfsales->LongID,
            $status);
        $dashboard->notes=$notes;
        $dashboard->save();
    }

    public function addChangedStatusNote(int $dashboard_id, int $tmfsales_id,string $status){
        $dashboard=DashboardV2::find($dashboard_id);
        $tmfsales=Tmfsales::find($tmfsales_id);

        $notes="\r\n\r\n";
        $notes.=sprintf('%s %s: Changes status to as %s',
            Carbon::now()->format('Y-m-d H:i:s'),
            $tmfsales->LongID,
            $status);
        $dashboard->notes=$notes;
        $dashboard->save();
    }
}