<?php

namespace App\Http\Controllers;

class TmfFilingQueueController extends Controller
{
    public function index()
    {
        session(['queue-type-id' => 1]);
        return redirect()->route('queue');
    }
}
