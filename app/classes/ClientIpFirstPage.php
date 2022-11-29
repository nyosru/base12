<?php

namespace App\classes;


use App\VisitorLog;
use App\NewsAndScrewups;
use App\classes\FaqCartoon;

class ClientIpFirstPage
{
    private $ip;

    public function __construct($ip)
    {
        $this->ip=$ip;
    }

    public function get(){
        $row=VisitorLog::where('ip',$this->ip)
//            ->where('created_at','<=',$date.' 23:59:59')
            ->orderBy('created_at','asc')
            ->first();

        if($row){
            $from_meta=$row->from_meta;
            $from_page=$row->page;
            switch ($from_page){
                case '/faq3.php':
                case '/faq4.php':
                    return [
                        'url'=>'/faq',
                        'title'=>'FAQ Index'
                    ];
                case '/index.php':
                    return [
                        'url'=>'/',
                        'title'=>'Main Page'
                    ];
                case '/faq5.php':
                    return $this->getFaqCartoon($from_meta,$from_page,new FaqCartoon('Faq'),'FAQ','/faq/');
                case '/cartoons2.php':
                    return [
                        'url'=>'/cartoons-about-trademarks',
                        'title'=>'CARTOONS INDEX'
                    ];
                case '/cartoons3.php':
                    return $this->getFaqCartoon($from_meta,$from_page,new FaqCartoon('Cartoon'),'Cartoon ','/cartoon/');
                case '/tm-news-and-screw-ups.php':
                    if(strpos($from_meta,'q=')!==false) {
                        $url=str_replace('q=','',$from_meta);
//                        $obj = NewsAndScrewupsQuery::create()->findOnePostUrl($url);
                        $obj=NewsAndScrewups::where('post_url',$url)->first();
                        if($obj)
                            return [
                                'url'=>'/tm-news-and-screw-ups/'.$obj->post_url,
                                'title'=>'NEWS AND SCREW-UPS: '.$obj->headline
                            ];

                    }
                    return [
                        'url'=>$from_page.'?'.$from_meta,
                        'title'=>'UNKNOWN NEWS AND SCREW-UP'
                    ];
                case '/calltmfsales.php':
                    return [
                        'url'=>'/calltmfsales.php',
                        'title'=>'/call-<closer>'
                    ];
                case '/new-booking-version.php':
                    return [
                        'url'=>'/call',
                        'title'=>'/call'
                    ];

                default:
                    return [
                        'url'=>$from_page.(strlen($from_meta)?'?'.$from_meta:''),
                        'title'=>$from_page.(strlen($from_meta)?'?'.$from_meta:'')
                    ];
            }
        }
        return [
            'url'=>'#',
            'title'=>'UNKNOWN'
        ];
    }

    private function getFaqCartoon($from_meta,$from_page,FaqCartoon $fc,$faq_cartoon_prefix,$fc_url_prefix){
        if(strlen($from_meta)){
            if(strpos($from_meta,'uid=')!==false) {
                $url=str_replace('uid=','',$from_meta);
                $fc_obj = $fc->getClassname()::where('url',$url)
                    ->whereIn('visibility',['visible', 'unlisted'])
                    ->first();
                if($fc_obj){
                    return [
                        'url'=>$fc_url_prefix.$url,
                        'title'=>$fc_obj->title
                    ];
                }
            }else{
                return [
                    'url'=>$from_page.'?'.$from_meta,
                    'title'=>$from_page.'?'.$from_meta
                ];
            }
        }else
            return [
                'url'=>''.$from_meta,
                'title'=>$faq_cartoon_prefix.' UNKNOWN'
            ];
    }

}