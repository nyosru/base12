<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#show-stat-btn').click(function () {
        $('#tmfwaiting400_modal').modal('show');
        $.post(
            '/pq-finder/search',
            {
                name:$.trim($('#name').val()),
                email:$.trim($('#email').val()),
                phone:$.trim($('#phone').val())
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



    $('body').on('click','.details-btn',function () {
        $('#details-modal').modal('show');
        let current_pq_id=$(this).data('id');
        loadCurrentStatus(current_pq_id);
        loadRequestDetails(current_pq_id);
        loadClientInfo(current_pq_id);
        loadProspectAnswers(current_pq_id);
        loadNotes(current_pq_id);
        return false;
    });
</script>