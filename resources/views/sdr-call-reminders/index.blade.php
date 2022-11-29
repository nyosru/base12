@extends('layouts.app')

@section('title')
    SDR Call Reminders
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        SDR Call Reminders
{{--                        @if(in_array(\Illuminate\Support\Facades\Auth::user()->ID,[1,53]))--}}
                        <a class="float-right" href="#" id="calls-history-link">History</a>
                        {{--@endif--}}
                    </div>
                    <div class="card-body">
                        @include('sdr-call-reminders.current-progress')
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('modals')
    @include('post-boom-bookings-calendar.notes-modal')
    @include('sdr-call-reminders.calls-history-modal')
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
    @include('sdr-call-reminders.css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.css" rel="stylesheet">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.1/themes/smoothness/jquery-ui.css">
    <script src="//code.jquery.com/jquery-migrate-3.0.0.min.js" type="text/javascript"></script>
    <script src="//code.jquery.com/ui/1.11.1/jquery-ui.js" type="text/javascript"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment.min.js"></script>
    <script src="https://trademarkfactory.com/js/moment-timezone-with-data.js"></script>
    @include('sdr-call-reminders.touch-punch-js')
    @include('sdr-call-reminders.js')
@endsection