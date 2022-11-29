<?php

namespace App\Http\Controllers;

use App\classes\SmsSender;
use App\TmfSubject;
use Illuminate\Http\Request;

class SmsSenderController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function loadMessage(Request $request){
        $tmf_subject=TmfSubject::find($request->id);
        if($tmf_subject){
            $obj=new SmsSender($tmf_subject);
            return $obj->getMessageHtml();
        }
        return '';
    }

    public function send(Request $request){
        $tmf_subject=TmfSubject::find($request->id);
        if($tmf_subject){
            $obj=new SmsSender($tmf_subject);
            return $obj->send($request->message);
        }
        return '';
    }
}
