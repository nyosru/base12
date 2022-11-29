<?php

namespace App\Http\Controllers;

use App\NewsAndScrewups;
use App\NewsAndScrewupsCategory;
use Carbon\Carbon;
use Illuminate\Http\Request;

class NsMaintainterController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $sections=NewsAndScrewupsCategory::orderBy('place_id','asc')->get();
        return view('ns-maintainer.index',[
            'title'=>'Screw-Up Maintainer',
            'sections'=>$sections,
            'left_nav_bar'=>view('ns-maintainer.left-nav-bar')->render()
        ]);
    }

    public function saveSection(Request $request){
        if($request->section) {
            $last_section = NewsAndScrewupsCategory::orderBy('place_id', 'desc')->first();
            $obj=new NewsAndScrewupsCategory();
            $obj->name=$request->section;
            $obj->place_id=$last_section->place_id+1;
            $obj->save();
            return 'DONE';
        }
        return '';
    }

    public function editSection(Request $request){
        if($request->section && $request->id) {
            $obj=NewsAndScrewupsCategory::find($request->id);
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
            $obj=NewsAndScrewupsCategory::find($request->id);
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
                    $obj = NewsAndScrewupsCategory::find($el);
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
                    $obj = NewsAndScrewups::find($el);
                    $obj->order_field = $index;
                    $obj->save();
                }
                return 'DONE';
            }
        }
        return '';
    }

    private function saveItemData($section,$obj,Request $request,$place_id){
        $category_field='news_and_screwups_category_id';
        $obj->$category_field=$request->section;
        $obj->headline=$request->headline;
        $obj->post_url=$request->url;
        $obj->youtube_url=$request->youtube_id;
        $obj->adlinks_url=$request->sniply_url;
        $obj->twitter=$request->twitter;
        $obj->visible_date=Carbon::now()->format('Y-m-d');
        $obj->visibility=$request->visibility;
        $obj->comment=$request->comment;
        $obj->long_url=$request->long_url;
        $obj->seo_title=$request->seo_title;
        $obj->seo_description=$request->seo_description;
        $obj->order_field=$place_id;
        $obj->save();
        $section->refresh();
        return view('ns-maintainer.section-table',compact('section'));
    }

    public function saveItem(Request $request){
        if($request->section) {
            $section = NewsAndScrewupsCategory::find($request->section);
            if($section){
                $obj=new NewsAndScrewups();
                $obj->created_at=Carbon::now()->format('Y-m-d H:i:s');
                $obj->commented_at='0000-00-00 00:00:00';
                $place_id=$section->items->count();
                return $this->saveItemData($section,$obj,$request,$place_id);
            }
        }
        return '';
    }

    public function editItem(Request $request){
        if($request->section && $request->id) {
            $section = NewsAndScrewupsCategory::find($request->section);
            $obj=NewsAndScrewups::find($request->id);
            if($section && $obj)
                return $this->saveItemData($section,$obj,$request,$obj->order_field);
        }
        return '';
    }

    public function deleteItem(Request $request){
        if($request->id) {
            $obj=NewsAndScrewups::find($request->id);
            if($obj){
                $section_id=$obj->newsAndScrewupsCategory->id;
                $obj->delete();
                $section = NewsAndScrewupsCategory::find($section_id);
                return view('ns-maintainer.section-table',compact('section'));
            }
        }
        return '';
    }

}
