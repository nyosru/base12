@include('common-queue.js-with-tss-list')

<script>
    $('.queue-type-list').change(function () {
        $.post(
            '/change-queue-status/queue-type-statuses',
            {queue_type_id:$(this).val()},
            function (msg) {
                if(msg.length){
                    $('#change-status-modal .modal-body').html(msg);
                    $('.tss-list').html('');
                }else{
                    new Noty({
                        type: 'error',
                        layout: 'topRight',
                        text: 'Error during loading queue type statuses!',
                        timeout: 1500
                    }).show();
                }
            }
        );
    });
</script>
@include('common-queue.change-status-js')