@extends('layouts.app')

@section('title')
    First Pages Stats
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">First Pages Stats</div>

                    <div class="card-body">
                        <div style="margin:auto;width:70%;">
                            <div class="text-center" style="margin-bottom:15px">
                                {!! $months_btns !!}{!! $q_btns !!}
                                <button class="btn btn-sm btn-info y-btn" style="margin-right: 7px;color:white;">Y
                                </button>
                                {!! $y_select !!}
                            </div>
                            <div class="row" style="margin:auto;margin-bottom: 15px">
                                <label style="font-weight: normal;" class="control-label col-md-6 text-right">
                                    From Date: <input type="text" id="from_date" class="form-control"
                                                      placeholder="YYYY-MM-DD" value="{{$first_date}}"
                                                      style="width: 130px;display: inline-block">
                                </label>
                                <label style="font-weight: normal;" class="control-label col-md-6">
                                    To Date: <input type="text" id="to_date" class="form-control"
                                                    placeholder="YYYY-MM-DD" value="{{$last_date}}"
                                                    style="width: 130px;display: inline-block">
                                </label>
                            </div>
                            <div class="text-center mb-3">
                                <div class="switch-top">
                                    <input type="radio" class="ready-option-input" name="client-type" value="booked"
                                           id="ct-booked">
                                    <label for="ct-booked" class="switch-top-label switch-top-label-off">Booked</label>
                                    <input type="radio" class="ready-option-input" name="client-type"
                                           value="self-checkout" id="ct-self-checkout">
                                    <label for="ct-self-checkout" class="switch-top-label switch-top-label-on">Self-Checkout</label>
                                    <input type="radio" class="ready-option-input" name="client-type" value="both"
                                           id="ct-both" checked>
                                    <label for="ct-both" class="switch-top-label switch-top-label-three">Both</label>
                                    <span class="switch-top-selection"></span>
                                </div>
                            </div>
                            <div class="text-center mb-3">
                                <label class="mr-3"><input type="checkbox" id="no-show-chbx" value="1" checked/> No-Show</label>
                                <label class="mr-3"><input type="checkbox" id="no-boom-chbx" value="1" checked/> No-BOOM</label>
                                <label><input type="checkbox" id="boom-chbx" value="1" checked/> BOOM</label>
                            </div>
                            <div class="text-center mb-5">
                                <button class="btn btn-success" id="show-data">SHOW</button>
                            </div>
                            <div id="result-table">{!! $result_table !!}</div>
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

    <style>
        .ready-option-input,
        .type-option-input,
        .countries-option-input,
        .deadlines-show-settings-input,
        .deleted-option-input {
            display: none;
        }

        .ready-option-input:checked + .switch-top-label,
        .type-option-input:checked + .switch-top-label,
        .deadlines-show-settings-input:checked + .switch-top-label,
        .countries-option-input:checked + .switch-top-label,
        .deleted-option-input:checked + .switch-top-label {
            font-weight: bold;
            color: rgba(0, 0, 0, 0.65);
            text-shadow: 0 1px rgba(255, 255, 255, 0.25);
            -webkit-transition: 0.15s ease-out;
            -moz-transition: 0.15s ease-out;
            -ms-transition: 0.15s ease-out;
            -o-transition: 0.15s ease-out;
            transition: 0.15s ease-out;
            -webkit-transition-property: color, text-shadow;
            -moz-transition-property: color, text-shadow;
            -ms-transition-property: color, text-shadow;
            -o-transition-property: color, text-shadow;
            transition-property: color, text-shadow;
        }
        .ready-option-input:checked + .switch-top-label-on ~ .switch-top-selection,
        .type-option-input:checked + .switch-top-label-on ~ .switch-top-selection,
        .deadlines-show-settings-input:checked + .switch-top-label-on ~ .switch-top-selection,
        .countries-option-input:checked + .switch-top-label-on ~ .switch-top-selection,
        .deleted-option-input:checked + .switch-top-label-on ~ .switch-top-selection {
            left: 100px;
        }

        .ready-option-input:checked + .switch-top-label-three ~ .switch-top-selection,
        .type-option-input:checked + .switch-top-label-three ~ .switch-top-selection,
        .deadlines-show-settings-input:checked + .switch-top-label-three ~ .switch-top-selection,
        .countries-option-input:checked + .switch-top-label-three ~ .switch-top-selection,
        .deleted-option-input:checked + .switch-top-label-three ~ .switch-top-selection {
            left: 200px;
        }

        .ready-option-input:checked + .switch-top-label-off ~ .switch-top-selection,
        .type-option-input:checked + .switch-top-label-off ~ .switch-top-selection,
        .deadlines-show-settings-input:checked + .switch-top-label-off ~ .switch-top-selection,
        .countries-option-input:checked + .switch-top-label-off ~ .switch-top-selection,
        .deleted-option-input:checked + .switch-top-label-off ~ .switch-top-selection {
            left: 2px;
        }

        .switch-top {
            margin: auto;
            position: relative;
            height: 26px;
            width: 300px;
            /*margin: 12px 20px 0px 20px;*/
            background: rgba(0, 0, 0, 0.25);
            border-radius: 3px;
            -webkit-box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.3), 0 1px rgba(255, 255, 255, 0.1);
            box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.3), 0 1px rgba(255, 255, 255, 0.1);
        }

        .switch-top-label {
            position: relative;
            z-index: 2;
            float: left;
            width: 100px;
            line-height: 26px;
            font-size: 11px;
            color: rgba(0, 0, 0, 0.35);
            text-align: center;
            text-shadow: 0 1px 1px rgba(0, 0, 0, 0.45);
            cursor: pointer;
        }
        .switch-top-label:active {
            font-weight: bold;
        }

        .switch-top-label-off {
            padding-right: 2px;
        }

        .switch-top-label-on {
            padding-right: 2px;
        }

        .switch-top-label-three {
            padding-right: 2px;
        }


        .switch-top-input,
        .switch-ready-input{
            display: none;
        }

        .switch-ready-input:checked + .switch-top-label,
        .switch-top-input:checked + .switch-top-label {
            font-weight: bold;
            color: rgba(0, 0, 0, 0.65);
            text-shadow: 0 1px rgba(255, 255, 255, 0.25);
            -webkit-transition: 0.15s ease-out;
            -moz-transition: 0.15s ease-out;
            -ms-transition: 0.15s ease-out;
            -o-transition: 0.15s ease-out;
            transition: 0.15s ease-out;
            -webkit-transition-property: color, text-shadow;
            -moz-transition-property: color, text-shadow;
            -ms-transition-property: color, text-shadow;
            -o-transition-property: color, text-shadow;
            transition-property: color, text-shadow;
        }
        .switch-ready-input:checked + .switch-top-label-on ~ .switch-top-selection,
        .switch-top-input:checked + .switch-top-label-on ~ .switch-top-selection {
            left: 100px;
            /* Note: left: 50%; doesn't transition in WebKit */
        }

        .switch-ready-input:checked + .switch-top-label-three ~ .switch-top-selection,
        .switch-top-input:checked + .switch-top-label-three ~ .switch-top-selection {
            left: 200px;
            /* Note: left: 50%; doesn't transition in WebKit */
        }

        .switch-ready-input:checked + .switch-top-label-off ~ .switch-top-selection,
        .switch-top-input:checked + .switch-top-label-off ~ .switch-top-selection {
            left: 2px;
            /* Note: left: 50%; doesn't transition in WebKit */
        }

        .switch-top-selection {
            position: absolute;
            z-index: 1;
            top: 2px;
            left: 2px;
            display: block;
            width: 98px;
            height: 22px;
            border-radius: 3px;
            background-color: #65bd63;
            background-image: -webkit-gradient(linear, left top, left bottom, color-stop(0%, #9dd993), color-stop(100%, #65bd63));
            background-image: -webkit-linear-gradient(top, #9dd993, #65bd63);
            background-image: -moz-linear-gradient(top, #9dd993, #65bd63);
            background-image: -ms-linear-gradient(top, #9dd993, #65bd63);
            background-image: -o-linear-gradient(top, #9dd993, #65bd63);
            background-image: linear-gradient(top, #9dd993, #65bd63);
            -webkit-box-shadow: inset 0 1px rgba(255, 255, 255, 0.5), 0 0 2px rgba(0, 0, 0, 0.2);
            box-shadow: inset 0 1px rgba(255, 255, 255, 0.5), 0 0 2px rgba(0, 0, 0, 0.2);
            -webkit-transition: left 0.15s ease-out;
            -moz-transition: left 0.15s ease-out;
            -ms-transition: left 0.15s ease-out;
            -o-transition: left 0.15s ease-out;
            transition: left 0.15s ease-out;
        }
        .switch-top-blue .switch-top-selection {
            background-color: #3aa2d0;
            background-image: -webkit-gradient(linear, left top, left bottom, color-stop(0%, #4fc9ee), color-stop(100%, #3aa2d0));
            background-image: -webkit-linear-gradient(top, #4fc9ee, #3aa2d0);
            background-image: -moz-linear-gradient(top, #4fc9ee, #3aa2d0);
            background-image: -ms-linear-gradient(top, #4fc9ee, #3aa2d0);
            background-image: -o-linear-gradient(top, #4fc9ee, #3aa2d0);
            background-image: linear-gradient(top, #4fc9ee, #3aa2d0);
        }
        .switch-top-yellow .switch-top-selection {
            background-color: #c4bb61;
            background-image: -webkit-gradient(linear, left top, left bottom, color-stop(0%, #e0dd94), color-stop(100%, #c4bb61));
            background-image: -webkit-linear-gradient(top, #e0dd94, #c4bb61);
            background-image: -moz-linear-gradient(top, #e0dd94, #c4bb61);
            background-image: -ms-linear-gradient(top, #e0dd94, #c4bb61);
            background-image: -o-linear-gradient(top, #e0dd94, #c4bb61);
            background-image: linear-gradient(top, #e0dd94, #c4bb61);
        }

    </style>

    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $(document).ready(function () {

            var dateFormat = "yy-mm-dd",
                from = $("#from_date")
                    .datepicker({
                        changeMonth: true,
                        numberOfMonths: 1,
                        minDate: "2020-06-12",
                        dateFormat: dateFormat
                    })
                    .on("change", function () {
                        to.datepicker("option", "minDate", getDate(this));
                    }),
                to = $("#to_date").datepicker({
                    changeMonth: true,
                    numberOfMonths: 1,
                    dateFormat: dateFormat,
                    minDate: "2020-06-12",
                    maxDate: "2025-06-12",
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
                $('#tmfwaiting400_modal').modal('show');
                $.post(
                    location.href,
                    {
                        from_date: $.trim($('#from_date').val()),
                        to_date: $.trim($('#to_date').val()),
                        client_type:$('input[name="client-type"]:checked').val(),
                        no_show:($('#no-show-chbx').prop('checked')?1:0),
                        no_boom:($('#no-boom-chbx').prop('checked')?1:0),
                        boom:($('#boom-chbx').prop('checked')?1:0)

                    },
                    function (msg) {
                        setTimeout(function () {
                            $('#tmfwaiting400_modal').modal('hide');
                        },500);
                        //
                        $('#result-table').html(msg);
                        // console.log(msg);
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