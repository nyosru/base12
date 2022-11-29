@extends('layouts.app')

@section('title')
    TEST
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        TEST
                    </div>
                    <div class="card-body">
                        <div class="mb-3 text-center">
                            <div class="mb-3 font-weight-bold">2020-08-23 &mdash; 2020-08-29</div>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th class="text-left">Date</th>
                                        <th class="text-left">TM</th>
                                        <th class="text-left">OA pending,days</th>
                                        <th class="text-left">OA started</th>
                                        <th class="text-left">STILL/DONE</th>
                                    </tr>
                                </thead>
                                <tbody>
                                {!! $p1_lines !!}
                                </tbody>
                            </table>
                        </div>
                        <div class="mb-3 text-center">
                            <div class="mb-3 font-weight-bold">2020-09-27 &mdash; 2020-10-03</div>
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th class="text-left">Date</th>
                                    <th class="text-left">TM</th>
                                    <th class="text-left">OA pending,days</th>
                                    <th class="text-left">OA started</th>
                                    <th class="text-left">STILL/DONE</th>
                                </tr>
                                </thead>
                                <tbody>
                                {!! $p2_lines !!}
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('external-jscss')
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.1/themes/smoothness/jquery-ui.css">
    <script src="//code.jquery.com/ui/1.11.1/jquery-ui.js" type="text/javascript"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.css" rel="stylesheet">
    <script type="text/javascript" src="https://trademarkfactory.com/selectize/js/standalone/selectize.js"></script>
    <link rel="stylesheet" type="text/css" href="https://trademarkfactory.com/selectize/css/selectize.css"/>
    <link href="http://trademarkfactory.com/js/noty/lib/noty.css" rel="stylesheet">
    <script type="text/javascript" src="http://trademarkfactory.com/js/noty/lib/noty.min.js"></script>
    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>
@endsection