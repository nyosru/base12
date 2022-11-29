@extends('layouts.app')

@section('title')
    Queue Stats
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        Queue Stats
                    </div>
                    <div class="card-body">
                        {{--<form action="/pq-stats/load-stats" method="post">--}}
                            @csrf
                            <div class="text-center" style="margin-bottom:15px;">
                                <?php echo $months_btns . $q_btns;?>
                                <button class="btn btn-sm btn-info y-btn" style="margin-right: 7px;color:white;">Y</button>
                                <?php echo $y_select;?>
                            </div>
                            <div class="text-center mb-3">
                                <label class="mr-3" style="font-weight: normal;">
                                    From Date: <input type="text" id="from_date" name="from_date" class="form-control"
                                                      placeholder="YYYY-MM-DD" value=""
                                                      style="width: 130px;display: inline-block">
                                </label>
                                <label style="font-weight: normal;">
                                    To Date: <input type="text" id="to_date" name="to_date" class="form-control" placeholder="YYYY-MM-DD"
                                                    value="<?php echo date('Y-m-d');?>"
                                                    style="width: 130px;display: inline-block">
                                </label>
                            </div>
                            <div class="mb-3 text-center">
                                <button class="btn btn-success" id="show-stat-btn">SHOW</button>
                            </div>
                        {{--</form>--}}
                        <div class="text-center">
                            <div class="d-inline-block m-auto text-left" id="result-block"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('modals')
@endsection

@section('external-jscss')
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.0/themes/smoothness/jquery-ui.css">
    <script src="//code.jquery.com/ui/1.12.0/jquery-ui.js" type="text/javascript"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.css" rel="stylesheet">
    <link href="https://trademarkfactory.com/js/noty/lib/noty.css" rel="stylesheet">
    <script type="text/javascript" src="https://trademarkfactory.com/js/noty/lib/noty.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment.min.js"></script>
    <script src="https://trademarkfactory.com/js/moment-timezone-with-data.js"></script>

    @include('queue-stats.js')
@endsection