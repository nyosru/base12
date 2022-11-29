<?php

namespace App\Http\Controllers;

use App\classes\dashboard\TssCreator;
use App\classes\queue\ReviewRequester;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QueueApiController extends Controller
{

    /**
     * Set mark as requested for review
     *
     * @param Request $request
     * @return int
     */
    public function requestReview(Request $request)
    {
        $obj = new ReviewRequester(
            Auth::user()->ID,
            $request->queue_status_id,
            $request->dashboard_id
        );
        $obj->run($request->message, $request->notification);
        return 1;
    }

    /**
     * Set new queue status to mark with custom tss_text
     *
     * @param Request $request
     * @return int
     */
    public function newStatus(Request $request)
    {
        $obj = new TssCreator(Auth::user()->ID,$request->dashboard_id);
        return $obj->runWithQueueStatusId($request->queue_status_id,$request->tss_text)->id;
    }

}
