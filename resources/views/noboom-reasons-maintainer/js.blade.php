<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(document).ready(function () {
        $('#template').summernote({
            height: 100,                 // set editor height
            minHeight: 100,             // set minimum height of editor
            maxHeight: null,             // set maximum height of editor
            // focus: true,                  // set focus to editable area after initializing summernote
            toolbar: [
                ['text', ['bold', 'italic', 'underline', 'clear', 'color']],
                ['para', ['paragraph', 'ul', 'ol']],
                ['misc', ['fullscreen', 'codeview', 'undo', 'redo']]
            ]
        });
    });

    $('#add-new-btn').click(function () {
        $('#noboom-reason-modal .modal-title').text('New No-Boom Reason');
        $('#noboom-reason,#template-name').val('');
        $('#template').summernote('code', '');
        $('#save-noboom-reason-btn').data('id',0);
        $('#noboom-reason-modal').modal('show');
    });

    $('.edit-btn').click(function () {
        $('#noboom-reason-modal .modal-title').text('Edit No-Boom Reason');
        var parent_tr=$(this).parents('tr:eq(0)');
        $('#noboom-reason').val($.trim(parent_tr.find('td:eq(0)').text()));
        $('#template-name').val($.trim(parent_tr.find('td:eq(1)').text()));
        $('#template').summernote('code', $(this).data('template'));
        $('#save-noboom-reason-btn').data('id',$(this).data('id'));
        $('#noboom-reason-modal').modal('show');
    });

    $('#save-noboom-reason-btn').click(function () {
        $('#noboom-reason-modal').modal('hide');
        $('#tmfwaiting400_modal').modal('show');
        $.post(
            '/noboom-reasons-maintainter/save',
            {
                id:$(this).data('id'),
                noboom_reason:$.trim($('#noboom-reason').val()),
                template_name:$.trim($('#template-name').val()),
                template:$('#template').summernote('code')
            },
            function (msg) {
                setTimeout(function () {
                    $('#tmfwaiting400_modal').modal('hide');
                }, 500);
                if (msg.length) {
                    $('.sys-message .toast-body').text('Done!');
                    location.reload();
                } else {
                    $('.sys-message .toast-body').text('Unknown error during saving data!');
                    $('#noboom-reason-modal').modal('show');
                }
                $('.sys-message').toast('show');
            }
        );
    });

</script>