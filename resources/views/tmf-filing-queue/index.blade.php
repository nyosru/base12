@extends('layouts.app')

@section('title')
    Filing Queue
@endsection

@section('content')
    <form action="https://trademarkfactory.com/mlcclients/envelope.php" method="post" target="_blank" id="shipping-label-form">
        <input type="hidden" name="tmoffer_id" value="">
        <input type="hidden" name="addy" value="">
        <input type="hidden" name="note" value="">
    </form>
    <ul class="dropdown-menu" id="context-menu">
        <li><a class="dropdown-item change-status-link" href="#"><i class="fas fa-project-diagram"></i> Change Status</a></li>
        <li><a class="dropdown-item view-in-dashboard-link" href="#"><i class="fas fa-tachometer-alt"></i> View in Dashboard</a></li>
        <li><a class="dropdown-item tmfentry-link" href="#"><i class="fas fa-book"></i> TMF ENTRY</a></li>
        <li><a class="dropdown-item view-in-aa-link" href="#"><i class="fas fa-file-contract"></i> View in Accepted Agreements</a></li>
        <li><a class="dropdown-item view-in-search-report-link" href="#"><i class="fas fa-search"></i> View Search Report</a></li>
        <li><a class="dropdown-item dashboard-notes-link" href="#"><i class="fas fa-sticky-note"></i> Notes</a></li>
        @if(in_array(\Illuminate\Support\Facades\Auth::user()->ID,[1]))
        <li><a class="dropdown-item print-shipping-link" href="#"><i class="fas fa-shipping-fast"></i> Print Shipping Label</a></li>
        @endif
    </ul>
    <main class="col-md-12 ms-sm-auto col-lg-12 px-md-4">
        <div class="row">
            <div class="col-3" style="min-width: 250px;">
                <div class="accordion" id="root-statuses">
                    @include('tmf-filing-queue.root-statuses-list')
                </div>
            </div>
            <div class="col-9">
                <div id="tms-area">
{{--
                    <ul class="list-group list-group-horizontal">
                        <li class="list-group-item trademark text-center font-weight-bold d-flex align-items-center" style="height: auto">Trademark</li>
                        <li class="list-group-item country-flag text-center d-flex align-items-center"><img src="//mincovlaw.com/images/icons/cipo_uspto.jpg" style="width: 20px;height: 12px;"></li>
                        <li class="list-group-item client text-center font-weight-bold d-flex align-items-center">Client</li>
                        <li class="list-group-item since-last-action text-center d-flex align-items-center">🏁</li>
                        <li class="list-group-item time-since text-center font-weight-bold d-flex align-items-center">Time since</li>
                        <li class="list-group-item pending-in text-center font-weight-bold d-flex align-items-center">Pending in<br/>this status</li>
                    </ul>
                    <div id="tms-list" class="text-center"></div>
--}}
                </div>
            </div>
        </div>
    </main>
@endsection

@section('modals')
    @include('post-boom-bookings-calendar.notes-modal')
    @include('tmf-filing-queue.change-status-modal')
    @include('tmf-filing-queue.search-modal')
@endsection

@section('external-jscss')
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.0/themes/smoothness/jquery-ui.css">
    <script src="//code.jquery.com/jquery-migrate-3.0.0.min.js" type="text/javascript"></script>
    <script src="//code.jquery.com/ui/1.12.0/jquery-ui.js" type="text/javascript"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.css" rel="stylesheet">
    <link href="https://trademarkfactory.com/js/noty/lib/noty.css" rel="stylesheet">
    <script type="text/javascript" src="https://trademarkfactory.com/js/noty/lib/noty.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment.min.js"></script>
    <script src="https://trademarkfactory.com/js/moment-timezone-with-data.js"></script>
    <link rel="stylesheet" type="text/css" href="/datatables/datatables.min.css"/>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.24/sc-2.0.3/datatables.min.css"/>

    <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.24/sc-2.0.3/datatables.min.js"></script>
    <link rel="stylesheet" href="{{asset('plugins/summernote/summernote-bs4.css')}}">
    <script src="{{asset('plugins/summernote/summernote-bs4.min.js')}}"></script>


    @include('tmf-filing-queue.css')

    @include('tmf-filing-queue.js')
@endsection