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
                minDate: "2021-01-01",
                maxDate: "2030-06-10",

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
    });

    $('.q-btn,.month-btn').click(function () {
        $('#from_date').val($('#s-year').val() + '-' + $(this).data('from'));
        $('#to_date').val($('#s-year').val() + '-' + $(this).data('to'));
    });

    $('.y-btn').click(function () {
        $('#from_date').val($('#s-year').val() + '-01-01');
        $('#to_date').val($('#s-year').val() + '-12-31');
    });

    function setYDate(selector){
        var val=$(selector).val();
        if(val.length){
            var arr=val.split('-');
            $(selector).val($('#s-year').val() + '-' + arr[1]+'-'+arr[2]);
        }
    }

    $('#s-year').change(function () {
        setYDate('#from_date');
        setYDate('#to_date');
    });

    $('#show-stat-btn').click(function () {
        $('#tmfwaiting400_modal').modal('show');
        $.post(
            '/queue-stats/load-stats',
            {
                from_date:$('#from_date').val(),
                to_date:$('#to_date').val()
            },
            function (msg) {
                setTimeout(function () {
                    $('#tmfwaiting400_modal').modal('hide');
                }, 1000);
                // console.log(msg);
                $('#result-block').html(msg);
            }
        );
    });
</script>