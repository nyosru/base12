@extends('layouts.app')

@section('title')
    Tmf Client Satisfaction Stat
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Tmf Client Satisfaction Stat</div>

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