@extends('layouts.app')

@section('title')
    Bni Results
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        Bni Results
                    </div>
                    <div class="card-body">
{{--                        <div class="mb-3 border-bottom">
                            <div class="row mb-3">
                                <label for="address-filter" class="col-md-2 font-weight-bold">Address:</label>
                                <div class="col-md-10">
                                    <input type="text" id="address-filter" class="form-control"/>
                                </div>
                            </div>
                        </div>--}}
                        <div class="mb-3 border-bottom">
                            <div class="mb-2 font-weight-bold">Regions: <button class="btn btn-sm btn-secondary ml-4" id="btn-all" data-all="1">Uncheck All</button></div>
                            {!! $regions_filters !!}
                        </div>
                        <div class="mb-3 border-bottom">
                            <div class="mb-2 font-weight-bold">Weekdays: <button class="btn btn-sm btn-secondary ml-4" id="btn-weekdays-all" data-all="1">Uncheck All</button></div>
                            <label class="mr-3 text-nowrap">
                                <input type="checkbox" class="weekday-chbx" value="Sunday" checked> Sunday
                            </label>
                            <label class="mr-3 text-nowrap">
                                <input type="checkbox" class="weekday-chbx" value="Monday" checked> Monday
                            </label>
                            <label class="mr-3 text-nowrap">
                                <input type="checkbox" class="weekday-chbx" value="Tuesday" checked> Tuesday
                            </label>
                            <label class="mr-3 text-nowrap">
                                <input type="checkbox" class="weekday-chbx" value="Wednesday" checked> Wednesday
                            </label>
                            <label class="mr-3 text-nowrap">
                                <input type="checkbox" class="weekday-chbx" value="Thursday" checked> Thursday
                            </label>
                            <label class="mr-3 text-nowrap">
                                <input type="checkbox" class="weekday-chbx" value="Friday" checked> Friday
                            </label>
                            <label class="mr-3 text-nowrap">
                                <input type="checkbox" class="weekday-chbx" value="Saturday" checked> Saturday
                            </label>
                        </div>
                        <div class="mb-3 border-bottom">
                            <div class="mb-2 font-weight-bold">Time slots: <button class="btn btn-sm btn-secondary ml-4" id="btn-time-slots-all" data-all="1">Uncheck All</button></div>
                            <label class="mr-3 text-nowrap">
                                <input type="checkbox" class="time-chbx" value="00:00-09:29" checked> Before 9:30
                            </label>
                            <label class="mr-3 text-nowrap">
                                <input type="checkbox" class="time-chbx" value="09:30-11:59" checked> 09:30&mdash;11:59
                            </label>
                            <label class="mr-3 text-nowrap">
                                <input type="checkbox" class="time-chbx" value="12:00-14:59" checked> 12:00&mdash;14:59
                            </label>
                            <label class="mr-3 text-nowrap">
                                <input type="checkbox" class="time-chbx" value="15:00-23:59" checked> After 15:00
                            </label>
                        </div>
                        <div class="mb-3 border-bottom">
                            <div class="mb-2 font-weight-bold">Members: <button class="btn btn-sm btn-secondary ml-4" id="btn-members-all" data-all="1">Uncheck All</button></div>
                            <label class="mr-3 text-nowrap">
                                <input type="checkbox" class="members-chbx" value="1-19" checked> 1&mdash;19
                            </label>
                            <label class="mr-3 text-nowrap">
                                <input type="checkbox" class="members-chbx" value="20-34" checked> 20&mdash;34
                            </label>
                            <label class="mr-3 text-nowrap">
                                <input type="checkbox" class="members-chbx" value="35-49" checked> 35&mdash;49
                            </label>
                            <label class="mr-3 text-nowrap">
                                <input type="checkbox" class="members-chbx" value="50+" checked> 50+
                            </label>
                        </div>
                        <div id="result-table-block" style="width: 99%;margin: auto">{!! $result_table !!}</div>
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
    <link href="http://trademarkfactory.com/js/noty/lib/noty.css" rel="stylesheet">
    <script type="text/javascript" src="http://trademarkfactory.com/js/noty/lib/noty.min.js"></script>
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

        data_table=$('#main-table').DataTable({
            'searching': false,
            "paging":   false,
            "info":     false
        });

        function getTimeSlot(time) {
            if(time>='00:00' && time<='09:29')
                return '00:00-09:29';
            if(time>='09:30' && time<='11:59')
                return '09:30-11:59';
            if(time>='12:00' && time<='14:59')
                return '12:00-14:59';
            if(time>='15:00' && time<='23:59')
                return '15:00-23:59';
        }

        function getMembersValue(members) {
            if(members>=1 && members<=19)
                return '1-19';
            if(members>=20 && members<=34)
                return '20-34';
            if(members>=35 && members<=49)
                return '35-49';
            if(members>=50)
                return '50+';
        }

        function redrawTableRows(){
            $('.t-row').each(function () {
                // var address_filter=$.trim($('#address-filter').val());
                // var row_address=$.trim($(this).find('td:eq(1)').text());
                if(
                    $('.region-chbx[value="'+$(this).data('region-id')+'"]').prop('checked') &&
                    $('.time-chbx[value="'+getTimeSlot($(this).data('time'))+'"]').prop('checked') &&
                    $('.weekday-chbx[value="'+$(this).data('weekday')+'"]').prop('checked') &&
                    $('.members-chbx[value="'+getMembersValue($(this).data('members'))+'"]').prop('checked')
/*                    &&
                    row_address.indexOf(address_filter)!=-1*/
                ) {
                    $(this).show();
                }else
                    $(this).hide();
            });
        }

        $('#address-filter').keyup(function () {
            redrawTableRows();
        });

        $('.region-chbx,.weekday-chbx,.time-chbx,.members-chbx').change(function () {
            redrawTableRows();
        });

        $('#btn-all').click(function () {
            if(Number($(this).data('all'))){
                $('.region-chbx').prop('checked',false);
                redrawTableRows();
                $(this).data('all',0);
                $(this).text('Check All');
            }else{
                $('.region-chbx').prop('checked',true);
                redrawTableRows();
                $(this).data('all',1);
                $(this).text('Uncheck All');
            }
        });

        $('#btn-time-slots-all').click(function () {
            if(Number($(this).data('all'))){
                $('.time-chbx').prop('checked',false);
                redrawTableRows();
                $(this).data('all',0);
                $(this).text('Check All');
            }else{
                $('.time-chbx').prop('checked',true);
                redrawTableRows();
                $(this).data('all',1);
                $(this).text('Uncheck All');
            }
        });

        $('#btn-members-all').click(function () {
            if(Number($(this).data('all'))){
                $('.members-chbx').prop('checked',false);
                redrawTableRows();
                $(this).data('all',0);
                $(this).text('Check All');
            }else{
                $('.members-chbx').prop('checked',true);
                redrawTableRows();
                $(this).data('all',1);
                $(this).text('Uncheck All');
            }
        });

        $('#btn-weekdays-all').click(function () {
            if(Number($(this).data('all'))){
                $('.weekday-chbx').prop('checked',false);
                redrawTableRows();
                $(this).data('all',0);
                $(this).text('Check All');
            }else{
                $('.weekday-chbx').prop('checked',true);
                redrawTableRows();
                $(this).data('all',1);
                $(this).text('Uncheck All');
            }
        });

    </script>
@endsection