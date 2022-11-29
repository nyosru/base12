<?php
namespace App\classes\queue;


use App\QueueFlagSettings;
use App\QueueStatus;

class FlagSettingsData
{
    protected $queue_status;

    public function __construct(QueueStatus $queue_status){
        $this->queue_status=$queue_status;
    }

    public function get()
    {
        $warning_settings=$this->queue_status->warningFlagSettings;
        $danger_settings=$this->queue_status->dangerFlagSettings;
        if($warning_settings && $danger_settings)
            return [
                'danger'=>$this->convertFlagSettings($danger_settings),
                'warning'=>$this->convertFlagSettings($warning_settings),
            ];
        else
            return [
                'danger'=>$this->defaultFlagSettings(),
                'warning'=>$this->defaultFlagSettings(),
            ];
    }

    protected function convertFlagSettings(QueueFlagSettings $queue_flag_settings){
        return [
                'year'=>$queue_flag_settings->year,
                'month'=>$queue_flag_settings->month,
                'day'=>$queue_flag_settings->day,
                'hour'=>$queue_flag_settings->hour,
                'plus_minus'=>($queue_flag_settings->plus_minus==1?'+':'-'),
                'plus_minus_settings'=>$queue_flag_settings->plus_minus_settings_id,
                'relative_date_type'=>$queue_flag_settings->dashboard_relative_start_date_type_id,
        ];
    }

    protected function defaultFlagSettings(){
        return [
            'year'=>0,
            'month'=>0,
            'day'=>0,
            'hour'=>0,
            'plus_minus'=>'+',
            'plus_minus_settings'=>2,
            'relative_date_type'=>1,
        ];
    }
}