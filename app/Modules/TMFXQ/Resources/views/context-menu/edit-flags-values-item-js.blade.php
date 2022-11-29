<script>
    $('#warning-at-datetimepicker,#danger-at-datetimepicker').datetimepicker({
        format:'YYYY-MM-DD HH:mm'
    });

    $('body').on('click', '.edit-flags-values-link', function () {
        $('#save-flag-values-btn').data('dashboard-id', $(this).data('dashboard-id'));
        $('#danger-at').val($(this).data('danger-at'));
        $('#warning-at').val($(this).data('warning-at'));
        hideContextMenu();
        $('#edit-flags-values-modal').modal('show');
        return false;
    });

    $('#save-flag-values-btn').click(function () {
        $('#edit-flags-values-modal').modal('hide');
        let dashboard_id = $(this).data('dashboard-id');
        $.post(
            '/queue/change-flags-values',
            {
                dashboard_id:dashboard_id,
                warning_at:$.trim($('#warning-at').val()),
                danger_at:$.trim($('#danger-at').val())
            },
            function (msg) {
                if (msg.length) {
                    //loadSubStatusTms(id);
                } else {
                    setTimeout(function () {
                        // $('#tmfwaiting400_modal').modal('hide');
                        $('#edit-flags-values-modal').modal('show');
                    }, 1000);
                    new Noty({
                        type: 'error',
                        layout: 'topRight',
                        text: 'Unknown error during changing flags values!',
                        timeout: 1500
                    }).show();
                }
            }
        );

    });

</script>