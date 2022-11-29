@extends('layouts.app')

@section('title')
    Welcome Asks Stat
@endsection

@section('content')
    <div class="container" style="max-width: 90%">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Welcome Asks Stat</div>

                    <div class="card-body">
                        <div style="margin:auto;width:100%;">
                            <div class="text-center">
                                <label class="font-weight-normal mr-3">
                                    <input type="checkbox" class="traffic-source-chbx" value="google" checked/> Google ad
                                </label>
                                <label class="font-weight-normal mr-3">
                                    <input type="checkbox" class="traffic-source-chbx" value="youtube" checked/> Youtube
                                </label>
                                <label class="font-weight-normal mr-3">
                                    <input type="checkbox" class="traffic-source-chbx" value="others" checked/> All others
                                </label>
                                <label class="font-weight-normal">
                                    <input type="checkbox" class="show-tmf-visitors" value="tmf"/> Also show TMF visits
                                </label>
                            </div>
                            <div class="text-center" style="margin-bottom:15px">
                                <?php echo $months_btns.$q_btns;?>
                                <button class="btn btn-sm btn-info y-btn" style="margin-right: 7px;color:white;">Y</button>
                                <?php echo $y_select;?>
                            </div>
                            <div class="row" style="margin:auto;margin-bottom: 15px;width: 80%">
                                <label style="font-weight: normal;" class="control-label col-md-5">
                                    From Date: <input type="text" id="from_date" class="form-control" placeholder="YYYY-MM-DD" value="" style="width: 130px;display: inline-block">
                                </label>
                                <label style="font-weight: normal;" class="control-label col-md-5">
                                    To Date: <input type="text" id="to_date" class="form-control" placeholder="YYYY-MM-DD" value="<?php echo date('Y-m-d');?>" style="width: 130px;display: inline-block">
                                </label>
                                <div class="col-md-2">
                                    <button class="btn btn-success" id="show-data">SHOW</button>
                                </div>
                            </div>
                            <div id="results">{!! $results !!}</div>
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
    <link href="http://trademarkfactory.com/js/noty/lib/noty.css" rel="stylesheet">
    <script type="text/javascript" src="http://trademarkfactory.com/js/noty/lib/noty.min.js"></script>
{{--    <link href="{{ asset('jstree/dist/themes/default/style.min.css') }}" rel="stylesheet"/>--}}
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

        .welcome-file{
            cursor: pointer;
        }
    </style>
{{--    <script src="{{ asset('jstree/dist/jstree.min.js') }}" type="text/javascript"></script>--}}
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
                var from_page=[];
                $('.traffic-source-chbx:checked').each(function () {
                    from_page.push($(this).val());
                });
                $.post(
                    location.href,
                    {
                        from_date:$.trim($('#from_date').val()),
                        to_date:$.trim($('#to_date').val()),
                        show_tmf_visitors:($('.show-tmf-visitors').prop('checked')?1:0),
                        from_page:JSON.stringify(from_page)
                    },
                    function (msg) {
                        $('#results').html(msg);
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

        $('.welcome-file').click(function () {
            prompt('',$(this).data('file'));
        });

    </script>
@endsection