@extends('layouts.app')

@section('title')
    NoBoom Reasons Maintainer
@endsection

@section('content')
    <ul class="dropdown-menu" id="context-menu">
    </ul>
    <div class="container-xl">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        NoBoom Reasons Maintainer
                    </div>
                    <div class="card-body">
                        <div class="text-center mb-3">
                            <button class="btn btn-sm btn-success" id="add-new-btn"><i class="fas fa-plus"></i> NEW</button>
                        </div>
                        {!! $result_table !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('modals')
    <div style="position: fixed; top: 15px; right: 15px;z-index:-1000;">
        <!-- Then put toasts within -->
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

@include('noboom-reasons-maintainer.noboom-reason-modal')

@section('external-jscss')
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.0/themes/smoothness/jquery-ui.css">
    <script src="//code.jquery.com/ui/1.12.0/jquery-ui.js" type="text/javascript"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.css" rel="stylesheet">
    <link href="https://trademarkfactory.com/js/noty/lib/noty.css" rel="stylesheet">
    <script type="text/javascript" src="https://trademarkfactory.com/js/noty/lib/noty.min.js"></script>
    <link rel="stylesheet" href="{{asset('plugins/summernote/summernote-bs4.css')}}">
    <script src="{{asset('plugins/summernote/summernote-bs4.min.js')}}"></script>

    @include('noboom-reasons-maintainer.css')

    @include('noboom-reasons-maintainer.js')
@endsection