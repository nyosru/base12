<?php

namespace App\traits;
use Illuminate\Http\Request;

trait FaqCartoonTrait
{
    private function getOptionsHours(){
        $result='';
        for($i=0;$i<24;$i++)
            $result.=sprintf('<option value="%d">%s</option>',$i,($i<10?'0':'').$i);
        return $result;
    }

    private function getOptionsMinutes(){
        $result='';
        for($i=0;$i<12;$i++)
            $result.=sprintf('<option value="%d">%s</option>',$i*5,($i*5<10?'0':'').$i*5);
        return $result;
    }

    private function getPostTimeArea(){
        $result='';
        for($i=1;$i<6;$i++)
            $result.=sprintf('
                <div class="row post-area" id="post-area-%d" style="display: none;margin-bottom: 20px">
                    <label class="control-label col-md-3">Post #%d time:</label>
                    <div class="col-md-9">
                        <select class="form-control post-time-hour" name="post_time_hour[]" style="display: inline-block;width:65px">
                            %s
                        </select> :
                        <select class="form-control post-time-minute" name="post_time_minute[]" style="display: inline-block;width:65px;">
                            %s
                        </select> <span style="margin-right: 40px;">PST</span>
                        +/- <select class="form-control post-time-plus-minus-minute" name="post_time_plus_minus_minute[]" style="display: inline-block;width:65px;">
                            <option value="0">00</option>
                            <option value="5">05</option>
                            <option value="15">15</option>
                            <option value="30">30</option>
                            <option value="60">60</option>
                        </select> min
                    </div>
                </div>

        ',$i,$i,$this->getOptionsHours(),$this->getOptionsMinutes());
        return $result;
    }


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $sections=$this->fc->getCategoryClassname()::orderBy('place_id','asc')->get();
//        dd($sections[0]->items->sortBy('place_id'));
        $prefix=strtolower(str_replace('App\\','',$this->fc->getClassname()));
        return view('fc-maintainer.index',[
            'title'=>str_replace('App\\','',$this->fc->getClassname()).' Maintainer',
            'sections'=>$sections,
            'url'=>'https://trademarkfactory.com/'.strtolower(str_replace('App\\','',$this->fc->getClassname())),
            'post_time_area'=>$this->getPostTimeArea(),
            'prefix'=>$prefix,
            'left_nav_bar'=>view('fc-maintainer.left-nav-bar',compact('prefix'))->render()
        ]);
    }

    public function saveSection(Request $request){
        if($request->section) {
            $last_section = $this->fc->getCategoryClassname()::orderBy('place_id', 'desc')->first();
            $category_classname=$this->fc->getCategoryClassname();
            $obj=new $category_classname();
            $obj->name=$request->section;
            $obj->place_id=$last_section->place_id+1;
            $obj->save();
            return 'DONE';
        }
        return '';
    }

    public function editSection(Request $request){
        if($request->section && $request->id) {
            $obj=$this->fc->getCategoryClassname()::find($request->id);
            if($obj){
                $obj->name=$request->section;
                $obj->save();
                return 'DONE';
            }
        }
        return '';
    }

    public function deleteSection(Request $request){
        if($request->id) {
            $obj=$this->fc->getCategoryClassname()::find($request->id);
            if($obj){
                $obj->delete();
                return 'DONE';
            }
        }
        return '';
    }

    public function reorderSections(Request $request){
        if($request->arr) {
            $arr=json_decode($request->arr,true);
            if(json_last_error()==JSON_ERROR_NONE) {
                foreach ($arr as $index => $el) {
                    $obj = $this->fc->getCategoryClassname()::find($el);
                    $obj->place_id = $index;
                    $obj->save();
                }
                return 'DONE';
            }
        }
        return '';
    }

    public function reorderItems(Request $request){
        if($request->arr) {
            $arr=json_decode($request->arr,true);
            if(json_last_error()==JSON_ERROR_NONE) {
                foreach ($arr as $index => $el) {
                    $obj = $this->fc->getClassname()::find($el);
                    $obj->place_id = $index;
                    $obj->save();
                }
                return 'DONE';
            }
        }
        return '';
    }

    private function saveItemData($classname,$section,$obj,Request $request,$place_id){
        $category_field=strtolower(str_replace('App\\','',$classname)).'_category_id';
        $obj->$category_field=$request->section;
        $obj->title=$request->title;
        $obj->title_html=$request->title_html;
        $obj->url=$request->url;
        $obj->description=$request->description;
        $obj->transcription=$request->transcription;
        $obj->youtube_id=$request->youtube_id;
        $obj->sniply_url=$request->sniply_url;
        $obj->twitter=$request->twitter;
        $obj->visibility=$request->visibility;
        $obj->seo_title=$request->seo_title;
        $obj->seo_description=$request->seo_description;
        $obj->place_id=$place_id;
        $obj->save();
        $section->refresh();
        return view('fc-maintainer.section-table',compact('section'));
    }

    public function saveItem(Request $request){
        if($request->section) {
            $section = $this->fc->getCategoryClassname()::find($request->section);
            if($section){
                $classname=$this->fc->getClassname();
                $obj=new $classname();
                $place_id=$section->items->count();
                return $this->saveItemData($classname,$section,$obj,$request,$place_id);
            }
        }
        return '';
    }

    public function editItem(Request $request){
        if($request->section && $request->id) {
            $section = $this->fc->getCategoryClassname()::find($request->section);
            $classname=$this->fc->getClassname();
            $obj=$classname::find($request->id);
            if($section && $obj)
                return $this->saveItemData($classname,$section,$obj,$request,$obj->place_id);
        }
        return '';
    }

    public function deleteItem(Request $request){
        if($request->id) {
            $obj=$this->fc->getClassname()::find($request->id);
            if($obj){
                $section_id=$obj->category->id;
                $obj->delete();
                $section = $this->fc->getCategoryClassname()::find($section_id);
                return view('fc-maintainer.section-table',compact('section'));
            }
        }
        return '';
    }

    public function exportForSocialPilot(Request $request){
        $objs=$this->fc->getClassname()::orderBy('place_id','asc')->get();
        $data=[];
        $date=$request->first_day_campaign;
        $objs_count=$objs->count();
        for($k=0;$k<$request->number_recurrences;$k++){
            for($index=0;$index<$objs_count;$index++) {
                for ($i = 0; $i < $request->post_per_day; $i++) {
                    if($i) {
                        $index++;
                        if ($index == $objs_count) {
                            break;
                        }
                    }
                    $plus_minus = (rand(0, 1) ? 1 : -1);
                    $delta = $plus_minus * rand(0, $request->post_time_plus_minus_minute[$i]) * 60;
                    $datetime = date('Y-m-d H:i', strtotime($date . ' ' . $request->post_time_hour[$i] . ':' . $request->post_time_minute[$i].':00') + $delta);
/*                    if($request->youtube_url==1)
                        $sniply=sprintf('https://youtu.be/watch?v=%s',$objs[$index]->youtube_id).' '.sprintf('snip.ly/%s',$objs[$index]->sniply_url);
                    elseif($request->youtube_url==2)
                        $sniply=sprintf('snip.ly/%s',$objs[$index]->sniply_url).' '.sprintf('https://youtu.be/watch?v=%s',$objs[$index]->youtube_id);
                    else*/
                    $sniply=sprintf('snip.ly/%s',$objs[$index]->sniply_url);
                    $youtube_url='';
                    if($request->youtube_url==1 || $request->youtube_url==2)
                        $youtube_url=sprintf('https://youtu.be/%s',$objs[$index]->youtube_id);
//                    $message = sprintf('%s %s %s %s',$objs[$index]->title, $sniply,$objs[$index]->twitter, $request->hashtag);
//                    var_dump($youtube_url);
                    if($request->export_action=='twitter')
                        $message = sprintf('%s %s %s %s %s',$objs[$index]->twitter,$sniply,$objs[$index]->title,$youtube_url,$request->hashtag);
                    else
                        $message = sprintf('%s'.PHP_EOL.'%s'.PHP_EOL.'%s'.PHP_EOL.'%s',$objs[$index]->twitter,$youtube_url,$objs[$index]->title,$request->hashtag);
                    $data[] = [
//                        'message' => preg_replace('!\s+!', ' ', $message),
                        'message' => $message,
                        'imageURL'=>' ',
                        'datetime' => $datetime,
                        'fourth_column'=>($request->export_action=='twitter'?170531:170533)
                    ];

                }
                $date = date('Y-m-d', strtotime($date . ' + 1 day'));
            }
        }
        $this->downloadSocialPilot($data);
    }

    private function downloadSocialPilot($data){
//        var_dump($data);exit;
        $prefix=strtolower(str_replace('App\\','',$this->fc->getClassname()));
        header("Content-Type: text/csv");
        header("Content-Disposition: attachment; filename=$prefix.csv");
        header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1
        header("Pragma: no-cache"); // HTTP 1.0
        header("Expires: 0"); // Proxies
        $output = fopen("php://output", "w");
        foreach($data as $el)
            fputcsv($output, ['Message'=>$el['message'],'imageURL'=>$el['imageURL'],'datetime'=>$el['datetime'],'fourth_column'=>$el['fourth_column']]);
//        fputcsv($output, $data);
        exit;
    }


}