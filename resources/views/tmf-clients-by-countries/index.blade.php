@extends('layouts.app')

@section('title')
    TMF Clients By Countries
@endsection

@section('content')
    <ul class="dropdown-menu" id="context-menu">
    </ul>
    <div class="container-xl">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        TMF Clients By Countries
                    </div>
                    <div class="card-body">
                        <div style="margin:auto;width:70%;">
                            <div class="text-center" style="margin-bottom:15px">
                                {!! $months_btns !!}{!! $q_btns !!}
                                <button class="btn btn-sm btn-info y-btn" style="margin-right: 7px;color:white;">Y</button>
                                {!! $y_select !!}
                            </div>
                            <div class="row" style="margin:auto;margin-bottom: 15px">
                                <label style="font-weight: normal;" class="control-label col-md-5">
                                    From Date: <input type="text" id="from_date" class="form-control" placeholder="YYYY-MM-DD" value="{{isset($request->from_date)? $request->from_date : ""}}" style="width: 130px;display: inline-block">
                                </label>
                                <label style="font-weight: normal;" class="control-label col-md-5">
                                    To Date: <input type="text" id="to_date" class="form-control" placeholder="YYYY-MM-DD" value="{{isset($request->to_date)? $request->to_date : date('Y-m-d')}}" style="width: 130px;display: inline-block">
                                </label>
                                <div class="col-md-2">
                                    <button class="btn btn-success" id="show-data">SHOW</button>
                                </div>
                            </div>

                            {{--                        @foreach($result_countries as $rc_key=>$rc_val)
                                                        <div class="mb-3"><strong>{{$rc_key}}:</strong> {{$rc_val}}</div>
                                                        @if($rc_key=='United States of America')
                                                            @foreach($us_states as $state_id=>$us_val)
                                                                <div class="mb-3 ml-3"><strong>{{(strlen($state_id)?\App\TmfState::find($state_id)->tmf_state_name:'N/A')}}</strong>: {{$us_val}}</div>
                                                                @if(isset($us_cities[$state_id]))
                                                                    @foreach($us_cities[$state_id] as $uc_key=>$uc_val)
                                                                        <div class="mb-3 ml-5"><strong>{{(strlen($uc_key)?ucfirst($uc_key):'N/A')}}</strong>: {{$uc_val}}</div>
                                                                    @endforeach
                                                                @endif
                                                            @endforeach
                                                        @endif
                                                    @endforeach--}}
                            <div id="result-table" style="text-align: center">
                                <div style="display: inline-block;text-align: left">
                                    <div id="jstree"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('external-jscss')
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.0/themes/smoothness/jquery-ui.css">
    <script src="//code.jquery.com/ui/1.12.0/jquery-ui.js" type="text/javascript"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.css" rel="stylesheet">
    @include('tmf-clients-by-countries.css')
    <link href="{{ asset('jstree/dist/themes/default/style.min.css') }}" rel="stylesheet"/>
    <style>
        .jstree-default a {
            white-space:normal !important; height: auto;
        }
        .jstree-anchor {
            height: auto !important;
        }
        .jstree-default li > ins {
            vertical-align:top;
        }
        .jstree-leaf {
            height: auto;
        }
        .jstree-leaf a{
            height: auto !important;
        }
    </style>
    <script src="{{ asset('jstree/dist/jstree.min.js') }}" type="text/javascript"></script>

    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var jstree_json={!! json_encode($result) !!};

        function initJSTree(){
            $('#jstree').jstree({
                'core' : {
                    "themes" : {
                        "default" : "large",
                    },
                    'data' : [jstree_json]
                }
            });
        }

        $(document).ready(function () {
            initJSTree();

            var dateFormat = "yy-mm-dd",
                from = $("#from_date")
                    .datepicker({
                        changeMonth: true,
                        numberOfMonths: 1,
                        minDate: "2020-06-10",
                        dateFormat: dateFormat
                    })
                    .on("change", function () {
                        to.datepicker("option", "minDate", getDate(this));
                    }),
                to = $("#to_date").datepicker({
                    changeMonth: true,
                    numberOfMonths: 1,
                    dateFormat: dateFormat,
                    minDate: "2020-06-10",
                    maxDate: "2025-06-10",

                })
                    .on("change", function () {
                        from.datepicker("option", "maxDate", getDate(this));
                    });

            function getDate(element) {
                var date;
                try {
                    date = $.datepicker.parseDate(dateFormat, element.value);
                } catch (error) {
                    date = null;
                }

                return date;
            }

            $('#show-data').click(function () {
                $.post(
                    location.href,
                    {from_date: $.trim($('#from_date').val()), to_date: $.trim($('#to_date').val())},
                    function (msg) {
                        if(Object.keys(msg).length) {
                            jstree_json=msg;
                            $('#jstree').jstree(true).settings.core.data = jstree_json;
                            $('#jstree').jstree(true).refresh();
                        }else
                            $('#jstree').html('EMPTY');
                    }
                );
            });
        });

        $('.q-btn,.month-btn').click(function () {
            $('#from_date').val($('#s-year').val() + '-' + $(this).data('from'));
            $('#to_date').val($('#s-year').val() + '-' + $(this).data('to'));
        });

        $('.y-btn').click(function () {
            $('#from_date').val($('#s-year').val() + '-01-01');
            $('#to_date').val($('#s-year').val() + '-12-31');
        });


    </script>
@endsection