<?php

namespace App\Modules\Affiliate\Http\Controllers;


use App\Http\Controllers\Controller;
use App\Modules\Affiliate\Actions\CreateRegApplication;
use App\Modules\Affiliate\Actions\GetRegApplicationsList;
use App\Modules\Affiliate\Actions\UpdateRegApplicationStatus;
use App\Modules\Affiliate\Http\Requests\CreateRegApplicationRequest;
use App\Modules\Affiliate\Http\Requests\GetRegApplicationsListRequest;
use App\Modules\Affiliate\Http\Requests\UpdateRegApplicationStatusRequest;
use App\Modules\Affiliate\Models\RegApplication;
use Illuminate\Support\Facades\Log;

class RegApplicationController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showSendApplicationPage()
    {
        return view('affiliate::reg_application.page_send_application');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showReviewApplicationsPage()
    {
        return view('affiliate::reg_application.page_review_applications');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showRegistrationSuccessPage()
    {
        return view('affiliate::reg_application.page_registration_success');
    }

    /**
     * @param GetRegApplicationsListRequest $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function index(GetRegApplicationsListRequest $request)
    {
        $fields = $request->get('fields', []);
        $filters = $request->except('fields', 'page', 'per_page', 'sort');
        $sort = $request->get('sort', []);
        $per_page = $request->get('per_page', 10);

        try {
            $action = new GetRegApplicationsList($fields, $filters, $sort, $per_page);
            $applications = $action->run();
            return response($applications);
        } catch (\Throwable $e) {
            Log::error($e);
            return response('', 500);
        }
    }

    /**
     * @param CreateRegApplicationRequest $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function create(CreateRegApplicationRequest $request)
    {
        try {
            $data = $request->all();
            $create_application = new CreateRegApplication($data);
            $create_application->run();

            return redirect('/affiliate/page-registration-success');
        } catch (\Throwable $e) {
            Log::error($e);
        }
    }

    /**
     * @param UpdateRegApplicationStatusRequest $request
     * @param RegApplication $regApplication
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function updateStatus(UpdateRegApplicationStatusRequest $request, RegApplication $regApplication)
    {
        try {
            $status = $request->get('status');
            $update_application_status = new UpdateRegApplicationStatus($regApplication, $status);
            $update_application_status->run();

            return response('');
        } catch (\Throwable $e) {
            Log::error($e);
            return response('', 500);
        }
    }
}
