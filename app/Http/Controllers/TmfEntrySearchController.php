<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TmfEntrySearchController extends Controller
{
    private const title='Search';

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request){
        return view('tmfentry.search.index',['title'=>self::title]);
    }

}
