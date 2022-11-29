<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\BlockIp;

class BlockTmfIpController extends Controller
{
    public function index()
    {
        if (isset($_SERVER["HTTP_CF_CONNECTING_IP"]))
            $_SERVER['REMOTE_ADDR'] = $_SERVER["HTTP_CF_CONNECTING_IP"];

        $block_ip=BlockIp::where('ip',$_SERVER['REMOTE_ADDR'])->first();
        if(!$block_ip){
            $block_ip=new BlockIp();
            $block_ip->ip=$_SERVER['REMOTE_ADDR'];
            $block_ip->save();
            echo 'Your IP-address saved successfully.';
        }else
            echo 'Your IP-address already saved.';
    }
}
