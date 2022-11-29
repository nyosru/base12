<script>
    $('body').on('click','.s-status',function () {
        $.post(
            '/change-queue-status/load-tss-list',
            {id:$(this).data('id')},
            function (msg) {
                if(msg.length){
                    $('#change-status-modal .tss-list').html(msg);
                }else{
                    $('#change-status-modal .tss-list').html('');
                    new Noty({
                        type: 'error',
                        layout: 'topRight',
                        text: 'Error during loading tss list!',
                        timeout: 1500
                    }).show();
                }
            }
        );
    });
</script>