<?php

namespace App\classes\bookingstat;


use App\GroupMeeting;

class GroupBookingsStat extends Stat
{

    public function get()
    {
        $group_meeting_objs=GroupMeeting::where([
            ['meeting_at','>=',$this->from_date->format('Y-m-d H:i:s')],
            ['meeting_at','<=',$this->to_date->format('Y-m-d H:i:s')],
        ])
            ->where('tmoffer_id',0)
            ->whereNull('cancelled_at');

        return 'Group Calls: '.$group_meeting_objs->count();
    }
}