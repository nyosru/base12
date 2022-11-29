<?php
namespace App\classes\cron;



use App\Tmfsales;
use App\TmfsalesAvailabilityLog;

class TmfsalesAvailabilityLogger
{
    public function __invoke()
    {
        $date=new \DateTime();
        $tmfsales=Tmfsales::where('sales_calls',1)
            ->where('Visible',1)
            ->where('Level',6)
            ->get();

        $weekday=strtolower($date->format('D'));
        foreach ($tmfsales as $closer){
            $schedule=json_decode($closer->schedule,true);
            $available_slots=0;
            foreach ($schedule as $schedule_el) {
                if ($schedule_el['weekday'] == $weekday) {
                    foreach ($schedule_el['time'] as $timeslot)
                        if($timeslot['available'])
                            $available_slots+=30;
                    break;
                }
            }
            $tmfsales_availability_log=TmfsalesAvailabilityLog::where('tmfsales_id',$closer->ID)
                ->where('ymd',$date->format('Y-m-d'))
                ->first();
            if(!$tmfsales_availability_log){
                $tmfsales_availability_log=new TmfsalesAvailabilityLog();
                $tmfsales_availability_log->tmfsales_id=$closer->ID;
                $tmfsales_availability_log->ymd=$date->format('Y-m-d');
            }
            $tmfsales_availability_log->availability_time=$available_slots*60;
            $tmfsales_availability_log->save();
//            dd($schedule);
        }
    }
}