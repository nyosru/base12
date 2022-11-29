<?php

namespace App\Http\Controllers;

use App\classes\SniplyLinkCreator;
use Illuminate\Http\Request;

class SniplyLinkCreatorController extends Controller
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
    public function index(Request $request)
    {
        if($request->url) {
            $slc = new SniplyLinkCreator();
            return $slc->run($request->url);
        }
        return '';
    }
}
