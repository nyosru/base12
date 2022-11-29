<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    let restrict_for_closers={!! json_encode($restrict_for_closers) !!};
    let max_inprogress={{$max_inprogress}};

    function resizeApplicationsListBlockHeight() {
        let wh=$(window).height();
        // let alb=$('#myTabContent').offset();
        let alb=$('#apps-list-block').offset();
        let delta=($('#filter-str').is(':visible')?40:0);
        $('#unclaimed,#inprogress,#finished,#hot,#boomopportunities').css({
            'height':wh-
            $('#pq-list-block .card-header:eq(0)').outerHeight()*$('#pq-list-block .card-header').length-
            alb.top-30-delta,
            'overflow':'hidden auto'
        });
        if($('#prospect-answers').is(':visible')) {
            let h=$('#prospect-answers').parents('.row:eq(0)').outerHeight() +
                ($('#apps-list-block').outerHeight() - $('#client-data').outerHeight())-3;
            if(h<160)
                h=160;
            $('#prospect-answers').parents('.card.shadow-lg:eq(0)').height(h);
            $('#prospect-answers').css('max-height', 'max-content');
        }
    }
    
    function loadUnclaimedItems(){
        $.get(
            '/pq-applications/unclaimed-items',
            function (msg) {
                $('#unclaimed-content').html(msg);
                if($('#unclaimed-content li.pq-application[data-id="'+current_pq_id+'"]').length){
                    $('#unclaimed-count .pq-application').css('background','');
                    $('#unclaimed-content li.pq-application[data-id="'+current_pq_id+'"]').css('background','orange');
                }
                $('#unclaimed-count').text($('#unclaimed-content li').length);
                if($('.collapse.show').length)
                    resizeApplicationsListBlockHeight();
            }
        );
    }
    function loadBoomOpportunitiesItems(){
        $.get(
            '/pq-applications/boom-opportunities-items',
            function (msg) {
                $('#boomopportunities-content').html(msg);
                if($('#boomopportunities-content li.pq-application[data-id="'+current_pq_id+'"]').length){
                    $('#boomopportunities-count .pq-application').css('background','');
                    $('#boomopportunities-content li.pq-application[data-id="'+current_pq_id+'"]').css('background','orange');
                }
                $('#boomopportunities-count').text($('#boomopportunities-content li').length);
                if($('.collapse.show').length)
                    resizeApplicationsListBlockHeight();
            }
        );
    }
    function loadHotItems(){
        $.get(
            '/pq-applications/hot-items',
            function (msg) {
                $('#hot-content').html(msg);
                if($('#hot-content li.pq-application[data-id="'+current_pq_id+'"]').length){
                    $('#hot-count .pq-application').css('background','');
                    $('#hot-content li.pq-application[data-id="'+current_pq_id+'"]').css('background','orange');
                }
                $('#hot-count').text($('#hot-content li').length);
                if($('.collapse.show').length)
                    resizeApplicationsListBlockHeight();
            }
        );
    }
    function loadInprogressItems(){
        $.get(
            '/pq-applications/inprogress-items',
            function (msg) {
                $('#inprogress-content').html(msg);
                if($('#inprogress-content li.pq-application[data-id="'+current_pq_id+'"]').length){
                    $('#inprogress-content .pq-application').css('background','');
                    $('#inprogress-content li.pq-application[data-id="'+current_pq_id+'"]').css('background','orange');
                }
                $('#inprogress-count').text($('#inprogress-content li').length);
                resizeApplicationsListBlockHeight();
            }
        );
    }

    function paintLegendPoints(ids) {
        $.post(
            '/pq-applications/paint-legend-points',
            {ids:JSON.stringify(ids)},
            function (msg) {
                if(Object.keys(msg).length){
                    $.each(msg,function (i,val) {
                        $('.pq-application[data-id="'+val.id+'"').find('.legend-point.not-painted').
                            removeClass('not-painted').
                            addClass(val.class);
                    });
                }else{
                    new Noty({
                        type: 'error',
                        layout: 'topRight',
                        text: 'Unknown error during getting colors for legend points!',
                        timeout: 1500
                    }).show();
                }
            }
        );
    }

    function loadFinishedItems(){
        loading_fisihed_content=1;
        $.post(
            '/pq-applications/finished-items',
            {offset:finished_loaded},
            function (msg) {
                finished_loaded+=finished_offset;
                loading_fisihed_content=0;
                $('#finished-content').append(msg.html);
                if($('#finished-content li.pq-application[data-id="'+current_pq_id+'"]').length){
                    $('#finished-content .pq-application').css('background','');
                    $('#finished-content li.pq-application[data-id="'+current_pq_id+'"]').css('background','orange');
                }
                if(msg.ids.length)
                    paintLegendPoints(msg.ids);
                $('#finished-count').text(msg.count);
                resizeApplicationsListBlockHeight();
            }
        );
    }

    $(window).resize(function () {
        if($('.curtain').is(':visible'))
            paintCurtain();
        resizeApplicationsListBlockHeight();
    });

    let current_tab='unclaimed-tab';
    let current_pq_id=0;
    let current_status='';
    let interval;
    let current_status_checking_interval=3000;
    let finished_loaded=0;
    let finished_offset={{$finished_offset}};
    let loading_fisihed_content=0;
    let filter_search_btn_clicked=0;
    let current_user={{session('current_user')}};

    $('#pq-list-block').on('shown.bs.collapse', function () {
        current_tab = $(this).find('.collapse.show').attr('id');
        switch (current_tab) {
            case 'unclaimed-tab':
                $('.filter-block').css('display', 'none');
                loadUnclaimedItems();
                break;
            case 'hot-tab':
                $('.filter-block').css('display', 'none');
                loadHotItems();
                break;
            case 'inprogress-tab':
                $('.filter-block').css('display', 'none');
                loadInprogressItems();
                break;
            case 'boomopportunities-tab':
                $('.filter-block').css('display', 'none');
                loadBoomOpportunitiesItems();
                break;
            case 'finished-tab':
                $('.filter-block').css('display', 'flex');
                if (finished_loaded == 0 && filter_search_btn_clicked == 0)
                    loadFinishedItems();
                break;
        }
    });

    // resizeApplicationsListBlockHeight();
    loadUnclaimedItems();
    loadHotItems();

    function loadEmailsBlock(){
        $.get(
            '/pq-applications/load-emails/'+current_pq_id,
            function (msg) {
                $('#emails-block').html(msg);
            }
        );
    }


    function paintCurtain() {
        let offset=$('#client-data').offset();
        $('.curtain').css({
            'top': offset.top - 10,
            'left':offset.left-10,
            'width':$('#client-data').width()+20,
            'height':$('#client-data').height()+20
        });
        $('.curtain').show();
    }



    function applicationClaimedByAnotherUser(user_fn) {
        $('.modal:visible').modal('hide');
        $('.curtain-message-block').text('Application claimed by '+user_fn);
        paintCurtain();
        // alert('this application claimed by another user');
    }

    function checkRestrictions() {
/*        var inprogress_total=Number($.trim($('#inprogress-count').text()))+
            Number($.trim($('#boomopportunities-count').text()));*/
        var inprogress_total=Number($.trim($('#inprogress-count').text()));
        if(
            restrict_for_closers.indexOf(current_user)!=-1 &&
            (current_status=='unclaimed' || current_status=='hot') &&
            inprogress_total>max_inprogress
        )
            $('.edit-claimed-request').hide();
        else {
            if(current_status=='boom-opportunities')
                $('.edit-claimed-request').hide();
            else
                $('.edit-claimed-request').show();
        }
    }

    function checkCurrentApplicationStatus(){
        if(current_status=='unclaimed' || current_status=='hot') {
            // loadEmailsBlock();
            // loadNotes();
            $.get(
                '/pq-applications/check-application-status/' + current_pq_id,
                function (msg) {
                    if (Object.keys(msg).length) {
                        if (msg.status == 'unclaimed')
                            setTimeout(function () {
                                checkCurrentApplicationStatus();
                            }, current_status_checking_interval);
                        else if (msg.tmfsales !=current_user)
                            applicationClaimedByAnotherUser(msg.tmfsales_fn);
                        else {
                            current_status = msg.status;
                            loadRequestDetails();
                            loadClientInfo();
                            loadProspectAnswers();
                            loadNotes();
                            loadEmailsBlock();
                        }

                        checkRestrictions();
                    } else
                        new Noty({
                            type: 'error',
                            layout: 'topRight',
                            text: 'Unknown error during checking status of current pq-application!',
                            timeout: 1500
                        }).show();
                }
            );
        }
    }

    function loadRequestDetails(){
        $.get(
            '/pq-applications/request-details/'+current_pq_id,
            function (msg) {
                if(Object.keys(msg).length){
                    $('#rd-from').text(msg.from);
                    $('#rd-first-page').html(msg.first_page);
                    $('#rd-offer').html(msg.offer);
                }else{
                    new Noty({
                        type: 'error',
                        layout: 'topRight',
                        text: 'Unknown error during loading request details!',
                        timeout: 1500
                    }).show();
                }
            }
        );
    }

    function loadClientInfo(){
        $.get(
            '/pq-applications/client-info/'+current_pq_id,
            function (msg) {
                if(Object.keys(msg).length){
                    let html='';
                    if(msg.tmoffer.length) {
                        html+=msg.client_fn + ' <a href="https://trademarkfactory.com/mlcclients/pq-manual-booking.php?id=' + current_pq_id + '" class="book-a-call" title="Click to book a call from our end" target="_blank"><i class="fas fa-calendar-plus" style="color:green"></i></a>' +
                            ' <a href="https://trademarkfactory.com/shopping-cart/' + msg.tmoffer + '&donttrack=1" target="_blank"><i class="fas fa-shopping-cart"></i></a>';
                        if(Number(msg.lead_status_id==7))
                            html+=' <a href="#" id="report-call-link" data-tmoffer-id="'+msg.tmoffer_id+'"><i class="fas fa-poo"></i></a>';
                    }else
                        html+=msg.client_fn+' <a href="https://trademarkfactory.com/mlcclients/pq-manual-booking.php?id='+current_pq_id+'" class="book-a-call" title="Click to book a call from our end" target="_blank"><i class="fas fa-calendar-plus" style="color:green"></i></a>';
                    $('#client-fn').html(html+' <a href="#" id="edit-tmf-subject"><i class="fas fa-user-edit"></i></a>');
                    $('#client-fn').data('firstname',msg.client_firstname);
                    $('#client-fn').data('lastname',msg.client_lastname);
                    $('#client-email').html(msg.client_email);
                    $('#client-phone').html(msg.client_phone);
                    $('#send-sms-btn').data('id',msg.tmf_subject_id);
                }else{
                    new Noty({
                        type: 'error',
                        layout: 'topRight',
                        text: 'Unknown error during loading clients data!',
                        timeout: 1500
                    }).show();
                }
            }
        );
    }

    $('body').on('click','#edit-tmf-subject',function () {
        $('#client-firstname').val($('#client-fn').data('firstname'));
        $('#client-lastname').val($('#client-fn').data('lastname'));
        $('#c-email').val($.trim($('#client-email').text()));
        $('#c-phone').val($.trim($('#client-phone').text()));
        $('#email-tmf-subject-attr-modal').modal('show');
        return false;
    });

    $('#email-tmf-subject-attr-save-btn').click(function () {
        $('#email-tmf-subject-attr-modal').modal('hide');
        $('#tmfwaiting400_modal').modal('show');
        $.post(
            location.pathname+'/save-tmf-subject-attr',
            {
                id:$('#send-sms-btn').data('id'),
                firstname:$.trim($('#client-firstname').val()),
                lastname:$.trim($('#client-lastname').val()),
                email:$.trim($('#c-email').val()),
                phone:$.trim($('#c-phone').val())
            },
            function (msg) {
                setTimeout(function () {
                    $('#tmfwaiting400_modal').modal('hide');
                }, 1000);
                if(msg.length){
                    new Noty({
                        type: 'success',
                        layout: 'topRight',
                        text: 'Saved',
                        timeout: 1500
                    }).show();
                    loadClientInfo();
                }else{
                    new Noty({
                        type: 'error',
                        layout: 'topRight',
                        text: 'Unknown error during saving lead personal data!',
                        timeout: 1500
                    }).show();
                    $('#email-tmf-subject-attr-modal').modal('show');
                }
            }
        );
    });

    function loadProspectAnswers(){
        $.get(
            '/pq-applications/prospect-answers/'+current_pq_id,
            function (msg) {
                if(msg.length){
                    $('#prospect-answers').html(msg);
                }else{
                    new Noty({
                        type: 'error',
                        layout: 'topRight',
                        text: 'Unknown error during loading prospect answers!',
                        timeout: 1500
                    }).show();
                }
            }
        );
    }

    function loadNotes(){
        $.get(
            '/pq-applications/load-notes/'+current_pq_id,
            function (msg) {
                $('#notes').val(msg);
            }
        );
    }

    function loadCurrentStatus(){
        $.get(
            '/pq-applications/load-current-status/'+current_pq_id,
            function (msg) {
                if (Object.keys(msg).length) {
                    $('#current-status').text(msg.status);
                    $('#booking-info-block').html(msg.booking_info);
                }else
                    new Noty({
                        type: 'error',
                        layout: 'topRight',
                        text: 'Unknown error during loading current status and booking info!',
                        timeout: 1500
                    }).show();
            }
        );
    }

    $('body').on('click','.pq-application',function () {
        $('.pq-application').css('background','');
        $(this).css('background','orange');
        current_pq_id=Number($(this).data('id'));
        current_status=$(this).data('status');
        if(current_status=='unclaimed' || current_status=='hot') {
            setTimeout(function () {
                checkCurrentApplicationStatus();
            }, current_status_checking_interval);
            $('#current-status').text('Unclaimed');
        }else
            loadCurrentStatus();
        checkRestrictions();
        loadRequestDetails();
        loadClientInfo();
        loadProspectAnswers();
        loadNotes();
        loadEmailsBlock();
        if($('.curtain').is(':visible'))
            $('.curtain').hide();
        $('#client-data').show();
        $('#prospect-answers').parents('.card.shadow-lg:eq(0)').height(
            $('#prospect-answers').parents('.row:eq(0)').outerHeight()+
            ($('#apps-list-block').outerHeight()-$('#client-data').outerHeight())-3
        );
        $('#prospect-answers').css('max-height','max-content');
/*        setTimeout(function () {
            $('#applications-list-block').height($('#client-data').height()-10);
        },500);*/
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

    $('body').on('click','.add-date-btn',function () {
        addDateToEl('notes');
        return false;
    });

    $('body').on('click','#add-date-alt',function () {
        addDateToEl('notes-alt');
        return false;
    });

    $('body').on('click','.save-notes-btn',function () {
        $('#tmfwaiting400_modal').modal('show');
        $.post(
            '/pq-applications/save-notes/'+current_pq_id,
            {notes:$.trim($('#notes').val())},
            function (msg) {
                setTimeout(function () {
                    $('#tmfwaiting400_modal').modal('hide');
                }, 1000);
                if(msg.length)
                    new Noty({
                        type: 'success',
                        layout: 'topRight',
                        text: 'Saved',
                        timeout: 1500
                    }).show();
                else
                    new Noty({
                        type: 'error',
                        layout: 'topRight',
                        text: 'Unknown error during saving notes!',
                        timeout: 1500
                    }).show();
            }
        );
    });

    $('body').on('click', '.show-email-details', function () {
        $('#tmfwaiting400_modal').modal('show');
        $.post(
            '/booking-applications/show-email-details',
            {id: $(this).data('id')},
            function (msg) {
                setTimeout(function () {
                    $('#tmfwaiting400_modal').modal('hide');
                }, 1000);
                if (msg.length) {
                    $('#client-data-modal .modal-dialog').addClass('modal-lg');
                    $('#client-data-modal .modal-title').html('Email Details');
                    $('#client-data-modal .modal-body').html(msg);
                    $('#client-data-modal').modal('show');
                } else {
                    new Noty({
                        type: 'error',
                        layout: 'topRight',
                        text: 'Unknown error during loading email details!',
                        timeout: 1500
                    }).show();
                }
            }
        );
        return false;
    });

    let email='';

    $('#my-message').summernote({
        height: 250,                 // set editor height
        minHeight: 250,             // set minimum height of editor
        maxHeight: null,             // set maximum height of editor
        // focus: true,                  // set focus to editable area after initializing summernote
        toolbar: [
            ['text', ['link', 'bold', 'italic', 'underline', 'clear', 'color']],
            ['para', ['paragraph', 'ul', 'ol']],
            ['misc', ['fullscreen', 'codeview', 'undo', 'redo']]
        ],
        callbacks: {
            onPaste: function (e) {
                var bufferText = ((e.originalEvent || e).clipboardData || window.clipboardData).getData('text/html');
                e.preventDefault();
                var div = $('<div />');
                div.append(bufferText);
                div.find('*').removeAttr('style');
                setTimeout(function () {
                    document.execCommand('insertHtml', false, div.html());
                }, 10);
            }
        }
    });

    $('body').on('click', '.follow-up-btn', function () {
        email = 'follow-up-email';
        $.post(
            '/booking-applications/follow-up-email',
            {id: current_pq_id},
            function (msg) {
                if (Object.keys(msg).length) {
                    $('#email-to-client-modal .modal-title').text('Follow-Up Email');
                    $('#my-email').val(msg.email);
                    $('#my-who').val(current_user);
                    $('#my-subject').val(msg.subj);
                    $('#my-message').summernote('code', msg.message);
                    $('#email-to-client-modal').modal('show');
                } else {
                    $('.sys-message .toast-body').text('Unknown error during loading data for follow-up email!');
                    $('.sys-message').toast('show');
                }
            }
        );
    });

    $('body').on('click', '.approve-for-booking-btn', function () {
        email = 'approve-for-booking';
        // $('#client-file-modal').modal('hide');
        $.post(
            '/booking-applications/approve-for-booking',
            {id: current_pq_id},
            function (msg) {
                if (Object.keys(msg).length) {
                    $('#email-to-client-modal .modal-title').text('Approve for Booking');
                    $('#my-email').val(msg.email);
                    $('#my-who').val(current_user);
                    $('#my-subject').val(msg.subj);
                    $('#my-message').summernote('code', msg.message);
                    $('#email-to-client-modal').modal('show');
                } else {
                    $('.sys-message .toast-body').text('Unknown error during loading data for approving!');
                    $('.sys-message').toast('show');
                }
            }
        );
    });

    $('body').on('click', '.approved-and-booked-btn', function () {
        email = 'approved-and-booked';
        // $('#client-file-modal').modal('hide');
        $.post(
            '/pq-applications/approved-and-booked',
            {id: current_pq_id},
            function (msg) {
                if (Object.keys(msg).length) {
                    if(msg.status=='success') {
                        $('#email-to-client-modal .modal-title').text('Approved&Booked');
                        $('#my-email').val(msg.email);
                        $('#my-who').val(current_user);
                        $('#my-subject').val(msg.subj);
                        $('#my-message').summernote('code', msg.message);
                        $('#email-to-client-modal').modal('show');
                    }else
                        new Noty({
                            type: 'error',
                            layout: 'topRight',
                            text: msg.message,
                            timeout: 1500
                        }).show();

                } else {
                    $('.sys-message .toast-body').text('Unknown error during loading data for approved and booked email!');
                    $('.sys-message').toast('show');
                }
            }
        );
    });

    $('body').on('click', '#email-to-client-send-btn', function () {
        $('#email-to-client-modal').modal('hide');
        $('#tmfwaiting400_modal').modal('show');
        $.post(
            '/booking-applications/send-email',
            {
                email: $.trim($('#my-email').val()),
                who: $('#my-who').val(),
                subj: $.trim($('#my-subject').val()),
                message: $('#my-message').summernote('code'),
                action: email,
                id: current_pq_id,
                notify_by_sms: ($('#notify-by-sms-chbx').prop('checked') ? 1 : 0)
            },
            function (msg) {
                setTimeout(function () {
                    $('#tmfwaiting400_modal').modal('hide');
                }, 1000);
                if (msg.length) {
                    loadEmailsBlock();
                    $('.sys-message .toast-body').text('Done');
                } else {
                    $('.sys-message .toast-body').text('Unknown error during sending email!');
                    $('#email-to-client-modal').modal('show');
                }
                $('.sys-message').toast('show');
            }
        );
    });

    $('body').on('click', '.edit-claimed-request', function () {
        if(current_status=='unclaimed'){
            $('input[name="lead-temp"][value="3"]').prop('checked', true);
            $('#lead-need-tm-1').prop('checked', true);
            $('#lead-knows-tmf-offer-1').prop('checked', true);
            $('#notes-alt').val($('#notes').val());
            $('#claim-pq-btn').data('id', current_pq_id);
            $('#call-report-modal').modal('show');
        }else
        $.get(
            '/pq-applications/load-status-data/'+current_pq_id,
            function (msg) {
                if(Object.keys(msg).length) {
                    $('input[name="lead-temp"][value="' + msg.temperature + '"]').prop('checked', true);
                    $('#lead-need-tm-' + msg.needs_tm).prop('checked', true);
                    $('#lead-knows-tmf-offer-' + msg.knows_offer).prop('checked', true);
                    $('#lead-status').val(msg.lead_status);
                    $('#notes-alt').val($('#notes').val());
                    $('#claim-pq-btn').data('id', current_pq_id);
                    $('#call-report-modal').modal('show');
                }else
                    new Noty({
                        type: 'error',
                        layout: 'topRight',
                        text: 'Unknown error during loading lead details data!',
                        timeout: 1500
                    }).show();
            }
        );
        return false;
    });

    $('body').on('click', '#claim-pq-btn', function () {
        if(!$('#lead-status').val()){
            new Noty({
                type: 'error',
                layout: 'topRight',
                text: 'Lead status not chosen!',
                timeout: 1500
            }).show();
            return false;
        }
        $('#call-report-modal').modal('hide');
        $('#tmfwaiting400_modal').modal('show');
        $.post(
            '/booking-applications/call-report',
            {
                temperature: $('input[name="lead-temp"]:checked').val(),
                needs_tm: $('input[name="lead-need-tm"]:checked').val(),
                knows_offer: $('input[name="lead-knows-tmf-offer"]:checked').val(),
                lead_status: $('#lead-status').val(),
                notes: $.trim($('#notes-alt').val()),
                id: current_pq_id
            },
            function (msg) {
                setTimeout(function () {
                    $('#tmfwaiting400_modal').modal('hide');
                }, 1000);
                if (msg.length) {
                    new Noty({
                        type: 'success',
                        layout: 'topRight',
                        text: 'Saved',
                        timeout: 1500
                    }).show();
                    loadInprogressItems();
                    loadBoomOpportunitiesItems();
                    loadFinishedItems();

                    loadCurrentStatus();
                    loadRequestDetails();
                    loadClientInfo();
                    loadProspectAnswers();
                    loadNotes();
                    loadEmailsBlock();

                } else {
                    new Noty({
                        type: 'error',
                        layout: 'topRight',
                        text: 'Unknown error during saving data!!',
                        timeout: 1500
                    }).show();
                    $('#call-report-modal').modal('show');
                }
            }
        );
    });


    $('#finished').on('scroll',function(){
        if(current_tab=='finished-tab' && filter_search_btn_clicked==0) {
             if($(this).scrollTop()>=Math.round($('#finished-content').height()/2) && loading_fisihed_content==0)
                 loadFinishedItems();
        }
    });

    $('#filter-search-btn').click(function () {
        filter_search_btn_clicked=1;
        $('#tmfwaiting400_modal').modal('show');
        $.post(
            '/pq-applications/search-finished-by-name',
            {name:$.trim($('#filter-str').val())},
            function (msg) {
                setTimeout(function () {
                    $('#tmfwaiting400_modal').modal('hide');
                }, 1000);
                if(Object.keys(msg).length){
                    $('#finished-content').html(msg.html);
                    if($('#finished-content li.pq-application[data-id="'+current_pq_id+'"]').length){
                        $('#finished-content .pq-application').css('background','');
                        $('#finished-content li.pq-application[data-id="'+current_pq_id+'"]').css('background','orange');
                    }
                    if(msg.ids.length)
                        paintLegendPoints(msg.ids);
                    $('#finished-count').text(msg.count);
                }else
                    $('#finished-content').html('<li class="list-group-item text-center">EMPTY</li>');
            }
        );
    });

    $('#filter-reset-btn').click(function () {
        filter_search_btn_clicked=0;
        finished_loaded=0;
        $('#filter-str').val('');
        $('#finished-content').html('');
        loadFinishedItems();
    });

    $('.view-as').click(function () {

        $('#view-as-modal').modal('show');
        return false;
    });
    
    $('#apply-btn').click(function () {
        current_user=$('#view-as-tmfsales').val();
        $('#view-as-tmfsales-fn').text($.trim($('#view-as-tmfsales option:selected').text()));
        $('#view-as-modal').modal('hide');
        $.post(
            '/pq-application/set-current-user',
            {id:current_user},
            function (msg) {
                location.href=location.href;
/*                $('#client-data').hide();
                loadUnclaimedItems();
                loadHotItems();
                loadInprogressItems();
                finished_loaded=0;
                filter_search_btn_clicked=0;
                $('#finished-content').html('');
                $('#filter-str').val('');
                loadFinishedItems();*/
            }
        );
    });

    setInterval(function () {
        loadUnclaimedItems();
        loadHotItems();
    },5000);

    setInterval(function () {
        loadInprogressItems();
        loadBoomOpportunitiesItems();
    },300000);

    resizeApplicationsListBlockHeight();

    function handleSaveBtns(){
        if($('#no-boom-reason option[value="'+$('#no-boom-reason').val()+'"]').length) {
            var email = Number($('#no-boom-reason option[value="' + $('#no-boom-reason').val() + '"]').data('email'));
            if (email) {
                $('#report-call-and-send-email-btn').text('Save Changes and Send Email');
                // $('#report-call-and-send-email-btn').data('id',$('#no-boom-reason').val());
                $('#report-call-and-send-email-btn').show();
                $('#report-call-save-btn').text('Save Changes and Close');
            } else {
                $('#report-call-and-send-email-btn').hide();
                $('#report-call-save-btn').text('Save Changes');
            }
        }else{
            $('#report-call-and-send-email-btn').hide();
            $('#report-call-save-btn').text('Save Changes');
        }
    }

    function initDatePicker(){
        if($("#datepicker").length) {
            var dateFormat = "yy-mm-dd";
            $("#datepicker").datepicker({
                changeMonth: true,
                nextText: '',
                prevText: '',
                numberOfMonths: 1,
                dateFormat: dateFormat,
                minDate: "{{Carbon\Carbon::now()->format('Y-m-d')}}",
                onSelect: function (selected, evnt) {
                    $('#reminder-date-text').text(moment(selected).format('MMMM D, YYYY'));
                    $('#calendar-popup').hide();
                }
            });
            $("#datepicker").datepicker('setDate', $('#reminder-date-text').data('reminder-date'));
        }
    }

    function loadReportCallBody(tmoffer_id){
        $.post(
            '/bookings-calendar/load-report-call-body',
            {tmoffer_id: tmoffer_id},
            function (msg) {
                setTimeout(function () {
                    $('#tmfwaiting400_modal').modal('hide');
                }, 1000);
                if (msg.length) {
                    $('#report-call-modal .modal-body').html(msg);
                    initDatePicker();
                    handleSaveBtns();
                    $('#notes-text').parents('.row:eq(0)').hide();
                    $('#report-call-and-send-email-btn').hide();
                    $('#report-call-modal').modal('show');
                } else {
                    new Noty({
                        type: 'error',
                        layout: 'topRight',
                        text: 'Unknown error during loading report call body!',
                        timeout: 1500
                    }).show();
                }
            }
        );
    }

    $('body').on('click', '#report-call-link', function () {
        $('#tmfwaiting400_modal').modal('show');
        let tmoffer_id=$(this).data('tmoffer-id');
        $('#report-call-save-btn').data('id', tmoffer_id);
        $.get(
            location.pathname+'/load-boom-status/'+tmoffer_id,
            function (msg) {
                if(msg.length){
                    $('#report-call-save-btn').data('action', msg);
                    loadReportCallBody(tmoffer_id);
                }else{
                    new Noty({
                        type: 'error',
                        layout: 'topRight',
                        text: 'Unknown error during loading boom status!',
                        timeout: 1500
                    }).show();
                }
            }

        );
        return false;
    });

    function calculateAndShowReminderDate(add_days) {
        $('#datepicker').datepicker('setDate', moment().add(add_days, 'days').format('YYYY-MM-DD'));
        $('#reminder-date-text').text(moment().add(add_days, 'days').format('MMMM D, YYYY'));
    }

    $('body').on('change','.remind-in-input',function () {
        var val = Number($(this).val());
        if (val == 100) {
            $('#calendar-popup').show();
        } else {
            $('#calendar-popup').hide();
            if (val == -1) {
                $('#reminder-date-text').html('&nbsp;');
                $('#datepicker').datepicker('setDate', null);
            } else
                calculateAndShowReminderDate(val);
        }
    });

    $('body').on('click','label[for="remind-in-option-100"]',function () {
        $('#calendar-popup').show();
    });

    $('body').on('change','input[name="closeable-option"]',function () {
        var value = Number($(this).val());
        if (value == -1) {
            $('#reminder-block').hide();
        } else {
            $('#reminder-block').show();
        }
    });

    function saveBoomReport(){
        $('#report-call-modal').modal('hide');
        $('#tmfwaiting400_modal').modal('show');
        $.post(
            '/bookings-calendar/save-boom-report',
            {
                tmoffer_id:$('#report-call-save-btn').data('id'),
                notes: $.trim($('#notes').val()),
                lead_temp: $('input[name="lead-temp"]:checked').val(),
                lead_need_tm: $('input[name="lead-need-tm"]:checked').val(),
                knows_tmf_offer: $('input[name="lead-knows-tmf-offer"]:checked').val(),
                call_record_url: $.trim($('#call-record-url').val()),
                boom_reason:$.trim($('#boom-reason-text').val())
            },
            function (msg) {
                setTimeout(function () {
                    $('#tmfwaiting400_modal').modal('hide');
                }, 1000);
                if (msg.length) {
                    new Noty({
                        type: 'success',
                        layout: 'topRight',
                        text: 'Saved',
                        timeout: 1500
                    }).show();
                } else {
                    new Noty({
                        type: 'error',
                        layout: 'topRight',
                        text: 'Unknown error during saving BOOM reasons for client!',
                        timeout: 1500
                    }).show();
                    setTimeout(function () {
                        $('#report-call-and-send-email-btn').hide();
                        $('#report-call-modal').modal('show');
                    }, 1000);
                }
                $('.sys-message').toast('show');
            }
        );
    }

    function saveNoBoomReport(){
        $('#report-call-modal').modal('hide');
        $('#tmfwaiting400_modal').modal('show');
        var selected_date = $("#datepicker").datepicker('getDate');
        $.post(
            '/bookings-calendar/save-noboom-reason',
            {
                tmoffer_id: $('#report-call-save-btn').data('id'),
                notes: $.trim($('#notes').val()),
                no_boom_reason: $('#no-boom-reason').val(),
                lead_temp: $('input[name="lead-temp"]:checked').val(),
                lead_need_tm: $('input[name="lead-need-tm"]:checked').val(),
                knows_tmf_offer: $('input[name="lead-knows-tmf-offer"]:checked').val(),
                no_boom_reason_text: $.trim($('#no-boom-reason-text').val()),
                call_record_url: $.trim($('#call-record-url').val()),
                closeable: $('input[name="closeable-option"]:checked').val(),
                closeable_remind: (selected_date == null ? null : moment(selected_date).format('YYYY-MM-DD'))
            },
            function (msg) {
                setTimeout(function () {
                    $('#tmfwaiting400_modal').modal('hide');
                }, 1000);
                if (msg.length) {
                    new Noty({
                        type: 'success',
                        layout: 'topRight',
                        text: 'Saved',
                        timeout: 1500
                    }).show();

                } else {
                    new Noty({
                        type: 'error',
                        layout: 'topRight',
                        text: 'Unknown error during saving noBOOM reasons for client!',
                        timeout: 1500
                    }).show();

                    setTimeout(function () {
                        $('#noboom-reason-modal').modal('show');
                    }, 1000);
                }
            }
        );
    }

    $('#report-call-save-btn').click(function () {
        let lead_status_id=0;
        if($(this).data('action')=='boom') {
            saveBoomReport();
            lead_status_id=8;
        }else {
            if($('#no-boom-reason').val()==''){
                new Noty({
                    type: 'error',
                    layout: 'topRight',
                    text: 'No-BOOM reason did not select!',
                    timeout: 1500
                }).show();
                $('#noboom-reason-modal').modal('show');
                return 0;
            }
            saveNoBoomReport();
            lead_status_id=9;
        }
        $.post(
            location.pathname+'/set-lead-status',
            {id:current_pq_id,lead_status_id:lead_status_id},
            function (msg) {
                if(msg.length){
                    $('#client-data').hide();
                    loadBoomOpportunitiesItems();
                    loadFinishedItems();
                }else{
                    new Noty({
                        type: 'error',
                        layout: 'topRight',
                        text: 'Unknown error during saving new lead status!',
                        timeout: 1500
                    }).show();
                }
            }
        );
    });
</script>
{!! \App\classes\SmsSender::getJs('#send-sms-btn') !!}