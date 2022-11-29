<script>
    $('body').on('click', '.unclaim-link', function () {
        let dashboard_id = $(this).data('dashboard-id');
        hideContextMenu();
        if (confirm('Unclaim?')) {
            // $('#tmfwaiting400_modal').modal('show');
            let id = $(this).data('queue-status-id');
            $.post(
                '/queue/unclaim',
                {
                    id: dashboard_id,
                    queue_status_id: id
                },
                function (msg) {
                    if (msg.length) {
                        //loadSubStatusTms(id);
                    } else {
                        setTimeout(function () {
                            $('#tmfwaiting400_modal').modal('hide');
                        }, 1000);
                        new Noty({
                            type: 'error',
                            layout: 'topRight',
                            text: 'Unknown error during unclaiming!',
                            timeout: 1500
                        }).show();
                    }
                }
            );

        }
        return false;
    });

</script>