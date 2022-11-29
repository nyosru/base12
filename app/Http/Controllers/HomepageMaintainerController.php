<?php

namespace App\Http\Controllers;

use App\HomepageCategory;
use App\HomepageCategoryAccessTmfsales;
use App\HomepageCategoryGroupAccess;
use App\HomepageItem;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomepageMaintainerController extends Controller
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

    private function isSuperAdmin(){
        return in_array(Auth::user()->ID,[1,53]);//Andrei or Vitaly
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $title='TMFPortal Maintainer';
        $user_superadmin=$this->isSuperAdmin();
        $homepage_categories=HomepageCategory::whereIn('id',
            HomepageCategoryAccessTmfsales::distinct()
                ->select('homepage_category_id')
                ->where('homepage_category_access_type_id',1)
                ->where('tmfsales_id',Auth::user()->ID)
        )
            ->orderBy('place_id','asc')
            ->get();

//        dd($homepage_categories);
        return view('homepagemaintainer.index',compact('title','user_superadmin','homepage_categories'));
    }

    public function addEditCategory(Request $request){
        if($request->id==0) {
            $hp_category = new HomepageCategory();
            $hp_category->created_at=Carbon::now()->format('Y-m-d H:i:s');
        }else
            $hp_category=HomepageCategory::find($request->id);

        $hp_category->name=$request->name;
        $hp_category->bg_color=$request->bg_color;
        $hp_category->view_access_all=$request->view_access_all;
        $hp_category->tmfsales_id=Auth::user()->ID;
        $hp_category->save();

        $view_access_arr=json_decode($request->view_access);
        if(json_last_error()==JSON_ERROR_NONE)
            $this->setAccessToCategory(2,$view_access_arr,$hp_category->id);

        $view_access_group_arr=json_decode($request->view_access_group);
        if(json_last_error()==JSON_ERROR_NONE)
            $this->setGroupAccessToCategory(2,$view_access_group_arr,$hp_category->id);

        $admin_access_arr=json_decode($request->admin_access);
        if(json_last_error()==JSON_ERROR_NONE)
            $this->setAccessToCategory(1,$admin_access_arr,$hp_category->id);

        return 'Done';
    }

    private function setAccessToCategory($homepage_category_access_type_id,$access_arr,$homepage_category_id){
        HomepageCategoryAccessTmfsales::where('homepage_category_id',$homepage_category_id)
            ->where('homepage_category_access_type_id',$homepage_category_access_type_id)
            ->delete();
        foreach ($access_arr as $tmfsales_id){
            $obj=new HomepageCategoryAccessTmfsales();
            $obj->homepage_category_id=$homepage_category_id;
            $obj->homepage_category_access_type_id=$homepage_category_access_type_id;
            $obj->tmfsales_id=$tmfsales_id;
            $obj->created_at=Carbon::now()->format('Y-m-d H:i:s');
            $obj->save();
        }
    }

    private function setGroupAccessToCategory($homepage_category_access_type_id,$access_arr,$homepage_category_id){
        HomepageCategoryGroupAccess::where('homepage_category_id',$homepage_category_id)
            ->where('homepage_category_access_type_id',$homepage_category_access_type_id)
            ->delete();
        foreach ($access_arr as $eos_member_id){
            $obj=new HomepageCategoryGroupAccess();
            $obj->homepage_category_id=$homepage_category_id;
            $obj->homepage_category_access_type_id=$homepage_category_access_type_id;
            $obj->eos_member_id=$eos_member_id;
            $obj->created_at=Carbon::now()->format('Y-m-d H:i:s');
            $obj->save();
        }
    }

    public function deleteCategory(Request $request){
        $hp_category=HomepageCategory::find($request->id);
        if($hp_category){
            $hp_category->delete();
            return 'Done';
        }
        return '';
    }

    public function deleteCategoryItem(Request $request){
        $hp_category_item=HomepageItem::find($request->id);
        if($hp_category_item){
            $hp_category=$hp_category_item->homepageCategory;
            $hp_category_item->delete();
            return view('homepagemaintainer.category-items-table',compact('hp_category'));
        }
        return '';
    }

    public function addEditCategoryItem(Request $request){
        if($request->id)
            $hp_item = HomepageItem::find($request->id);
        else{
            $hp_item=new HomepageItem();
            $hp_item->homepage_category_id=$request->category_id;
            $hp_item->place_id=HomepageItem::where('homepage_category_id',$request->category_id)->count()+1;
            $hp_item->created_at=Carbon::now()->format('Y-m-d H:i:s');
        }
        $hp_item->tmfsales_id=Auth::user()->ID;
        $hp_item->name=$request->name;
        $hp_item->url=$request->url;
        $hp_item->save();
        $hp_category=$hp_item->homepageCategory;
        return view('homepagemaintainer.category-items-table',compact('hp_category'));
    }

    public function reorderItems(Request $request){
        $ids=json_decode($request->arr,true);
        if(json_last_error()==JSON_ERROR_NONE){
            foreach ($ids as $index=>$item_id){
                $hp_item=HomepageItem::find($item_id);
                $hp_item->place_id=($index+1);
                $hp_item->save();
            }
        }
        return 0;
    }
    public function reorderCategories(Request $request){
        $ids=json_decode($request->arr,true);
        if(json_last_error()==JSON_ERROR_NONE){
            foreach ($ids as $index=>$hp_category_id){
                $hp_item=HomepageCategory::find($hp_category_id);
                $hp_item->place_id=($index+1);
                $hp_item->save();
            }
        }
        return 0;
    }
}
