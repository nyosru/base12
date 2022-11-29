<?php

namespace App\Http\Controllers;

use App\NotBoomReason;
use Carbon\Carbon;
use Illuminate\Http\Request;

class NoBoomReasonsMaintainerController extends Controller
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
        $result_table=$this->getResultTable();
        return view('noboom-reasons-maintainer.index',compact('result_table'));
    }

    private function getResultTable(){
        $not_boom_reasons=NotBoomReason::all();
        return view('noboom-reasons-maintainer.result-table',compact('not_boom_reasons'));
    }

    public function save(Request $request){
        if($request->id)
            $not_boom_reason=NotBoomReason::find($request->id);
        else {
            $not_boom_reason=new NotBoomReason();
            $not_boom_reason->created_at=(new Carbon())->format('Y-m-d H:i:s');
        }
        $not_boom_reason->reason=$request->noboom_reason;
        $not_boom_reason->email_template_name=$request->template_name;
        $not_boom_reason->email_template=$request->template;
        $not_boom_reason->save();
        return 'Done';
    }

}
