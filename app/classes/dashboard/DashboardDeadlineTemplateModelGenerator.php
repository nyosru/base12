<?php
namespace App\classes\dashboard;

use App\DashboardReminderTemplate;
use App\DashboardTssTemplate;

class DashboardDeadlineTemplateModelGenerator
{
    private $dashboard_tss_template;

    public function __construct(DashboardTssTemplate $dashboard_tss_template)
    {
        $this->dashboard_tss_template=$dashboard_tss_template;
    }

    public static function initByDashboardTssTemplateId($dashboard_tss_template_id){
        return new self(DashboardTssTemplate::find($dashboard_tss_template_id));
    }

    public function run(){
        $deadlines=[];
        $dashboard_deadline_template_objs=$this->dashboard_tss_template->dashboardDeadlineTemplateRows;
//        dd($dashboard_deadline_template_objs);
        if($dashboard_deadline_template_objs && $dashboard_deadline_template_objs->count())
            foreach ($dashboard_deadline_template_objs as $dashboard_deadline_template_el){
                $deadlines[]=[
                    'deadline_type'=>$dashboard_deadline_template_el->deadline_type_id,
                    'tmfsales'=>[
                        'id'=>$dashboard_deadline_template_el->tmfsales_id,
                        'text'=>$dashboard_deadline_template_el->tmfsales->LongID
                    ],
                    'relative_data_type'=>[
                        'id'=>$dashboard_deadline_template_el->dashboardRelativeStartDateType->id,
                        'text'=>$dashboard_deadline_template_el->dashboardRelativeStartDateType->type_name
                    ],
                    'deadline_action'=>[
                        'id'=>$dashboard_deadline_template_el->deadline_action_id,
                        'text'=>$dashboard_deadline_template_el->deadlineAction->action_text
                    ],
                    'plus_minus'=>($dashboard_deadline_template_el->plus_minus==1?'+':'-'),
                    'year'=>$dashboard_deadline_template_el->year,
                    'month'=>$dashboard_deadline_template_el->month,
                    'day'=>$dashboard_deadline_template_el->day,
                    'plus_minus_settings'=>$dashboard_deadline_template_el->plus_minus_settings_id,
                    'reminders'=>$this->getRemindersTemplateModel($dashboard_deadline_template_el->id),
                ];
            }
        return $deadlines;
    }

    private function getRemindersTemplateModel($dashboard_deadline_template_id){
        $result=[];
        $dashboard_reminder_template_objs=DashboardReminderTemplate::where(
            'dashboard_deadline_template_id',$dashboard_deadline_template_id
        )->get();
        if($dashboard_reminder_template_objs && $dashboard_reminder_template_objs->count())
            foreach ($dashboard_reminder_template_objs as $el){
                $users=[];
                $tmfsales_objs=$el->tmfsalesRows;
                if($tmfsales_objs && $tmfsales_objs->count())
                    foreach ($tmfsales_objs as $tmfsales_obj)
                        $users[]=[
                            'id'=>$tmfsales_obj->ID,
                            'text'=>$tmfsales_obj->LongID
                        ];

                $group=[];
                $tmf_resource_level_objs=$el->tmfResourceLevelRows;
                if($tmf_resource_level_objs && $tmf_resource_level_objs->count())
                    foreach ($tmf_resource_level_objs as $tmf_resource_level_obj)
                        $group[]=[
                            'id'=>$tmf_resource_level_obj->id,
                            'text'=>$tmf_resource_level_obj->tmf_resource_level_name
                        ];
                $result[]=[
                    'plus_minus'=>$el->plus_minus,
                    'year'=>$el->year,
                    'month'=>$el->month,
                    'day'=>$el->day,
                    'who'=>[
                        'group'=>$group,
                        'users'=>$users
                    ]
                ];
            }
        return $result;
    }

}