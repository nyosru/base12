<?php

namespace App\Http\Controllers;

use App\Tmfsales;
use Illuminate\Http\Request;

class FlowchartEmailPreviewerController extends Controller
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


    public function showEmail(Request $request){
//        return "tmoffer_id:{$request->tmoffer_id} last_action_id:{$request->last_action_id}";
        $tmfsales=Tmfsales::find(1);
        $auth = base64_encode($tmfsales->Login.":".$tmfsales->passw);
        $arrContextOptions=array(
            "ssl"=>array(
                "verify_peer"=>false,
                "verify_peer_name"=>false,
            ),
            "http" => [
                "header" => "Authorization: Basic $auth"
            ]
        );
        $url=sprintf('https://trademarkfactory.com/mlcclients/flowchart-template-translator.php?tmoffer_id=%d&last_action_id=%s',
            $request->tmoffer_id,
            $request->last_action_id
        );
        $json=file_get_contents($url,false,stream_context_create($arrContextOptions));
        if(strlen($json)){
            $data=json_decode($json,true);
            return view('flowchart-email-previewer.index',compact('data'));
        }else
            return '';
    }
}
