<?php
namespace App\classes\trends;


use App\DashboardInTimingsType;

abstract class HistorySnapshotDataLoader
{
    protected $dashboard_ids=[];
    protected $dashboard_tms=[];
    protected $dashboard_details_data=[];
    protected $value=0;
    protected $countries=[];
    protected $from_date;
    protected $to_date;
    protected $dashboard_in_timings_type_objs;
    
    protected $ops_snapshot_country_preset;

    protected function __construct($ops_snapshot_country_preset,\DateTime $from_date,\DateTime $to_date)
    {
        $this->dashboard_in_timings_type_objs=DashboardInTimingsType::orderBy('id')->get();
        $this->ops_snapshot_country_preset=$ops_snapshot_country_preset;
        $this->countries=$ops_snapshot_country_preset->tmfCountries()->pluck('tmf_country.id')->toArray();
        $this->from_date=$from_date;
        $this->to_date=$to_date;
        $this->initData();
    }

    abstract protected function initData();

    public function loadHistoryValue()
    {
    }

//    abstract public function showDetails();

    public static function line1DataLoader($ops_snapshot_country_preset,\DateTime $from_date,\DateTime $to_date){
        return new Line1HistorySnapshotDataLoader($ops_snapshot_country_preset,$from_date,$to_date);
    }

    public static function line2DataLoader($ops_snapshot_country_preset,\DateTime $from_date,\DateTime $to_date){
        return new Line2HistorySnapshotDataLoader($ops_snapshot_country_preset,$from_date,$to_date);
    }

    public static function line3DataLoader($ops_snapshot_country_preset,\DateTime $from_date,\DateTime $to_date){
        return new Line3HistorySnapshotDataLoader($ops_snapshot_country_preset,$from_date,$to_date);
    }

    public static function line4DataLoader($ops_snapshot_country_preset,\DateTime $from_date,\DateTime $to_date){
        return new Line4HistorySnapshotDataLoader($ops_snapshot_country_preset,$from_date,$to_date);
    }

    public static function line5DataLoader($ops_snapshot_country_preset,\DateTime $from_date,\DateTime $to_date){
        return new Line5HistorySnapshotDataLoader($ops_snapshot_country_preset,$from_date,$to_date);
    }

    public static function line6DataLoader($ops_snapshot_country_preset,\DateTime $from_date,\DateTime $to_date){
        return new Line6HistorySnapshotDataLoader($ops_snapshot_country_preset,$from_date,$to_date);
    }

    public static function line7DataLoader($ops_snapshot_country_preset,\DateTime $from_date,\DateTime $to_date){
        return new Line7HistorySnapshotDataLoader($ops_snapshot_country_preset,$from_date,$to_date);
    }

    public static function line8DataLoader($ops_snapshot_country_preset,\DateTime $from_date,\DateTime $to_date){
        return new Line8HistorySnapshotDataLoader($ops_snapshot_country_preset,$from_date,$to_date);
    }

    public static function line9DataLoader($ops_snapshot_country_preset,\DateTime $from_date,\DateTime $to_date){
        return new Line9HistorySnapshotDataLoader($ops_snapshot_country_preset,$from_date,$to_date);
    }

    public static function line10DataLoader($ops_snapshot_country_preset,\DateTime $from_date,\DateTime $to_date){
        return new Line10HistorySnapshotDataLoader($ops_snapshot_country_preset,$from_date,$to_date);
    }

    public static function line11DataLoader($ops_snapshot_country_preset,\DateTime $from_date,\DateTime $to_date){
        return new Line11HistorySnapshotDataLoader($ops_snapshot_country_preset,$from_date,$to_date);
    }

    public static function line12DataLoader($ops_snapshot_country_preset,\DateTime $from_date,\DateTime $to_date){
        return new Line12HistorySnapshotDataLoader($ops_snapshot_country_preset,$from_date,$to_date);
    }

    public static function line13DataLoader($ops_snapshot_country_preset,\DateTime $from_date,\DateTime $to_date){
        return new Line13HistorySnapshotDataLoader($ops_snapshot_country_preset,$from_date,$to_date);
    }

    public static function line14DataLoader($ops_snapshot_country_preset,\DateTime $from_date,\DateTime $to_date){
        return new Line14HistorySnapshotDataLoader($ops_snapshot_country_preset,$from_date,$to_date);
    }

    public static function line15DataLoader($ops_snapshot_country_preset,\DateTime $from_date,\DateTime $to_date){
        return new Line15HistorySnapshotDataLoader($ops_snapshot_country_preset,$from_date,$to_date);
    }

    public static function line16DataLoader($ops_snapshot_country_preset,\DateTime $from_date,\DateTime $to_date){
        return new Line16HistorySnapshotDataLoader($ops_snapshot_country_preset,$from_date,$to_date);
    }

    public static function line17DataLoader($ops_snapshot_country_preset,\DateTime $from_date,\DateTime $to_date){
        return new Line17HistorySnapshotDataLoader($ops_snapshot_country_preset,$from_date,$to_date);
    }

    public static function line18DataLoader($ops_snapshot_country_preset,\DateTime $from_date,\DateTime $to_date){
        return new Line18HistorySnapshotDataLoader($ops_snapshot_country_preset,$from_date,$to_date);
    }

    public static function line19DataLoader($ops_snapshot_country_preset,\DateTime $from_date,\DateTime $to_date){
        return new Line19HistorySnapshotDataLoader($ops_snapshot_country_preset,$from_date,$to_date);
    }

    public function getValue(){
        return $this->value;
    }

    public function getIds(){
        return $this->dashboard_ids;
    }

    protected function getDashboardTM($dashboard_obj)
    {
        $tmf_trademark = $dashboard_obj->tmfCountryTrademark->tmfTrademark;
        $tmf_country = $dashboard_obj->tmfCountryTrademark->tmfCountry;
        $mark = $tmf_trademark->tmf_trademark_mark;
        if ($tmf_trademark->tmf_trademark_type_id == 1)
            $mark=sprintf('<img src="https://trademarkfactory.imgix.net/offerimages/%s" style="max-width: 100px;max-height: 75px;"/>',$mark);
        return sprintf('<img src="https://trademarkfactory.imgix.net/img/countries/%s" style="width: 20px;height: 12px;"> %s',$tmf_country->tmf_country_flag,$mark);
    }

    public function showDetails()
    {
        return '';
    }

    public function getDashboardDetailsData(){
        return $this->dashboard_details_data;
    }
}