<?php
namespace App\classes;


use App\Tmoffer;
use Carbon\Carbon;

class TmofferCreator
{
    public static function get(){
        $mt=explode(".",microtime(true));
        do {
            $login = 'tmf' . date('ymdHis') . $mt[1];
            $tmp_tmoffer=Tmoffer::where('login',$login)->first();
        }while($tmp_tmoffer);
        if (isset($_SERVER["HTTP_CF_CONNECTING_IP"]))
            $_SERVER['REMOTE_ADDR'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
        $whose_file = (isset($_SERVER['PHP_AUTH_USER']) ? $_SERVER['PHP_AUTH_USER'] : 'rbt_secret');

        $tmoffer=new Tmoffer();
        $tmoffer->Login=$login;
        $tmoffer->WhoseFile=$whose_file;
        $tmoffer->Code=rand(1000, 9999);
        $tmoffer->created_date=Carbon::now()->format('Y-m-d H:i:s');
        $tmoffer->buffer_flag=0;
        $tmoffer->client_ip=$_SERVER['REMOTE_ADDR'];
        $tmoffer->ConfirmationCode=substr(md5(rand()), 0, 30);
        $tmoffer->save();

        return $tmoffer;
    }
}