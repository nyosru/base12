<?php

namespace App\Http\Controllers;

use App\MoneyMlcCategory;
use Illuminate\Http\Request;

class MoneyCategoriesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){

        $js_tree_data=[
            'text'=>'Categories Root',
            'id'=>0,
            'icon'=>false,
            'state'=>['opened'=>true,'disabled'=>false,'selected'=>false],
            'a_attr'=>['style'=>'border:1px solid black;padding:3px;margin-bottom:2px;background-color:#ddd'],
            'children'=>$this->generateTreeData(0)
        ];
//        $this->generateTreeData(0);

        return view('money.categories.index',compact('js_tree_data'));
    }

    private function generateTreeData($parent_id){
        $categories=MoneyMlcCategory::where('parent_id',$parent_id)->orderBy('id','asc')->get();
        $result=[];
        if($categories->count())
            foreach ($categories as $category){
                $edit_link=sprintf('<a class="edit-category-link ml-1" data-id="%d" data-category="%s" href="#"><i class="fas fa-pen-square"></i></a>',
                        $category->id,$category->category_name);
                $result[]=[
                    'text'=>$category->category_name.$edit_link,
                    'id'=>$category->id,
                    'icon'=>false,
                    'state'=>['opened'=>true,'disabled'=>false,'selected'=>false],
                    'a_attr'=>['style'=>'border:1px solid black;padding:2px;margin-bottom:5px;background-color:#ddd'],
                    'children'=>$this->generateTreeData($category->id)
                ];
            }
        return $result;
    }

    public function saveNewCategory(Request $request){
        $money_mlc_category=MoneyMlcCategory::find($request->id);
        $money_mlc_category->category_name=$request->category;
        $money_mlc_category->save();
        return 'Done';
    }

}
