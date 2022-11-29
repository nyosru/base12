<?php

use Illuminate\Support\Facades\Route;

Route::prefix('affiliate')->group(function () {
    Route::get('page-send-application', 'RegApplicationController@showSendApplicationPage');
    Route::get('page-review-applications', 'RegApplicationController@showReviewApplicationsPage');
    Route::get('page-registration-success', 'RegApplicationController@showRegistrationSuccessPage');

    Route::get('reg-applications', 'RegApplicationController@index')->name('reg_applications.index');
    Route::post('reg-applications/{reg_application}/update_status', 'RegApplicationController@updateStatus')
        ->name('reg-applications.update_status');
    Route::post('reg-applications', 'RegApplicationController@create')->name('reg_applications.create');
});
