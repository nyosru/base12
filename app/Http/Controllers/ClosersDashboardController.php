<?php

namespace App\Http\Controllers;

use App\classes\dashboard\closers\EmptyCallReports;
use App\classes\dashboard\closers\LatestBooms;
use App\classes\dashboard\closers\UpcomingBookingCalls;
use App\Tmfsales;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClosersDashboardController extends Controller
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
        $tmfsales=Auth::user();
        if($tmfsales->Level!=6){
            $tmfsales=Tmfsales::find(79);//Bronson
        }
        return view('closers-dashboard.index',compact('tmfsales'));
    }

    public function getLatestBooms(Request $request){
        $latest_booms_obj=new LatestBooms(Tmfsales::find($request->tmfsales_id));
        return response()->json([
            'data'=>$latest_booms_obj->getData(),
            'count'=>$latest_booms_obj->getTotalBooms()
        ]);
    }

    public function getAllBooms(Request $request){
        $latest_booms_obj=new LatestBooms(Tmfsales::find($request->tmfsales_id));
        $data=$latest_booms_obj->getData(0);
        return view('closers-dashboard.all-booms',compact('data'));
    }

    public function getAllUpcomingBookings(Request $request){
        $data=(new UpcomingBookingCalls(Tmfsales::find($request->tmfsales_id)))->getData(0);
        return view('closers-dashboard.all-upcoming-bookings',compact('data'));
    }

    public function getUpcomingBookings(Request $request){
        $data=(new UpcomingBookingCalls(Tmfsales::find($request->tmfsales_id)))->getData();
        return response()->json($data);
    }
    public function getEmptyCallReports(Request $request){
        $data=(new EmptyCallReports(Tmfsales::find($request->tmfsales_id)))->getData();
        return response()->json($data);
    }


}
