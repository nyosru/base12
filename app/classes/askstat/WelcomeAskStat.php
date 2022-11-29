<?php


namespace App\classes\askstat;

use App\VisitorLog;
use App\BlockIp;
use App\classes\askstat\WelcomeAskStatData;

abstract class WelcomeAskStat
{
    protected $from_date;
    protected $to_date;
    protected $from_pages;
    protected $visitor_log_first;
    protected $visitor_log_last;
    protected $show_tmf_visitors;
    protected $ips;
    protected $lps_pages=[
        'guaranteed-result-idea',
        'guaranteed-result-startup',
        'guaranteed-result-monetizing',
        'guaranteed-result-growing',
        'guaranteed-result-expanding',
    ];

    protected function __construct($from_date,$to_date,$from_pages,$show_tmf_visitors)
    {
        $this->show_tmf_visitors=$show_tmf_visitors;
        $this->from_pages=$from_pages;
        if ($from_date && $to_date)
            $objs = VisitorLog::whereBetween('created_at', [$from_date . ' 00:00:00', $to_date . ' 23:59:59']);
        elseif ($from_date)
            $objs = VisitorLog::where('created_at', '>=', $from_date . ' 00:00:00');
        elseif ($to_date)
            $objs = VisitorLog::where('created_at', '<=', $to_date . ' 23:59:59');

        $cloned_objs=clone $objs;
        $this->visitor_log_first=$objs->orderBy('created_at','asc')->first();
        $this->visitor_log_last=$cloned_objs->orderBy('created_at','desc')->first();
        $this->from_date=$this->visitor_log_first->created_at->format('Y-m-d H:i:s');
        $this->to_date=$this->visitor_log_last->created_at->format('Y-m-d H:i:s');
        $this->ips=null;
    }

    public static function init($from_date,$to_date,$welcome_ask_page,$from_pages,$show_tmf_visitors=0){
        switch ($welcome_ask_page){
            case 'welcome-ask1.php': return new WelcomeAskAStat($from_date,$to_date,$from_pages,$show_tmf_visitors);
            case 'welcome-ask2.php': return new WelcomeAskBStat($from_date,$to_date,$from_pages,$show_tmf_visitors);
            case 'welcome-ask3.php': return new WelcomeAskCStat($from_date,$to_date,$from_pages,$show_tmf_visitors);
            case 'welcome-ask4.php': return new WelcomeAskDStat($from_date,$to_date,$from_pages,$show_tmf_visitors);
            case 'welcome-ask5.php': return new WelcomeAskEStat($from_date,$to_date,$from_pages,$show_tmf_visitors);
            case 'welcome-ask6.php': return new WelcomeAskFStat($from_date,$to_date,$from_pages,$show_tmf_visitors);
            case 'welcome-ask7.php': return new WelcomeAskGStat($from_date,$to_date,$from_pages,$show_tmf_visitors);
            case 'welcome-ask8.php': return new WelcomeAskHStat($from_date,$to_date,$from_pages,$show_tmf_visitors);
            case 'welcome-ask9.php': return new WelcomeAskIStat($from_date,$to_date,$from_pages,$show_tmf_visitors);
            case 'welcome-ask10.php': return new WelcomeAskJStat($from_date,$to_date,$from_pages,$show_tmf_visitors);
            case 'welcome-ask11.php': return new WelcomeAskKStat($from_date,$to_date,$from_pages,$show_tmf_visitors);
            case 'welcome-ask12.php': return new WelcomeAskLStat($from_date,$to_date,$from_pages,$show_tmf_visitors);
        }
    }

    abstract public function get();

    protected function getTmfEbookVisitorsIps(){
        return VisitorLog::whereBetween('created_at', [$this->from_date, $this->to_date])
            ->select('ip')
            ->distinct()
            ->where('page','/tmf-ebook.php')
            ->whereIn('ip',$this->ips)
            ->where('from_page','https://trademarkfactory.com/ask')
            ->get()
            ->count();
    }

    protected function getLpsVisitorsIps(){
        $this->ips = VisitorLog::whereBetween('created_at', [$this->from_date, $this->to_date])
            ->select('ip')
            ->distinct()
            ->whereIn('page',[
                '/business-idea.php',
                '/startup.php',
                '/monetizing.php',
                '/growing.php',
                '/established.php',
            ])
            ->whereIn('ip',$this->ips)
            ->where('from_page','https://trademarkfactory.com/guaranteed-result');
        return (clone $this->ips)->get()->count();
    }

    protected function getClikedCTACount(){
        return $this->getBookingsFromLpsCount()+$this->getCheckoutFromLpsCount();
    }

    protected function getCheckoutFromLpsCount(){
        return VisitorLog::whereBetween('created_at', [$this->from_date, $this->to_date])
            ->select('ip')
            ->distinct()
            ->where('page','/apply-online.php')
            ->whereIn('ip',$this->ips)
            ->where(function ($query){
                foreach ($this->lps_pages as $index=>$ppp)
                    if($index)
                        $query=$query->orWhere('from_page','like','%'.$ppp.'%');
                    else
                        $query=$query->where('from_page','like','%'.$ppp.'%');
            })->get()->count();
    }

    protected function getBookingsFromLpsCount(){
        return VisitorLog::whereBetween('created_at', [$this->from_date, $this->to_date])
            ->select('ip')
            ->distinct()
            ->where('page','/consultationcallbooked.php')
            ->whereIn('ip',$this->ips)
            ->where(function ($query){
                foreach ($this->lps_pages as $index=>$ppp)
                    if($index)
                        $query=$query->orWhere('from_page','like','%'.$ppp.'%');
                    else
                        $query=$query->where('from_page','like','%'.$ppp.'%');
            })->get()->count();
    }


}

class WelcomeAskAStat extends WelcomeAskStat{

    public function get()
    {
        $result=[];
        $wsd=new WelcomeAskStatData();
        $wsd->caption='Welcome';
        $wsd->num=$this->getWelcomeAsk1VisitorsIps();
        $wsd->file='welcome-ask1.php';
        $result['welcome']=$wsd;
        $wsd=new WelcomeAskStatData();
        $wsd->caption='Ask1';
        $wsd->num=$this->getAsk1VisitorsIps();
        $result['ask1']=$wsd;

        $seven_red_flags_data=new WelcomeAskStatData();
        $seven_red_flags_data->caption='Got to 7 red flags';
        $seven_red_flags_data->num=$this->getTmfEbookVisitorsIps();
        $result['7red-flags']=$seven_red_flags_data;
        $wsd=new WelcomeAskStatData();
        $wsd->caption='Ask2';
        $wsd->num=$this->getAsk2VisitorsIps();
        $result['ask2']=$wsd;
        $wsd=new WelcomeAskStatData();
        $wsd->caption='Got to one of 5 landings';
        $wsd->num=$this->getLpsVisitorsIps();
        $result['lps']=$wsd;

        $wsd=new WelcomeAskStatData();
        $wsd->caption='Clicked CTA';
        $wsd->num=$this->getClikedCTACount();
        $result['clicked-cta']=$wsd;
        return $result;
    }


    private function getAsk2VisitorsIps(){
        $this->ips = VisitorLog::whereBetween('created_at', [$this->from_date, $this->to_date])
            ->select('ip')
            ->distinct()
            ->where('page','/guaranteed-result.php')
            ->whereIn('ip',$this->ips)
            ->where('from_page','https://trademarkfactory.com/ask');
//        echo $this->ips->count().'<br/>';
//        dd($this->ips->get()->toArray());
        return (clone $this->ips)->get()->count();
    }

    private function getAsk1VisitorsIps(){
        $this->ips = VisitorLog::whereBetween('created_at', [$this->from_date, $this->to_date])
            ->select('ip')
            ->distinct()
            ->where('page','/ask1.php')
            ->whereIn('ip',$this->ips)
            ->where(function ($query){
                foreach ($this->from_pages as $index=>$ppp)
                    if($index)
                        $query=$query->orWhere('from_page','like','%'.$ppp.'%');
                    else
                        $query=$query->where('from_page','like','%'.$ppp.'%');
            })
            ->whereRaw('length(from_page)>0');
        return (clone $this->ips)->get()->count();
    }

    private function getWelcomeAsk1VisitorsIps(){
        $this->ips = VisitorLog::whereBetween('created_at', [$this->from_date, $this->to_date])
            ->select('ip')
            ->distinct()
            ->where('page','welcome-ask1.php')
            ->where(function ($query){
                foreach ($this->from_pages as $index=>$ppp)
                    if($index)
                        $query=$query->orWhere('from_page','like','%'.$ppp.'%');
                    else
                        $query=$query->where('from_page','like','%'.$ppp.'%');
            })
            ->whereRaw('length(from_page)>0');
        if(!$this->show_tmf_visitors)
            $this->ips=$this->ips->whereNotIn('ip',BlockIp::select('ip'));
        return (clone $this->ips)->get()->count();
    }
}

class WelcomeAskBStat extends WelcomeAskStat{

    public function get()
    {
        $result=[];
        $wsd=new WelcomeAskStatData();
        $wsd->caption='Welcome';
        $wsd->num=$this->getWelcomeAsk3VisitorsIps();
        $wsd->file='welcome-ask2.php';
        $result['welcome']=$wsd;
        $wsd=new WelcomeAskStatData();
        $wsd->caption='Ask2';
        $wsd->num=$this->getAsk2VisitorsIps();
        $result['ask2']=$wsd;
        $wsd=new WelcomeAskStatData();
        $wsd->caption='Ask1';
        $wsd->num=$this->getAsk1VisitorsIps();
        $result['ask1']=$wsd;

        $seven_red_flags_data=new WelcomeAskStatData();
        $seven_red_flags_data->caption='Got to 7 red flags';
        $seven_red_flags_data->num=$this->getTmfEbookVisitorsIps();
        $result['7red-flags']=$seven_red_flags_data;

        $wsd=new WelcomeAskStatData();
        $wsd->caption='Got to one of 5 landings';
        $wsd->num=$this->getLpsVisitorsIps();
        $result['lps']=$wsd;

        $wsd=new WelcomeAskStatData();
        $wsd->caption='Clicked CTA';
        $wsd->num=$this->getClikedCTACount();
        $result['clicked-cta']=$wsd;
        return $result;

    }

    private function getWelcomeAsk3VisitorsIps(){
        $this->ips = VisitorLog::whereBetween('created_at', [$this->from_date, $this->to_date])
            ->select('ip')
            ->distinct()
            ->where('page','welcome-ask2.php')
            ->where(function ($query){
                foreach ($this->from_pages as $index=>$ppp)
                    if($index)
                        $query=$query->orWhere('from_page','like','%'.$ppp.'%');
                    else
                        $query=$query->where('from_page','like','%'.$ppp.'%');
            })
            ->whereRaw('length(from_page)>0');
        if(!$this->show_tmf_visitors)
            $this->ips=$this->ips->whereNotIn('ip',BlockIp::select('ip'));
        return (clone $this->ips)->get()->count();
    }

    private function getAsk2VisitorsIps(){
        $this->ips = VisitorLog::whereBetween('created_at', [$this->from_date, $this->to_date])
            ->select('ip')
            ->distinct()
            ->where('page','/guaranteed-result.php')
            ->whereIn('ip',$this->ips)
            ->where(function ($query){
                foreach ($this->from_pages as $index=>$ppp)
                    if($index)
                        $query=$query->orWhere('from_page','like','%'.$ppp.'%');
                    else
                        $query=$query->where('from_page','like','%'.$ppp.'%');
            })
            ->whereRaw('length(from_page)>0');
        return (clone $this->ips)->get()->count();
    }

    private function getAsk1VisitorsIps(){
        $this->ips = VisitorLog::whereBetween('created_at', [$this->from_date, $this->to_date])
            ->select('ip')
            ->distinct()
            ->where('page','/ask1.php')
            ->whereIn('ip',$this->ips)
            ->where('from_page','https://trademarkfactory.com/guaranteed-result');
//        echo $this->ips->count().'<br/>';
//        dd($this->ips->get()->toArray());
        return (clone $this->ips)->get()->count();
    }


    protected function getLpsVisitorsIps(){
        $this->ips = VisitorLog::whereBetween('created_at', [$this->from_date, $this->to_date])
            ->select('ip')
            ->distinct()
            ->whereIn('page',[
                '/business-idea.php',
                '/startup.php',
                '/monetizing.php',
                '/growing.php',
                '/established.php',
            ])
            ->whereIn('ip',$this->ips)
            ->where('from_page','like','%https://trademarkfactory.com/ask/%');
        return (clone $this->ips)->get()->count();
    }

    protected function getTmfEbookVisitorsIps(){
        $this->ips = VisitorLog::whereBetween('created_at', [$this->from_date, $this->to_date])
            ->select('ip')
            ->distinct()
            ->where('page','/tmf-ebook.php')
            ->whereIn('ip',$this->ips)
            ->where('from_page','like','%https://trademarkfactory.com/ask/%');
        return (clone $this->ips)->get()->count();
    }

}

class WelcomeAskCStat extends WelcomeAskStat{

    public function get()
    {
        $result=[];
        $wsd=new WelcomeAskStatData();
        $wsd->caption='Welcome';
        $wsd->num=$this->getWelcomeAsk2VisitorsIps();
        $wsd->file='welcome-ask3.php';
        $result['welcome']=$wsd;
        $wsd=new WelcomeAskStatData();
        $wsd->caption='Ask2';
        $wsd->num=$this->getAsk2VisitorsIps();
        $result['ask2']=$wsd;
/*        foreach ($this->ips->get()->toArray() as $el)
            echo '"'.$el['ip'].'",';
        dd($this->ips->get()->toArray());*/
        $wsd=new WelcomeAskStatData();
        $wsd->caption='Got to one of 5 landings';
        $wsd->num=$this->getLpsVisitorsIps();
        $result['lps']=$wsd;
        $wsd=new WelcomeAskStatData();
        $wsd->caption='Clicked CTA';
        $wsd->num=$this->getClikedCTACount();
        $result['clicked-cta']=$wsd;
        return $result;
    }

    private function getWelcomeAsk2VisitorsIps(){
        $this->ips = VisitorLog::whereBetween('created_at', [$this->from_date, $this->to_date])
            ->select('ip')
            ->distinct()
            ->where('page','welcome-ask3.php')
            ->where(function ($query){
                foreach ($this->from_pages as $index=>$ppp)
                    if($index)
                        $query=$query->orWhere('from_page','like','%'.$ppp.'%');
                    else
                        $query=$query->where('from_page','like','%'.$ppp.'%');
            })
            ->whereRaw('length(from_page)>0');
        if(!$this->show_tmf_visitors)
            $this->ips=$this->ips->whereNotIn('ip',BlockIp::select('ip'));
        return (clone $this->ips)->get()->count();
    }

    private function getAsk2VisitorsIps(){
        $this->ips = VisitorLog::whereBetween('created_at', [$this->from_date, $this->to_date])
            ->select('ip')
            ->distinct()
            ->where('page','/guaranteed-result.php')
            ->whereIn('ip',$this->ips)
            ->where(function ($query){
                foreach ($this->from_pages as $index=>$ppp)
                    if($index)
                        $query=$query->orWhere('from_page','like','%'.$ppp.'%');
                    else
                        $query=$query->where('from_page','like','%'.$ppp.'%');
            })
            ->whereRaw('length(from_page)>0');
        return (clone $this->ips)->get()->count();
    }

}

class WelcomeAskDStat extends WelcomeAskStat{

    public function get()
    {
        $result=[];
        $wsd=new WelcomeAskStatData();
        $wsd->caption='WelcomeAsk2';
        $wsd->num=$this->getWelcomeAsk2VisitorsIps();
        $wsd->file='welcome-ask4.php';
        $result['welcome']=$wsd;

        $wsd=new WelcomeAskStatData();
        $wsd->caption='Got to one of 5 landings';
        $wsd->num=$this->getLpsVisitorsIps();
        $result['lps']=$wsd;

        $wsd=new WelcomeAskStatData();
        $wsd->caption='Clicked CTA';
        $wsd->num=$this->getClikedCTACount();
        $result['clicked-cta']=$wsd;
        return $result;
    }

    private function getWelcomeAsk2VisitorsIps(){
        $this->ips = VisitorLog::whereBetween('created_at', [$this->from_date, $this->to_date])
            ->select('ip')
            ->distinct()
            ->where('page','welcome-ask4.php')
            ->where(function ($query){
                foreach ($this->from_pages as $index=>$ppp)
                    if($index)
                        $query=$query->orWhere('from_page','like','%'.$ppp.'%');
                    else
                        $query=$query->where('from_page','like','%'.$ppp.'%');
            })
            ->whereRaw('length(from_page)>0');
        if(!$this->show_tmf_visitors)
            $this->ips=$this->ips->whereNotIn('ip',BlockIp::select('ip'));
        return (clone $this->ips)->get()->count();
    }

    protected function getLpsVisitorsIps(){
        $this->ips = VisitorLog::whereBetween('created_at', [$this->from_date, $this->to_date])
            ->select('ip')
            ->distinct()
            ->whereIn('page',[
                '/business-idea.php',
                '/startup.php',
                '/monetizing.php',
                '/growing.php',
                '/established.php',
            ])
            ->whereIn('ip',$this->ips)
            ->where(function ($query){
                foreach ($this->from_pages as $index=>$ppp)
                    if($index)
                        $query=$query->orWhere('from_page','like','%'.$ppp.'%');
                    else
                        $query=$query->where('from_page','like','%'.$ppp.'%');
            });
        return (clone $this->ips)->get()->count();
    }

}

class WelcomeAskEStat extends WelcomeAskStat{

    public function get()
    {
        $result=[];
        $wsd=new WelcomeAskStatData();
        $wsd->caption='WelcomeAsk2-Auto';
        $wsd->num=$this->getWelcomeAsk2VisitorsIps();
        $wsd->file='welcome-ask5.php';
        $result['welcome']=$wsd;


        $wsd=new WelcomeAskStatData();
        $wsd->caption='Got to one of 5 landings';
        $wsd->num=$this->getLpsVisitorsIps();
        $result['lps']=$wsd;

        $wsd=new WelcomeAskStatData();
        $wsd->caption='Clicked CTA';
        $wsd->num=$this->getClikedCTACount();
        $result['clicked-cta']=$wsd;
        return $result;
    }

    private function getWelcomeAsk2VisitorsIps(){
        $this->ips = VisitorLog::whereBetween('created_at', [$this->from_date, $this->to_date])
            ->select('ip')
            ->distinct()
            ->where('page','welcome-ask5.php')
            ->where(function ($query){
                foreach ($this->from_pages as $index=>$ppp)
                    if($index)
                        $query=$query->orWhere('from_page','like','%'.$ppp.'%');
                    else
                        $query=$query->where('from_page','like','%'.$ppp.'%');
            })
            ->whereRaw('length(from_page)>0');
        if(!$this->show_tmf_visitors)
            $this->ips=$this->ips->whereNotIn('ip',BlockIp::select('ip'));
        return (clone $this->ips)->get()->count();
    }

    protected function getLpsVisitorsIps(){
        $this->ips = VisitorLog::whereBetween('created_at', [$this->from_date, $this->to_date])
            ->select('ip')
            ->distinct()
            ->whereIn('page',[
                '/business-idea.php',
                '/startup.php',
                '/monetizing.php',
                '/growing.php',
                '/established.php',
            ])
            ->whereIn('ip',$this->ips)
            ->where(function ($query){
                foreach ($this->from_pages as $index=>$ppp)
                    if($index)
                        $query=$query->orWhere('from_page','like','%'.$ppp.'%');
                    else
                        $query=$query->where('from_page','like','%'.$ppp.'%');
            });
        return (clone $this->ips)->get()->count();
    }

}

class WelcomeAskFStat extends WelcomeAskStat{

    public function get()
    {
        $result=[];
        $wsd=new WelcomeAskStatData();
        $wsd->caption='WelcomeAsk2-Promo';
        $wsd->num=$this->getWelcomeAsk2VisitorsIps();
        $wsd->file='welcome-ask6.php';
        $result['welcome']=$wsd;

        $wsd=new WelcomeAskStatData();
        $wsd->caption='Got to one of 5 landings';
        $wsd->num=$this->getLpsVisitorsIps();
        $result['lps']=$wsd;

        $wsd=new WelcomeAskStatData();
        $wsd->caption='Clicked CTA';
        $wsd->num=$this->getClikedCTACount();
        $result['clicked-cta']=$wsd;
        return $result;
    }

    private function getWelcomeAsk2VisitorsIps(){
        $this->ips = VisitorLog::whereBetween('created_at', [$this->from_date, $this->to_date])
            ->select('ip')
            ->distinct()
            ->where('page','welcome-ask6.php')
            ->where(function ($query){
                foreach ($this->from_pages as $index=>$ppp)
                    if($index)
                        $query=$query->orWhere('from_page','like','%'.$ppp.'%');
                    else
                        $query=$query->where('from_page','like','%'.$ppp.'%');
            })
            ->whereRaw('length(from_page)>0');
        if(!$this->show_tmf_visitors)
            $this->ips=$this->ips->whereNotIn('ip',BlockIp::select('ip'));
        return (clone $this->ips)->get()->count();
    }

    protected function getLpsVisitorsIps(){
        $this->ips = VisitorLog::whereBetween('created_at', [$this->from_date, $this->to_date])
            ->select('ip')
            ->distinct()
            ->whereIn('page',[
                '/business-idea.php',
                '/startup.php',
                '/monetizing.php',
                '/growing.php',
                '/established.php',
            ])
            ->whereIn('ip',$this->ips)
            ->where(function ($query){
                foreach ($this->from_pages as $index=>$ppp)
                    if($index)
                        $query=$query->orWhere('from_page','like','%'.$ppp.'%');
                    else
                        $query=$query->where('from_page','like','%'.$ppp.'%');
            });
        return (clone $this->ips)->get()->count();
    }

}

class WelcomeAskGStat extends WelcomeAskStat{

    public function get()
    {
        $result=[];
        $wsd=new WelcomeAskStatData();
        $wsd->caption='WelcomeAsk2-Auto-Promo';
        $wsd->num=$this->getWelcomeAsk2VisitorsIps();
        $wsd->file='welcome-ask7.php';
        $result['welcome']=$wsd;


        $wsd=new WelcomeAskStatData();
        $wsd->caption='Got to one of 5 landings';
        $wsd->num=$this->getLpsVisitorsIps();
        $result['lps']=$wsd;

        $wsd=new WelcomeAskStatData();
        $wsd->caption='Clicked CTA';
        $wsd->num=$this->getClikedCTACount();
        $result['clicked-cta']=$wsd;
        return $result;
    }

    private function getWelcomeAsk2VisitorsIps(){
        $this->ips = VisitorLog::whereBetween('created_at', [$this->from_date, $this->to_date])
            ->select('ip')
            ->distinct()
            ->where('page','welcome-ask7.php')
            ->where(function ($query){
                foreach ($this->from_pages as $index=>$ppp)
                    if($index)
                        $query=$query->orWhere('from_page','like','%'.$ppp.'%');
                    else
                        $query=$query->where('from_page','like','%'.$ppp.'%');
            })
            ->whereRaw('length(from_page)>0');
        if(!$this->show_tmf_visitors)
            $this->ips=$this->ips->whereNotIn('ip',BlockIp::select('ip'));
        return (clone $this->ips)->get()->count();
    }

    protected function getLpsVisitorsIps(){
        $this->ips = VisitorLog::whereBetween('created_at', [$this->from_date, $this->to_date])
            ->select('ip')
            ->distinct()
            ->whereIn('page',[
                '/business-idea.php',
                '/startup.php',
                '/monetizing.php',
                '/growing.php',
                '/established.php',
            ])
            ->whereIn('ip',$this->ips)
            ->where(function ($query){
                foreach ($this->from_pages as $index=>$ppp)
                    if($index)
                        $query=$query->orWhere('from_page','like','%'.$ppp.'%');
                    else
                        $query=$query->where('from_page','like','%'.$ppp.'%');
            });
        return (clone $this->ips)->get()->count();
    }

}

class WelcomeAskHStat extends WelcomeAskStat{

    public function get()
    {
        $result=[];
        $wsd=new WelcomeAskStatData();
        $wsd->caption='WelcomeAsk2-BigButton';
        $wsd->num=$this->getWelcomeAsk2VisitorsIps();
        $wsd->file='welcome-ask8.php';
        $result['welcome']=$wsd;

        $wsd=new WelcomeAskStatData();
        $wsd->caption='Got to one of 5 landings';
        $wsd->num=$this->getLpsVisitorsIps();
        $result['lps']=$wsd;

        $wsd=new WelcomeAskStatData();
        $wsd->caption='Clicked CTA';
        $wsd->num=$this->getClikedCTACount();
        $result['clicked-cta']=$wsd;
        return $result;
    }

    private function getWelcomeAsk2VisitorsIps(){
        $this->ips = VisitorLog::whereBetween('created_at', [$this->from_date, $this->to_date])
            ->select('ip')
            ->distinct()
            ->where('page','welcome-ask8.php')
            ->where(function ($query){
                foreach ($this->from_pages as $index=>$ppp)
                    if($index)
                        $query=$query->orWhere('from_page','like','%'.$ppp.'%');
                    else
                        $query=$query->where('from_page','like','%'.$ppp.'%');
            })
            ->whereRaw('length(from_page)>0');
        if(!$this->show_tmf_visitors)
            $this->ips=$this->ips->whereNotIn('ip',BlockIp::select('ip'));
        return (clone $this->ips)->get()->count();
    }

    protected function getLpsVisitorsIps(){
        $this->ips = VisitorLog::whereBetween('created_at', [$this->from_date, $this->to_date])
            ->select('ip')
            ->distinct()
            ->whereIn('page',[
                '/business-idea.php',
                '/startup.php',
                '/monetizing.php',
                '/growing.php',
                '/established.php',
            ])
            ->whereIn('ip',$this->ips)
            ->where(function ($query){
                foreach ($this->from_pages as $index=>$ppp)
                    if($index)
                        $query=$query->orWhere('from_page','like','%'.$ppp.'%');
                    else
                        $query=$query->where('from_page','like','%'.$ppp.'%');
            });
        return (clone $this->ips)->get()->count();
    }

}

class WelcomeAskIStat extends WelcomeAskStat{

    public function get()
    {
        $result=[];
        $wsd=new WelcomeAskStatData();
        $wsd->caption='WelcomeAsk2-SmallButton';
        $wsd->num=$this->getWelcomeAsk2VisitorsIps();
        $wsd->file='welcome-ask9.php';
        $result['welcome']=$wsd;


        $wsd=new WelcomeAskStatData();
        $wsd->caption='Got to one of 5 landings';
        $wsd->num=$this->getLpsVisitorsIps();
        $result['lps']=$wsd;

        $wsd=new WelcomeAskStatData();
        $wsd->caption='Clicked CTA';
        $wsd->num=$this->getClikedCTACount();
        $result['clicked-cta']=$wsd;
        return $result;
    }

    private function getWelcomeAsk2VisitorsIps(){
        $this->ips = VisitorLog::whereBetween('created_at', [$this->from_date, $this->to_date])
            ->select('ip')
            ->distinct()
            ->where('page','welcome-ask9.php')
            ->where(function ($query){
                foreach ($this->from_pages as $index=>$ppp)
                    if($index)
                        $query=$query->orWhere('from_page','like','%'.$ppp.'%');
                    else
                        $query=$query->where('from_page','like','%'.$ppp.'%');
            })
            ->whereRaw('length(from_page)>0');
        if(!$this->show_tmf_visitors)
            $this->ips=$this->ips->whereNotIn('ip',BlockIp::select('ip'));
        return (clone $this->ips)->get()->count();
    }

    protected function getLpsVisitorsIps(){
        $this->ips = VisitorLog::whereBetween('created_at', [$this->from_date, $this->to_date])
            ->select('ip')
            ->distinct()
            ->whereIn('page',[
                '/business-idea.php',
                '/startup.php',
                '/monetizing.php',
                '/growing.php',
                '/established.php',
            ])
            ->whereIn('ip',$this->ips)
            ->where(function ($query){
                foreach ($this->from_pages as $index=>$ppp)
                    if($index)
                        $query=$query->orWhere('from_page','like','%'.$ppp.'%');
                    else
                        $query=$query->where('from_page','like','%'.$ppp.'%');
            });
        return (clone $this->ips)->get()->count();
    }

}

class WelcomeAskJStat extends WelcomeAskStat{

    public function get()
    {
        $result=[];
        $wsd=new WelcomeAskStatData();
        $wsd->caption='WelcomeAsk2-ColorRadio';
        $wsd->num=$this->getWelcomeAsk2VisitorsIps();
        $wsd->file='welcome-ask10.php';
        $result['welcome']=$wsd;


        $wsd=new WelcomeAskStatData();
        $wsd->caption='Got to one of 5 landings';
        $wsd->num=$this->getLpsVisitorsIps();
        $result['lps']=$wsd;

        $wsd=new WelcomeAskStatData();
        $wsd->caption='Clicked CTA';
        $wsd->num=$this->getClikedCTACount();
        $result['clicked-cta']=$wsd;
        return $result;
    }

    private function getWelcomeAsk2VisitorsIps(){
        $this->ips = VisitorLog::whereBetween('created_at', [$this->from_date, $this->to_date])
            ->select('ip')
            ->distinct()
            ->where('page','welcome-ask10.php')
            ->where(function ($query){
                foreach ($this->from_pages as $index=>$ppp)
                    if($index)
                        $query=$query->orWhere('from_page','like','%'.$ppp.'%');
                    else
                        $query=$query->where('from_page','like','%'.$ppp.'%');
            })
            ->whereRaw('length(from_page)>0');
        if(!$this->show_tmf_visitors)
            $this->ips=$this->ips->whereNotIn('ip',BlockIp::select('ip'));
        return (clone $this->ips)->get()->count();
    }

    protected function getLpsVisitorsIps(){
        $this->ips = VisitorLog::whereBetween('created_at', [$this->from_date, $this->to_date])
            ->select('ip')
            ->distinct()
            ->whereIn('page',[
                '/business-idea.php',
                '/startup.php',
                '/monetizing.php',
                '/growing.php',
                '/established.php',
            ])
            ->whereIn('ip',$this->ips)
            ->where(function ($query){
                foreach ($this->from_pages as $index=>$ppp)
                    if($index)
                        $query=$query->orWhere('from_page','like','%'.$ppp.'%');
                    else
                        $query=$query->where('from_page','like','%'.$ppp.'%');
            });
        return (clone $this->ips)->get()->count();
    }

}

class WelcomeAskKStat extends WelcomeAskStat{

    public function get()
    {
        $result=[];
        $wsd=new WelcomeAskStatData();
        $wsd->caption='WelcomeAsk2-5Radios';
        $wsd->num=$this->getWelcomeAsk2VisitorsIps();
        $wsd->file='welcome-ask11.php';
        $result['welcome']=$wsd;


        $wsd=new WelcomeAskStatData();
        $wsd->caption='Got to one of 5 landings';
        $wsd->num=$this->getLpsVisitorsIps();
        $result['lps']=$wsd;

        $wsd=new WelcomeAskStatData();
        $wsd->caption='Clicked CTA';
        $wsd->num=$this->getClikedCTACount();
        $result['clicked-cta']=$wsd;
        return $result;
    }

    private function getWelcomeAsk2VisitorsIps(){
        $this->ips = VisitorLog::whereBetween('created_at', [$this->from_date, $this->to_date])
            ->select('ip')
            ->distinct()
            ->where('page','welcome-ask11.php')
            ->where(function ($query){
                foreach ($this->from_pages as $index=>$ppp)
                    if($index)
                        $query=$query->orWhere('from_page','like','%'.$ppp.'%');
                    else
                        $query=$query->where('from_page','like','%'.$ppp.'%');
            })
            ->whereRaw('length(from_page)>0');
        if(!$this->show_tmf_visitors)
            $this->ips=$this->ips->whereNotIn('ip',BlockIp::select('ip'));
        return (clone $this->ips)->get()->count();
    }

    protected function getLpsVisitorsIps(){
        $this->ips = VisitorLog::whereBetween('created_at', [$this->from_date, $this->to_date])
            ->select('ip')
            ->distinct()
            ->whereIn('page',[
                '/business-idea.php',
                '/startup.php',
                '/monetizing.php',
                '/growing.php',
                '/established.php',
            ])
            ->whereIn('ip',$this->ips)
            ->where(function ($query){
                foreach ($this->from_pages as $index=>$ppp)
                    if($index)
                        $query=$query->orWhere('from_page','like','%'.$ppp.'%');
                    else
                        $query=$query->where('from_page','like','%'.$ppp.'%');
            });
        return (clone $this->ips)->get()->count();
    }

}

class WelcomeAskLStat extends WelcomeAskStat{

    public function get()
    {
        $result=[];
        $wsd=new WelcomeAskStatData();
        $wsd->caption='WelcomeAsk2-5Radios-New';
        $wsd->num=$this->getWelcomeAsk2VisitorsIps();
        $wsd->file='welcome-ask12.php';
        $result['welcome']=$wsd;


        $wsd=new WelcomeAskStatData();
        $wsd->caption='Got to one of 5 landings';
        $wsd->num=$this->getLpsVisitorsIps();
        $result['lps']=$wsd;

        $wsd=new WelcomeAskStatData();
        $wsd->caption='Clicked CTA';
        $wsd->num=$this->getClikedCTACount();
        $result['clicked-cta']=$wsd;
        return $result;
    }

    private function getWelcomeAsk2VisitorsIps(){
        $this->ips = VisitorLog::whereBetween('created_at', [$this->from_date, $this->to_date])
            ->select('ip')
            ->distinct()
            ->where('page','welcome-ask12.php')
            ->where(function ($query){
                foreach ($this->from_pages as $index=>$ppp)
                    if($index)
                        $query=$query->orWhere('from_page','like','%'.$ppp.'%');
                    else
                        $query=$query->where('from_page','like','%'.$ppp.'%');
            })
            ->whereRaw('length(from_page)>0');
        if(!$this->show_tmf_visitors)
            $this->ips=$this->ips->whereNotIn('ip',BlockIp::select('ip'));
        return (clone $this->ips)->get()->count();
    }

    protected function getLpsVisitorsIps(){
        $this->ips = VisitorLog::whereBetween('created_at', [$this->from_date, $this->to_date])
            ->select('ip')
            ->distinct()
            ->whereIn('page',[
                '/business-idea.php',
                '/startup.php',
                '/monetizing.php',
                '/growing.php',
                '/established.php',
            ])
            ->whereIn('ip',$this->ips)
            ->where(function ($query){
                foreach ($this->from_pages as $index=>$ppp)
                    if($index)
                        $query=$query->orWhere('from_page','like','%'.$ppp.'%');
                    else
                        $query=$query->where('from_page','like','%'.$ppp.'%');
            });
        return (clone $this->ips)->get()->count();
    }

}
