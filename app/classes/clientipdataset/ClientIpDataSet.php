<?php
namespace App\classes\clientipdataset;
use App\classes\clientipdataset\BookedClientIpDataSet;
use App\classes\clientipdataset\SelfCheckoutClientIpDataSet;

abstract class ClientIpDataSet
{
    protected $ips=[];
    protected $filter;
    protected $tmoffer_objs=null;

    protected function __construct(ClientIpDatasetFilter $filter)
    {
        $this->filter=$filter;
    }

    public static function initBookedIps(ClientIpDatasetFilter $filter){
        return new BookedClientIpDataSet($filter);
    }

    public static function initSelfCheckoutIps(ClientIpDatasetFilter $filter){
        return new SelfCheckoutClientIpDataSet($filter);
    }

    abstract protected function initTmofferObj();

    protected function getNoShowData(){
        return [];
    }

    protected function getNoBoomData()
    {
        if($this->filter->no_boom==0)
            return [];

        return $this->dataToArr($this->initTmofferObj()
            ->where('DateConfirmed','=','0000-00-00')
            ->get()
            ->toArray());
    }

    protected function getBoomData(){
        if($this->filter->boom==0)
            return [];

//        echo $this->initTmofferObj()
//            ->where('DateConfirmed','!=','0000-00-00')->dump();
//        exit;

        return $this->dataToArr($this->initTmofferObj()
            ->where('DateConfirmed','!=','0000-00-00')
            ->get()
            ->toArray());
    }

    public function get(){
        $arr=array_unique(array_merge(
            $this->getNoShowData(),
            $this->getNoBoomData(),
            $this->getBoomData()
        ));
       sort($arr);
       return $arr;
    }

    protected function dataToArr($data){
        $result=[];
        foreach ($data as $el)
            $result[]=$el['client_ip'];
        return $result;
    }
}