<script>
    $('body').on('click', '.remove-request-review-link', function () {
        let dashboard_id = $(this).data('dashboard-id');
        hideContextMenu();
        if (confirm($.trim($(this).text())+'?')) {
            // $('#tmfwaiting400_modal').modal('show');
            let id = $(this).data('queue-status-id');
            $.post(
                '/queue/remove-request-review/'+dashboard_id,
                {queue_status_id:id},
                function (msg) {
                    if (msg.length) {
                        // loadSubStatusTms(id);
                    } else {
                        // setTimeout(function () {
                        //     $('#tmfwaiting400_modal').modal('hide');
                        // }, 1000);
                        new Noty({
                            type: 'error',
                            layout: 'topRight',
                            text: 'Unknown error during removing request review!',
                            timeout: 1500
                        }).show();
                    }
                }
            );
        }
        return false;
    });
</script><?php /**PATH /var/www/html/in.trademarkfactory.com/app/Modules/TMFXQ/Resources/views/context-menu/remove-request-review-item-js.blade.php ENDPATH**/ ?>