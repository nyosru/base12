<script>
    $('body').on('click','{{$selector}}',function () {
        let id=$(this).data('id');
        $.get(
            '/sms-sender/load-message/'+id,
            function (msg) {
                if(msg.length){
                    let obj=JSON.parse(msg);
                    if(obj.html.length){
                        $('#send-sms-btn').data('id',id);
                        $('#send-sms-btn').show();
                        $('#sms-sender-modal .modal-body').html(obj.html);
                        $('#send-sms-to').text(' to '+obj.phone);
                        $('#sms-sender-modal').modal('show');
                    }else{
                        $('#sms-sender-modal .modal-body').html('<p class="text-center">This client does not have phone number</p>');
                        $('#send-sms-btn').data('id',0);
                        $('#send-sms-btn').hide();
                        $('#sms-sender-modal').modal('show');
                    }
                }else
                    alert('Error during loading message for SMS sender!');
            }
        );
        return false;
    });

    $('body').on('click','#send-sms-btn',function () {
        $.post(
            '/sms-sender/send',
            {
                id:$(this).data('id'),
                message:$.trim($('#sms-text').val())
            },
            function (msg) {
                if(msg.length){
                    $('#sms-sender-modal').modal('hide');
                }else
                    alert('Unknown error during sending message!');
            }
        );
    });
</script>