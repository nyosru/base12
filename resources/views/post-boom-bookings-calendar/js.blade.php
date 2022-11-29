<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('.export-leads-csv-link').click(function () {
        $('#export-to-csv-modal').modal('show');
        return false;
    });

    $('.q-btn,.month-btn').click(function () {
        $('#from_date').val($('#s-year').val() + '-' + $(this).data('from'));
        $('#to_date').val($('#s-year').val() + '-' + $(this).data('to'));
        return false;
    });

    $('.y-btn').click(function () {
        $('#from_date').val($('#s-year').val() + '-01-01');
        $('#to_date').val($('#s-year').val() + '-12-31');
        return false;
    });


    $(document).ready(function () {
        var dateFormat = "yy-mm-dd",
            from = $("#from_date")
                .datepicker({
                    changeMonth: true,
                    numberOfMonths: 1,
                    minDate: "2020-06-10",
                    dateFormat: dateFormat
                })
                .on("change", function () {
                    to.datepicker("option", "minDate", getDate(this));
                }),
            to = $("#to_date").datepicker({
                changeMonth: true,
                numberOfMonths: 1,
                dateFormat: dateFormat,
                minDate: "2020-06-10",
                maxDate: "2035-06-10",

            })
                .on("change", function () {
                    from.datepicker("option", "maxDate", getDate(this));
                });

        function getDate(element) {
            var date;
            try {
                date = $.datepicker.parseDate(dateFormat, element.value);
            } catch (error) {
                date = null;
            }

            return date;
        }
    });


    var today = '{{(new \DateTime())->format('Y-m-d')}}';
    var current_date = '{{$today->format('Y-m-d')}}';
    var prev_date = '{{$prev_date}}';
    var next_date = '{{$next_date}}';
    var calendar;
    var show_context_menu = 0;
    var current_info = null;

    var c_options ={!! $calendar_options_json !!};

    var filter = {
        closing_calls: {call_types: [], closeable: [], bookings_from: [], closers: [],booking_types:[]},
        gc: {closers: []},
        oe: {closers: []},
        sou: {closers: []}
    };

    function loadClosingCallsFilterData() {
        filter.closing_calls.call_types = [];
        // var html = [];
        $('.closing-call-type:checked').each(function () {
            filter.closing_calls.call_types.push($(this).val());
            // html.push($(this).next('.badge')[0].outerHTML);
        });
        // $('.call-types-filter-results').html(html.join(' '));

        filter.closing_calls.closeable = [];
        // var closeable = [];
        $('.closeable-filter-chbx:checked').each(function () {
            filter.closing_calls.closeable.push(Number($(this).val()));
            // closeable.push($.trim($(this).parents('label:eq(0)').text()));
        });
        // $('.closeable-filter-results').html('<b>Closable</b>: ' + closeable.join(', '));

        filter.closing_calls.bookings_from = [];
        // var bookings_from = [];
        $('.cc-from-filter-chbx:checked').each(function () {
            filter.closing_calls.bookings_from.push($(this).val());
            // bookings_from.push($.trim($(this).parents('label:eq(0)').text()));
        });
        // $('.bookings-from-filter-results').html('<b>Bookings from</b>: ' + bookings_from.join(', '));

        filter.closing_calls.closers = [];
        // var closers = [];
        $('.closer-filter-chbx:checked').each(function () {
            filter.closing_calls.closers.push(Number($(this).val()));
            // closers.push($(this).data('user'));
        });
        filter.closing_calls.booking_types=[];
        $('.funnel-filter-chbx:checked').each(function () {
            filter.closing_calls.booking_types.push($(this).val());
            // closers.push($(this).data('user'));
        });
        // $('.closers-from-filter-results').html(closers.join(', '));
    }

    function loadGcOeSouFilterData() {
        filter.gc.closers = [];
        filter.oe.closers = [];
        filter.sou.closers = [];
        $('.closer-filter-chbx:checked').each(function () {
            if ($('.booking-type-filter[value="gc"]:checked').length)
                filter.gc.closers.push(Number($(this).val()));
            if ($('.booking-type-filter[value="oec"]:checked').length)
                filter.oe.closers.push(Number($(this).val()));
            if ($('.booking-type-filter[value="souc"]:checked').length)
                filter.sou.closers.push(Number($(this).val()));
        });
    }


    function loadFilterData() {
        loadClosingCallsFilterData();
        loadGcOeSouFilterData();
    }

    function applyClosingCallsFilters(event) {
        var flag = 1;
        var booking_props = event.extendedProps.booking_props;

        if ($.inArray(booking_props.booking_from, ['ga', 'yt','fb']) == -1)
            booking_props.booking_from = 'other';

        if (
            ($.inArray(booking_props.booking_from, filter.closing_calls.bookings_from) == -1) ||
            ($.inArray(booking_props.call_type, filter.closing_calls.call_types) == -1) ||
            ($.inArray(booking_props.closeable, filter.closing_calls.closeable) == -1) ||
            ($.inArray(booking_props.closer, filter.closing_calls.closers) == -1) ||
            ($.inArray(booking_props.booking_type, filter.closing_calls.booking_types) == -1)
        )
            flag = 0;

        return flag;
    }

    function applyGsOeSouFilters(event, closers) {
        var flag = 0;
        var booking_props = event.extendedProps.booking_props;
        $.each(booking_props, function (i, val) {
            if ($.inArray(val, closers) != -1)
                flag = 1;
        });

        return flag;
    }


    function eventDidMount(info) {
        var val = info.event;
        var flag = 1;
        switch (val.extendedProps.block_class) {
            case 'closing-call':
                flag = applyClosingCallsFilters(val);
                break;
            case 'group-call':
                flag = applyGsOeSouFilters(val, filter.gc.closers);
                break;
            case 'oe-booking':
                flag = applyGsOeSouFilters(val, filter.oe.closers);
                break;
            case 'sou-booking':
                flag = applyGsOeSouFilters(val, filter.sou.closers);
                break;
        }
        if (flag)
            info.el.style.display = 'block';
        // val.setProp('display', 'auto');
        else
            info.el.style.display = 'none';
        // val.setProp('display', 'none');
    }

    function invertColor(hex, bw) {
        if (hex.indexOf('#') === 0) {
            hex = hex.slice(1);
        }
        // convert 3-digit hex to 6-digits.
        if (hex.length === 3) {
            hex = hex[0] + hex[0] + hex[1] + hex[1] + hex[2] + hex[2];
        }
        if (hex.length !== 6) {
            throw new Error('Invalid HEX color.');
        }
        var r = parseInt(hex.slice(0, 2), 16),
            g = parseInt(hex.slice(2, 4), 16),
            b = parseInt(hex.slice(4, 6), 16);
        if (bw) {
            // http://stackoverflow.com/a/3943023/112731
            return (r * 0.299 + g * 0.587 + b * 0.114) > 186
                ? '#000000'
                : '#FFFFFF';
        }
        // invert color components
        r = (255 - r).toString(16);
        g = (255 - g).toString(16);
        b = (255 - b).toString(16);
        // pad each with zeros and return
        return "#" + padZero(r) + padZero(g) + padZero(b);
    }

    function renderContentEvent(info) {
        var booking_block = '<div style="display:block;width:100%;cursor:pointer;border-radius:3px;background-color:' + info.event.extendedProps.title_bkg +
            ';border: 2px solid ' + info.event.extendedProps.border_color + '"><div class="pl-1 pr-1 text-white">' +
            '<span style="color:'+invertColor(info.event.extendedProps.title_bkg,1)+'">'+info.event.title +'</span>'+
            (info.event.extendedProps.booking_source_icon.length ? '<img src="' + info.event.extendedProps.booking_source_icon + '" class="booking-source-icon float-right"/>' : '') +
            '</div>' +
            '<div class="pl-1 pr-1 text-black" style="background-color:' + info.event.extendedProps.content_bkg + ';white-space: pre-line"><p class="participants text-black" title="'+
            info.event.extendedProps.participants.join('+')+
            '">' +
            // (info.event.extendedProps.participants.length>1?'<i class="fas fa-users"></i> ':'<i class="fas fa-user"></i> ')+
            info.event.extendedProps.call_icon +
            info.event.extendedProps.participants.join('+') +
            '</p></div></div>';
        var html =
            '<table>' +
            '<tr>' +
            '<td class="booking-time-cell"><div class="booking-time">' + info.event.extendedProps.time + '</div></td>' +
            '<td>' + booking_block + '</td>' +
            '</tr>' +
            '</table>';
        return {
            html: html
        };

    }

    function weekNumberContentPaint(info){
        info.text='';
        return info;
    }
    var ddd=[];
    function weekNumberDidMount(info){
        console.log(info);
        ddd.push(info);
        info.text='';
        info.el.outerHTML='<a href="#" class="bookings-stat" data-date="'+moment(info.date).format('YYYY-MM-DD')+'" style="color:orange;display:block;margin-top: 3px;margin-left:5px;"><i class="fas fa-calculator"></i></a>';
        return info;
    }

    function loadEmails(tmoffer_id) {
        $('#tmfwaiting400_modal').modal('show');
        $.post(
            '/bookings-calendar/load-emails',
            {
                tmoffer_id:tmoffer_id
            },
            function (msg) {
                setTimeout(function () {
                    $('#tmfwaiting400_modal').modal('hide');
                }, 1000);
                if (msg.length) {
                    $('#booking-info-modal .modal-title').text('History of actions');
                    $('#booking-info-modal .modal-body').html(msg);
                    $('#booking-info-modal').modal('show');
                } else {
                    $('.sys-message .toast-body').text('Unknown error during loading history of actions!');
                    $('.sys-message').toast('show');
                }
            }
        );

    }

    $('body').on('click','.load-pq-answers',function () {

        loadPqAnswers($(this).data('tmoffer-id'));
        return false;
    });

    function loadPqAnswers(tmoffer_id) {
        $('#tmfwaiting400_modal').modal('show');
        $.post(
            '/bookings-calendar/load-pq-answers',
            {
                tmoffer_id:tmoffer_id
            },
            function (msg) {
                setTimeout(function () {
                    $('#tmfwaiting400_modal').modal('hide');
                }, 1000);
                if (msg.length) {
                    $contextMenu.hide();
                    $('.client-answers').html(msg);
                    $('#client-file-modal').modal('show');
                } else {
                    $('.sys-message .toast-body').text('Unknown error during loading PQ answers!');
                    $('.sys-message').toast('show');
                }
            }
        );

    }

    function initCalendar(selector) {
        var calendarEl = document.getElementById(selector);
        calendar = new FullCalendar.Calendar(calendarEl, c_options);

        calendar.render();
        @if(!is_null($action_data))
        @switch($action_data['action'])
        @case('enter-boom-reason')
        loadBoomReasonText({{$action_data['tmoffer_id']}});
        @break
        @case('load-emails')
        loadEmails({{$action_data['tmoffer_id']}});
        @break
        @case('load-pq-answers')
        loadPqAnswers({{$action_data['tmoffer_id']}});
        @break
        @endswitch
        @endif
        // applyFilters();
    }

    Array.prototype.unique = function () {
        var a = this.concat();
        for (var i = 0; i < a.length; ++i) {
            for (var j = i + 1; j < a.length; ++j) {
                if (a[i] === a[j])
                    a.splice(j--, 1);
            }
        }

        return a;
    };

    function redrawCalendar() {
        var calendar_object = {};
        Object.assign(calendar_object, calendar.getEventSources());
        calendar_object[0].refetch();
        $('.fc-daygrid-event-harness').css('margin-top', 0);
        redrawMoreLinks();
    }

    function reloadCalendar() {
        var scrolltop = $('.fc-scroller.fc-scroller-liquid-absolute')[0].scrollTop;
        $('#tmfwaiting400_modal').modal('show');
        var now = moment(next_date).add(-1, 'month').format('YYYY-MM-DD');
        $.get(
            '/bookings-calendar/load-month-data',
            {start: now},
            function (msg) {
                setTimeout(function () {
                    $('#tmfwaiting400_modal').modal('hide');
                }, 1000);

                calendar.removeAllEventSources();
                calendar.addEventSource(JSON.parse(msg));
                current_date = moment().format('YYYY-MM-DD');
                prev_date = moment(now).add(-1, 'month').format('YYYY-MM-DD');
                next_date = moment(now).add(1, 'month').format('YYYY-MM-DD');
                $('.fc-scroller.fc-scroller-liquid-absolute')[0].scrollTop = scrolltop;
                // applyFilters();
                redrawCalendar();
            }
        );
    }

    $(document).ready(function () {

        loadFilterData();
        initCalendar('booking-calendar');
        redrawMoreLinks();

        document.getElementById('booking-calendar').querySelector('.fc-today-button').addEventListener('click', function () {
            next_date = moment(today).add(1, 'month').format('YYYY-MM-DD');
            reloadCalendar();
        });

        $('#my-message').summernote({
            height: 250,                 // set editor height
            minHeight: 250,             // set minimum height of editor
            maxHeight: null,             // set maximum height of editor
            // focus: true,                  // set focus to editable area after initializing summernote
            toolbar: [
                ['text', ['bold', 'italic', 'underline', 'clear', 'color']],
                ['para', ['paragraph', 'ul', 'ol']],
                ['misc', ['fullscreen', 'codeview', 'undo', 'redo']]
            ]
        });

    });

    $('body').on('click', '.fc-toolbar-title', function () {
        $('#year').val(moment(current_date).format('YYYY'));
        $('#month').val(moment(current_date).format('M'));
        $('#select-month-modal').modal('show');
    });

    $('#select-month-btn').click(function () {
        $('#select-month-modal').modal('hide');
        $('#tmfwaiting400_modal').modal('show');
        var date = $('#year').val() + '-' + $('#month').val() + '-01';
        current_date = moment(date).endOf('month').format('YYYY-MM-DD');
        $.get(
            '/bookings-calendar/load-month-data',
            {start: current_date},
            function (msg) {
                setTimeout(function () {
                    $('#tmfwaiting400_modal').modal('hide');
                }, 1000);

                calendar.removeAllEventSources();
                calendar.addEventSource(JSON.parse(msg));
                calendar.gotoDate(current_date);
                next_date = moment(current_date).add(+1, 'month').format('YYYY-MM-DD');
                prev_date = moment(current_date).add(-1, 'month').format('YYYY-MM-DD');
                // applyFilters();
                redrawCalendar();
            }
        );

    });

    var $contextMenu = $("#context-menu");

    function calendarMouseLeaveEvent(info) {
        show_context_menu = 0;
    }

    function calendarSetCurrentEvent(info) {
        current_info = info;
        show_context_menu = 1;
    }


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
        var text_color=invertColor(current_info.event.extendedProps.content_bkg,1);
        var html_wrapper = '<div class="p-1 text-center text-white" style="background: ' +
            (current_info.event.extendedProps.content_bkg == '#ffffff' ? current_info.event.backgroundColor : current_info.event.extendedProps.content_bkg) +
            ';display:table;width:100%;height: 36px;line-height:1;">';
        var html = html_wrapper + '<div style="display:table-cell;vertical-align:middle;">' +
            '<span style="color:'+text_color+'">'+current_info.event.extendedProps.client +'</span>'+
            '</div></div>';
        var footer = html_wrapper +
            '<div style="display:table-cell;vertical-align:middle;text-align:left" class="text-white"><i class="fas fa-phone-square-alt" style="color:'+text_color+'"></i> ' +
            '<a href="tel:'+current_info.event.extendedProps.client_info.phone+'" style="color:black">'+current_info.event.extendedProps.client_info.phone +'</a> '+
            '<a href="#" data-tel="'+current_info.event.extendedProps.client_info.phone+'" style="color:black" class="copy-phone-link" title="Click to copy phone"><i class="fas fa-copy"></i></a>'+
            '<a href="mailto:' +
            current_info.event.extendedProps.client_info.email +
            '?body=Hi ' + current_info.event.extendedProps.client_info.firstname + ',%0D%0A%0D%0A" target="_blank" style="float:right;"><i class="fas fa-envelope-square text-black"></i></a></div></div>';
        $('#context-menu').html(html + current_info.event.extendedProps.menu_items + footer);

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
        if (show_context_menu)
            showContextMenu($contextMenu, e);
        else
            $contextMenu.hide();
    });

    $('body').on('click', '.fc-prev-button', function () {
        $('#tmfwaiting400_modal').modal('show');
        $.get(
            '/bookings-calendar/load-month-data',
            {start: prev_date},
            function (msg) {
                setTimeout(function () {
                    $('#tmfwaiting400_modal').modal('hide');
                }, 1000);

                calendar.removeAllEventSources();
                calendar.addEventSource(JSON.parse(msg));
                current_date = moment(prev_date).format('YYYY-MM-DD');
                next_date = moment(next_date).add(-1, 'month').format('YYYY-MM-DD');
                prev_date = moment(prev_date).add(-1, 'month').format('YYYY-MM-DD');
                // applyFilters();
                redrawCalendar();
            }
        );
    });

    $('body').on('click', '.fc-next-button', function () {
        $('#tmfwaiting400_modal').modal('show');
        $.get(
            '/bookings-calendar/load-month-data',
            {start: next_date},
            function (msg) {
                setTimeout(function () {
                    $('#tmfwaiting400_modal').modal('hide');
                }, 1000);

                calendar.removeAllEventSources();
                calendar.addEventSource(JSON.parse(msg));
                current_date = moment(next_date).format('YYYY-MM-DD');
                prev_date = moment(prev_date).add(1, 'month').format('YYYY-MM-DD');
                next_date = moment(next_date).add(1, 'month').format('YYYY-MM-DD');
                // applyFilters();
                redrawCalendar();
            }
        );
    });

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

    function redrawMoreLinks() {
        $('.fc-daygrid-day-bottom').each(function () {
            var day_div = $(this).parents('.fc-daygrid-day-events:eq(0)');
            var hidden_divs=day_div.find('.fc-daygrid-event-harness.fc-daygrid-event-harness-abs');
            var objs=[];
            $.each(hidden_divs,function (i,div) {
                var a_el=$(div).find('a:eq(0)');
                if(a_el.css('display')!='none') {
                    var div_el = $(div).find('a:eq(0)').find('table tr:eq(0) td:eq(1) div:eq(0)');
                    var index = findObjIndex(objs, div_el.css('background-color'));
                    if (index == -1) {
                        var local_obj = {
                            bg_color: div_el.css('background-color'),
                            count: 0
                        };
                        objs.push(local_obj);
                        index = objs.length - 1;
                    }
                    objs[index].count++;
                }
            });
            $(this).find('a:eq(0)').html('+more: '+getMoreLinksHtml(objs));
        });
    }


    $('#legend-link').click(function () {
        $('.legend-popup').toast('show');
        return false;
    });

    $('.legend-popup,.sys-message').on('shown.bs.toast', function () {
        $(this).parents('div:eq(0)').css('z-index', '1000');
    });


    $('.legend-popup,.sys-message').on('hidden.bs.toast', function () {
        $(this).parents('div:eq(0)').css('z-index', '-1000');
    });

    $('body').on('click', '.change-noboom-reason-link', function () {
        $('#tmfwaiting400_modal').modal('show');
        $('#noboom-reason-save-data').data('id', $(this).data('id'));
        $.post(
            '/bookings-calendar/load-noboom-reason',
            {tmoffer_id: $(this).data('id')},
            function (msg) {
                setTimeout(function () {
                    $('#tmfwaiting400_modal').modal('hide');
                }, 1000);
                if (msg.hasOwnProperty('notes')) {
                    $('#notes').val(msg.notes);
                    $('#no-boom-reason').val(msg.noboom_reason);
                    $('input[name="lead-temp"][value="' + msg.lead_temp + '"]').prop('checked', true);
                    $('input[name="lead-need-tm"][value="' + msg.need_tm + '"]').prop('checked', true);
                    $('input[name="lead-knows-tmf-offer"][value="' + msg.knows_tmf_offer + '"]').prop('checked', true);
                    $('#no-boom-reason-text').val(msg.no_boom_reason_text);
                    $('#call-record-url').val(msg.call_record_url);
                    $('input[name="closeable-option"][value="' + msg.closeable + '"]').prop('checked', true);
                    if (Number(msg.closeable) == -1) {
                        $('#reminder-block').hide();
                    } else {
                        if (msg.closeable_notification_at == null) {
                            $('input[name="remind-in-option"][value="7"]').prop('checked', true);
                            $('input[name="remind-in-option"][value="7"]').trigger('change');
                        } else {
                            $("#datepicker").datepicker('setDate', msg.closeable_notification_at);
                            $('input[name="remind-in-option"][value="100"]').prop('checked', true);
                            $('#reminder-date-text').text(moment(msg.closeable_notification_at).format('MMMM D, YYYY'));
                        }
                    }
                    $('#noboom-reason-modal').modal('show');
                } else {
                    $('.sys-message .toast-body').text('Unknown error during loading noBOOM reasons for client!');
                    $('.sys-message').toast('show');
                }
            }
        );

        return false;
    });

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

    $('body').on('click', '.report-call-link', function () {
        $('#tmfwaiting400_modal').modal('show');
        $('#report-call-save-btn').data('id', $(this).data('id'));
        $('#report-call-save-btn').data('action', $(this).data('action'));
        $.post(
            '/bookings-calendar/load-report-call-body',
            {tmoffer_id: $(this).data('id')},
            function (msg) {
                setTimeout(function () {
                    $('#tmfwaiting400_modal').modal('hide');
                }, 1000);
                if (msg.length) {
                    $('#report-call-modal .modal-body').html(msg);
                    initDatePicker();
                    handleSaveBtns();
                    $('#report-call-modal').modal('show');
                } else {
                    $('.sys-message .toast-body').text('Unknown error during loading report call body!');
                    $('.sys-message').toast('show');
                }
            }
        );
        return false;
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
                    $('.sys-message .toast-body').text('Saved');
                } else {
                    $('.sys-message .toast-body').text('Unknown error during saving BOOM reasons for client!');
                    setTimeout(function () {
                        $('#report-call-modal').modal('show');
                    }, 1000);
                }
                $('.sys-message').toast('show');
            }
        );
    }

    function saveNoBoomReport(){
        if($('#no-boom-reason').val()==''){
            $('.sys-message .toast-body').text('No BOOM reason did not select!');
            $('.sys-message').toast('show');
            $('#noboom-reason-modal').modal('show');
            return 0;
        }
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
                    $('.sys-message .toast-body').text('Saved');
                } else {
                    $('.sys-message .toast-body').text('Unknown error during saving noBOOM reasons for client!');
                    setTimeout(function () {
                        $('#noboom-reason-modal').modal('show');
                    }, 1000);
                }
                $('.sys-message').toast('show');
            }
        );
    }

    $('#report-call-and-send-email-btn').click(function () {
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
                if (msg.length) {
                    $('.sys-message .toast-body').text('Saved');
                    $.post(
                        '/bookings-calendar/load-post-report-email',
                        {
                            id:$('#no-boom-reason').val(),
                            tmoffer_id:$('#report-call-save-btn').data('id')
                        },
                        function (msg) {
                            setTimeout(function () {
                                $('#tmfwaiting400_modal').modal('hide');
                            }, 1000);
                            var obj=JSON.parse(msg);
                            $('#my-message').summernote('code',obj.message);
                            $('#my-subject').val(obj.subj);
                            $('#my-email').val(obj.email);
                            $('#email-to-client-send-btn').data('id',$('#report-call-save-btn').data('id'));
                            $('#email-to-client-modal').modal('show');
                        }

                    );
                } else {
                    setTimeout(function () {
                        $('#tmfwaiting400_modal').modal('hide');
                    }, 1000);
                    $('.sys-message .toast-body').text('Unknown error during saving noBOOM reasons for client!');
                    setTimeout(function () {
                        $('#noboom-reason-modal').modal('show');
                    }, 1000);
                }
                $('.sys-message').toast('show');
            }
        );
    });

    $('#report-call-save-btn').click(function () {
        if($(this).data('action')=='boom')
            saveBoomReport();
        else
            saveNoBoomReport();
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

    $('body').on('click','#add-date',function () {
        addDateToEl('notes');
        return false;
    });

    $('body').on('click','#add-date-alt',function () {
        addDateToEl('notes-alt');
        return false;
    });

    /*
        $('#noboom-reason-save-data').click(function () {
            $('#noboom-reason-modal').modal('hide');
            $('#tmfwaiting400_modal').modal('show');
            var selected_date = $("#datepicker").datepicker('getDate');
            $.post(
                '/bookings-calendar/save-noboom-reason',
                {
                    tmoffer_id: $('#noboom-reason-save-data').data('id'),
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
                        $('.sys-message .toast-body').text('Saved');
                    } else {
                        $('.sys-message .toast-body').text('Unknown error during saving noBOOM reasons for client!');
                        setTimeout(function () {
                            $('#noboom-reason-modal').modal('show');
                        }, 1000);
                    }
                    $('.sys-message').toast('show');
                }
            );
        });
    */

    $('body').on('click', '.change-closer-link', function () {
        $('#new-closer').val($(this).data('closer-id'));
        $('#change-closer-save-btn').data('booking-id', $(this).data('booking-id'));
        $('#change-closer-modal').modal('show');
        return false;
    });

    $('#change-closer-save-btn').click(function () {
        $('#change-closer-modal').modal('hide');
        $('#tmfwaiting400_modal').modal('show');
        $.post(
            '/bookings-calendar/change-closer',
            {
                booking_id: $('#change-closer-save-btn').data('booking-id'),
                new_closer_id: $('#new-closer').val()
            },
            function (msg) {
                setTimeout(function () {
                    $('#tmfwaiting400_modal').modal('hide');
                }, 1000);
                if (msg.length) {
                    $('.sys-message .toast-body').text('Saved');
                    reloadCalendar();
                } else {
                    $('.sys-message .toast-body').text('Unknown error during changing closer for client!');
                    setTimeout(function () {
                        $('#change-closer-modal').modal('show');
                    }, 1000);
                }
                $('.sys-message').toast('show');
            }
        );
    });

    $('body').on('click', '.remove-booking-link', function () {
        if (confirm('Remove Booking?')) {
            $('#tmfwaiting400_modal').modal('show');
            $.post(
                '/bookings-calendar/remove-booking',
                {
                    booking_id: $(this).data('booking-id')
                },
                function (msg) {
                    setTimeout(function () {
                        $('#tmfwaiting400_modal').modal('hide');
                    }, 1000);
                    if (msg.length) {
                        reloadCalendar();
                        $('.sys-message .toast-body').text('Removed');
                        $contextMenu.hide();
                    } else {
                        $('.sys-message .toast-body').text('Unknown error during removing booking!');
                    }
                    $('.sys-message').toast('show');
                }
            );

        }
        return false;
    });

    $('body').on('click', '.edit-notes-link', function () {
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
                } else {
                    $('.sys-message .toast-body').text('Unknown error during saving notes for client!');
                    setTimeout(function () {
                        $('#notes-modal').modal('show');
                    }, 1000);
                }
                $('.sys-message').toast('show');
            }
        );
    });

    $('body').on('click', '.upload-recordings-link', function () {
        $('#upload-call-btn').data('id', $(this).data('tmoffer-id'));
        $('#upload-call-modal').modal('show');
        return false;
    });

    var files_list_selector = '#uploaded-files';
    var files_input_selector = '#upfiles';
    var files = [];

    function paintFiles() {
        var result = '';
        if (files.length) {
            result += '<table style="margin: auto">';
            $.each(files, function (i, val) {
                result += '<tr>';
                result += '<td class="text-left">';
                result += val.name;
                result += '<span style="float:right;cursor:pointer;color:red;padding-left:10px;" class="remove-file" data-index="' + i + '"><i class="fa fa-times" aria-hidden="true"></i></span>';
                result += '</td>';
                result += '</tr>';
            });
            result += '</table>';
        }
        if (result.length)
            $(files_list_selector).html(result);
        else
            $(files_list_selector).html('NO UPLOADED FILES YET');
    }

    function alreadyInFiles(val) {
        var flag = 0;
        $.each(files, function (i, el) {
            if (el.name == val.name)
                flag = 1;
        });
        return flag;
    }

    $(files_input_selector).change(function () {
        $.each($(this)[0].files, function (i, val) {
            if (!alreadyInFiles(val))
                files.push(val);
        });
        paintFiles();
    });

    $('body').on('click', '.remove-file', function () {
        var index = Number($(this).data('index'));
        files.splice(index, 1);
        paintFiles();
    });

    $('body').on('dragover', '.multi-files-dragarea', function () {
        $(this).css('background', 'lightgray');
        return false
    });

    $('body').on('dragleave', '.multi-files-dragarea', function () {
        $(this).css('background', 'transparent');
        return false
    });

    $('body').on('drop', '.multi-files-dragarea', function (event) {
        event.preventDefault();
        //var img_id = getImgId($(this));
        $.each(event.originalEvent.dataTransfer.files, function (i, val) {
            if (!alreadyInFiles(val))
                files.push(val);
        });
        $(this).css('background', 'transparent');
        paintFiles();
    });

    $('body').on('click', '.multi-files-dragarea', function () {
        $(files_input_selector).trigger('click');
    });

    function uploadAttachedFiles() {
        if (files.length) {
            var formData = new FormData();
            $.each(files, function (i, el) {
                formData.append('tmf-file[]', el);
            });
            formData.append('tmoffer_id', $('#upload-call-btn').data('id'));
            $('#upload-files-progress').show();
            $.ajax({
                url: '/bookings-calendar/upload-recordings',
                data: formData,
                type: 'POST',
                contentType: false,
                processData: false,
                xhr: function () {
                    var xhr = new window.XMLHttpRequest();
                    xhr.upload.addEventListener("progress", function (evt) {
                        if (evt.lengthComputable) {
                            var percentComplete = evt.loaded / evt.total;
                            // console.log(percentComplete);
                            var percent = Math.round(percentComplete * 100);
                            $("#upload-files-progress .progress-bar").css("width", +percent + "%");
                            $("#upload-files-progress .progress-bar").text(percent + "%");
                        }
                    }, false);
                    return xhr;
                },
                success: function (msg) {
                    $('#upload-files-progress').hide();
                    if (msg.length) {
                        $('#upload-call-modal').modal('hide');
                        $('.sys-message .toast-body').text('DONE');
                        reloadCalendar();
                    } else {
                        $('.sys-message .toast-body').text('Unknown error during saving file!');
                    }
                    $('.sys-message').toast('show');
                }
            });
        }
    }

    $('#upload-call-btn').click(function () {
        uploadAttachedFiles();
    });

    $('input[name="closeable-option"]').change(function () {
        var value = Number($(this).val());
        if (value == -1) {
            $('#reminder-block').hide();
        } else {
            $('#reminder-block').show();
        }
    });

    $('#filter-apply-btn').click(function () {
        $('#filter-modal').modal('hide');
        loadFilterData();
        // applyFilters();
        redrawCalendar();
    });

    $('#filters-link').click(function () {
        $('#filter-modal').modal('show');
        return false;
    });

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

    function setStatusForInactiveClosersChbx(status){
        $('.inactive-closers-filter-chbx').prop('checked',status);
    }

    $('.all-btn').click(function () {
        var current_class_selector = '.' + $(this).data('class');
        var checked_status;
        if ($(current_class_selector + ':checked').length < $(current_class_selector).length) {
            $(current_class_selector).prop('checked', true);
            $(this).parents('.filter-block:eq(0)').find('.booking-type-filter').prop('checked', true);
            checked_status=true;
        } else {
            $(current_class_selector).prop('checked', false);
            checked_status=false;
        }
        if(current_class_selector=='.closer-filter-chbx')
            setStatusForInactiveClosersChbx(checked_status);
        loadFilterData();
        redrawCalendar();
        return false;
    });

    $('.booking-type-filter').click(function (e) {
        if ($(this).val() == 'cc')
            $('.closer-calls-fblock').find('input[type="checkbox"]').prop('checked', $(this).prop('checked'));
        loadFilterData();
        redrawCalendar();
        e.stopPropagation();
    });

    $('.inactive-closers-filter-chbx').change(function () {
        let el_checked=$(this).prop('checked');
        $('.inactive-closer').each(function () {
            $(this).find('.closer-filter-chbx').prop('checked',el_checked);
        });
        loadFilterData();
        redrawCalendar();
    });

    $('.closing-call-type,' +
        '.closeable-filter-chbx,' +
        '.cc-from-filter-chbx,' +
        '.funnel-filter-chbx,' +
        '.closer-filter-chbx').change(function () {
        loadFilterData();
        redrawCalendar();
    });

    $('.filters-tab li.nav-item').click(function (e) {
        $(this).find('a').tab('show');
        var closest_checkbox = $(this).closest('li').find('input[type="checkbox"]');
        if (closest_checkbox.prop('checked'))
            closest_checkbox.prop('checked', false);
        else
            closest_checkbox.prop('checked', true);
    });

    function loadBoomReasonText(tmoffer_id) {
        $('#tmfwaiting400_modal').modal('show');
        $('#report-call-save-btn').data('id', tmoffer_id);
        $('#report-call-save-btn').data('action', 'boom');
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
                    if($('#no-boom-reason').length)
                        $('#report-call-save-btn').data('action', 'no-boom');
                    $('#report-call-modal').modal('show');
                } else {
                    $('.sys-message .toast-body').text('Unknown error during loading report call body!');
                    $('.sys-message').toast('show');
                }
            }
        );
        return false;

        /*
                $('#tmfwaiting400_modal').modal('show');
                $('#save-boom-reason-btn').data('id', tmoffer_id);
                $.post(
                    '/bookings-calendar/load-boom-reason',
                    {tmoffer_id: tmoffer_id},
                    function (msg) {
                        setTimeout(function () {
                            $('#tmfwaiting400_modal').modal('hide');
                        }, 1000);

                        $('#boom-reason-text').val(msg);
                        $('#boom-reason-modal').modal('show');
                    }
                );
        */

    }

    $('body').on('click', '.change-boom-reason-link', function () {
        loadBoomReasonText($(this).data('tmoffer-id'));
        return false;
    });

    $('#save-boom-reason-btn').click(function () {
        $('#boom-reason-modal').modal('hide');
        $('#tmfwaiting400_modal').modal('show');
        $.post(
            '/bookings-calendar/save-boom-reason',
            {
                tmoffer_id: $('#save-boom-reason-btn').data('id'),
                boom_reason: $.trim($('#boom-reason-text').val())
            },
            function (msg) {
                setTimeout(function () {
                    $('#tmfwaiting400_modal').modal('hide');
                }, 1000);
                if (msg.length) {
                    $('.sys-message .toast-body').text('Saved');
                } else {
                    $('.sys-message .toast-body').text('Unknown error during saving boom reason for client!');
                    setTimeout(function () {
                        $('#boom-reason-modal').modal('show');
                    }, 1000);
                }
                $('.sys-message').toast('show');
            }
        );
    });

    $('body').on('click', '.cancel-gc-booking-link', function () {
        if (confirm('Cancel Booking?')) {
            $('#tmfwaiting400_modal').modal('show');
            $.post(
                '/bookings-calendar/cancel-gc-booking',
                {gc_id: $(this).data('booking-id')},
                function (msg) {
                    setTimeout(function () {
                        $('#tmfwaiting400_modal').modal('hide');
                    }, 1000);
                    if (msg.length) {
                        reloadCalendar();
                        $('.sys-message .toast-body').text('Done');
                        $contextMenu.hide();
                    } else
                        $('.sys-message .toast-body').text('Unknown error during cancelling booking!');
                    $('.sys-message').toast('show');
                }
            );
        }
        return false;
    });

    $('body').on('click', '.resend-gc-zoom-link', function () {
        if (confirm('Resend Zoom Link to Client?')) {
            $('#tmfwaiting400_modal').modal('show');
            $.post(
                '/bookings-calendar/resend-gc-zoom-link-email',
                {gc_id: $(this).data('booking-id')},
                function (msg) {
                    setTimeout(function () {
                        $('#tmfwaiting400_modal').modal('hide');
                    }, 1000);
                    if (msg.length) {
                        $('.sys-message .toast-body').text('Done');
                        $contextMenu.hide();
                    } else
                        $('.sys-message .toast-body').text('Unknown error during loading email text!');
                    $('.sys-message').toast('show');
                }
            );
        }
        return false;
    });

    $('body').on('click', '.resend-oesou-zoom-link', function () {
        if (confirm('Resend Zoom Link to Client?')) {
            $('#tmfwaiting400_modal').modal('show');
            $.post(
                '/bookings-calendar/resend-oe-sou-zoom-link-email',
                {id: $(this).data('booking-id'),classname:$(this).data('classname')},
                function (msg) {
                    setTimeout(function () {
                        $('#tmfwaiting400_modal').modal('hide');
                    }, 1000);
                    if (msg.length) {
                        $('.sys-message .toast-body').text('Done');
                        $contextMenu.hide();
                    } else
                        $('.sys-message .toast-body').text('Unknown error during loading email text!');
                    $('.sys-message').toast('show');
                }
            );
        }
        return false;
    });

    $('body').on('click', '.cancel-booking-link', function () {
        if (confirm('Cancel Booking?')) {
            $('#tmfwaiting400_modal').modal('show');
            $.post(
                '/bookings-calendar/cancel-oesou-booking',
                {
                    id: $(this).data('booking-id'),
                    booking_type: $(this).data('booking-type'),
                    classname: $(this).data('classname')
                },
                function (msg) {
                    setTimeout(function () {
                        $('#tmfwaiting400_modal').modal('hide');
                    }, 1000);
                    if (msg.length) {
                        reloadCalendar();
                        $('.sys-message .toast-body').text('Done');
                        $contextMenu.hide();
                    } else
                        $('.sys-message .toast-body').text('Unknown error during cancelling booking!');
                    $('.sys-message').toast('show');
                }
            );
        }
        return false;
    });

    $('body').on('click','.copy-phone-link',function () {
        $contextMenu.hide();
        clipboard.writeText($(this).data('tel')).then(function(){
            $('.sys-message .toast-body').text('Phone number copied');
            $('.sys-message').toast('show');
        });
        return false;
    });

    $('body').on('click','#view-edit-notes-btn',function () {
        $(this).parents('div:eq(0)').hide();
        $('#notes-block').show();
    });

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

    $('body').on('change','#no-boom-reason',function () {
        handleSaveBtns();
    });

    $('#email-to-client-send-btn').click(function () {
        $('#email-to-client-modal').modal('hide');
        $('#tmfwaiting400_modal').modal('show');
        $.post(
            '/bookings-calendar/send-post-report-email',
            {
                tmoffer_id:$('#email-to-client-send-btn').data('id'),
                email:$.trim($('#my-email').val()),
                tmfsales_id:$('#my-who').val(),
                subj:$.trim($('#my-subject').val()),
                message:$('#my-message').summernote('code')
            },
            function (msg) {
                setTimeout(function () {
                    $('#tmfwaiting400_modal').modal('hide');
                }, 1000);
                if (msg.length) {
                    $('.sys-message .toast-body').text('Done');
                } else {
                    $('.sys-message .toast-body').text('Unknown error during sending email!');
                    $('#email-to-client-modal').modal('show');
                }
                $('.sys-message').toast('show');
            }
        );
    });

    $('body').on('click','.booking-info',function () {
        $('#tmfwaiting400_modal').modal('show');
        $.post(
            '/bookings-calendar/load-booking-info',
            {
                booking_id:$(this).data('booking-id')
            },
            function (msg) {
                setTimeout(function () {
                    $('#tmfwaiting400_modal').modal('hide');
                }, 1000);
                if (msg.length) {
                    $('#booking-info-modal .modal-title').text('Booking Info');
                    $('#booking-info-modal .modal-body').html(msg);
                    $('#booking-info-modal').modal('show');
                } else {
                    $('.sys-message .toast-body').text('Unknown error during loading booking info!');
                    $('.sys-message').toast('show');
                }
            }
        );
        return false;
    });

    $('body').on('click','.confirm-booking-link',function () {
        $contextMenu.hide();
        $('#tmfwaiting400_modal').modal('show');
        var el_li=$(this).parents('li:eq(0)');
        $.post(
            '/bookings-calendar/confirm-booking-link',
            {
                tmoffer_id:$(this).data('tmoffer-id')
            },
            function (msg) {
                setTimeout(function () {
                    $('#tmfwaiting400_modal').modal('hide');
                }, 1000);
                if (msg.length) {
                    el_li.remove();
                    reloadCalendar();
                    $('.sys-message .toast-body').text('Booking call confirmed');
                    $('.sys-message').toast('show');
                } else {
                    $('.sys-message .toast-body').text('Unknown error during confirmation booking info!');
                    $('.sys-message').toast('show');
                }
            }
        );
        return false;
    });

    $('body').on('click','.hfo-details',function () {
        var show=Number($(this).data('show'));
        if(!show){
            $(this).data('show',1);
            $('#hfo-details').show();
        }else{
            $(this).data('show',0);
            $('#hfo-details').hide();
        }
        return false;
    });

    $('body').on('click','.bookings-stat',function(){
        $('#tmfwaiting400_modal').modal('show');
        $.post(
            '/bookings-calendar/load-stat',
            {
                date:$(this).data('date')
            },
            function (msg) {
                setTimeout(function () {
                    $('#tmfwaiting400_modal').modal('hide');
                }, 1000);
                if (msg.length) {
                    $('#booking-info-modal .modal-title').text('Stat');
                    $('#booking-info-modal .modal-body').html(msg);
                    $('#booking-info-modal').modal('show');
                } else {
                    $('.sys-message .toast-body').text('Unknown error during loading bookings stat!');
                    $('.sys-message').toast('show');
                }
            }
        );
        return false;
    });

    $('body').on('click','.view-emails',function(){
        $('#tmfwaiting400_modal').modal('show');
        $.post(
            '/bookings-calendar/load-emails',
            {
                tmoffer_id:$(this).data('tmoffer-id')
            },
            function (msg) {
                setTimeout(function () {
                    $('#tmfwaiting400_modal').modal('hide');
                }, 1000);
                if (msg.length) {
                    $('#booking-info-modal .modal-title').text('History of actions');
                    $('#booking-info-modal .modal-body').html(msg);
                    $('#booking-info-modal').modal('show');
                } else {
                    $('.sys-message .toast-body').text('Unknown error during loading history of actions!');
                    $('.sys-message').toast('show');
                }
            }
        );
        return false;
    });
</script>