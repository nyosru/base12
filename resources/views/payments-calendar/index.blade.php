@extends('layouts.app')

@section('title')
    Payments Calendar
@endsection

@section('content')
    <ul class="dropdown-menu" id="context-menu">
        <li id="client-info-block"></li>
        <li><a class="dropdown-item" href="#" id="add-note-item">Notes</a></li>
        <li><a class="dropdown-item" href="#" id="mark-paid-unpaid-item">Mark as paid</a></li>
        <li><a class="dropdown-item" href="#" id="set-scheduled-email-sent">Set Scheduled Email Sent</a></li>
        <li><a class="dropdown-item" id="send-receipt-item" href="#">Send Receipt</a></li>
        <li><a class="dropdown-item" id="send-expedited-payment-item" href="#">Send Expedited payment email</a></li>
        <li><a class="dropdown-item" id="send-failed-payment-item" href="#">Send Failed payment email</a></li>
        <li><a class="dropdown-item" id="resend-scheduled-email" href="#">Resend scheduled email</a></li>
        <li><a class="dropdown-item" id="edit-scheduled-email" href="#">Edit scheduled email</a></li>
        <li><a class="dropdown-item" href="#" id="block-scheduled-email-sending">Block Sending Scheduled Email</a></li>
        <li><a class="dropdown-item" id="show-in-acceptedagreements" href="#" target="_blank">Show in AcceptedAgreements</a></li>
        <li id="closed-by-block"></li>
    </ul>
    <div class="container-xl">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Payments Calendar</div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-12 text-center">
                                <a href="#" id="boom-sources-link">BOOM Sources: {{Auth::user()->sales_calls?1:count($boom_sources)+1}} of {{count($boom_sources)+1}}</a>
                            </div>
                        </div>
                        <div class="row m-4">
                            <div class="col-md-3">
                                <div class="switch-top">
                                    <input type="radio" class="ready-option-input" name="currency-option" value="CAD" id="currency-cad">
                                    <label for="currency-cad" class="switch-top-label switch-top-label-off">CAD</label>
                                    <input type="radio" class="ready-option-input" name="currency-option" value="USD" id="currency-usd">
                                    <label for="currency-usd" class="switch-top-label switch-top-label-on">USD</label>
                                    <input type="radio" class="ready-option-input" name="currency-option" value="both" id="currency-both" checked>
                                    <label for="currency-both" class="switch-top-label switch-top-label-three">Both</label>
                                    <span class="switch-top-selection"></span>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="switch-top">
                                    <input type="radio" class="ready-option-input" name="paid-option" value="Paid" id="paid-option-paid">
                                    <label for="paid-option-paid" class="switch-top-label switch-top-label-off">Paid</label>
                                    <input type="radio" class="ready-option-input" name="paid-option" value="Unpaid" id="paid-option-unpaid">
                                    <label for="paid-option-unpaid" class="switch-top-label switch-top-label-on">Unpaid</label>
                                    <input type="radio" class="ready-option-input" name="paid-option" value="both" id="paid-option-both" checked>
                                    <label for="paid-option-both" class="switch-top-label switch-top-label-three">Both</label>
                                    <span class="switch-top-selection"></span>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="switch-top">
                                    <input type="radio" class="ready-option-input" name="pnum-option" value="1-Pay" id="pnum-1pay">
                                    <label for="pnum-1pay" class="switch-top-label switch-top-label-off">1-Pay</label>
                                    <input type="radio" class="ready-option-input" name="pnum-option" value="Multipay" id="pnum-multipay">
                                    <label for="pnum-multipay" class="switch-top-label switch-top-label-on">Multipay</label>
                                    <input type="radio" class="ready-option-input" name="pnum-option" value="both" id="pnum-both" checked>
                                    <label for="pnum-both" class="switch-top-label switch-top-label-three">Both</label>
                                    <span class="switch-top-selection"></span>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="switch-top">
                                    <input type="radio" class="ready-option-input" name="status-option" value="Active" id="status-option-active" checked>
                                    <label for="status-option-active" class="switch-top-label switch-top-label-off">Active</label>
                                    <input type="radio" class="ready-option-input" name="status-option" value="Cancelled" id="status-option-cancelled">
                                    <label for="status-option-cancelled" class="switch-top-label switch-top-label-on">Cancelled</label>
                                    <input type="radio" class="ready-option-input" name="status-option" value="both" id="status-option-both">
                                    <label for="status-option-both" class="switch-top-label switch-top-label-three">Both</label>
                                    <span class="switch-top-selection"></span>
                                </div>
                            </div>
                        </div>
                        <div id="payments-calendar"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('modals')
    <div class="modal" id="upload-call-modal" tabindex="-1" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Upload Call</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center">
                    <div class="row recently-uploaded-block" style="font-size:11px;margin-bottom: 20px;">
                        <div class="col-md-12 text-center" id="uploaded-files">NO UPLOADED FILES YET</div>
                    </div>
                    <div class="row" id="upload-files-progress" style="margin-bottom: 15px;display: none;">
                        <div class="col-md-12 text-center">
                            <div class="progress">
                                <div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 0%;">
                                    0%
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="multi-files-dragarea">
                        Drag file here or click to upload
                    </div>
                    <input type="file" name="upfile[]" id="upfiles" multiple="" style="display: none">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" id="upload-call-btn">Start Upload</button>
                </div>
            </div>
        </div>
    </div>
    @include('email-forms.payments-calendar')
    @include('payments-calendar.notes-modal')
    @include('payments-calendar.select-month-modal')
    @include('payments-calendar.boom-sources-modal')

@endsection

@section('external-jscss')
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.1/themes/smoothness/jquery-ui.css">
    <script src="//code.jquery.com/ui/1.11.1/jquery-ui.js" type="text/javascript"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.css" rel="stylesheet">
    <link href="https://trademarkfactory.com/js/noty/lib/noty.css" rel="stylesheet">
    <script type="text/javascript" src="https://trademarkfactory.com/js/noty/lib/noty.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.0.0/main.css"/>
    <script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment.min.js"></script>
    <script src="https://trademarkfactory.com/js/moment-timezone-with-data.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.0.0/main.min.js"></script>
    <script src="{{ asset('tinymce/js/tinymce/tinymce.min.js') }}" type="text/javascript"></script>

    {{--    <link href="{{ asset('jstree/dist/themes/default/style.min.css') }}" rel="stylesheet"/>--}}

    @include('payments-calendar.css')

    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var today='{{$today->format('Y-m-d')}}';
        var current_date='{{$today->format('Y-m-d')}}';
        var prev_date='{{$prev_date}}';
        var next_date='{{$next_date}}';
        var calendar;

        $('.dropdown-menu a.dropdown-toggle').on('click', function(e) {
            if (!$(this).next().hasClass('show')) {
                $(this).parents('.dropdown-menu').first().find('.show').removeClass("show");
            }
            var $subMenu = $(this).next(".dropdown-menu");
            $subMenu.toggleClass('show');


            $(this).parents('li.nav-item.dropdown.show').on('hidden.bs.dropdown', function(e) {
                $('.dropdown-submenu .show').removeClass("show");
            });


            return false;
        });

        function reloadCalendar() {
            $.get(
                '/payments-calendar/load-month-data',
                {start:moment(next_date).add(-1,'month').format('YYYY-MM-DD')},
                function (msg) {
                    calendar.removeAllEventSources();
                    calendar.addEventSource(JSON.parse(msg));
                    applyFilters();
                }
            );
        }

        var show_context_menu=0;
        function calendarClickEventHandler(info) {
            // console.log(info);
            // var win = window.open(info.event.extendedProps['aa-link'], '_blank');
            // win.focus();
            // showContextMenu($contextMenu, info.jsEvent);
        }

        function calendarMouseLeaveEvent(info){
            show_context_menu=0;
        }

        function calendarSelectEventHandler(info) {
            console.log(event);
        }

        var current_info=null;

        function calendarSetCurrentEvent(info){
            //     $contextMenu.hide();
            current_info=info;
            show_context_menu=1;
        }

        function checkEl(filter,el_val){
            var flag=1;
            if(filter!='both')
                if(filter!=el_val)
                    flag=0;
            return flag;
        }

        function calendarEventOrder(arg1,arg2) {
            return (arg1.weight<arg2.weight?-1:1);
        }

        function findObjIndex(objs,bg_color) {
            var result=-1;
            $.each(objs,function (i,val) {
                if(val.bg_color==bg_color)
                    result=i;
            });
            return result;
        }

        function getMoreLinksHtml(objs) {
            var html=[];
            $.each(objs,function (i,val) {
                html.push('<span style="background-color:'+val.bg_color+';color:white;">+'+
                    val.count+
                    '</span>');
            });
            return html.join(' ');
        }


        function renderContentEvent(info){
            // console.log(info);
/*
            var currency=$('input[name="currency-option"]:checked').val();
            var paid=$('input[name="paid-option"]:checked').val();
            var pnum=$('input[name="pnum-option"]:checked').val();

            var flag0=checkEl(currency,info.event.extendedProps.selected_currency);
            var flag1=checkEl(paid,(info.event.extendedProps.invoice_paid?'Paid':'Unpaid'));
            var flag2=checkEl(pnum,info.event.extendedProps.pnum);
*/

/*
            if(flag0 && flag1 && flag2)
                info.event.setProp('display','auto');
            else
                info.event.setProp('display','none');*/
            // info.event.title = info.event.title + '<b>new title</b>';
            var notes_icon='';
            if(info.event.extendedProps.notes.length)
                notes_icon='<span class="float-right" style="color:yellow"><i class="fas fa-sticky-note"></i></span>';

            var bell_icon='';
            if(info.event.extendedProps['email-blocked'])
                bell_icon='<span class="float-right" style="color:black"><i class="fas fa-bell-slash"></i></span>';
            else
                if(info.event.extendedProps['scheduled-email-edited'])
                    bell_icon='<span class="float-right" style="color:black"><i class="fas fa-bell"></i></span>';
            return {
                html: '<div style="display:block;width:100%;cursor:pointer;"><div class="pl-1 pr-1">' + info.event.title + notes_icon+bell_icon+'</div><div class="pl-1 pr-1 bg-white text-dark"><span>' +
                info.event.extendedProps.selected_currency +
                ' $' +
                info.event.extendedProps.amount +
                '</span><span class="float-right">(' +
                info.event.extendedProps.current_invoice_data +
                ')</span></div></div>'
            };
        }

        function redrawMoreLinks() {
            $('.fc-daygrid-day-bottom').each(function () {
                var day_div = $(this).parents('.fc-daygrid-day-events:eq(0)');
                var hidden_divs=day_div.find('.fc-daygrid-event-harness.fc-daygrid-event-harness-abs');
                var objs=[];
                $.each(hidden_divs,function (i,div) {
                    var a_el=$(div).find('a:eq(0)');
                    var index=findObjIndex(objs,a_el.css('background-color'));
                    if(index==-1){
                        var local_obj={
                            bg_color:a_el.css('background-color'),
                            count:0
                        };
                        objs.push(local_obj);
                        index=objs.length-1;
                    }
                    objs[index].count++;
                });
                $(this).find('a:eq(0)').html('+more: '+getMoreLinksHtml(objs));
            });
        }

        function applyFilters(){
            var currency=$('input[name="currency-option"]:checked').val();
            var paid=$('input[name="paid-option"]:checked').val();
            var pnum=$('input[name="pnum-option"]:checked').val();
            var ac=$('input[name="status-option"]:checked').val();

            var boom_sources=[];
            $('.boom-source-chbx:checked').each(function () {
                boom_sources.push(Number($(this).val()));
            });

            $.each(calendar.getEvents(),function (i,val) {
                var flag0=checkEl(currency,val.extendedProps.selected_currency);
                var flag1=checkEl(paid,(val.extendedProps.invoice_paid?'Paid':'Unpaid'));
                var flag2=checkEl(pnum,val.extendedProps.pnum);
                var flag3=checkEl(ac,val.extendedProps['active-status']);

                var flag4=($.inArray(val.extendedProps.boom_source,boom_sources)==-1?0:1);

                if(flag0 && flag1 && flag2 && flag3 && flag4)
                    val.setProp('display','auto');
                else
                    val.setProp('display','none');
            });
            redrawMoreLinks();
        }

        $('.ready-option-input').change(function () {
            applyFilters();
        });


        function setEventClassNames(info) {
            return [
                info.event.extendedProps.selected_currency,
                (info.event.extendedProps.invoice_paid?'Paid':'Unpaid'),
                info.event.extendedProps.pnum
            ];
        }


        var $contextMenu = $("#context-menu");

        function setContextMenuPostion(event, contextMenu) {

            var mousePosition = {};
            var menuPostion = {};
            var menuDimension = {};

            menuDimension.x = contextMenu.outerWidth();
            menuDimension.y = contextMenu.outerHeight();
            mousePosition.x = event.pageX;
            mousePosition.y = event.pageY;

            if (mousePosition.x + menuDimension.x > $(window).width() + $(window).scrollLeft()) {
                menuPostion.x = mousePosition.x - menuDimension.x;
            } else {
                menuPostion.x = mousePosition.x;
            }

            if (mousePosition.y + menuDimension.y > $(window).height() + $(window).scrollTop()) {
                menuPostion.y = mousePosition.y - menuDimension.y;
            } else {
                menuPostion.y = mousePosition.y;
            }

            return menuPostion;
        }

        function showContextMenu(el_menu, e) {
            var html='<div class="p-1 text-center text-white" style="background: '+
                current_info.event.backgroundColor+
                ';display:table;width:100%;height: 36px;line-height:1;"><div style="display:table-cell;vertical-align:middle;">'+
                current_info.event.extendedProps.client+
                '</div></div>';
            $('#client-info-block').html(html);
            var closed_by_html='<div class="p-1 text-center text-white" ' +
                'style="background: #eeb44e;display:table;width:100%;height: 36px;line-height:1;">' +
                '<div style="display:table-cell;vertical-align:middle;color:black">'+
                    current_info.event.extendedProps.boom_source_caption+
                '</div></div>';
            $('#closed-by-block').html(closed_by_html);
            $('#context-menu a').data('tmoffer',current_info.event.id);
            $('#context-menu a').data('firstname',current_info.event.extendedProps['firstname']);
            $('#context-menu a').data('email',current_info.event.extendedProps['email']);
            $('#context-menu a').data('amount',current_info.event.extendedProps['amount']);
            $('#context-menu a').data('selected_currency',current_info.event.extendedProps['selected_currency']);
            $('#context-menu a').data('paid-index',current_info.event.extendedProps['paid_index']);
            $('#context-menu a').data('next-installment',current_info.event.extendedProps['next_installment']);

            $('#add-note-item').data('notes',current_info.event.extendedProps['notes']);

            var arr=current_info.event.extendedProps['current_invoice_data'].split('/');
            var delta=Number(arr[1])-Number(arr[0]);
            if(current_info.event.extendedProps['save_amount']>50 && delta>0)
                $('#send-expedited-payment-item').show();
            else
                $('#send-expedited-payment-item').hide();
            $('#resend-scheduled-email,' +
                '#set-scheduled-email-sent,' +
                '#block-scheduled-email-sending').hide();
            if(current_info.event.extendedProps['invoice_paid']){
                $('#mark-paid-unpaid-item').
                    data('paid',1).
                    text('Mark as unpaid');
                $('#send-receipt-item').show();
            }else{
                $('#mark-paid-unpaid-item').
                    data('paid',0).
                    text('Mark as paid');
                $('#send-receipt-item').hide();
            }
            if(current_info.event.extendedProps['payment-date']<=today){
                $('#edit-scheduled-email').hide();
                if(current_info.event.extendedProps['invoice_paid'])
                    $('#send-failed-payment-item').hide();
                else {
                    $('#send-failed-payment-item').show();
                    $('#resend-scheduled-email').show();
                }
            }else {
                $('#send-failed-payment-item').hide();
                if (current_info.event.extendedProps['invoice_paid'])
                    $('#edit-scheduled-email').hide();
                else {
                    $('#edit-scheduled-email').show();
                    if(current_info.event.extendedProps['payment-date']>moment().add(7,'days').format('YYYY-MM-DD'))
                        $('#block-scheduled-email-sending').show();
                }
            }
            if(current_info.event.extendedProps['email-blocked']) {
                $('#block-scheduled-email-sending').text('Unblock Sending Scheduled Email');
                $('#block-scheduled-email-sending').data('block',0);
            }else {
                $('#block-scheduled-email-sending').text('Block Sending Scheduled Email');
                $('#block-scheduled-email-sending').data('block',1);
            }

            $('#show-in-acceptedagreements').attr('href',current_info.event.extendedProps['aa-link']);

            var d = setContextMenuPostion(e, el_menu);

            el_menu.css({
                display: "block",
                left: d.x,
                top: d.y
            });
        }


        $("body").on("contextmenu", ".fc-daygrid-event-harness", function (e) {
            showContextMenu($contextMenu, e);
            return false;
        });

        $('html').click(function (e) {
            if(show_context_menu)
                showContextMenu($contextMenu, e);
            else
                $contextMenu.hide();
        });

        $('#mark-paid-unpaid-item').click(function () {
            $contextMenu.hide();
            var answer='Mark as paid?';
            if(Number($(this).data('paid')))
                answer='Mark as unpaid?';
            if(confirm(answer)) {
                $('#tmfwaiting400_modal').modal('show');
                $.post(
                    '/payments-calendar/invoice-paid-unpaid',
                    {
                        paid: $(this).data('paid'),
                        paid_index: $(this).data('paid-index'),
                        tmoffer_id: $(this).data('tmoffer')
                    },
                    function (msg) {
                        setTimeout(function () {
                            $('#tmfwaiting400_modal').modal('hide');
                        },500);
                        if (msg.length) {
                            new Noty({
                                type: 'success',
                                layout: 'topRight',
                                text: 'DONE',
                                timeout: 1500
                            }).show();
                            reloadCalendar();
                        } else {
                            new Noty({
                                type: 'error',
                                layout: 'topRight',
                                text: 'Unknown error during changing paid status!',
                                timeout: 1500
                            }).show();
                        }
                    }
                );
            }
            return false;
        });

        $('#block-scheduled-email-sending').click(function () {
            $contextMenu.hide();
            if(confirm($(this).text()+'?'))
                $('#tmfwaiting400_modal').modal('show');
            $.post(
                '/payments-calendar/invoice-block-unblock',
                {
                    block: $(this).data('block'),
                    paid_index: $(this).data('paid-index'),
                    tmoffer_id: $(this).data('tmoffer')
                },
                function (msg) {
                    setTimeout(function () {
                        $('#tmfwaiting400_modal').modal('hide');
                    },500);
                    if (msg.length) {
                        new Noty({
                            type: 'success',
                            layout: 'topRight',
                            text: 'DONE',
                            timeout: 1500
                        }).show();
                        reloadCalendar();
                    } else {
                        new Noty({
                            type: 'error',
                            layout: 'topRight',
                            text: 'Unknown error during changing paid status!',
                            timeout: 1500
                        }).show();
                    }
                }
            );
            return false;
        });

        $(document).ready(function () {
            tinymce.init({
                selector: "#email-text",
                height: 400,
                convert_urls: false,
                theme: "modern",
                plugins: [
                    "advlist autolink link image lists charmap print preview hr anchor pagebreak",
                    "searchreplace wordcount visualblocks visualchars insertdatetime code media nonbreaking",
                    "table contextmenu directionality emoticons paste textcolor"
                ],
                toolbar1: "undo redo | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | styleselect",
                toolbar2: "link unlink anchor | image media | forecolor backcolor  | print preview code ",
                image_advtab: true,
                init_instance_callback : function(editor) {
                }
            });

        });

        var email_body='';

        function setEmailText(){
            var html='<p> Hi '+$.trim($('#dear').val())+',</p>'+email_body;
            tinymce.get('email-text').setContent(html);
        }

        $('#dear').keyup(function () {
            setEmailText();
        });

        $('#send-expedited-payment-item').click(function () {
            $('#dear').val($(this).data('firstname'));
            $('#email').val($(this).data('email'));
            $('#tmfwaiting400_modal').modal('show');
            $.post(
                '/payments-calendar/expedited-payment-email',
                {
                    tmoffer_id: $(this).data('tmoffer'),
                    firstname:$(this).data('firstname'),
                    email:$(this).data('email'),
                },
                function (msg) {
                    setTimeout(function () {
                        $('#tmfwaiting400_modal').modal('hide');
                    },500);
                    if(Object.keys(msg).length){
                        // var obj=JSON.parse(msg);
                        $('#subj').val(msg.subj);
                        email_body=msg.body;
                        setEmailText();
                        $('#email-form-modal .modal-title').text('Expedited payment email');
                        $('#schedule-email-btn').hide();
                        $('#send-email-btn').data('action','send-expedited-payment-email').show();
                        $('#payments-methods').css('display','none');
                        $('#email-form-modal').modal('show');
                    }else {
                        new Noty({
                            type: 'error',
                            layout: 'topRight',
                            text: 'Unknown error during loading expedited payment email text!',
                            timeout: 1500
                        }).show();
                    }

                }
            );
            return false;
        });

        $('#edit-scheduled-email').click(function () {
            $contextMenu.hide();
            $('#tmfwaiting400_modal').modal('show');
            $('#schedule-email-btn').data('tmoffer',$(this).data('tmoffer'));
            $.post(
                '/payments-calendar/scheduled-email',
                {
                    tmoffer_id: $(this).data('tmoffer'),
                    firstname:$(this).data('firstname'),
                    email:$(this).data('email'),
                },
                function (msg) {
                    setTimeout(function () {
                        $('#tmfwaiting400_modal').modal('hide');
                    },500);
                    if(Object.keys(msg).length){
                        // var obj=JSON.parse(msg);
                        $('#subj').val(msg.subj);
                        email_body=msg.body;
                        $('#dear').val(msg.firstname);
                        $('#email').val(msg.email);
                        setEmailText();
                        $('#email-form-modal .modal-title').text('Edit scheduled email');
                        $('#send-email-btn').hide();
                        $('#schedule-email-btn').show();
                        $('#send-email-btn').data('action','schedule-email');
                        $('#payments-methods').css('display','none');
                        $('#email-form-modal').modal('show');
                    }else {
                        new Noty({
                            type: 'error',
                            layout: 'topRight',
                            text: 'Unknown error during loading scheduled email text!',
                            timeout: 1500
                        }).show();
                    }

                }
            );
            return false;
        });

        $('#resend-scheduled-email').click(function () {
            $('#tmfwaiting400_modal').modal('show');
            $('#send-email-btn').data('tmoffer',$(this).data('tmoffer'));
            $.post(
                '/payments-calendar/scheduled-email',
                {
                    tmoffer_id: $(this).data('tmoffer'),
                    firstname:$(this).data('firstname'),
                    email:$(this).data('email'),
                },
                function (msg) {
                    setTimeout(function () {
                        $('#tmfwaiting400_modal').modal('hide');
                    },500);
                    if(Object.keys(msg).length){
                        // var obj=JSON.parse(msg);
                        $('#subj').val('Resending: '+msg.subj);
                        email_body=msg.body;
                        $('#dear').val(msg.firstname);
                        $('#email').val(msg.email);
                        setEmailText();
                        $('#email-form-modal .modal-title').text('Edit scheduled email');
                        $('#send-email-btn').show();
                        $('#schedule-email-btn').hide();
                        $('#send-email-btn').data('action','resend-scheduled-email');
                        $('#payments-methods').css('display','none');
                        $('#email-form-modal').modal('show');
                    }else {
                        new Noty({
                            type: 'error',
                            layout: 'topRight',
                            text: 'Unknown error during loading scheduled email text!',
                            timeout: 1500
                        }).show();
                    }

                }
            );
            return false;
        });

        $('#send-receipt-item').click(function () {
            $contextMenu.hide();
            $('#tmfwaiting400_modal').modal('show');
            $('#send-email-btn').data('tmoffer',$(this).data('tmoffer'));
            $.post(
                '/payments-calendar/receipt-email',
                {
                    tmoffer_id: $(this).data('tmoffer'),
                    firstname:$(this).data('firstname'),
                    email:$(this).data('email'),
                    paid_index:$(this).data('paid-index')
                },
                function (msg) {
                    setTimeout(function () {
                        $('#tmfwaiting400_modal').modal('hide');
                    },500);
                    if(Object.keys(msg).length){
                        // var obj=JSON.parse(msg);
                        $('#subj').val(msg.subj);
                        email_body=msg.body;
                        $('#dear').val(msg.firstname);
                        $('#email').val(msg.email);
                        setEmailText();
                        $('#email-form-modal .modal-title').text('Send Receipt');
                        $('#send-email-btn').show();
                        $('#schedule-email-btn').hide();
                        $('#send-email-btn').data('action','send-receipt-email');
                        $('#payments-methods').css('display','none');
                        $('#email-form-modal').modal('show');
                    }else {
                        new Noty({
                            type: 'error',
                            layout: 'topRight',
                            text: 'Unknown error during loading receipt email text!',
                            timeout: 1500
                        }).show();
                    }

                }
            );
            return false;
        });

        $('#send-failed-payment-item').click(function () {
            $contextMenu.hide();
            $('#dear').val($(this).data('firstname'));
            $('#email').val($(this).data('email'));
            $('#tmfwaiting400_modal').modal('show');
            $('#send-email-btn').data('tmoffer',$(this).data('tmoffer'));
            $.post(
                '/payments-calendar/failed-payment-email',
                {
                    tmoffer_id: $(this).data('tmoffer'),
                    amount: $(this).data('amount'),
                    selected_currency: $(this).data('selected_currency'),
                    paid_index: $(this).data('paid-index'),
                    pay_by:$('#pay-by').val()
                },
                function (msg) {
                    setTimeout(function () {
                        $('#tmfwaiting400_modal').modal('hide');
                    },500);
                    if(Object.keys(msg).length){
                        $('#subj').val(msg.subj);
                        email_body=msg.body;
                        setEmailText();
                        $('#email-form-modal .modal-title').text('Failed payment email');
                        $('#schedule-email-btn').hide();
                        $('#send-email-btn').data('action','send-failed-payment-email').show();
                        $('#payments-methods').css('display','flex');
                        $('#email-form-modal').modal('show');
                    }else {
                        new Noty({
                            type: 'error',
                            layout: 'topRight',
                            text: 'Unknown error during loading failed payment email text!',
                            timeout: 1500
                        }).show();
                    }

                }
            );
            return false;
        });

        $('#pay-by').change(function () {
            $.post(
                '/payments-calendar/failed-payment-email',
                {
                    tmoffer_id: $('#send-failed-payment-item').data('tmoffer'),
                    amount: $('#send-failed-payment-item').data('amount'),
                    selected_currency: $('#send-failed-payment-item').data('selected_currency'),
                    paid_index: $('#send-failed-payment-item').data('next-installment'),
                    pay_by:$('#pay-by').val()
                },
                function (msg) {
                    if(Object.keys(msg).length){
                        $('#subj').val(msg.subj);
                        email_body=msg.body;
                        setEmailText();
                    }else {
                        new Noty({
                            type: 'error',
                            layout: 'topRight',
                            text: 'Unknown error during loading failed payment email text!',
                            timeout: 1500
                        }).show();
                    }
                }
            );
        });


        $('#send-email-btn').click(function () {
            $('#email-form-modal').modal('hide');
            setTimeout(function () {
                $('#tmfwaiting400_modal').modal('show');
            },100);
            $.post(
                '/payments-calendar/send-email',
                {
                    dear:$.trim($('#dear').val()),
                    email:$.trim($('#email').val()),
                    by:$('#pay-by').val(),
                    from:$('#from').val(),
                    subj:$.trim($('#subj').val()),
                    email_body:tinymce.get('email-text').getContent(),
                    tmoffer_id: $(this).data('tmoffer'),
                    paid_index:$('#send-failed-payment-item').data('next-installment'),
                    action:$(this).data('action')
                },
                function (msg) {
                    setTimeout(function () {
                        $('#tmfwaiting400_modal').modal('hide');
                    },500);
                    if(msg.length){
                        new Noty({
                            type: 'success',
                            layout: 'topRight',
                            text: 'DONE',
                            timeout: 1500
                        }).show();
                        reloadCalendar();
                    }else{
                        $('#email-form-modal').modal('show');
                        new Noty({
                            type: 'error',
                            layout: 'topRight',
                            text: 'Unknown error during sending email!',
                            timeout: 1500
                        }).show();
                    }
                }
            );
        });

        $('#schedule-email-btn').click(function () {
            $('#email-form-modal').modal('hide');
            setTimeout(function () {
                $('#tmfwaiting400_modal').modal('show');
            },100);
            $.post(
                '/payments-calendar/schedule-email',
                {
                    dear:$.trim($('#dear').val()),
                    email:$.trim($('#email').val()),
                    by:$('#pay-by').val(),
                    from:$('#from').val(),
                    subj:$.trim($('#subj').val()),
                    email_body:tinymce.get('email-text').getContent(),
                    tmoffer_id: $(this).data('tmoffer'),
                },
                function (msg) {
                    setTimeout(function () {
                        $('#tmfwaiting400_modal').modal('hide');
                    },500);
                    if(msg.length){
                        new Noty({
                            type: 'success',
                            layout: 'topRight',
                            text: 'DONE',
                            timeout: 1500
                        }).show();
                        reloadCalendar();
                    }else{
                        $('#email-form-modal').modal('show');
                        new Noty({
                            type: 'error',
                            layout: 'topRight',
                            text: 'Unknown error during scheduling email!',
                            timeout: 1500
                        }).show();
                    }
                }
            );
        });

        $('#email-form-modal').on('shown.bs.modal', function (e) {
            resizeEditorArea();
        });

        function resizeEditorArea() {
                if($(window).height()<=768)
                    $('#email-form-modal .modal-body').css({
                        'height':$(window).height()-170,
                        'overflow':'auto'
                    });
                else
                    $('#email-form-modal .modal-body').css({
                        'height':'auto',
                    });
        }

        $(window).resize(function () {
            resizeEditorArea();
        });

        var c_options={!! $calendar_options_json !!};

        function initCalendar(selector) {
            var calendarEl = document.getElementById(selector);
            calendar = new FullCalendar.Calendar(calendarEl, c_options);

            calendar.render();
            applyFilters();
        }

        Array.prototype.unique = function() {
            var a = this.concat();
            for(var i=0; i<a.length; ++i) {
                for(var j=i+1; j<a.length; ++j) {
                    if(a[i] === a[j])
                        a.splice(j--, 1);
                }
            }

            return a;
        };

        $(document).ready(function () {
            initCalendar('payments-calendar');

            document.getElementById('payments-calendar').querySelector('.fc-today-button').addEventListener('click', function() {
                $('#tmfwaiting400_modal').modal('show');
                var now=moment().format('YYYY-MM-DD');
                $.get(
                    '/payments-calendar/load-month-data',
                    {start:now},
                    function (msg) {
                        setTimeout(function () {
                            $('#tmfwaiting400_modal').modal('hide');
                        },500);
                        calendar.removeAllEventSources();
                        calendar.addEventSource(JSON.parse(msg));
                        current_date=moment().format('YYYY-MM-DD');
                        prev_date=moment(now).add(-1,'month').format('YYYY-MM-DD');
                        next_date=moment(now).add(1,'month').format('YYYY-MM-DD');
                        applyFilters();
                    }
                );
            });
        });

        $('body').on('click','.fc-prev-button',function () {
            $('#tmfwaiting400_modal').modal('show');
            $.get(
                '/payments-calendar/load-month-data',
                {start:prev_date},
                function (msg) {
                    setTimeout(function () {
                        $('#tmfwaiting400_modal').modal('hide');
                    },500);
                    calendar.removeAllEventSources();
                    calendar.addEventSource(JSON.parse(msg));
                    current_date=moment(prev_date).format('YYYY-MM-DD');
                    next_date=moment(next_date).add(-1,'month').format('YYYY-MM-DD');
                    prev_date=moment(prev_date).add(-1,'month').format('YYYY-MM-DD');
                    applyFilters();
                }
            );
        });

        $('body').on('click','.fc-next-button',function () {
            $('#tmfwaiting400_modal').modal('show');
            $.get(
                '/payments-calendar/load-month-data',
                {start:next_date},
                function (msg) {
                    setTimeout(function () {
                        $('#tmfwaiting400_modal').modal('hide');
                    },500);
                    calendar.removeAllEventSources();
                    calendar.addEventSource(JSON.parse(msg));
                    current_date=moment(next_date).format('YYYY-MM-DD');
                    prev_date=moment(prev_date).add(1,'month').format('YYYY-MM-DD');
                    next_date=moment(next_date).add(1,'month').format('YYYY-MM-DD');
                    applyFilters();
                }
            );
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

        $('#new-note-btn').click(function(){
            var txt="\r\n\r\n"+$('#notes').val();
            $('#notes').val(printDate() + ' {{Auth::user()->LongID}}:');
            moveCursorToEnd(document.getElementById('notes'));
            $('#notes').val($('#notes').val()+txt);
            return false;
        });

        $('#add-note-item').click(function () {
            $contextMenu.hide();
            $('#notes').val($(this).data('notes'));
            $('#save-notes-btn').data('tmoffer',$(this).data('tmoffer'));
            $('#notes-modal').modal('show');
            return false;
        });

        $('#save-notes-btn').click(function () {
            $('#notes-modal').modal('hide');
            $('#tmfwaiting400_modal').modal('show');
            $.post(
                '/payments-calendar/save-invoice-notes',
                {
                    tmoffer_id:$(this).data('tmoffer'),
                    notes:$.trim($('#notes').val())
                },
                function (msg) {
                    setTimeout(function () {
                        $('#tmfwaiting400_modal').modal('hide');
                    },500);
                    if(msg.length){
                        new Noty({
                            type: 'success',
                            layout: 'topRight',
                            text: 'DONE',
                            timeout: 1500
                        }).show();
                        reloadCalendar();
                    }else{
                        setTimeout(function () {
                            $('#notes-modal').modal('show');
                        },500);
                        new Noty({
                            type: 'error',
                            layout: 'topRight',
                            text: 'Unknown error during saving notes!',
                            timeout: 1500
                        }).show();
                    }
                }
            );
        });

        $('body').on('click','.fc-toolbar-title',function () {
            $('#year').val(moment(current_date).format('YYYY'));
            $('#month').val(moment(current_date).format('M'));
            $('#select-month-modal').modal('show');
        });

        $('#select-month-btn').click(function () {
            $('#select-month-modal').modal('hide');
            $('#tmfwaiting400_modal').modal('show');
            var date=$('#year').val()+'-'+$('#month').val()+'-01';
            current_date=moment(date).endOf('month').format('YYYY-MM-DD');
            $.get(
                '/payments-calendar/load-month-data',
                {start:current_date},
                function (msg) {
                    setTimeout(function () {
                        $('#tmfwaiting400_modal').modal('hide');
                    },500);
                    calendar.removeAllEventSources();
                    calendar.addEventSource(JSON.parse(msg));
                    calendar.gotoDate(current_date);
                    next_date=moment(current_date).add(+1,'month').format('YYYY-MM-DD');
                    prev_date=moment(current_date).add(-1,'month').format('YYYY-MM-DD');
                    applyFilters();
                }
            );

        });

        $('#boom-sources-link').click(function () {
            $('#boom-sources-modal').modal('show');
            return false;
        });

        $('#apply-bs-filter-btn').click(function () {
            $('#boom-sources-link').text('BOOM Sources: '+
                $('.boom-source-chbx:checked').length+
                ' of '+
                $('.boom-source-chbx').length);
            applyFilters();
            $('#boom-sources-modal').modal('hide');
        });
    </script>
@endsection