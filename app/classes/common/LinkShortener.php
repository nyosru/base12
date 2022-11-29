<?php
/**
 * Created by PhpStorm.
 * User: vitaly
 * Date: 9/22/20
 * Time: 12:17 PM
 */

namespace App\classes\common;


use App\TmfShortUrl;
use Vinkla\Hashids\Facades\Hashids;

class LinkShortener
{
    private $tmf_short_url_obj;

    public function addURL($url,$single_use=0){
        $this->tmf_short_url_obj=TmfShortUrl::where('url','=',$url)->first();
        if(!$this->tmf_short_url_obj){
            $this->tmf_short_url_obj=new TmfShortUrl();
            $this->tmf_short_url_obj->url=$url;
            $this->tmf_short_url_obj->hash='template';
            $this->tmf_short_url_obj->created_at=date('Y-m-d H:i:s');
            $this->tmf_short_url_obj->single_use=$single_use;
            $this->tmf_short_url_obj->save();
            $this->tmf_short_url_obj->hash=Hashids::encode($this->tmf_short_url_obj->id);
            $this->tmf_short_url_obj->save();
        }
        return $this;
    }

    public function getCurrentHash(){
        return $this->tmf_short_url_obj->hash;
    }

    public function getTinyURL($url){
        return $this->addURL($url)->getCurrentHash();
    }
}