@extends('layouts.app')

@section('title')
    Youtube Clicks Report
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Youtube Clicks Report</div>

                    <div class="card-body">
                        <div style="margin:auto;width:70%;">
                            <div class="text-center" style="margin-bottom:15px">
                                <?php echo $months_btns.$q_btns;?>
                                <button class="btn btn-sm btn-info y-btn" style="margin-right: 7px;color:white;">Y</button>
                                <?php echo $y_select;?>
                            </div>
                            <div class="row" style="margin:auto;margin-bottom: 15px">
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
                            <div id="result-table"></div>
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
    <link rel="stylesheet" type="text/css" href="/datatables/datatables.min.css"/>
    <script type="text/javascript" src="/datatables/datatables.min.js"></script>
    <style>
        table.dataTable {border-collapse: collapse !important;}
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

            var data_table=null;

            $('#show-data').click(function () {
                // $('#tmfwaiting400_modal').modal('show');
                $.post(
                    '/youtube-clicks-show-report',
                    {from_date: $.trim($('#from_date').val()), to_date: $.trim($('#to_date').val())},
                    function (msg) {
                        // $('#tmfwaiting400_modal').modal('hide');
                        $('#result-table').html(msg);
                        if(data_table)
                            data_table.destroy();
                        data_table=$('#main-table').DataTable({
                            'searching': false,
                            "paging":   false,
                            "info":     false
                        });
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