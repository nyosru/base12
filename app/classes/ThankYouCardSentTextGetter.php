<?php
namespace App\classes;


use App\Tmfsales;

class ThankYouCardSentTextGetter
{
    public static function run($tmoffer_id){
        $tmfsales=Tmfsales::find(1);
        $auth = base64_encode($tmfsales->Login.":".$tmfsales->passw);
        $arrContextOptions=[
            "ssl"=>[
                "verify_peer"=>false,
                "verify_peer_name"=>false,
            ],
            "http" => [
                "header" => "Authorization: Basic $auth"
            ]
        ];
        $url=sprintf('https://trademarkfactory.com/mlcclients/thank-you-card-sent-text.php?tmoffer_id=%d',$tmoffer_id);
        return file_get_contents($url,false,stream_context_create($arrContextOptions));
    }
}