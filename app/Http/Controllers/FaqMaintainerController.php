<?php

namespace App\Http\Controllers;

use App\classes\FaqCartoon;
use App\FaqCategory;
use Illuminate\Http\Request;

use App\TmfportalIndexSection;
use App\TmfResourceLevel;
use App\TmfResourceLevelIndexItem;
use App\Tmfsales;
use App\traits\FaqCartoonTrait;
use Illuminate\Support\Facades\Auth;


class FaqMaintainerController extends Controller
{
    private $fc;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->fc=new FaqCartoon('Faq');
    }

    use FaqCartoonTrait;

}
