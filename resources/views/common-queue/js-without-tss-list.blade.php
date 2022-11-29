<script>
    $('body').on('click','.s-status',function () {
        $.post(
            '/change-queue-status/load-tss-template-id',
            {id:$(this).data('id')},
            function (msg) {
                if(msg.length){
                    $('#change-status-modal .tss-list').val(msg);
                }else{
                    $('#change-status-modal .tss-list').val('');
                    new Noty({
                        type: 'error',
                        layout: 'topRight',
                        text: 'Error during loading tss template id!',
                        timeout: 1500
                    }).show();
                }
            }
        );
    });
</script>