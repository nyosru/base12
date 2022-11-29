<?php
namespace App\classes\common;
use App\classes\tsstranslator\StringEncryptor;
use App\TmfSatisfactionIconScore;
use App\TmfSatisfactionProcess;

define('ENCRYPTION_KEY', md5('tmf satisfaction widget'));

class TSW
{
    private $tsp_obj;

    private function __construct($tmf_satifaction_process_obj)
    {
        $this->tsp_obj=$tmf_satifaction_process_obj;
    }

    public static function initProcess($tmf_satifaction_process_id){
        return new self(TmfSatisfactionProcess::find($tmf_satifaction_process_id));
    }

    public function show($tmf_subject_id){
        $icon_score_objs=TmfSatisfactionIconScore::orderBy('score','asc')->get();
        $widget_data=[];
        foreach ($icon_score_objs as $icon_score_obj){
            $query=sprintf('tmf_satisfaction_process_id=%d&tmf_subject_id=%d&score_id=%d',
                $this->tsp_obj->id,
                $tmf_subject_id,
                $icon_score_obj->id
            );
            $widget_data[]=[
                'icon'=>$icon_score_obj->icon,
                'score'=>$icon_score_obj->score,
                'url'=>sprintf('https://trademarkfactory.com/satisfaction/%s',
                    str_replace(['+', '/'], ['-', '_'], (new StringEncryptor())->run($query,ENCRYPTION_KEY))
                ),
            ];
        }
        $widget_text=$this->tsp_obj->message;
        return view('tsw.index',compact('widget_text','widget_data'))->render();
    }

    public function getCss(){
        return view('tsw.css');
    }
}