<script>
    $('body').on('click', '.claim-link', function () {
        let dashboard_id = $(this).data('dashboard-id');
        let queue_status_id = $(this).data('queue-status-id');
        $.post(
            '/queue/claim',
            {dashboard_id: dashboard_id,queue_status_id:queue_status_id},
            function (msg) {
                // let id = $('.sub-status.active').data('id');
                // loadSubStatusTms(id);
            }
        );
        hideContextMenu();
        return false;
    });

</script>