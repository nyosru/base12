<?php

namespace App\classes;


use App\SniplyToken;

class SniplyLinkCreator{

    private $campaign='5a9776e776ae5637fe0bf4b0';
    private $cta='5a9776e776ae5637470bf4b1';
    private $token;

    public function __construct(){
        $sniply_token=SniplyToken::first();
        $this->token=$sniply_token->access_token;
    }

    public function run($url){
        $authorization = "Authorization: Bearer $this->token";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://snip.ly/api/v2/links/');
        curl_setopt($ch, CURLOPT_HTTPHEADER, array($authorization));
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS,
            "url=".urlencode($url)."&campaign={$this->campaign}");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FRESH_CONNECT, 1);
        curl_setopt($ch, CURLOPT_REFERER, "");
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION,true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 4);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 4);
        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 5.1; rv:5.0) Gecko/20100101 Firefox/5.0");
        $body = curl_exec($ch);
        $error=curl_error($ch);
        curl_close($ch);

        if(!$error){
            $arr=json_decode($body,true);
            /*            echo "url:$url<br/>";
                        var_dump($arr);
                        echo "<br/><br/>";*/
            return $arr['href'];
        }
        return '';
    }
}
