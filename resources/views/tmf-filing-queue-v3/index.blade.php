@extends('layouts.app')

@section('title')
    Filing Queue
@endsection

@section('content')
    @include('common-queue.context-menu')
    <main class="col-md-12 ms-sm-auto col-lg-12 px-md-4">
        <div class="d-inline-flex w-100">
            <div class="sub-statuses-block d-inline-flex">
                <div class="accordion" id="root-statuses">
                    @include('tmf-filing-queue-v3.root-statuses-list')
                </div>
            </div>
            <div class="tms-block d-table w-100">
                <div class="w-100" id="tms-area">
                </div>
            </div>
        </div>
    </main>
@endsection

@section('modals')
    @include('post-boom-bookings-calendar.notes-modal')
    {{--@include('tmf-filing-queue-v3.change-status-modal')--}}
    {!! $change_status_obj->getModals() !!}
    @include('tmf-filing-queue-v3.search-modal')
    @include('tmf-filing-queue-v3.request-review-modal')
    @include('tmf-filing-queue-v3.history-modal')
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


    @include('tmf-filing-queue-v3.css')
    {!! $change_status_obj->getJs() !!}
    @include('common-queue.image-preview-js')
    {{--@include('tmf-filing-queue-v3.js')--}}
    @include('tmf-reg-queue.js')
@endsection