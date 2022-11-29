@extends('layouts.app')

@section('title')
    Queue Statuses Maintainer
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        Queue Statuses Maintainer
                        <select id="queue-type" class="form-control w-auto d-inline-block float-right">
                            @foreach($queue_type_objs as $queue_type_obj)
                                <option value="{{$queue_type_obj->id}}">{{$queue_type_obj->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-header">
                                        Root Statuses
                                        <button class="btn btn-sm btn-success float-right" id="new-root-status-btn" title="New Root Status"><i class="fas fa-plus"></i></button>
                                    </div>
                                    <div class="card-body">
                                        <ul class="list-group" id="root-statuses-block"></ul>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-header">
                                        SubStatuses
                                        <button class="btn btn-sm btn-success float-right" id="new-sub-status-btn" title="New SubStatus"><i class="fas fa-plus"></i></button>
                                    </div>
                                    <div class="card-body">
                                        <div class="list-group" id="sub-statuses-block">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('modals')
    @include('queue-status-maintainer.new-status-modal')
    @include('queue-status-maintainer.new-sub-status-modal')
    @include('queue-status-maintainer.custom-context-menu-modal')
@endsection

@section('external-jscss')
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.1/themes/smoothness/jquery-ui.css">
    <script src="//code.jquery.com/jquery-migrate-3.0.0.min.js" type="text/javascript"></script>
    <script src="//code.jquery.com/ui/1.11.1/jquery-ui.js" type="text/javascript"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.css" rel="stylesheet">
    <script type="text/javascript" src="https://trademarkfactory.com/selectize/js/standalone/selectize.js"></script>
    <link rel="stylesheet" type="text/css" href="https://trademarkfactory.com/selectize/css/selectize.css"/>
    <link href="http://trademarkfactory.com/js/noty/lib/noty.css" rel="stylesheet">
    <script type="text/javascript" src="http://trademarkfactory.com/js/noty/lib/noty.min.js"></script>

    @include('queue-status-maintainer.css')
    @include('queue-status-maintainer.js')
@endsection