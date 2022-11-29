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

    $('body').on('click', '.all-btn', function () {
        var current_class_selector = '.' + $(this).data('class');
        if ($(current_class_selector + ':checked').length < $(current_class_selector).length) {
            $(current_class_selector).prop('checked', true);
        } else
            $(current_class_selector).prop('checked', false);
        return false;
    });

    $('#show-stat-btn').click(function () {
        let lead_statuses=[];
        $('.lead-status-filter-chbx:checked').each(function () {
            lead_statuses.push($(this).val());
        });

        let sdrs=[];
        $('.sdr-filter-chbx:checked').each(function () {
            sdrs.push($(this).val());
        });
/*

        let boom_statuses=[];
        $('.boom-status-filter-chbx:checked').each(function () {
            boom_statuses.push($(this).val());
        });
*/

        let came_from=[];
        $('.from-filter-chbx:checked').each(function () {
            came_from.push($(this).val());
        });
        $('#tmfwaiting400_modal').modal('show');
        $.post(
            '/pq-stats/load-stats',
            {
                from_date:$('#from_date').val(),
                to_date:$('#to_date').val(),
                date_type_filter:$('input[name="date-type-filter"]:checked').val(),
                name:$.trim($('#name').val()),
                email:$.trim($('#email').val()),
                phone:$.trim($('#phone').val()),
                lead_statuses:JSON.stringify(lead_statuses),
                sdrs:JSON.stringify(sdrs),
                // boom_statuses:JSON.stringify(boom_statuses),
                came_from:JSON.stringify(came_from)
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

    $('body').on('click','.stat-details',function () {
        $('#tmfwaiting400_modal').modal('show');
        $('#details-modal .modal-title').text($(this).data('action'));
        $.post(
            '/pq-stats/load-details',
            {ids:JSON.stringify($(this).data('ids')),action:$(this).data('action')},
            function (msg) {
                setTimeout(function () {
                    $('#tmfwaiting400_modal').modal('hide');
                }, 1000);
                if(msg.length){
                    $('#details-content').html(msg);
                    $('#details-modal').modal('show');
                }else
                    new Noty({
                        type: 'error',
                        layout: 'topRight',
                        text: 'Unknown error during loading details!',
                        timeout: 1500
                    }).show();
            }
        );
        return false;
    });

    function loadCurrentStatus(current_pq_id){
        $.get(
            '/pq-applications/load-current-status/'+current_pq_id,
            function (msg) {
                if (Object.keys(msg).length) {
                    $('#current-status').text(msg.status);
                    $('#booking-info-block').html(msg.booking_info);
                }else
                    new Noty({
                        type: 'error',
                        layout: 'topRight',
                        text: 'Unknown error during loading current status and booking info!',
                        timeout: 1500
                    }).show();
            }
        );
    }

    function loadRequestDetails(current_pq_id){
        $.get(
            '/pq-applications/request-details/'+current_pq_id,
            function (msg) {
                if(Object.keys(msg).length){
                    $('#rd-from').text(msg.from);
                    $('#rd-first-page').html(msg.first_page);
                    $('#rd-offer').html(msg.offer);
                }else{
                    new Noty({
                        type: 'error',
                        layout: 'topRight',
                        text: 'Unknown error during loading request details!',
                        timeout: 1500
                    }).show();
                }
            }
        );
    }

    function loadClientInfo(current_pq_id){
        $.get(
            '/pq-applications/client-info/'+current_pq_id,
            function (msg) {
                if(Object.keys(msg).length){
                    if(msg.tmoffer.length)
                        $('#client-fn').html(msg.client_fn+' <a href="https://trademarkfactory.com/mlcclients/pq-manual-booking.php?id='+current_pq_id+'" class="book-a-call" title="Click to book a call from our end" target="_blank"><i class="fas fa-calendar-plus" style="color:green"></i></a>'+
                            ' <a href="https://trademarkfactory.com/shopping-cart/'+msg.tmoffer+'&donttrack=1" target="_blank"><i class="fas fa-shopping-cart"></i></a>');
                    else
                        $('#client-fn').html(msg.client_fn+' <a href="https://trademarkfactory.com/mlcclients/pq-manual-booking.php?id='+current_pq_id+'" class="book-a-call" title="Click to book a call from our end" target="_blank"><i class="fas fa-calendar-plus" style="color:green"></i></a>');
                    $('#client-email').html(msg.client_email);
                    $('#client-phone').html(msg.client_phone);
                    $('#send-sms-btn').data('id',msg.tmf_subject_id);
                }else{
                    new Noty({
                        type: 'error',
                        layout: 'topRight',
                        text: 'Unknown error during loading clients data!',
                        timeout: 1500
                    }).show();
                }
            }
        );
    }

    function loadProspectAnswers(current_pq_id){
        $.get(
            '/pq-applications/prospect-answers/'+current_pq_id,
            function (msg) {
                if(msg.length){
                    $('#prospect-answers').html(msg);
                }else{
                    new Noty({
                        type: 'error',
                        layout: 'topRight',
                        text: 'Unknown error during loading prospect answers!',
                        timeout: 1500
                    }).show();
                }
            }
        );
    }

    function loadNotes(current_pq_id){
        $.get(
            '/pq-applications/load-notes/'+current_pq_id,
            function (msg) {
                $('#users-notes').val(msg);
            }
        );
    }

    $('body').on('click','.request-history',function () {
        $('#details-modal').modal('hide');
        $('#client-data-modal').modal('show');
        let current_pq_id=$(this).data('id');
        loadCurrentStatus(current_pq_id);
        loadRequestDetails(current_pq_id);
        loadClientInfo(current_pq_id);
        loadProspectAnswers(current_pq_id);
        loadNotes(current_pq_id);
        return false;
    });

    $('#client-data-modal').on('hidden.bs.modal', function (e) {
        $('#details-modal').modal('show');
    });

</script>