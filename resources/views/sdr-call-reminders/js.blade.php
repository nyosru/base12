<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    let current_user='{{\Illuminate\Support\Facades\Auth::user()->LongID}}';
    let allow_refresh=1;

    function setNewStatus(status,tmf_booking_id) {
        $.post(
            '/sdr-call-reminders/new-status',
            {status:status,tmf_booking_id:tmf_booking_id},
            function (msg) {
                if(msg.length==0){
                    $('.sys-message .toast-body').text('Unknown error during changing status!');
                    $('.sys-message').toast('show');
                }
            }
        );
    }

    function drop(event,ui){
        console.log(ui);
        let parent_div=ui.item.parents('div:eq(0)');
        if(parent_div.hasClass('u-calls')){
            ui.item.find('small:eq(0)').text('');
            setNewStatus('unhandled',ui.item.data('id'));
            // ui.item.find('small.notes:eq(0)').hide();
        }else
            if(parent_div.hasClass('ip-calls')){
                ui.item.find('small:eq(0)').text(current_user);
                setNewStatus('in progress',ui.item.data('id'));
                // ui.item.find('small.notes:eq(0)').show();
            }else
                if(parent_div.hasClass('finished-calls')){
                    ui.item.find('small:eq(0)').text(current_user);
                    setNewStatus('finished',ui.item.data('id'));
                    // ui.item.find('small.notes:eq(0)').show();
                }
        allow_refresh=1;
    }

    function initSortable() {
        $( "#u-calls, #ip-calls,#finished-calls" ).sortable({
            connectWith: ".connected-div",
            placeholder: "block-hl",
            sort:function(event,ui){allow_refresh=0;},
            stop: function( event, ui ) {drop(event,ui);}
        });
        $( "#u-calls, #ip-calls,#finished-calls" ).disableSelection();
    }
    
    function refreshCurrentProgress(){
        if(allow_refresh)
            $.get(
                '/sdr-call-reminders/get-current-progress',
                function (msg) {
                    if(allow_refresh) {
                        $('.card-body').html(msg);
                        initSortable();
                        setTimeout(function () {
                            refreshCurrentProgress();
                        }, 1000);
                    }else
                        setTimeout(function () {
                            refreshCurrentProgress();
                        }, 1000);
                }
            );
        else
            setTimeout(function () {
                refreshCurrentProgress();
            },1000);

    }

    initSortable();
/*    setTimeout(function () {
        refreshCurrentProgress();
    },1000);*/

    $('body').on('click','.list-group-item.list-group-item-action',function () {
        return false;
    });

    $('body').on('click', '.fas.fa-sticky-note', function (e) {
        allow_refresh=0;
        $('#tmfwaiting400_modal').modal('show');
        $('#save-notes-data').data('id', $(this).data('tmoffer-id'));
        $.post(
            '/bookings-calendar/load-notes',
            {tmoffer_id: $(this).data('tmoffer-id')},
            function (msg) {
                setTimeout(function () {
                    $('#tmfwaiting400_modal').modal('hide');
                }, 1000);

                $('#notes-alt').val(msg);
                $('#notes-modal').modal('show');
            }
        );

        e.stopPropagation();
        return false;
    });


    $('#save-notes-data').click(function () {
        $('#notes-modal').modal('hide');
        $('#tmfwaiting400_modal').modal('show');
        $.post(
            '/bookings-calendar/save-notes',
            {
                tmoffer_id: $('#save-notes-data').data('id'),
                notes: $.trim($('#notes-alt').val())
            },
            function (msg) {
                setTimeout(function () {
                    $('#tmfwaiting400_modal').modal('hide');
                }, 1000);
                if (msg.length) {
                    $('.sys-message .toast-body').text('Saved');
                    allow_refresh=1;
                } else {
                    $('.sys-message .toast-body').text('Unknown error during saving notes for client!');
                    setTimeout(function () {
                        allow_refresh=0;
                        $('#notes-modal').modal('show');
                    }, 1000);
                }
                $('.sys-message').toast('show');
            }
        );
    });

    $('#notes-modal').on('hidden.bs.modal', function (event) {
        allow_refresh=1;
    });

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
        $('#' + el_str).val(printDate() + ' {{Auth::user()->LongID}}:');
        moveCursorToEnd(document.getElementById(el_str));
        $('#' + el_str).val($('#' + el_str).val() + txt);
    }

    $('body').on('click','#add-date-alt',function () {
        addDateToEl('notes-alt');
        return false;
    });


    $('body').on('click','.fas.fa-user-clock',function () {
        var win = window.open('https://trademarkfactory.com/mlcclients/sdr-manual-rebooking.php?id='+$(this).data('tmoffer-id'), '_blank');
        win.focus();
    });

    $('#calls-history-link').click(function () {
        $('#tmfwaiting400_modal').modal('show');
        $.get(
            '/sdr-call-reminders/get-calls-history',
            function (msg) {
                setTimeout(function () {
                    $('#tmfwaiting400_modal').modal('hide');
                }, 1000);
                if (msg.length) {
                    $('#client-name-filter').val('');
                    $('#sdr-name-filter').val(-1);
                    $('#history-table').html(msg);
                    $('#calls-history-modal').modal('show');
                } else {
                    $('.sys-message .toast-body').text('Unknown error during loading history calls!');
                    $('.sys-message').toast('show');
                }
            }
        );
        return false;
    });

    function callsHistoryApplyFilters(){
        $('.calls-history-row').each(function () {
            let sdr_filter_show=1;
            if($('#sdr-name-filter').val()!=-1 &&
                Number($('#sdr-name-filter').val())!=Number($(this).data('sdr-id')))
                sdr_filter_show=0;
            let client_name_filter_show=1;
            let clname=$.trim($('#client-name-filter').val());
            let row_clname=$.trim($(this).find('.client-name:eq(0)').text());
            if(clname.length &&
                row_clname.toLowerCase().indexOf(clname.toLowerCase())==-1)
                client_name_filter_show=0;
            if(sdr_filter_show && client_name_filter_show)
                $(this).show();
            else
                $(this).hide();
        });
    }

    $('#sdr-name-filter').change(function () {
        callsHistoryApplyFilters();
    });

    $('#client-name-filter').keyup(function () {
        callsHistoryApplyFilters();
    });
</script>