<?php

namespace App\Http\Controllers;

use App\HomepageCategory;
use App\HomepageCategoryAccessTmfsales;
use App\HomepageCategoryGroupAccess;
use App\TmfsalesEosMember;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TmfPortalController extends Controller
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
/*        $hp_categories = HomepageCategory::whereIn('id',
            HomepageCategoryAccessTmfsales::distinct()
                ->select('homepage_category_id')
                ->where('homepage_category_access_type_id', 2)
                ->where('tmfsales_id', Auth::user()->ID)
        )

            ->get();*/
        $hp_categories=HomepageCategory::where('view_access_all',1)->orderBy('place_id','asc')->get();
        $hp_categories = $hp_categories->merge(
            HomepageCategory::where('place_id','>',0)
                ->whereIn('id',
                HomepageCategoryGroupAccess::distinct()
                    ->select('homepage_category_id')
                    ->where('homepage_category_access_type_id', 2)
                    ->whereIn('eos_member_id',
                        TmfsalesEosMember::select('eos_member_id')->where('tmfsales_id',Auth::user()->ID)
                    )
                )
                ->orderBy('place_id','asc')
                ->get()
        );
        $hp_categories = $hp_categories->merge(HomepageCategory::where('place_id','>','0')
            ->whereIn('id',
                HomepageCategoryAccessTmfsales::distinct()
                    ->select('homepage_category_id')
                    ->where('homepage_category_access_type_id', 2)
                    ->where('tmfsales_id', Auth::user()->ID))
            ->orderBy('place_id','asc')
            ->get());
        $hp_categories=$hp_categories->merge(HomepageCategory::where('place_id',0)
            ->whereIn('id',
                HomepageCategoryAccessTmfsales::distinct()
                    ->select('homepage_category_id')
                    ->where('homepage_category_access_type_id', 2)
                    ->where('tmfsales_id', Auth::user()->ID))
            ->orderBy('id','asc')
            ->get());
        $columns=['',''];
        foreach ($hp_categories as $index=>$hp_category){
            $columns[$index%2].=view('tmfportal.card-column',compact('hp_category'))->render();
        }
        return view('tmfportal.index', compact('hp_categories','columns'));
    }

    public function addEditCategory(Request $request)
    {
        if ($request->id == 0) {
            $hp_category = new HomepageCategory();
            $hp_category->created_at = Carbon::now()->format('Y-m-d H:i:s');
        } else
            $hp_category = HomepageCategory::find($request->id);

        $hp_category->name = $request->name;
        $hp_category->tmfsales_id = Auth::user()->ID;
        $hp_category->save();

        $this->setAccessToCategory(2, Auth::user()->ID, $hp_category->id);
        return 'Done';
    }

    private function setAccessToCategory($homepage_category_access_type_id, $tmfsales_id, $homepage_category_id)
    {
        HomepageCategoryAccessTmfsales::where('homepage_category_id', $homepage_category_id)
            ->where('homepage_category_access_type_id', $homepage_category_access_type_id)
            ->delete();
        $obj = new HomepageCategoryAccessTmfsales();
        $obj->homepage_category_id = $homepage_category_id;
        $obj->homepage_category_access_type_id = $homepage_category_access_type_id;
        $obj->tmfsales_id = $tmfsales_id;
        $obj->created_at = Carbon::now()->format('Y-m-d H:i:s');
        $obj->save();
    }

}
