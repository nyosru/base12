<?php
namespace App\classes\trends;


class TrendsChart
{
    private $trend_periods_obj;
    private $trend_chart_data;
    private $countries;
    private $snapshot_loaders;
    private $datasets=[];

    protected $ops_snapshot_country_preset;

    public function __construct(TrendPeriods $trend_periods_obj,$trend_chart_data,$ops_snapshot_country_preset)
    {
        $this->ops_snapshot_country_preset=$ops_snapshot_country_preset;
        $this->trend_periods_obj=$trend_periods_obj;
        $this->trend_chart_data=$trend_chart_data;
        $this->countries=$ops_snapshot_country_preset->tmfCountries()->pluck('tmf_country.id')->toArray();
    }

    private function initSnapshotLoaders(){
        $ids=[];
        foreach ($this->trend_chart_data as $el)
            if(!in_array($el->getOpsSnapshotTitleId(),$ids)) {
                $this->snapshot_loaders[$el->getOpsSnapshotTitleId()] = new SnapshotDataLoader($el->getOpsSnapshotTitleId());
                $ids[]=$el->getOpsSnapshotTitleId();
            }
    }

/*    public function getDatasets(){
        if(count($this->datasets))
            return $this->datasets;

        foreach ($this->trend_periods_obj->getPeriods() as $period){

            foreach ($this->trend_chart_data as $trend_chart_el){
                $caption=$trend_chart_el->name;
                if(!isset($this->datasets[$caption])) {
                    $color='#'.$this->getRandomColor();
                    $this->datasets[$caption] = [
                        'label' => $caption,
                        'backgroundColor' => $color,
                        'borderColor' => $color,
                        'fill' => false,
                        'trends_chart_id'=>$trend_chart_el->id,
                        'data' => []
                    ];
                }
                $static_method = $trend_chart_el->code . 'DataLoader';
                $this->datasets[$caption]['data'][]=HistorySnapshotDataLoader::$static_method(
                    $this->countries,
                    new \DateTime($period['from']->format('Y-m-d').' 00:00:00'),
                    new \DateTime($period['to']->format('Y-m-d').' 23:59:59')
                )
                    ->getValue();
            }
        }
        return $this->datasets;
    }*/

    public function getDatasets(){
        if(count($this->datasets))
            return $this->datasets;

        foreach ($this->trend_periods_obj->getPeriods() as $period){

            foreach ($this->trend_chart_data as $trend_chart_el){
                $caption=$trend_chart_el->name;
                if(!isset($this->datasets[$trend_chart_el->chart_group_num]))
                    $this->datasets[$trend_chart_el->chart_group_num]=[];

                if(!isset($this->datasets[$trend_chart_el->chart_group_num][$trend_chart_el->id])){
                    if(strlen($trend_chart_el->color))
                        $color=$trend_chart_el->color;
                    else
                        $color='#'.$this->getRandomColor();
                    $this->datasets[$trend_chart_el->chart_group_num][$trend_chart_el->id]=[
                        'label' => $caption,
                        'backgroundColor' => $color,
                        'borderColor' => $color,
                        'fill' => false,
                        'trends_chart_id'=>$trend_chart_el->id,
                        'pointRadius'=>23,
                        'pointHoverRadius'=>25,
                        'data' => [],
                        'min'=>0,
                        'max'=>0
                    ];
                }

                $static_method = $trend_chart_el->code . 'DataLoader';
                $this->datasets[$trend_chart_el->chart_group_num][$trend_chart_el->id]['data'][]=HistorySnapshotDataLoader::$static_method(
                    $this->ops_snapshot_country_preset,
                    new \DateTime($period['from']->format('Y-m-d').' 00:00:00'),
                    new \DateTime($period['to']->format('Y-m-d').' 23:59:59')
                )
                    ->getValue();
                $this->datasets[$trend_chart_el->chart_group_num][$trend_chart_el->id]['min']=min($this->datasets[$trend_chart_el->chart_group_num][$trend_chart_el->id]['data']);
                $this->datasets[$trend_chart_el->chart_group_num][$trend_chart_el->id]['max']=max($this->datasets[$trend_chart_el->chart_group_num][$trend_chart_el->id]['data']);
            }
        }
        return $this->datasets;
    }

    public function getPeriods(){
        $data=[];
        foreach ($this->trend_periods_obj->getPeriods() as $period)
            $data[]=$period['from']->format('Y-m-d').'-'.$period['to']->format('Y-m-d');
        return $data;
    }

    private function loadSnapshotData(\DateTime $from,\DateTime $to){
        foreach ($this->snapshot_loaders as $el)
            $el->run($from,$to);
    }

    public function reloadDatasets(){
        $this->datasets=[];
        return $this;
    }

    private function getRandomColorPart() {
        return str_pad( dechex( mt_rand( 0, 255 ) ), 2, '0', STR_PAD_LEFT);
    }

    private function getRandomColor() {
        return $this->getRandomColorPart() . $this->getRandomColorPart() . $this->getRandomColorPart();
    }



}