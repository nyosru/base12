@extends('layouts.app')

@section('title')
    Queue Random Check
@endsection

@section('content')
    {!! $context_menu->getHtml(); !!}
    <div class="container"  style="min-width: 768px;">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card mb-3">
                    <div class="card-header text-center">
                        PLEASE CONFIRM THAT EVERYTHING IS CORRECT
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-xl-6 mb-3">
                                <div class="card">
                                    <div class="card-header sub-card-header text-center" id="status-block">
                                        @include('tmfxq::random-check.queue-status-block')
                                    </div>
                                    <div class="card-body sub-card-body text-center" id="tm-block">
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-6">
                                <div class="card">
                                    <div class="card-header sub-card-header text-center">
                                        TSS <a href="https://trademarkfactory.com/mlcclients/dashboard-trademarks-details.php?id={{$dashboard_id}}" id="tss-edit-link" target="_blank"><i class="fas fa-pencil-alt"></i></a>
                                        <a href="#" id="refresh-tss-link" data-dashboard-tss-id="{{$dashboard_tss_id}}"><i class="fas fa-sync"></i></a>
                                    </div>
                                    <div class="card-body sub-card-body" id="tss-description-block">
                                        {!! $tss_description !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <button class="btn btn-primary" id="rebucket-btn">REBUCKET</button>
                        <button class="btn btn-success" id="all-good-btn">ALL IS GOOD</button>
                    </div>
                </div>
                <div class="text-center">
                    <div style="width: 400px;margin: auto;text-align: left">
                        <div>You've already cleared {{$tms_cleared_today}} TM{{$tms_cleared_today>1?'s':''}} today (PST time).</div>
                        <div>
                            @if(is_null($today_leader_info) || $current_tmfsales_id==$today_leader_info[0]->ID)
                                You are in the lead today
                            @else
                                {{$today_leader_info[0]->FirstName}} is in the lead today with {{$today_leader_info[1]}} TM{{$today_leader_info[1]>1?'s':''}} cleared
                            @endif
                        </div>
                        <div>All-time record is {{$all_time_record[1]}} cleared TM{{$all_time_record[1]>1?'s':''}} in one day by {{$all_time_record[0]->FirstName}}.</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('modals')
    {!! $context_menu->getModals() !!}
    {!! $change_status->getHtml() !!}
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
    @include('queue.css')
    <style>
        .sub-card-header{height: 71px;}
        .sub-card-body{height: 235px;overflow-x: hidden;overflow-y: auto}
        #tm-block{overflow-y: hidden!important;}
        .change-status-link, .view-tss-link{display: none;}
    </style>
    {!! $context_menu->getJs('.sub-status-tm') !!}
    @include('common-queue.image-preview-js')
    {{--@include('queue.context-menu-js')--}}
    {!! $change_status->getJs() !!}
    @include('tmfxq::random-check.js')
@endsection