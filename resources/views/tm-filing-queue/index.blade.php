@extends('layouts.app')

@section('title')
    TM Filing Queue
@endsection

@section('content')
    <ul class="dropdown-menu" id="context-menu">
        <li><a class="dropdown-item view-in-dashboard-link" href="#"><i class="fas fa-tachometer-alt"></i> View in Dashboard</a></li>
        <li><a class="dropdown-item tmfentry-link" href="#"><i class="fas fa-book"></i> TMF ENTRY</a></li>
        <li><a class="dropdown-item view-in-aa-link" href="#"><i class="fas fa-file-contract"></i> View in Accepted Agreements</a></li>
        <li><a class="dropdown-item view-in-search-report-link" href="#"><i class="fas fa-search"></i> View Search Report</a></li>
        <li><a class="dropdown-item dashboard-notes-link" href="#"><i class="fas fa-sticky-note"></i> Notes</a></li>
    </ul>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        TM Filing Queue
                    </div>
                    <div class="card-body">
                        <div class="accordion" id="root-block">
                            @foreach($data as $th_caption=>$el)
                                @include('tm-filing-queue.map')
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('modals')
    @include('post-boom-bookings-calendar.notes-modal')
    <div style="position: fixed; top: 15px; right: 15px;z-index:-1000;">
        <div class="toast sys-message" role="alert" aria-live="polite" aria-atomic="true" data-delay="3000" data-animation="true" style="width: 350px;">
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
@endsection

@section('external-jscss')
    @include('tm-filing-queue.css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.css" rel="stylesheet">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.1/themes/smoothness/jquery-ui.css">
    <script src="//code.jquery.com/jquery-migrate-3.0.0.min.js" type="text/javascript"></script>
    <script src="//code.jquery.com/ui/1.11.1/jquery-ui.js" type="text/javascript"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment.min.js"></script>
    <script src="https://trademarkfactory.com/js/moment-timezone-with-data.js"></script>
    <link rel="stylesheet" type="text/css" href="/datatables/datatables.min.css"/>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.23/css/dataTables.bootstrap4.min.css"/>
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.23/js/dataTables.bootstrap4.min.js"></script>
    @include('sdr-call-reminders.touch-punch-js')
    @include('tm-filing-queue.js')
@endsection