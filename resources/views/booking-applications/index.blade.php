@extends('layouts.app')

@section('title')
    Booking Applications
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        Booking Applications
                        @if($show_stats)
                        <a class="float-right" href="#" id="show-stats-link">Stats</a>
                        @endif
                    </div>
                    <div class="card-body">
                        <div class="text-center" style="margin-bottom:15px;@if($show_stats==0) display:none; @endif">
                            <?php echo $months_btns . $q_btns;?>
                            <button class="btn btn-sm btn-info y-btn" style="margin-right: 7px;color:white;">Y</button>
                            <?php echo $y_select;?>
                        </div>
                        <div class="text-center mb-3" style="@if($show_stats==0) display:none; @endif">
                            <label class="mr-3"><input type="radio" name="date-type-filter" id="pq-request-rb"
                                                       value="pq-request" checked/> PQ Request</label>
                            <label class="mr-3"><input type="radio" name="date-type-filter" id="booking-confirmed-rb"
                                                       value="booking-confirmed"/> Booking Confirmed</label>
                            <label class="mr-3" style="font-weight: normal;">
                                From Date: <input type="text" id="from_date" class="form-control"
                                                  placeholder="YYYY-MM-DD" value=""
                                                  style="width: 130px;display: inline-block">
                            </label>
                            <label style="font-weight: normal;">
                                To Date: <input type="text" id="to_date" class="form-control" placeholder="YYYY-MM-DD"
                                                value="<?php echo date('Y-m-d');?>"
                                                style="width: 130px;display: inline-block">
                            </label>
                        </div>
                        <div class="row mb-3">
                            <div class="col-4">
                                <div class="row">
                                    <label for="name" class="col-3">Name:</label>
                                    <div class="col-9">
                                        <input type="text" class="form-control" id="name"/>
                                    </div>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="row">
                                    <label for="email" class="col-3">Email:</label>
                                    <div class="col-9">
                                        <input type="email" class="form-control" id="email"/>
                                    </div>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="row">
                                    <label for="phone" class="col-3">Phone:</label>
                                    <div class="col-9">
                                        <input type="text" class="form-control" id="phone"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <table>
                                    <tr>
                                        <td style="white-space: nowrap;padding: 3px;vertical-align: top;">Lead Status:
                                        </td>
                                        <td style="padding: 3px;vertical-align: top;">
                                            <a href="#" data-class="lead-status-filter-chbx" data-all="1"
                                               class="all-btn badge badge-dark mr-3">ALL</a>
                                            @foreach(\App\LeadStatus::all() as $el)
                                                <label class="mr-3">
                                                    <input type="checkbox" class="lead-status-filter-chbx"
                                                           value="{{$el->id}}" checked=""> {{$el->name}}
                                                </label>
                                            @endforeach
                                            <label class="mr-3">
                                                <input type="checkbox" class="lead-status-filter-chbx"
                                                       value="-1" checked=""> UNCLAIMED
                                            </label>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <table>
                                    <tr>
                                        <td style="white-space: nowrap;padding: 3px;vertical-align: top;">SDR:</td>
                                        <td style="padding: 3px;vertical-align: top;">
                                            <a href="#" data-class="sdr-filter-chbx" data-all="1"
                                               class="all-btn badge badge-dark mr-3">ALL</a>
                                            <label class="mr-3">
                                                <input type="checkbox" class="sdr-filter-chbx" value="86" checked="">
                                                Nick
                                            </label>
                                            <label class="mr-3">
                                                <input type="checkbox" class="sdr-filter-chbx" value="115" checked="">
                                                George
                                            </label>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <table>
                                    <tr>
                                        <td style="white-space: nowrap;padding: 3px;vertical-align: top;">BOOM Status:
                                        </td>
                                        <td style="padding: 3px;vertical-align: top;">
                                            <a href="#" data-class="boom-status-filter-chbx" data-all="1"
                                               class="all-btn badge badge-dark mr-3">ALL</a>
                                            <label class="mr-3">
                                                <input type="checkbox" class="boom-status-filter-chbx" value="boom"
                                                       checked=""> BOOM!
                                            </label>
                                            <label class="mr-3">
                                                <input type="checkbox" class="boom-status-filter-chbx" value="no-boom"
                                                       checked=""> No BOOM
                                            </label>
                                            <label class="mr-3">
                                                <input type="checkbox" class="boom-status-filter-chbx"
                                                       value="future-booking" checked=""> Future Booking
                                            </label>
                                            <label>
                                                <input type="checkbox" class="boom-status-filter-chbx"
                                                       value="no-booking" checked=""> No Booking
                                            </label>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <table>
                                    <tr>
                                        <td style="white-space: nowrap;padding: 3px;vertical-align: top;">From:</td>
                                        <td style="padding: 3px;vertical-align: top;">
                                            <a href="#" data-class="from-filter-chbx" data-all="1"
                                               class="all-btn badge badge-dark mr-3">ALL</a>
                                            <label class="mr-3">
                                                <input type="checkbox" class="from-filter-chbx" value="FB Paul LaMarca Ad" checked="">
                                                Paul LaMarca FB Ad
                                            </label>
                                            <label class="mr-3">
                                                <input type="checkbox" class="from-filter-chbx" value="Instagram" checked="">
                                                Instagram
                                            </label>
                                            <label class="mr-3">
                                                <input type="checkbox" class="from-filter-chbx" value="Other" checked="">
                                                Other
                                            </label>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <div id="result-table">
                            @include('booking-applications.result-table')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('modals')
    @include('booking-applications.client-file-modal')
    @include('booking-applications.email-to-client-modal')
    @include('booking-applications.client-data-modal')
    @include('booking-applications.call-report-modal')
    @include('booking-applications.notes-preview-modal')
    @include('booking-applications.claimed-warning-modal')
    @include('booking-applications.closer-notes-preview-modal')
    @include('booking-applications.stat-modal')
    <div style="position: fixed; top: 15px; right: 15px;z-index:-1000;">
        <div class="toast sys-message" role="alert" aria-live="polite" aria-atomic="true" data-delay="3000"
             data-animation="true" style="width: 350px;">
            <div class="toast-header">
                <img src="/img/magentatmf.png" style="width: 16px;height: 16px;" class="rounded mr-2">
                <strong class="mr-auto">System Message</strong>
                <small class="text-muted">just now</small>
                <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="toast-body">
                Saved
            </div>
        </div>
    </div>
    {!! \App\classes\SmsSender::getModalHtml() !!}
@endsection

@section('external-jscss')
    @include('booking-applications.css')
    @include('post-boom-bookings-calendar.css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.css" rel="stylesheet">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.1/themes/smoothness/jquery-ui.css">
    <script src="//code.jquery.com/jquery-migrate-3.0.0.min.js" type="text/javascript"></script>
    <script src="//code.jquery.com/ui/1.11.1/jquery-ui.js" type="text/javascript"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment.min.js"></script>
    <script src="https://trademarkfactory.com/js/moment-timezone-with-data.js"></script>
    <link rel="stylesheet" href="{{asset('plugins/summernote/summernote-bs4.css')}}">
    <script src="{{asset('plugins/summernote/summernote-bs4.min.js')}}"></script>
    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
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
                    maxDate: "2025-06-10",

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

        function reloadResultTable() {
            $.get(
                '/booking-applications{{($show_stats==0)?'-2w':''}}/reload-table',
                function (msg) {
                    $('#result-table').html(msg);
                    showHideResultTableRows();
                }
            );
        }

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
                        $('.sys-message .toast-body').text('Unknown error during loading email details!');
                        $('.sys-message').toast('show');
                    }
                }
            );
            return false;
        });

        $('body').on('click', '.show-request-info', function () {
            $('#tmfwaiting400_modal').modal('show');
            $.post(
                '/booking-applications/show-request-info',
                {id: $(this).data('id')},
                function (msg) {
                    setTimeout(function () {
                        $('#tmfwaiting400_modal').modal('hide');
                    }, 1000);
                    if (msg.length) {
                        $('#client-data-modal .modal-dialog').removeClass('modal-lg');
                        $('#client-data-modal .modal-title').html('Request Details');
                        $('#client-data-modal .modal-body').html(msg);
                        $('#client-data-modal').modal('show');
                    } else {
                        $('.sys-message .toast-body').text('Unknown error during loading request info!');
                        $('.sys-message').toast('show');
                    }
                }
            );
            return false;
        });

        $('body').on('click', '.show-client-data', function () {
            let data_block = '<div>Client: ' + $.trim($(this).text()) + '</div>' +
                '<div>Email: <a href="mailto:' + $(this).data('email') + '" target="_blank">' + $(this).data('email') + '</a></div>' +
                '<div>Phone: <a href="tel:' + $(this).data('phone') + '" target="_blank">' + $(this).data('phone') + '</a></div>';
            $('#client-data-modal .modal-dialog').removeClass('modal-lg');
            $('#client-data-modal .modal-title').html('Client Info');
            $('#client-data-modal .modal-body').html(data_block);
            $('#client-data-modal').modal('show');
            return false;
        });

        $('.note-editable').css('font-size', 'initial');

        let service_btns_clicked = 0;
        let email = '';

        function loadClientFileHtml(id) {
            $('#tmfwaiting400_modal').modal('show');
            $.post(
                '/booking-applications',
                {id: id},
                function (msg) {
                    setTimeout(function () {
                        $('#tmfwaiting400_modal').modal('hide');
                    }, 1000);
                    if (msg.length) {
                        service_btns_clicked = 0;
                        $('#client-file-modal .client-answers').html(msg);
                        $('#notify-by-sms-chbx').prop('checked', true);
                        $('#client-file-modal').modal('show');
                    } else {
                        $('.sys-message .toast-body').text('Unknown error during loading client\'s data!');
                        $('.sys-message').toast('show');
                    }
                }
            );
        }

        let current_id = 0;
        $('.show-answers').click(function () {
            current_id = $(this).data('id');
            loadClientFileHtml(current_id);
            return false;
        });

        function loadProspectAnswers() {
            let answers = [];
            $('.prospect-answer').each(function () {
                var re = /<br><br>/gi;
                var str = $.trim($(this).html());
                var newstr = str.replace(re, ' / ');
                answers.push(newstr);
            });
            $('#prospect-answers').html(answers.join('<br/>'));
        }


        $('body').on('click', '.approve-for-booking-btn', function () {
            service_btns_clicked = 1;
            email = 'approve-for-booking';
            $('#client-file-modal').modal('hide');
            $.post(
                '/booking-applications/approve-for-booking',
                {id: $(this).data('id')},
                function (msg) {
                    if (Object.keys(msg).length) {
                        $('#email-to-client-modal .modal-title').text('Approve for Booking');
                        $('#my-email').val(msg.email);
                        $('#my-who').val({{\Illuminate\Support\Facades\Auth::user()->ID}});
                        $('#my-subject').val(msg.subj);
                        $('#my-message').summernote('code', msg.message);
                        loadProspectAnswers();
                        $('#email-to-client-modal').modal('show');
                    } else {
                        $('.sys-message .toast-body').text('Unknown error during loading data for approving!');
                        $('.sys-message').toast('show');
                    }
                }
            );
        });

        $('body').on('click', '.follow-up-btn', function () {
            service_btns_clicked = 1;
            email = 'follow-up-email';
            $('#client-file-modal').modal('hide');
            $.post(
                '/booking-applications/follow-up-email',
                {id: $(this).data('id')},
                function (msg) {
                    if (Object.keys(msg).length) {
                        $('#email-to-client-modal .modal-title').text('Follow-Up Email');
                        $('#my-email').val(msg.email);
                        $('#my-who').val({{\Illuminate\Support\Facades\Auth::user()->ID}});
                        $('#my-subject').val(msg.subj);
                        $('#my-message').summernote('code', msg.message);
                        loadProspectAnswers();
                        $('#email-to-client-modal').modal('show');
                    } else {
                        $('.sys-message .toast-body').text('Unknown error during loading data for follow-up email!');
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
                    id: current_id,
                    notify_by_sms: ($('#notify-by-sms-chbx').prop('checked') ? 1 : 0)
                },
                function (msg) {
                    setTimeout(function () {
                        $('#tmfwaiting400_modal').modal('hide');
                    }, 1000);
                    if (msg.length) {
                        current_id = 0;
                        $('.sys-message .toast-body').text('Done');
                        if (service_btns_clicked)
                            reloadResultTable();
                    } else {
                        $('.sys-message .toast-body').text('Unknown error during sending email!');
                        $('#email-to-client-modal').modal('show');
                    }
                    $('.sys-message').toast('show');
                }
            );
        });

        $('body').on('click', '#email-to-client-modal .btn.btn-secondary', function () {
            $('#email-to-client-modal').modal('hide');
            loadClientFileHtml(current_id);
        });

        @if($current_id)
        $(document).ready(function () {
            current_id ={{$current_id}};
            loadClientFileHtml(current_id);
        });

        @endif

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

        $('body').on('click', '#add-date', function () {
            addDateToEl('notes');
            return false;
        });

        $('body').on('click', '.unclaimed-link', function () {
            $('#tmfwaiting400_modal').modal('show');
            var id = $(this).data('id');
            var parent_cell = $(this).parents('td:eq(0)');
            $.post(
                '/booking-applications/sdr-status',
                {id: id},
                function (obj) {
                    setTimeout(function () {
                        $('#tmfwaiting400_modal').modal('hide');
                    }, 1000);
                    console.log(obj);
                    if (obj.status == 'error') {
                        $('.sys-message .toast-body').text('Unknown error during checking status!');
                        $('.sys-message').toast('show');
                        return 0;
                    }
                    if (obj.status == 'free') {
                        $('input[name="lead-temp"][value="3"]').prop('checked', true);
                        $('#lead-need-tm-1').prop('checked', true);
                        $('#lead-knows-tmf-offer-1').prop('checked', true);
                        $('#notes').val('');
                        $('#claim-pq-btn').data('id', id);
                        $('#call-report-modal').modal('show');
                    } else {
                        parent_cell.css('background', obj.background);
                        parent_cell.html(obj.html);
                        let ecr = parent_cell.find('.edit-claimed-request:eq(0)');
                        $('input[name="lead-temp"][value="' + ecr.data('temperature') + '"]').prop('checked', true);
                        $('#lead-need-tm-' + ecr.data('needs-tm')).prop('checked', true);
                        $('#lead-knows-tmf-offer-' + ecr.data('knows-offer')).prop('checked', true);
                        $('#lead-status').val(ecr.data('lead-status'));
                        $('#notes').val($('.pq-notes[data-id="' + ecr.data('id') + '"]').data('notes'));
                        $('#claim-pq-btn').data('id', id);
                        let text = 'It looks like this lead has already been claimed by ' + obj.sdr_fname + ' on ' + obj.claimed_datetime + ' PST.';
                        $('#claimed-warning-modal .modal-body p').text(text);
                        $('#claimed-warning-modal .btn.btn-primary').text('Let ' + obj.sdr_fname + ' Deal With It');
                        $('#claimed-warning-modal').modal('show');
                    }
                }
            );
            return false;
        });

        $('body').on('click', '#reclaim-lead-btn', function () {
            $('#claimed-warning-modal').modal('hide');
            $('#call-report-modal').modal('show');
        });

        $('body').on('click', '.edit-claimed-request', function () {
            $('input[name="lead-temp"][value="' + $(this).data('temperature') + '"]').prop('checked', true);
            $('#lead-need-tm-' + $(this).data('needs-tm')).prop('checked', true);
            $('#lead-knows-tmf-offer-' + $(this).data('knows-offer')).prop('checked', true);
            $('#lead-status').val($(this).data('lead-status'));
            $('#notes').val($('.pq-notes[data-id="' + $(this).data('id') + '"]').data('notes'));
            $('#claim-pq-btn').data('id', $(this).data('id'));
            $('#call-report-modal').modal('show');
            return false;
        });

        $('body').on('click', '#claim-pq-btn', function () {
            $('#call-report-modal').modal('hide');
            $('#tmfwaiting400_modal').modal('show');
            $.post(
                '/booking-applications/call-report',
                {
                    temperature: $('input[name="lead-temp"]:checked').val(),
                    needs_tm: $('input[name="lead-need-tm"]:checked').val(),
                    knows_offer: $('input[name="lead-knows-tmf-offer"]:checked').val(),
                    lead_status: $('#lead-status').val(),
                    notes: $.trim($('#notes').val()),
                    id: $(this).data('id')
                },
                function (msg) {
                    setTimeout(function () {
                        $('#tmfwaiting400_modal').modal('hide');
                    }, 1000);
                    if (msg.length) {
                        $('.sys-message .toast-body').text('Saved');
                        $('.sys-message').toast('show');
                        reloadResultTable();
                    } else {
                        $('.sys-message .toast-body').text('Unknown error during saving data!');
                        $('.sys-message').toast('show');
                        $('#call-report-modal').modal('hide');
                    }
                }
            );
        });


        $('body').on('click', '.pq-notes', function () {
            $('#notes-preview-block').html($(this).data('notes-alt'));
            $('#notes-preview-modal').modal('show');
            return false;
        });

        function showHideResultTableRows() {
            let name = $.trim($('#name').val());
            let email = $.trim($('#email').val());
            let phone = $.trim($('#phone').val());
            let total_length = name.length + email.length + phone.length;
            let lead_statuses = [];
            $('.lead-status-filter-chbx:checked').each(function () {
                lead_statuses.push(Number($(this).val()));
            });

            let sdrs = [];
            $('.sdr-filter-chbx:checked').each(function () {
                sdrs.push(Number($(this).val()));
            });
            if (sdrs.length == 0)
                sdrs.push(0);

            let boom_statuses = [];
            $('.boom-status-filter-chbx:checked').each(function () {
                boom_statuses.push($(this).val());
            });

            let from_arr = [];
            $('.from-filter-chbx:checked').each(function () {
                from_arr.push($(this).val());
            });


            if (total_length) {
                $('.result-table-rows:not(.test)').each(function () {
                    let show = 0;
                    let client_data_el = $(this).find('.show-client-data:eq(0)');
                    if (
                        (
                            name.length &&
                            $.trim(client_data_el.text().toLowerCase()).indexOf(name) != -1
                        ) ||
                        (
                            email.length &&
                            client_data_el.data('email').toLowerCase().indexOf(email) != -1
                        ) ||
                        (
                            phone.length &&
                            client_data_el.data('phone').toString().toLowerCase().indexOf(phone) != -1
                        )
                    )
                        show = 1;

                    let from_date_show = 1;
                    if ($('#from_date').length) {
                        if ($('#pq-request-rb').prop('checked')) {
                            if ($(this).data('request-date') < $('#from_date').val())
                                from_date_show = 0;
                        } else if ($(this).data('booked-confirmed') == 'N/A' ||
                            ($(this).data('booked-confirmed') != 'N/A' &&
                                $(this).data('booked-confirmed') < $('#from_date').val())
                        )
                            from_date_show = 0;

                    }

                    let to_date_show = 1;
                    if ($('#to_date').length) {
                        if ($('#pq-request-rb').prop('checked')) {
                            if ($(this).data('request-date') > $('#to_date').val())
                                to_date_show = 0;
                        } else if ($(this).data('booked-confirmed') == 'N/A' ||
                            ($(this).data('booked-confirmed') != 'N/A' &&
                                $(this).data('booked-confirmed') > $('#to_date').val())
                        )
                            to_date_show = 0;
                    }

                    if (show &&
                        lead_statuses.indexOf(Number($(this).data('lead-status-id'))) != -1 &&
                        sdrs.indexOf(Number($(this).data('sdr'))) != -1 &&
                        boom_statuses.indexOf($(this).data('boom-status')) != -1 &&
                        from_arr.indexOf($(this).data('from'))!=-1 &&
                        from_date_show && to_date_show
                    )
                        $(this).show();
                    else
                        $(this).hide();
                });
            } else {
                $('.result-table-rows:not(.test)').each(function () {
                    let from_date_show = 1;
                    if ($('#from_date').length) {
                        if ($('#pq-request-rb').prop('checked')) {
                            if ($(this).data('request-date') < $('#from_date').val())
                                from_date_show = 0;
                        } else if ($(this).data('booked-confirmed') == 'N/A' ||
                            ($(this).data('booked-confirmed') != 'N/A' &&
                                $(this).data('booked-confirmed') < $('#from_date').val())
                        )
                            from_date_show = 0;

                    }

                    let to_date_show = 1;
                    if ($('#to_date').length) {
                        if ($('#pq-request-rb').prop('checked')) {
                            if ($(this).data('request-date') > $('#to_date').val())
                                to_date_show = 0;
                        } else if ($(this).data('booked-confirmed') == 'N/A' ||
                            ($(this).data('booked-confirmed') != 'N/A' &&
                                $(this).data('booked-confirmed') > $('#to_date').val())
                        )
                            to_date_show = 0;
                    }

                    if (
                        lead_statuses.indexOf(Number($(this).data('lead-status-id'))) != -1 &&
                        sdrs.indexOf(Number($(this).data('sdr'))) != -1 &&
                        boom_statuses.indexOf($(this).data('boom-status')) != -1 &&
                        from_arr.indexOf($(this).data('from'))!=-1 &&
                        from_date_show && to_date_show
                    )
                        $(this).show();
                    else
                        $(this).hide();
                });
            }
        }

        $('body').on('keyup', '#name,#phone,#email', function () {
            showHideResultTableRows();
        });

        $('body').on('click', '.call-report-link', function () {
            $('#tmfwaiting400_modal').modal('show');
            $.post(
                '/bookings-calendar/load-report-call-body',
                {tmoffer_id: $(this).data('tmoffer-id')},
                function (msg) {
                    setTimeout(function () {
                        $('#tmfwaiting400_modal').modal('hide');
                    }, 1000);
                    if (msg.length) {
                        $('#closer-notes-preview-modal .modal-body .result').html(msg);
                        // initDatePicker();
                        $('#closer-notes-preview-modal').modal('show');
                    } else {
                        $('.sys-message .toast-body').text('Unknown error during loading report call body!');
                        $('.sys-message').toast('show');
                    }
                }
            );
            return false;
        });

        $('body').on('click', '.lead-status-filter-chbx, .sdr-filter-chbx, .boom-status-filter-chbx,.from-filter-chbx', function () {
            showHideResultTableRows();
        });

        $('body').on('change', '#from_date, #to_date', function () {
            showHideResultTableRows();
        });

        $('body').on('click', '.all-btn', function () {
            var current_class_selector = '.' + $(this).data('class');
            if ($(current_class_selector + ':checked').length < $(current_class_selector).length) {
                $(current_class_selector).prop('checked', true);
            } else
                $(current_class_selector).prop('checked', false);
            showHideResultTableRows();
            // loadFilterData();
            // redrawCalendar();
            return false;
        });

        $('.q-btn,.month-btn').click(function () {
            $('#from_date').val($('#s-year').val() + '-' + $(this).data('from'));
            $('#to_date').val($('#s-year').val() + '-' + $(this).data('to'));
            showHideResultTableRows();
        });

        $('.y-btn').click(function () {
            $('#from_date').val($('#s-year').val() + '-01-01');
            $('#to_date').val($('#s-year').val() + '-12-31');
            showHideResultTableRows();
        });

        $('body').on('change','input[name="date-type-filter"]',function () {
            showHideResultTableRows();
        });

        function calculateStat() {
            let requests_handled=$('.result-table-rows:visible:not([data-lead-status-id="-1"])').length;
            let successful_calls=$('.result-table-rows:visible:not([data-lead-status-id="-1"],[data-lead-status-id="5"],[data-lead-status-id="1"])').length;
            let total_bookings=$('.result-table-rows:visible:not([data-booked-confirmed="N/A"])').length;
            let future_bookings=$('.result-table-rows:visible[data-boom-status="future-booking"]').length;
            let noshows=$('.result-table-rows:visible[data-noshow="1"]').length;
            let booms=$('.result-table-rows:visible[data-boom-status="boom"]').length;
            let tms_count=0;
            $('.result-table-rows:visible[data-boom-status="boom"]').each(function () {
                tms_count+=Number($(this).data('tms-count'));
            });
            let boom_rate=Math.round(100*booms/(total_bookings-future_bookings)).toFixed(2);
            let boom_rate_minus_noshows=Math.round(100*booms/(total_bookings-future_bookings-noshows)).toFixed(2);

            let html='<p>Requests handled: '+requests_handled+'</p>' +
                '<p>Successful calls: '+successful_calls+'</p>'+
                '<p>Total Bookings: '+total_bookings+' ('+Math.round(100*total_bookings/successful_calls).toFixed(2)+'%)</p>'+
                '<p>Future Bookings: '+future_bookings+'</p>' +
                '<p>No-Shows: '+noshows+'</p>' +
                '<p>BOOMs: '+booms+' ('+tms_count+' TM'+(tms_count>1?'s':'')+')</p>' +
                '<p>BOOM Rate: '+boom_rate+'%</p>' +
                '<p>BOOM Rate Minus No-Shows: '+boom_rate_minus_noshows+'%</p>';

            $('#stat-modal .modal-body').html(html);
        }

        $('#show-stats-link').click(function () {
            calculateStat();
            $('#stat-modal').modal('show');
            return false;
        });
    </script>
    {!! \App\classes\SmsSender::getJs('.send-sms-to-person') !!}
@endsection