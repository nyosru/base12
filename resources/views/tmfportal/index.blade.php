@extends('layouts.app')

@section('content')
                <div id="columns-container">
                    <div class="row mr-1 ml-1 mb-3">
                        <div class="col-sm-6">
                            {!! $columns[0] !!}
                        </div>
                        <div class="col-sm-6">
                            {!! $columns[1] !!}
                        </div>
                    </div>
                </div>
                <div class="text-center">
                    <button class="btn btn-lg btn-success" id="add-new-category-btn">
                        <i class="fas fa-plus"></i> NEW PRIVATE CATEGORY
                    </button>
                </div>
@endsection

@section('modals')
    @include('tmfportal.add-edit-category-modal')
    @include('homepagemaintainer.add-edit-category-item-modal')
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
    @include('tmfportal.css')
    <style>
        .bd-highlight {
            background-color: rgba(86, 61, 124, .15);
            border: 1px solid rgba(86, 61, 124, .15);
        }

        .bd-item-highlight {
            background-color: white;
            border: 1px solid rgba(86, 61, 124, .15);
        }

        .list-group-item{
            font-size: 13pt;
            line-height: 1.5;
            font-family: "Roboto", sans-serif;
            -webkit-font-smoothing: antialiased !important;
        }

        .card-header{
            font-size:21px;
            font-weight: bold;
            line-height: 1.1;
            font-family: "Roboto", sans-serif;
            -webkit-font-smoothing: antialiased !important;
        }
    </style>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.1/themes/smoothness/jquery-ui.css">
    <script src="//code.jquery.com/jquery-migrate-3.0.0.min.js" type="text/javascript"></script>
    <script src="//code.jquery.com/ui/1.11.1/jquery-ui.js" type="text/javascript"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,700" media="screen" rel="stylesheet" type="text/css" />

    @include('tmfportal.js')
@endsection

@section('title')
    Tmf Portal
@endsection