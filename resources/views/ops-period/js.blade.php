<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $( function() {
        var dateFormat = "yy-mm-dd",
            from = $("#from_date")
                .datepicker({
                    changeMonth: true,
                    numberOfMonths: 1,
                    minDate: "2011-06-12",
                    dateFormat: dateFormat
                })
                .on("change", function () {
                    to.datepicker("option", "minDate", getDate(this));
                    reloadResultTable();
                }),
            to = $("#to_date").datepicker({
                changeMonth: true,
                numberOfMonths: 1,
                dateFormat: dateFormat,
                minDate: "2011-06-12",
                maxDate: "2035-06-12",
            })
                .on("change", function () {
                    from.datepicker("option", "maxDate", getDate(this));
                    reloadResultTable();
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
    } );

    function reloadResultTable() {
        var countries = [];
        $('.country-chbx:checked').each(function () {
            countries = countries.concat(JSON.parse($(this).val()));
        });

        $('#tmfwaiting400_modal').modal('show');
        $.post(
            '/ops-period/reload-table',
            {
                countries: JSON.stringify(countries),
                from_date: $.trim($('#from_date').val()),
                to_date:$.trim($('#to_date').val()),
            },
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
        reloadResultTable();
    });

    var data_table=null;

    $('body').on('click','.show-details',function () {
        var data=$(this).data('ids');
        if(Object.keys(data).length) {
            $('#tmfwaiting400_modal').modal('show');
            $.post(
                '/ops-period/loading-details',
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

    $('.q-btn,.month-btn').click(function () {
        $('#from_date').val($('#s-year').val() + '-' + $(this).data('from'));
        $('#to_date').val($('#s-year').val() + '-' + $(this).data('to'));
        reloadResultTable();
    });

    $('.y-btn').click(function () {
        $('#from_date').val($('#s-year').val() + '-01-01');
        $('#to_date').val($('#s-year').val() + '-12-31');
        reloadResultTable();
    });

</script>