<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\TmfportalIndexSection;
use App\TmfResourceLevel;
use App\TmfResourceLevelIndexItem;
use App\Tmfsales;
use Illuminate\Support\Facades\Auth;


class IndexMaintainerController extends Controller
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
        $tmf_resource_levels=TmfResourceLevel::orderBy('id','desc')->get();
        $result_table=$this->getResultTable(Auth::user()->Level);
        $tmfportal_index_sections=TmfportalIndexSection::orderBy('name')->get();
        return view('index-maintainer.index',
            compact(
                'tmf_resource_levels',
                'result_table',
                'tmfportal_index_sections'
            )
        );
    }

    private function getResultTable($tmf_resource_level_id,$render=0){
        $items=TmfResourceLevelIndexItem::select('tmf_resource_level_index_item.*')
            ->where('tmf_resource_level_id',$tmf_resource_level_id)
            ->join('tmfportal_index_section','tmfportal_index_section.id','=','tmf_resource_level_index_item.tmfportal_index_section_id')
            ->orderBy('tmfportal_index_section.name','asc')
            ->get();
        $data=[];
        foreach ($items as $item){
//            dd($item->toArray());
            if(!isset($data[$item->tmfportal_index_section_id]))
                $data[$item->tmfportal_index_section_id]=[
                    'name'=>$item->tmfportalIndexSection->name,
                    'data'=>[]
                ];
            $data[$item->tmfportal_index_section_id]['data'][]=$item;
        }
//        dd($data);
        if($render)
            return view('index-maintainer.result-table',compact('data'))->render();
        else
            return view('index-maintainer.result-table',compact('data'));
    }

    public function save(Request $request)
    {
        if($request->section && $request->link && $request->link_name && $request->level){
            if(Auth::user()->Level!=9 && $request->level!=Auth::user()->Level)
                return '';

            $obj=new TmfResourceLevelIndexItem();
            $obj->name=$request->link_name;
            $obj->url=$request->link;
            $obj->tmf_resource_level_id=$request->level;
            $section_id=$this->getTmfportalIndexSection($request->section);
            $obj->tmfportal_index_section_id=$section_id;
            $obj->save();
            $response=[
                'result_table'=>$this->getResultTable($request->level,1),
                'portal_sections'=>$this->getPortalSectionOptions()
            ];
//            return print_r(json_encode($response),true);
            return response()->json($response);
        }
        return response()->json([]);
    }

    private function getPortalSectionOptions(){
        $tmfportal_index_sections=TmfportalIndexSection::orderBy('name')->get();
        return view('index-maintainer.portal-section-options',compact('tmfportal_index_sections'))->render();
    }

    private function getTmfportalIndexSection($tmfportal_index_section_id){
        if(is_numeric($tmfportal_index_section_id))
                return $tmfportal_index_section_id;
        else{
            $obj=TmfportalIndexSection::where('name','tmfportal_index_section_id')->first();
            if(!$obj){
                $obj=new TmfportalIndexSection();
                $obj->name=$tmfportal_index_section_id;
                $obj->save();
            }
            return $obj->id;
        }
    }

    public function edit(Request $request,$id)
    {
        $obj=TmfResourceLevelIndexItem::find($id);
        if($obj){
            $obj->name=$request->link_name;
            $obj->url=$request->link;
            $section_id=$this->getTmfportalIndexSection($request->section);
            $obj->tmfportal_index_section_id=$section_id;
            $obj->save();
            $response=[
                'result_table'=>$this->getResultTable($request->level,1),
                'portal_sections'=>$this->getPortalSectionOptions()
            ];
            return response()->json($response);
        }
        return response()->json([]);
    }

    public function delete(Request $request,$id)
    {
        $obj=TmfResourceLevelIndexItem::find($id);
        if($obj){
            $level=$obj->tmf_resource_level_id;
            $obj->delete();
            return $this->getResultTable($level);
        }
        return '';
    }
}
