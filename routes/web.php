<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UloginController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     // return view('welcome');
//     return redirect('/index/');
// });


// Auth::routes([
//     'register'=>false,
//     'password.request'=>false,
//     'reset'=>false
//     ]);

// Route::group([
//     'middleware' => 'auth.basic.once',
// ], function () {

//     Route::post('/queue-request-review/{queue_status_id}/{dashboard_id}', 'QueueApiController@requestReview');
//     Route::post('/queue-new-status/{queue_status_id}/{dashboard_id}', 'QueueApiController@newStatus');

// });

// Route::get('/test', 'TestController@index');

// Route::get('/home', 'HomeController@index')->name('home');
// Route::get('/home-alt', 'HomeAltController@index')->name('home');


// Route::get('/dashboard', 'HomeController@index')->name('home');



// Route::get('/test/{path?}', 'TestController@checkUrl')->name('test');
// Route::get('/email-campaign', 'EmailCampaignController@index');
// Route::get('/brand-checkup', 'EmailCampaignController@brandCheckUp');

// Route::get('/youtube-clicks-report', 'YoutubeClicksReportController@index')->name('Youtube Clicks Report');

// Route::post('/youtube-clicks-show-report', 'YoutubeClicksReportController@showReport');

// Route::get('/ask-stat', 'AskStat@index')->name('Ask Stat');

// Route::post('/ask-stat', 'AskStat@rebuildTree');

// Route::get('/7rf-stats', 'SevenRedFlagStatsController@index')->name('7RF Stats');

// Route::get('/7rf-stats/{from_date}/{to_date}', 'SevenRedFlagStatsController@index');

// Route::post('/7rf-stats', 'SevenRedFlagStatsController@rebuildResult');

// Route::get('/index-maintainer', 'IndexMaintainerController@index');

// Route::post('/index-maintainer/save', 'IndexMaintainerController@save');
// Route::post('/index-maintainer/edit/{id}', 'IndexMaintainerController@edit');
// Route::post('/index-maintainer/delete/{id}', 'IndexMaintainerController@delete');

// Route::get('/bni-results', 'BniAmericaResultsController@index');

// Route::get('/welcome-asks-stat', 'WelcomeAskStatController@index');
// Route::post('/welcome-asks-stat', 'WelcomeAskStatController@reloadResults');

// Route::get('/block-tmf-ip', 'BlockTmfIpController@index');

// Route::get('/outreach-email-1', 'OutreachEmail1Controller@index');
// Route::post('/outreach-email-1', 'OutreachEmail1Controller@sendEmail');


// Route::get('/closers-recordings-uploader', 'ClosersRecordingsUploaderController@index');
// Route::post('/closers-recordings-uploader', 'ClosersRecordingsUploaderController@uploadCall');
// Route::post('/closers-recordings-uploader/remove-call', 'ClosersRecordingsUploaderController@removeCall');
// Route::get('/closers-recordings-uploader/{id}', 'ClosersRecordingsUploaderController@showTmofferRecordings');

// Route::get('/calendar-test', 'CalendarTestController@index');

// Route::get('/payments-calendar', 'PaymentsCalendarController@index');
// Route::post('/payments-calendar/invoice-paid-unpaid', 'PaymentsCalendarController@setTmofferInvoicePaidUnpaid');
// Route::post('/payments-calendar/invoice-block-unblock', 'PaymentsCalendarController@setTmofferInvoiceBlockUnblock');
// Route::post('/payments-calendar/expedited-payment-email', 'PaymentsCalendarController@getExpeditedPaymentEmail');
// Route::post('/payments-calendar/failed-payment-email', 'PaymentsCalendarController@getFailedPaymentEmail');
// Route::post('/payments-calendar/send-email', 'PaymentsCalendarController@sendEmail');
// Route::post('/payments-calendar/scheduled-email', 'PaymentsCalendarController@getScheduledEmail');
// Route::post('/payments-calendar/schedule-email', 'PaymentsCalendarController@scheduleEmail');
// Route::post('/payments-calendar/save-invoice-notes', 'PaymentsCalendarController@saveInvoiceNotes');
// Route::post('/payments-calendar/receipt-email', 'PaymentsCalendarController@getReceiptEmail');
// //Route::post('/payments-calendar/load-month-data', 'PaymentsCalendarController@loadMonthData');
// Route::get('/payments-calendar/load-month-data', 'PaymentsCalendarController@loadMonthData');

// Route::get('/faq-maintainer', 'FaqMaintainerController@index');
// Route::post('/faq-maintainer/save-section', 'FaqMaintainerController@saveSection');
// Route::post('/faq-maintainer/edit-section/{id}', 'FaqMaintainerController@editSection');
// Route::post('/faq-maintainer/delete-section/{id}', 'FaqMaintainerController@deleteSection');
// Route::post('/faq-maintainer/reorder-sections', 'FaqMaintainerController@reorderSections');
// Route::post('/faq-maintainer/reorder-items', 'FaqMaintainerController@reorderItems');
// Route::post('/faq-maintainer/save-item', 'FaqMaintainerController@saveItem');
// Route::post('/faq-maintainer/edit-item/{id}', 'FaqMaintainerController@editItem');
// Route::post('/faq-maintainer/delete-item/{id}', 'FaqMaintainerController@deleteItem');
// Route::post('/faq-maintainer/export-for-social-pilot', 'FaqMaintainerController@exportForSocialPilot');

// Route::get('/sniply-link-creator', 'SniplyLinkCreatorController@index');

// Route::get('/cartoon-maintainer', 'CartoonMaintainerController@index');
// Route::post('/cartoon-maintainer/save-section', 'CartoonMaintainerController@saveSection');
// Route::post('/cartoon-maintainer/edit-section/{id}', 'CartoonMaintainerController@editSection');
// Route::post('/cartoon-maintainer/delete-section/{id}', 'CartoonMaintainerController@deleteSection');
// Route::post('/cartoon-maintainer/reorder-sections', 'CartoonMaintainerController@reorderSections');
// Route::post('/cartoon-maintainer/reorder-items', 'CartoonMaintainerController@reorderItems');
// Route::post('/cartoon-maintainer/save-item', 'CartoonMaintainerController@saveItem');
// Route::post('/cartoon-maintainer/edit-item/{id}', 'CartoonMaintainerController@editItem');
// Route::post('/cartoon-maintainer/delete-item/{id}', 'CartoonMaintainerController@deleteItem');
// Route::post('/cartoon-maintainer/export-for-social-pilot', 'CartoonMaintainerController@exportForSocialPilot');

// Route::get('/ns-maintainer', 'NsMaintainterController@index');
// Route::post('/ns-maintainer/save-section', 'NsMaintainterController@saveSection');
// Route::post('/ns-maintainer/edit-section/{id}', 'NsMaintainterController@editSection');
// Route::post('/ns-maintainer/delete-section/{id}', 'NsMaintainterController@deleteSection');
// Route::post('/ns-maintainer/reorder-sections', 'NsMaintainterController@reorderSections');
// Route::post('/ns-maintainer/reorder-items', 'NsMaintainterController@reorderItems');
// Route::post('/ns-maintainer/save-item', 'NsMaintainterController@saveItem');
// Route::post('/ns-maintainer/edit-item/{id}', 'NsMaintainterController@editItem');
// Route::post('/ns-maintainer/delete-item/{id}', 'NsMaintainterController@deleteItem');


// Route::get('/first-pages-stat', 'FirstPageStatController@index');
// Route::post('/first-pages-stat', 'FirstPageStatController@showStat');

// Route::get('/tmf-client-satisfaction-stat', 'TmfClientSatisfactionStatController@index');
// Route::post('/tmf-client-satisfaction-stat', 'TmfClientSatisfactionStatController@showStat');

// Route::get('/tmf-revenue-breakdown', 'TmfRevenueBreakdownController@index');
// Route::post('/tmf-revenue-breakdown/save-rr-types', 'TmfRevenueBreakdownController@saveRrTypes');
// Route::post('/tmf-revenue-breakdown', 'TmfRevenueBreakdownController@showData');

// Route::get('/ops-snapshot', 'OpsSnapshotController@index');
// Route::post('/ops-snapshot/reload-table', 'OpsSnapshotController@reloadTable');
// Route::post('/ops-snapshot/loading-details', 'OpsSnapshotController@loadingDetails');
// Route::post('/ops-snapshot/update-dashboard-in-timings-type', 'OpsSnapshotController@updateDashboardInTimingsType');

// Route::get('/ops-period', 'OpsPeriodController@index');
// Route::post('/ops-period/loading-details', 'OpsPeriodController@loadingDetails');
// Route::post('/ops-period/reload-table', 'OpsPeriodController@reloadTable');


// Route::get('/client-cabinet-initializer','ClientCabinetInitializer@index');

// Route::get('/bookings-calendar','BookingsCalendarController@index');
// Route::get('/bookings-calendar/load-month-data', 'BookingsCalendarController@loadMonthData');
// Route::get('bookings-calendar/enter-boom-reason/{tmoffer_login}', 'BookingsCalendarController@enterBoomReason');
// Route::get('bookings-calendar/call-report/{tmoffer_login}', 'BookingsCalendarController@enterBoomReason');
// Route::post('/bookings-calendar/load-noboom-reason', 'BookingsCalendarController@loadNoboomReasonData');
// Route::post('/bookings-calendar/save-noboom-reason', 'BookingsCalendarController@saveNoboomReasonData');
// Route::post('/bookings-calendar/change-closer', 'BookingsCalendarController@changeCloser');
// Route::post('/bookings-calendar/remove-booking', 'BookingsCalendarController@removeBooking');
// Route::post('/bookings-calendar/load-notes', 'BookingsCalendarController@loadNotes');
// Route::post('/bookings-calendar/save-notes', 'BookingsCalendarController@saveNotes');
// Route::post('/bookings-calendar/upload-recordings', 'BookingsCalendarController@uploadRecordings');
// Route::get('/closeable-reminder/{tmoffer_login}/{delta_days_reminder}', 'BookingsCalendarController@setCloseableNextReminder');
// Route::post('/bookings-calendar/load-boom-reason', 'BookingsCalendarController@loadBoomReason');
// Route::post('/bookings-calendar/save-boom-reason', 'BookingsCalendarController@saveBoomReason');
// Route::post('/bookings-calendar/cancel-gc-booking', 'BookingsCalendarController@cancelGcBooking');
// Route::post('/bookings-calendar/cancel-oesou-booking', 'BookingsCalendarController@cancelOeSouBooking');
// Route::post('/bookings-calendar/resend-gc-zoom-link-email', 'BookingsCalendarController@resendGcZoomLinkEmail');
// Route::post('/bookings-calendar/resend-oe-sou-zoom-link-email', 'BookingsCalendarController@resendOeSouZoomLinkEmail');
// Route::post('/bookings-calendar/load-report-call-body', 'BookingsCalendarController@loadReportCallBody');
// Route::post('/bookings-calendar/save-boom-report', 'BookingsCalendarController@saveBoomReport');
// Route::post('/bookings-calendar/load-post-report-email', 'BookingsCalendarController@loadPostReportEmail');
// Route::post('/bookings-calendar/send-post-report-email', 'BookingsCalendarController@sendPostReportEmail');
// Route::post('/bookings-calendar/load-booking-info', 'BookingsCalendarController@loadBookingInfo');
// Route::post('/bookings-calendar/load-stat', 'BookingsCalendarController@loadStat');
// Route::post('/bookings-calendar/load-emails', 'BookingsCalendarController@loadEmails');
// Route::get('/bookings-calendar/load-emails/{tmoffer_login}', 'BookingsCalendarController@loadEmailsForTmoffer');
// Route::get('/bookings-calendar/pq-answers/{tmoffer_login}', 'BookingsCalendarController@loadPqAnswersForTmoffer');
// Route::post('/bookings-calendar/load-pq-answers', 'BookingsCalendarController@pqAnswersForTmoffer');
// Route::post('/bookings-calendar/confirm-booking-link', 'BookingsCalendarController@confirmBookingLink');
// Route::post('/bookings-calendar/export-to-csv', 'BookingsCalendarController@exportToCsv');

// Route::get('/bookings-search', 'BookingsSearcherController@index');
// Route::post('/bookings-search', 'BookingsSearcherController@find');


// Route::get('/ops-trends','OpsTrendsController@index');
// Route::post('/ops-trends/reload-charts','OpsTrendsController@reloadCharts');
// Route::post('/ops-trends/load-chart-details','OpsTrendsController@loadChartDetails');

// Route::get('/noboom-reasons-maintainter','NoBoomReasonsMaintainerController@index');
// Route::post('/noboom-reasons-maintainter/save','NoBoomReasonsMaintainerController@save');

// Route::get('/tmf-clients-by-countries','TmfClientsByCountriesController@index');
// Route::post('/tmf-clients-by-countries','TmfClientsByCountriesController@showData');

// Route::get('/flowchart-email-previewer/{tmoffer_id}/{last_action_id}', 'FlowchartEmailPreviewerController@showEmail');

// Route::get('/shopping-cart-finder', 'ShoppingCartFinderController@index');
// Route::post('/shopping-cart-finder', 'ShoppingCartFinderController@find');

// Route::get('/closers-dashboard','ClosersDashboardController@index');
// Route::post('/closers-dashboard/latest-booms','ClosersDashboardController@getLatestBooms');
// Route::post('/closers-dashboard/all-booms','ClosersDashboardController@getAllBooms');
// Route::post('/closers-dashboard/upcoming-bookings','ClosersDashboardController@getUpcomingBookings');
// Route::post('/closers-dashboard/all-upcoming-bookings','ClosersDashboardController@getAllUpcomingBookings');
// Route::post('/closers-dashboard/empty-call-reports','ClosersDashboardController@getEmptyCallReports');

// Route::get('/booking-applications-2w','BookingApplications2WController@index');
// Route::get('/booking-applications-2w/reload-table','BookingApplications2WController@reloadTable');
// Route::get('/booking-applications-2w/{id}','BookingApplications2WController@showRequest');

// Route::get('/booking-applications','BookingApplicationsController@index');
// Route::get('/booking-applications/{id}','BookingApplicationsController@showRequest');
// Route::post('/booking-applications','BookingApplicationsController@loadClientAnswers');
// Route::post('/booking-applications/approve-for-booking','BookingApplicationsController@approveForBookingData');
// Route::post('/booking-applications/follow-up-email','BookingApplicationsController@followUpEmailData');
// Route::post('/booking-applications/send-email','BookingApplicationsController@sendEmail');
// Route::post('/booking-applications/show-request-info','BookingApplicationsController@showRequestInfo');
// Route::post('/booking-applications/show-email-details','BookingApplicationsController@showEmailDetails');
// Route::post('/booking-applications/call-report','BookingApplicationsController@callReportSave');
// Route::post('/booking-applications/sdr-status','BookingApplicationsController@sdrStatus');
// Route::get('/booking-applications/reload-table','BookingApplicationsController@reloadTable');

// Route::get('/tmfportal-maintainer', 'HomepageMaintainerController@index');
// Route::post('/tmfportal-maintainer/add-edit-category', 'HomepageMaintainerController@addEditCategory');
// Route::post('/tmfportal-maintainer/delete-category', 'HomepageMaintainerController@deleteCategory');
// Route::post('/tmfportal-maintainer/add-edit-category-item', 'HomepageMaintainerController@addEditCategoryItem');
// Route::post('/tmfportal-maintainer/reorder-items', 'HomepageMaintainerController@reorderItems');
// Route::post('/tmfportal-maintainer/reorder-categories', 'HomepageMaintainerController@reorderCategories');
// Route::post('/tmfportal-maintainer/delete-category-item', 'HomepageMaintainerController@deleteCategoryItem');

// Route::get('/tmfportal', 'TmfPortalController@index');
// Route::post('/tmfportal/add-edit-category', 'TmfPortalController@addEditCategory');

// Route::get('/sms-sender/load-message/{id}', 'SmsSenderController@loadMessage');
// Route::post('/sms-sender/send', 'SmsSenderController@send');

// Route::get('/searcher-stat','SearcherStatController@index');

// Route::get('/sdr-call-reminders','SdrCallRemindersController@index');
// Route::post('/sdr-call-reminders/new-status','SdrCallRemindersController@newStatus');
// Route::get('/sdr-call-reminders/get-current-progress','SdrCallRemindersController@getCurrentProgress');
// Route::get('/sdr-call-reminders/get-calls-history','SdrCallRemindersController@getCallsHistory');

// //Route::get('/tm-filing-queue','TmFilingQueueController@index');
// //Route::post('/tm-filing-queue/load-dashboard-notes','TmFilingQueueController@loadDashboardNotes');
// //Route::post('/tm-filing-queue/save-dashboard-notes','TmFilingQueueController@saveDashboardNotes');

// Route::get('/pq-applications','PqApplicationsController@index');
// Route::get('/pq-applications/hot-items','PqApplicationsController@loadHotItems');
// Route::get('/pq-applications/boom-opportunities-items','PqApplicationsController@loadBoomOpportunitiesItems');
// Route::get('/pq-applications/unclaimed-items','PqApplicationsController@loadUnclaimedItems');
// Route::get('/pq-applications/inprogress-items','PqApplicationsController@loadInprogressItems');
// Route::post('/pq-applications/finished-items','PqApplicationsController@loadFinishedItems');
// Route::get('/pq-applications/client-info/{id}','PqApplicationsController@loadClientInfo');
// Route::get('/pq-applications/request-details/{id}','PqApplicationsController@loadRequestDetails');
// Route::get('/pq-applications/prospect-answers/{id}','PqApplicationsController@loadProspectAnswers');
// Route::get('/pq-applications/load-emails/{id}','PqApplicationsController@loadEmails');
// Route::get('/pq-applications/load-notes/{id}','PqApplicationsController@loadNotes');
// Route::get('/pq-applications/load-status-data/{id}','PqApplicationsController@loadStatusData');
// Route::get('/pq-applications/check-application-status/{id}','PqApplicationsController@checkApplicationStatus');
// Route::get('/pq-applications/load-current-status/{id}','PqApplicationsController@loadCurrentStatus');
// Route::get('/pq-applications/load-boom-status/{id}','PqApplicationsController@loadBoomStatus');
// Route::post('/pq-applications/save-notes/{id}','PqApplicationsController@saveNotes');
// Route::post('/pq-applications/paint-legend-points','PqApplicationsController@paintLegendPoints');
// Route::post('/pq-applications/search-finished-by-name','PqApplicationsController@searchFinishedByName');
// Route::post('/pq-application/set-current-user','PqApplicationsController@setCurrentUser');
// Route::post('/pq-applications/approved-and-booked','PqApplicationsController@approvedAndBookedEmail');
// Route::post('/pq-applications/set-lead-status','PqApplicationsController@setLeadStatus');
// Route::post('/pq-applications/save-tmf-subject-attr','PqApplicationsController@saveTmfSubjectAttr');


// Route::get('/pq-stats','PqStatsController@index');
// Route::post('/pq-stats/load-stats','PqStatsController@loadStats');
// Route::post('/pq-stats/load-details','PqStatsController@loadDetails');

// Route::get('/pq-finder','PqFinderController@index');
// Route::post('/pq-finder/search','PqFinderController@search');
// Route::get('/pq-finder/load-details/{id}','PqFinderController@loadDetails');

// Route::redirect('/tmf-reg-queue', '/tmrq', 301);
// Route::get('/tmrq','TmfRegQueueController@index');
// //Route::get('/tmrq/load-sub-status-tms/{id}','TmfRegQueueController@loadSubStatusTms');
// //Route::post('/tmrq/load-sub-status-tms/{id}','TmfRegQueueController@loadSubStatusTms');
// //Route::get('/tmrq/sub-status-numbers/{id}','TmfRegQueueController@loadSubStatusNumbers');
// //Route::post('/tmrq/sub-status-numbers/{id}','TmfRegQueueController@loadSubStatusNumbers');
// //Route::post('/tmrq/reload-sub-statuses/{id}','TmfRegQueueController@reloadSubStatuses');
// //Route::post('/tmrq/load-dashboard-notes','TmfRegQueueController@loadDashboardNotes');
// //Route::post('/tmrq/save-dashboard-notes','TmfRegQueueController@saveDashboardNotes');
// //Route::post('/tmrq/apply-new-status','TmfRegQueueController@applyNewStatus');
// //Route::post('/tmrq/search','TmfRegQueueController@search');
// //Route::post('/tmrq/claim','TmfRegQueueController@claim');
// //Route::post('/tmrq/request-review','TmfRegQueueController@requestReview');
// //Route::post('/tmrq/unclaim','TmfRegQueueController@manualUnclaim');
// //Route::post('/tmrq/load-history','TmfRegQueueController@loadHistory');
// //Route::get('/tmrq/claimed-by-me-setting/{flag}','TmfRegQueueController@setClaimedByMeSetting');

// //Route::redirect('/tmf-reg-queue-status-maintainer', '/tmrq-maintainer', 301);
// //Route::get('/tmrq-maintainer','TmfRegQueueStatusMaintainerController@index');
// //Route::get('/tmrq-maintainer/load-root-statuses','TmfRegQueueStatusMaintainerController@loadRootStatuses');
// //Route::get('/tmrq-maintainer/load-root-status-options','TmfRegQueueStatusMaintainerController@loadRootStatusOptions');
// //Route::get('/tmrq-maintainer/remove-root-status/{id}','TmfRegQueueStatusMaintainerController@removeRootStatus');
// //Route::get('/tmrq-maintainer/remove-sub-status/{id}','TmfRegQueueStatusMaintainerController@removeSubStatus');
// //Route::get('/tmrq-maintainer/load-sub-statuses/{id}','TmfRegQueueStatusMaintainerController@loadSubStatuses');
// //Route::post('/tmrq-maintainer/save-status','TmfRegQueueStatusMaintainerController@saveStatus');
// //Route::post('/tmrq-maintainer/save-sub-status','TmfRegQueueStatusMaintainerController@saveStatus');
// //Route::post('/tmrq-maintainer/reorder-root-statuses','TmfRegQueueStatusMaintainerController@reorderRootStatuses');
// //Route::post('/tmrq-maintainer/reorder-sub-statuses','TmfRegQueueStatusMaintainerController@reorderSubStatuses');
// //Route::post('/tmrq-maintainer/dashboard-tss-options','TmfRegQueueStatusMaintainerController@dashboardTssOptions');

// //Route::redirect('/tmf-filing-queue-status-maintainer', '/tmfq-maintainer', 301);
// //Route::get('/tmfq-maintainer','TmfFilingQueueStatusMaintainerController@index');
// //Route::get('/tmfq-maintainer/load-root-statuses','TmfFilingQueueStatusMaintainerController@loadRootStatuses');
// //Route::get('/tmfq-maintainer/load-root-status-options','TmfFilingQueueStatusMaintainerController@loadRootStatusOptions');
// //Route::get('/tmfq-maintainer/remove-root-status/{id}','TmfFilingQueueStatusMaintainerController@removeRootStatus');
// //Route::get('/tmfq-maintainer/remove-sub-status/{id}','TmfFilingQueueStatusMaintainerController@removeSubStatus');
// //Route::get('/tmfq-maintainer/load-sub-statuses/{id}','TmfFilingQueueStatusMaintainerController@loadSubStatuses');
// //Route::post('/tmfq-maintainer/save-status','TmfFilingQueueStatusMaintainerController@saveStatus');
// //Route::post('/tmfq-maintainer/save-sub-status','TmfFilingQueueStatusMaintainerController@saveStatus');
// //Route::post('/tmfq-maintainer/reorder-root-statuses','TmfFilingQueueStatusMaintainerController@reorderRootStatuses');
// //Route::post('/tmfq-maintainer/reorder-sub-statuses','TmfFilingQueueStatusMaintainerController@reorderSubStatuses');
// //Route::post('/tmfq-maintainer/dashboard-tss-options','TmfFilingQueueStatusMaintainerController@dashboardTssOptions');

// Route::redirect('/tmf-filing-queue', '/tmfq', 301);
// Route::get('/tmfq','TmfFilingQueueController@index');
// //Route::get('/tmfq/load-sub-status-tms/{id}','TmfFilingQueueController@loadSubStatusTms');
// //Route::post('/tmfq/load-sub-status-tms/{id}','TmfFilingQueueController@loadSubStatusTms');
// //Route::get('/tmfq/sub-status-numbers/{id}','TmfFilingQueueController@loadSubStatusNumbers');
// //Route::post('/tmfq/sub-status-numbers/{id}','TmfFilingQueueController@loadSubStatusNumbers');
// //Route::post('/tmfq/reload-sub-statuses/{id}','TmfFilingQueueController@reloadSubStatuses');
// //Route::post('/tmfq/load-dashboard-notes','TmfFilingQueueController@loadDashboardNotes');
// //Route::post('/tmfq/save-dashboard-notes','TmfFilingQueueController@saveDashboardNotes');
// //Route::post('/tmfq/apply-new-status','TmfFilingQueueController@applyNewStatus');
// //Route::post('/tmfq/search','TmfFilingQueueController@search');
// //Route::post('/tmfq/claim','TmfFilingQueueController@claim');
// //Route::post('/tmfq/request-review','TmfFilingQueueController@requestReview');
// //Route::post('/tmfq/unclaim','TmfFilingQueueController@manualUnclaim');
// //Route::post('/tmfq/load-history','TmfFilingQueueController@loadHistory');
// //Route::get('/tmfq/claimed-by-me-setting/{flag}','TmfFilingQueueController@setClaimedByMeSetting');

// //Route::get('/tmf-filing-queue-v2','TmfFilingQueueV2Controller@index');
// //Route::get('/tmf-filing-queue-v2/load-sub-status-tms/{id}','TmfFilingQueueV2Controller@loadSubStatusTms');
// //Route::post('/tmf-filing-queue-v2/load-sub-status-tms/{id}','TmfFilingQueueV2Controller@loadSubStatusTms');
// //Route::get('/tmf-filing-queue-v2/sub-status-numbers/{id}','TmfFilingQueueV2Controller@loadSubStatusNumbers');
// //Route::post('/tmf-filing-queue-v2/sub-status-numbers/{id}','TmfFilingQueueV2Controller@loadSubStatusNumbers');
// //Route::post('/tmf-filing-queue-v2/reload-sub-statuses/{id}','TmfFilingQueueV2Controller@reloadSubStatuses');
// //Route::post('/tmf-filing-queue-v2/load-dashboard-notes','TmfFilingQueueV2Controller@loadDashboardNotes');
// //Route::post('/tmf-filing-queue-v2/save-dashboard-notes','TmfFilingQueueV2Controller@saveDashboardNotes');
// //Route::post('/tmf-filing-queue-v2/apply-new-status','TmfFilingQueueV2Controller@applyNewStatus');
// //Route::post('/tmf-filing-queue-v2/search','TmfFilingQueueV2Controller@search');

// Route::post('/change-queue-status/load-tss-list','ChangeQueueStatusController@loadTssList');
// Route::post('/change-queue-status/dashboard-and-tss-params/{id}','ChangeQueueStatusController@dashboardAndTssParams');
// Route::post('/change-queue-status/load-dashboard-tss-template-and-deadlines/{id}','ChangeQueueStatusController@loadDashboardTssTemplateAndDeadlines');
// Route::post('/change-queue-status/apply-new-tmf-reg-queue-status','ChangeQueueStatusController@applyNewTmfRegQueueStatus');
// Route::post('/change-queue-status/apply-new-tmf-filing-queue-status','ChangeQueueStatusController@applyNewTmfFilingQueueStatus');
// Route::post('/change-queue-status/apply-new-queue-status','ChangeQueueStatusController@applyNewQueueStatus');
// Route::post('/change-queue-status/load-tss-template-id','ChangeQueueStatusController@loadTssTemplateId');
// Route::post('/change-queue-status/queue-type-statuses','ChangeQueueStatusController@queueTypeStatuses');


// Route::get('/queue-status-maintainer','QueueStatusMaintainerController@index');
// Route::get('/queue-status-maintainer/load-root-statuses/{id}','QueueStatusMaintainerController@loadRootStatuses');
// Route::get('/queue-status-maintainer/load-root-status-options/{id}','QueueStatusMaintainerController@loadRootStatusOptions');
// Route::get('/queue-status-maintainer/remove-root-status/{id}','QueueStatusMaintainerController@removeRootStatus');
// Route::get('/queue-status-maintainer/remove-sub-status/{id}','QueueStatusMaintainerController@removeSubStatus');
// Route::get('/queue-status-maintainer/load-sub-statuses/{id}','QueueStatusMaintainerController@loadSubStatuses');
// Route::post('/queue-status-maintainer/save-status/{queue_type_id}','QueueStatusMaintainerController@saveStatus');
// Route::post('/queue-status-maintainer/save-sub-status','QueueStatusMaintainerController@saveStatus');
// Route::post('/queue-status-maintainer/reorder-root-statuses','QueueStatusMaintainerController@reorderRootStatuses');
// Route::post('/queue-status-maintainer/reorder-sub-statuses','QueueStatusMaintainerController@reorderSubStatuses');
// Route::post('/queue-status-maintainer/dashboard-tss-options','QueueStatusMaintainerController@dashboardTssOptions');
// Route::post('/queue-status-maintainer/save-custom-context-menu','QueueStatusMaintainerController@saveCustomContextMenu');
// Route::post('/queue-status-maintainer/load-context-menu-data','QueueStatusMaintainerController@loadContextMenuData');


// Route::get('/queue','QueueController@index')->name('queue');
// Route::get('/queue/load-root-statuses/{id}','QueueController@loadRootStatuses');
// Route::get('/queue/load-sub-status-tms/{id}','QueueController@loadSubStatusTms');
// Route::post('/queue/load-sub-status-tms/{id}','QueueController@loadSubStatusTms');
// Route::get('/queue/sub-status-numbers/{id}','QueueController@loadSubStatusNumbers');
// Route::post('/queue/sub-status-numbers/{id}','QueueController@loadSubStatusNumbers');
// Route::post('/queue/reload-sub-statuses/{id}','QueueController@reloadSubStatuses');
// Route::post('/queue/load-dashboard-notes','QueueController@loadDashboardNotes');
// Route::post('/queue/save-dashboard-notes','QueueController@saveDashboardNotes');
// Route::post('/queue/apply-new-status','QueueController@applyNewStatus');
// Route::post('/queue/search','QueueController@search');
// Route::post('/queue/claim','QueueController@claim');
// Route::post('/queue/request-review','QueueController@requestReview');
// Route::post('/queue/unclaim','QueueController@manualUnclaim');
// Route::post('/queue/load-history','QueueController@loadHistory');
// Route::post('/queue/load-tms-data','QueueController@loadTmsData');
// Route::get('/queue/claimed-by-me-setting/{flag}','QueueController@setClaimedByMeSetting');
// Route::get('/queue/review-requested-only-setting/{flag}','QueueController@setReviewRequestedOnlySetting');
// Route::post('/queue/remove-request-review/{dashboard_id}','QueueController@removeRequestReview');
// Route::post('/queue/load-dashboard-details','QueueController@loadDashboardDetails');
// Route::post('/queue/change-flags-values','QueueController@changeFlagsValues');
// Route::post('/queue/load-additional-menu-items','QueueController@loadAdditionalMenuItems');
// Route::post('/queue/load-tss','QueueController@loadTss');
// Route::get('/queue/mark/{queue_status_id}/{dashboard_id}','QueueController@showMark');
// Route::get('/queue/dismiss-request/{queue_status_id}/{dashboard_id}','QueueController@dismissRequest');

// Route::get('/tmfentry/search/{id}','TmfEntrySearchController@index');

// Route::get('/queue-stats','QueueStatsController@index');
// Route::post('/queue-stats/load-stats','QueueStatsController@loadStats');

// Route::get('/money/categories/','MoneyCategoriesController@index');
// Route::post('/money/save-new-category','MoneyCategoriesController@saveNewCategory');

Route::get('ulogout', [UloginController::class, 'logout']);
