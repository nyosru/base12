<script>
    function moveCursorToEnd(el) {
        if (typeof el.selectionStart == 'number') {
            el.selectionStart = el.selectionEnd = el.value.length;
        } else if (typeof el.createTextRange != 'undefined') {
            el.focus();
            var range = el.createTextRange();
            range.collapse(false);
            range.select();
        }
    }

    function printDate() {
        return moment().tz('America/Los_Angeles').format('YYYY-MM-DD HH:mm');
    }

    function addDateToEl(el_str) {
        var txt = "\r\n\r\n" + $('#' + el_str).val();
        $('#' + el_str).val(printDate() + ' {{\Illuminate\Support\Facades\Auth::user()->LongID}}:');
        moveCursorToEnd(document.getElementById(el_str));
        $('#' + el_str).val($('#' + el_str).val() + txt);
    }

    $('body').on('click', '#add-date', function () {
        addDateToEl('notes');
        return false;
    });

    $('body').on('click', '#add-date-alt', function () {
        addDateToEl('notes-alt');
        return false;
    });

    $('body').on('click', '.dashboard-notes-link', function () {
        $('#tmfwaiting400_modal').modal('show');
        let dashboard_id = $(this).data('dashboard-id');
        $.post(
            '/queue/load-dashboard-notes',
            {id: dashboard_id},
            function (msg) {
                setTimeout(function () {
                    $('#tmfwaiting400_modal').modal('hide');
                }, 1000);
                $('#notes-alt').val(msg);
                $('#save-notes-data').data('dashboard-id', dashboard_id);
                $('#notes-modal').modal('show');
            }
        );
        hideContextMenu();
        return false;
    });

    $('#save-notes-data').click(function () {
        $('#notes-modal').modal('hide');
        $('#tmfwaiting400_modal').modal('show');
        $.post(
            '/queue/save-dashboard-notes',
            {
                id: $('#save-notes-data').data('dashboard-id'),
                notes: $.trim($('#notes-alt').val())
            },
            function (msg) {
                setTimeout(function () {
                    $('#tmfwaiting400_modal').modal('hide');
                }, 1000);
                if (msg.length) {
                    $('.sys-message .toast-body').text('Saved');
                } else {
                    $('.sys-message .toast-body').text('Unknown error during saving dashboard notes!');
                    setTimeout(function () {
                        $('#notes-modal').modal('show');
                    }, 1000);
                }
                $('.sys-message').toast('show');
            }
        );
    });
</script>