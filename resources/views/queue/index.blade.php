@extends('layouts.app')

@section('title')
    OPS Queues
@endsection

@section('content')
    @include('common-queue.context-menu')
    <main class="col-md-12 ms-sm-auto col-lg-12 px-md-4">
        <div class="d-inline-flex w-100">
            <div class="sub-statuses-block d-inline-flex">
                <div class="accordion" id="root-statuses">
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
    {{--@include('queue.change-status-modal')--}}
    {!! $change_status_obj->getModals(session('queue-type-id')?session('queue-type-id'):$queue_type_objs[0]->id) !!}
    @include('queue.search-modal')
    @include('queue.request-review-modal')
    @include('queue.history-modal')
    @include('queue.edit-flags-values-modal')
    @include('queue.tss-viewer-modal')

@endsection

@section('external-jscss')
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.0/themes/smoothness/jquery-ui.css">
    <script src="//code.jquery.com/jquery-migrate-3.0.0.min.js" type="text/javascript"></script>
    <script src="//code.jquery.com/ui/1.12.0/jquery-ui.js" type="text/javascript"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.css" rel="stylesheet">
    <link href="https://trademarkfactory.com/js/noty/lib/noty.css" rel="stylesheet">
    <script type="text/javascript" src="https://trademarkfactory.com/js/noty/lib/noty.min.js"></script>
    <script src="https://momentjs.com/downloads/moment.js"></script>
    <script src="https://trademarkfactory.com/js/moment-timezone-with-data.js"></script>

    <link rel="stylesheet" href="{{asset('plugins/bdtp/tempusdominus-bootstrap-4.min.css')}}">
    <script src="{{asset('plugins/bdtp/tempusdominus-bootstrap-4.min.js')}}"></script>

    <script src="https://js.pusher.com/7.0/pusher.min.js"></script>

    <script>
        $.fn.datetimepicker.Constructor.Default = $.extend({},
            $.fn.datetimepicker.Constructor.Default,
            { icons:
                    { time: 'fas fa-clock',
                        date: 'fas fa-calendar',
                        up: 'fas fa-arrow-up',
                        down: 'fas fa-arrow-down',
                        previous: 'fas fa-arrow-circle-left',
                        next: 'fas fa-arrow-circle-right',
                        today: 'far fa-calendar-check-o',
                        clear: 'fas fa-trash',
                        close: 'far fa-times' } });
    </script>
    <link rel="stylesheet" href="{{asset('plugins/summernote/summernote-bs4.css')}}">
    <script src="{{asset('plugins/summernote/summernote-bs4.min.js')}}"></script>


    @include('queue.css')
    {!! $change_status_obj->getJs() !!}
    @include('common-queue.image-preview-js')
    {{--@include('queue.js')--}}
    @include('queue.js')
@endsection