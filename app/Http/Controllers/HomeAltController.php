<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TmfResourceLevelIndexItem;
use Auth;

class HomeAltController extends Controller
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
        $sections_data=$this->getSectionsData();
//        dd($sections_data);
        $sections=count($sections_data);
        return view('home-alt.index',compact('sections_data','sections'));
    }

    private function getSectionsData(){
        $items=TmfResourceLevelIndexItem::select('tmf_resource_level_index_item.*')
            ->where('tmf_resource_level_id',Auth::user()->Level)
            ->join('tmfportal_index_section','tmfportal_index_section.id','=','tmf_resource_level_index_item.tmfportal_index_section_id')
            ->orderBy('tmfportal_index_section.name','asc')
            ->get();
        $data=[];
        foreach ($items as $item){
            if(!isset($data[$item->tmfportal_index_section_id]))
                $data[$item->tmfportal_index_section_id]=[
                    'name'=>$item->tmfportalIndexSection->name,
                    'data'=>[]
                ];
            $data[$item->tmfportal_index_section_id]['data'][]=$item;
        }
        return $data;
    }
}
