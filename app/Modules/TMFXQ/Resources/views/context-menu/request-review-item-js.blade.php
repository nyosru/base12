<script>
    $('body').on('click', '.request-review-link', function () {
        $('#request-review-yes-btn').data('dashboard-id', $(this).data('dashboard-id'));
        $('#request-review-yes-btn').data('queue-status-id', $(this).data('queue-status-id'));
        $('#request-review-modal').modal('show');
        return false;
    });

    $('#request-review-yes-btn').click(function () {
        $('#request-review-modal').modal('hide');
        // $('#tmfwaiting400_modal').modal('show');
        let dashboard_id = $(this).data('dashboard-id');
        let id = $(this).data('queue-status-id');
        $.post(
            '/queue/request-review',
            {
                id: dashboard_id,
                notification: ($('#notify-request-review-chbx').prop('checked') ? 1 : 0),
                message:$.trim($('#review-message').val()),
                current_queue_status_id: id
            },
            function (msg) {
                if (msg.length) {
                    // loadSubStatusTms(id);
                } else {
                    setTimeout(function () {
                        // $('#tmfwaiting400_modal').modal('hide');
                        $('#request-review-modal').modal('show');
                    }, 1000);
                    new Noty({
                        type: 'error',
                        layout: 'topRight',
                        text: 'Owner not found!',
                        timeout: 1500
                    }).show();
                }
            }
        );
    });

</script>