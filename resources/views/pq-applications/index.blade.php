@extends('layouts.app')

@section('title')
    PQ Applications
@endsection

@section('content')
    <main class="col-md-12 ms-sm-auto col-lg-12 px-md-4">
        <div class="row">
            <div class="col-4">
                <div class="card p-1 shadow-lg" id="applications-list-block">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a class="nav-link active" id="unclaimed-tab" data-toggle="tab" href="#unclaimed" role="tab"
                               aria-controls="unclaimed" aria-selected="true">Unclaimed (<span
                                        id="unclaimed-count"></span>)</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" id="inprogress-tab" data-toggle="tab" href="#inprogress" role="tab"
                               aria-controls="inprogress" aria-selected="false">In Progress (<span
                                        id="inprogress-count">{{$inprogress_count}}</span>)</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" id="finished-tab" data-toggle="tab" href="#finished" role="tab"
                               aria-controls="finished" aria-selected="false">Finished (<span
                                        id="finished-count">{{$finished_count}}</span>)</a>
                        </li>
                    </ul>
                    <div class="input-group mt-1 mb-1 filter-block">
                            <input type="text" class="form-control" placeholder="Prospect's name" id="filter-str" aria-label="Prospect's name" aria-describedby="button-addon4">
                            <div class="input-group-append" id="button-addon4">
                                <button class="btn btn-outline-secondary" id="filter-search-btn" type="button">Search</button>
                                <button class="btn btn-outline-secondary" id="filter-reset-btn" type="button">Reset</button>
                            </div>
                    </div>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="unclaimed" role="tabpanel"
                             aria-labelledby="unclaimed-tab">
                            <ul class="list-group list-group-flush" id="unclaimed-content">
                            </ul>
                        </div>
                        <div class="tab-pane fade" id="inprogress" role="tabpanel" aria-labelledby="inprogress-tab">
                            <ul class="list-group list-group-flush" id="inprogress-content">
                            </ul>
                        </div>
                        <div class="tab-pane fade" id="finished" role="tabpanel" aria-labelledby="finished-tab">
                            <ul class="list-group list-group-flush" id="finished-content">
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-8">
                <div id="client-data">
                    <div class="row mb-3">
                        <div class="col-12">
                            <div class="card shadow-lg">
                                <div class="card-body">
                                    <h5 class="mb-0 text-center">Status: <span id="current-status">Unclaimed</span><a href="#" class="edit-claimed-request"><sup><i class="fas fa-pencil-alt"></i></sup></a></h5>
                                    <div id="booking-info-block" class="text-center"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-4">
                            <div class="card shadow-lg" style="height: 150px">
                                <div class="card-body">
                                    <h5 class="card-title text-center" id="client-fn"></h5>
                                    <div class="row text-center">
                                        <div class="col-12 text-left">
                                            <div id="client-email"></div>
                                            <div><span id="client-phone"></span>
                                                <button class="btn btn-sm btn-primary" id="send-sms-btn">SMS</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-8">
                            <div class="card shadow-lg" style="height: 150px;overflow-x: hidden;overflow-y: auto">
                                <div class="card-body">
                                    <h5 class="card-title text-center">Request Details</h5>
                                    <div class="row text-center">
                                        <div class="col-12 text-left">
                                            <div>From: <span id="rd-from"></span></div>
                                            <div>First Page: <span id="rd-first-page"></span></div>
                                            <div>Offer: <span id="rd-offer"></span></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12">
                            <div class="card shadow-lg">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">
                                        Prospect Answers
                                        <div class="d-inline float-right">
                                            <button class="btn btn-sm btn-warning follow-up-btn">Jump-Thru-Hoops Email</button>
                                            <button class="btn btn-sm btn-success approve-for-booking-btn">Approve for Booking</button>
                                            <button class="btn btn-sm btn-info approved-and-booked-btn mr-2">Approved & Booked</button>
                                        </div>
                                    </h5>
                                </div>
                                <div class="card-body" id="prospect-answers" style="max-height: 250px;overflow-y: auto">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-8">
                            <div class="card shadow-lg" style="height: 276px;overflow-y: auto">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">
                                        Notes
                                        <div class="d-inline float-right">
                                            <button class="btn btn-sm btn-info add-date-btn">Add Date</button>
                                            <button class="btn btn-sm btn-success save-notes-btn mr-2">Save</button>
                                        </div>
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <textarea id="notes" class="form-control h-100" style="resize: vertical"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="card shadow-lg" style="height: 276px;overflow-y: auto">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">Emails</h5>
                                </div>
                                <div class="card-body" id="emails-block">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <div class="curtain"><div class="curtain-message-block"></div></div>
@endsection

@section('modals')
    @include('booking-applications.client-data-modal')
    @include('booking-applications.closer-notes-preview-modal')
    @include('pq-applications.call-report-modal')
    @include('pq-applications.email-to-client-modal')
    @include('pq-applications.view-as-modal')
    @include('pq-applications.edit-tmf-subject-attr-modal')
    <div style="position: fixed; top: 15px; right: 15px;z-index:-1000;">
        <div class="toast sys-message" role="alert" aria-live="polite" aria-atomic="true" data-delay="3000"
             data-animation="true" style="width: 350px;">
            <div class="toast-header">
                <img src="/img/magentatmf.png" style="width: 16px;height: 16px;" class="rounded mr-2">
                <strong class="mr-auto">System Message</strong>
                <small class="text-muted">just now</small>
                <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="toast-body">
                Saved
            </div>
        </div>
    </div>
    {!! \App\classes\SmsSender::getModalHtml() !!}
@endsection

@section('external-jscss')
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.0/themes/smoothness/jquery-ui.css">
    <script src="//code.jquery.com/ui/1.12.0/jquery-ui.js" type="text/javascript"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.css" rel="stylesheet">
    <link href="https://trademarkfactory.com/js/noty/lib/noty.css" rel="stylesheet">
    <script type="text/javascript" src="https://trademarkfactory.com/js/noty/lib/noty.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment.min.js"></script>
    <script src="https://trademarkfactory.com/js/moment-timezone-with-data.js"></script>
    <link rel="stylesheet" href="{{asset('plugins/summernote/summernote-bs4.css')}}">
    <script src="{{asset('plugins/summernote/summernote-bs4.min.js')}}"></script>


    @include('pq-applications.css')

    @include('pq-applications.js')
@endsection