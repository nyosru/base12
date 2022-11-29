<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    var periods={!! $periods !!};
    var config_arr={!! $config !!};
    var iit_changed=0;

    function getCheckedCountries() {
        var countries=[];
        $('.country-chbx:checked').each(function () {
                countries.push($(this).val());
        });
        return countries;
    }

    function applyDetailsDates() {
        if($('.details-dates').length){
            $('#details-modal .details-table').hide();
            $('#details-modal .details-table.row-'+$('.details-dates').val()).show();
        }
    }

    $('body').on('change','.details-dates',function () {
        applyDetailsDates();
    });

    var data_table=null;
    
    function showChartPeriodDetails(ops_snapshot_title_id,period) {
        $('#tmfwaiting400_modal').modal('show');
        var countries=getCheckedCountries();
        var period_arr=period.split('-');
        $.post(
            '/ops-trends/load-chart-details',
            {
                ops_snapshot_title_id:ops_snapshot_title_id,
                countries:JSON.stringify(countries),
                from_date:period_arr[0]+'-'+period_arr[1]+'-'+period_arr[2],
                to_date:period_arr[3]+'-'+period_arr[4]+'-'+period_arr[5]
            },
            function (msg) {
                setTimeout(function () {
                    $('#tmfwaiting400_modal').modal('hide');
                },500);
                if(msg.length){
                    $('#details-modal .modal-body').html(msg);

                    if(data_table)
                        data_table.destroy();
                    data_table=$('.details-table').DataTable({
                        'searching': false,
                        "paging": false,
                        "info": false
                    });

                    applyDetailsDates();
                    $('#details-modal').modal('show');
                }else{
                    $('.toast-body').text('Unknown error during loading details!');
                    $('.toast').toast('show');
                }
            }
        );
    }

    @foreach($tchart->getDatasets() as $dataset_el)
        var myNewChart{{$loop->index}};
    @endforeach

{{--    function initCharts(_config_arr){
        @foreach($chart_data as $chart_data_el)
            var ctx{{$loop->index}} = document.getElementById('tc{{$loop->index}}-canvas').getContext('2d');
            myNewChart{{$loop->index}} = new Chart(ctx{{$loop->index}}, _config_arr[{{$loop->index}}]);
        @endforeach
    }--}}

    function initCharts(_config_arr){
       @foreach($tchart->getDatasets() as $dataset_el)
        {{--@if(\App\OpsSnapshotTitle::find(array_values($dataset_el)[0]['trends_chart_id'])->ops_snapshot_title_group_id==$ops_snapshot_title_group_obj->id)--}}
            var ctx{{$loop->index}} = document.getElementById('tc{{$loop->index}}-canvas').getContext('2d');
            myNewChart{{$loop->index}} = new Chart(ctx{{$loop->index}}, _config_arr[{{$loop->index}}]);
        {{--@endif--}}
       @endforeach
    }

    window.onload = function() {
        initCharts(config_arr);
    };

    function reloadCharts() {
        var countries=getCheckedCountries();
        $('#tmfwaiting400_modal').modal('show');
        $.post(
            '/ops-trends/reload-charts',
            {
                countries:JSON.stringify(countries),
                days:$.trim($('.selected-day').text()),
                period:$.trim($('.selected-period').text())
            },
            function (msg) {
                setTimeout(function () {
                    $('#tmfwaiting400_modal').modal('hide');
                },500);
                if(msg.length){
                    iit_changed=0;
                    var arr=eval(msg[0]);
                    periods=arr;
                    var __config=eval(msg[1]);
                    @foreach($tchart->getDatasets() as $dataset_el)
                        myNewChart{{$loop->index}}.destroy();
                    @endforeach
                    initCharts(__config);
                }else{
                    $('.toast-body').text('Unknown error during reloading data!');
                    $('.toast').toast('show');
                }
            }
        );
    }

    function paintDays(selected_value){
        var arr=[3,4,6,10,12];
        var html='';
        $.each(arr,function (i,val) {
            if(val==Number(selected_value))
                html+='<span class="mr-1 font-weight-bold selected-day">'+val+'</span>';
            else
                html+='<a href="#" class="last-el mr-1" data-value="'+val+'">'+val+'</a>';
        });
        $('#days').html(html);
    }

    function paintPeriods(selected_value){
        // var arr=['Weeks','Months','Quarters','Years'];
        var arr=['Weeks','Months','Quarters'];
        var html='';
        $.each(arr,function (i,val) {
            if(val==selected_value)
                html+='<span class="mr-1 font-weight-bold selected-period">'+val+'</span>';
            else
                html+='<a href="#" class="last-period mr-1" data-value="'+val+'">'+val+'</a>';
        });
        $('#periods').html(html);
    }

    $('body').on('click','.last-el',function () {
        paintDays($(this).data('value'));
        reloadCharts();
        return false;
    });

    $('body').on('click','.last-period',function () {
        paintPeriods($(this).data('value'));
        reloadCharts();
        return false;
    });

    $('.country-chbx').change(function () {
        reloadCharts();
    });


    $('body').on('change','.iit-select',function () {
        $('.iit-select[data-id="'+$(this).data('id')+'"]').val($(this).val());
        iit_changed=1;
        $.post(
            '/ops-snapshot/update-dashboard-in-timings-type',
            {dashboard_id:$(this).data('id'),id:$(this).val()},
            function (msg) {}
        );
    });

    $('#details-modal').on('hidden.bs.modal', function (e) {
        if(iit_changed)
            reloadCharts();
    });


</script>