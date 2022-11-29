<script>
    $('body').on('click', '.show-history-link', function () {
        $('#tmfwaiting400_modal').modal('show');
        let dashboard_id = $(this).data('dashboard-id');
        let queue_root_status_id = $(this).data('queue-root-status-id');
        $.post(
            '/queue/load-history',
            {id: dashboard_id, queue_root_status_id: queue_root_status_id},
            function (msg) {
                setTimeout(function () {
                    $('#tmfwaiting400_modal').modal('hide');
                }, 1000);
                $('#history-modal .modal-body').html(msg);
                $('#history-modal').modal('show');
            }
        );
        hideContextMenu();
        return false;
    });

</script>