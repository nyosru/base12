<?php

namespace App\Http\Controllers;

use App\classes\queue\ChangeStatus;
use App\classes\queue\QueueHoursCalculator;
use App\classes\queue\QueuePainter;
use App\classes\queue\QueueTmHistory;
use App\classes\ThankYouCardSentTextGetter;
use App\classes\tmoffer\CompanySubjectInfo;
use App\DashboardDeadline;
use App\DashboardOwner;
use App\DashboardTss;
use App\DashboardV2;
use App\TmfAftersearches;
use App\TmfCompany;
use App\TmfCompanySubject;
use App\TmfConditionTmfsalesTmoffer;
use App\TmfCountryTrademark;
use App\TmfRegQueueRootStatus;
use App\TmfRegQueueStatus;
use App\Tmfsales;
use App\TmfSubject;
use App\TmfTrademark;
use App\Tmoffer;
use App\TmofferBin;
use App\TmofferTmfCountryTrademark;
use App\traits\TmfXXXQueueCommon;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Telegram\Bot\Api;

class TmfRegQueueController extends Controller
{
//    use TmfXXXQueueCommon;

    public function index()
    {
        session(['queue-type-id' => 2]);
        return redirect()->route('queue');
    }
}
