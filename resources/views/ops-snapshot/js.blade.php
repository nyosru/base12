<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    function reloadResultTable(countries) {
        $('#tmfwaiting400_modal').modal('show');
        $.post(
            '/ops-snapshot/reload-table',
            {countries: JSON.stringify(countries)},
            function (msg) {
                setTimeout(function () {
                    $('#tmfwaiting400_modal').modal('hide');
                }, 500);
                if (msg.length) {
                    $('#result-table').html(msg);
                } else {
                    $('.toast-body').text('Unknown error during reloading data!');
                    $('.toast').toast('show');
                }
            }
        );
    }

    $('.country-chbx').change(function () {
        var countries = [];
        $('.country-chbx:checked').each(function () {
            countries = countries.concat(JSON.parse($(this).val()));
        });

        reloadResultTable(countries);
    });

    var data_table=null;

    $('body').on('click','.show-details',function () {
        var data=$(this).data('ids');
        if(data.length) {
            $('#tmfwaiting400_modal').modal('show');
            $.post(
                '/ops-snapshot/loading-details',
                {ids: JSON.stringify(data)},
                function (msg) {
                    setTimeout(function () {
                        $('#tmfwaiting400_modal').modal('hide');
                    }, 500);
                    if (msg.length) {
                        $('#status-details-modal .modal-body').html(msg);
                        if(data_table)
                            data_table.destroy();
                        data_table=$('#details-table').DataTable({
                            'searching': false,
                            "paging":   false,
                            "info":     false
                        });

                        $('#status-details-modal').modal('show');
                    } else {
                        $('.toast-body').text('Unknown error during loading details!');
                        $('.toast').toast('show');
                    }
                }
            );
        }else{
            $('.toast-body').text('Nothing to show');
            $('.toast').toast('show');
        }
        return false;
    });

    $('body').on('change','.iit-select',function () {
        $.post(
            '/ops-snapshot/update-dashboard-in-timings-type',
            {dashboard_id:$(this).data('id'),id:$(this).val()},
            function (msg) {}
        );
    });
</script>