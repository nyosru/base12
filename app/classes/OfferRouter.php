<?php
namespace App\classes;


class OfferRouter{
    private $tmoffer;
    private $donttrack;

    public function __construct(Tmoffer $tmoffer,$donttrack=0){
        $this->tmoffer=$tmoffer;
        $this->donttrack=$donttrack;
    }

    public function getCurrentOffer(){
        return $this->getActualOfferHistory()->getOffer();
    }

    private function getActualOfferHistory(){

        $offer_history_objs=OfferHistoryQuery::create()
            ->filterByTmofferId($this->tmoffer->getId())
            ->orderById('desc')
            ->find();

        if($offer_history_objs->count())
            $offer_history=$this->findActualOfferHistory($offer_history_objs);
        else
            $offer_history=$this->createActualOfferHistory('Default');
        $offer=$offer_history->getOffer();
        if($this->donttrack &&
            !in_array($offer->getOfferType()->getOfferTypeName(),['Events','Affiliates']) &&
            !$offer->getDefaultOfferPricePresetId() &&
            !$offer->getDiscountOfferPricePresetId()
        )
//            return $this->getSalesCallOfferHistory();
            return $this->getOfferHistoryByType('Sales Call');

        /*        if($this->tmoffer->getAffiliateUserId())
                    return $this->getAffiilateUserOfferHistory();*/

        return $offer_history;
    }

    private function findActualOfferHistory($offer_history_objs){

        foreach ($offer_history_objs as $offer_history_obj){
            if($this->isActualStatus($offer_history_obj))
                return $offer_history_obj;
        }
//        throw new Exception(sprintf('Can\'t find offer for user: %s!',$this->tmoffer->getLogin()));
        return $this->createActualOfferHistory('Default');
    }

    private function isActualStatus($offer_history_obj){
        $offer=$offer_history_obj->getOffer();
        if($offer->getOfferName()=='Sales Call')
            return false;
        if($offer->getHasDeadline() && $offer->getDeadlineValue()){
            switch($offer->getDeadlineType()){
                case 'date':
                    $total_time=$offer->getDeadlineValue();
                    break;
                case 'event':
                default:
                    $total_time=$offer->getDeadlineValue()*3600+strtotime($offer_history_obj->getCreatedAt()->format('Y-m-d H:i:s'));
                    break;
            }
            return $total_time>=time();
        }
        return true;
    }

    private function getAffiilateUserOfferHistory(){
//        $type_name='Sales Call';

        $offer_history_obj=OfferHistoryQuery::create()
            ->useOfferQuery()
            ->useOfferTypeQuery()
            ->filterByOfferTypeName('Affiliates')
            ->endUse()
            ->endUse()
            ->filterByTmofferId($this->tmoffer->getId())
            ->findOne();

        if($offer_history_obj)
            return $offer_history_obj;
        else
            return $this->createActualAffiliateOfferHistory();
    }

    private function createActualAffiliateOfferHistory(){

        $affiliate_user=AffiliateUserQuery::create()->findPk($this->tmoffer->getAffiliateUserId());
        $offer_history=new OfferHistory();
        $offer_history->setTmofferId($this->tmoffer->getId());
        $offer_history->setOfferId($affiliate_user->getOfferId());
        $offer_history->setCreatedAt(date('Y-m-d H:i:s'));
        $offer_history->save();
        $offer_history->reload();
        return $offer_history;
    }

//    private function getSalesCallOfferHistory(){
    private function getOfferHistoryByType($type_name){
//        $type_name='Sales Call';
        $offer_history_obj=OfferHistoryQuery::create()
            ->useOfferQuery()
            ->useOfferTypeQuery()
            ->filterByOfferTypeName($type_name)
            ->endUse()
            ->endUse()
            ->filterByTmofferId($this->tmoffer->getId())
            ->findOne();
        if($offer_history_obj)
            return $offer_history_obj;
        else
            return $this->createActualOfferHistory($type_name);
    }

    private function createActualOfferHistory($type_name){
        $offer=$this->getOfferByTypeName($type_name);
        $offer_history=new OfferHistory();
        $offer_history->setTmofferId($this->tmoffer->getId());
        $offer_history->setOfferId($offer->getId());
        $offer_history->setCreatedAt(date('Y-m-d H:i:s'));
        $offer_history->save();
        $offer_history->reload();
        if(in_array($offer->getSendTemplates(),['all','dt auto']))
            $offer_templates=1;
        else
            $offer_templates=0;
        $this->tmoffer->setOfferTemplates($offer_templates);
        if(in_array($offer->getWatchService(),['all','dt auto']))
            $watch_service=1;
        else
            $watch_service=0;
        $all_tmoffer_tmf_country_trademark_objs=TmofferTmfCountryTrademarkQuery::create()
            ->filterByTmofferId($this->tmoffer->getId())
            ->filterBySearchOnly(0)
            ->find();
        if($all_tmoffer_tmf_country_trademark_objs && $all_tmoffer_tmf_country_trademark_objs->count())
            foreach ($all_tmoffer_tmf_country_trademark_objs as $el){
                $el->setWatchService($watch_service);
                $el->save();
            }

        $this->tmoffer->setOfferTemplates($offer_templates);
        $this->tmoffer->save();
        return $offer_history;
    }

    private function getOfferByTypeName($type_name){
        return OfferQuery::create()
            ->useOfferTypeQuery()
            ->filterByOfferTypeName($type_name)
            ->endUse()
            ->findOne();
    }
}