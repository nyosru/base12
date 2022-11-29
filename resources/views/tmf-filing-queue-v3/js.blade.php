<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    let selected_dashboard_id = 0;
    let datatables = [];

    let current_tms_data;

    String.prototype.stripSlashes = function () {
        return this.replace(/\\(.)/mg, "$1");
    }

    function stripslashes(str) {
        return (str + '').replace(/\\(.?)/g, function (s, n1) {
            switch (n1) {
                case '\\':
                    return '\\';
                case '0':
                    return '\u0000';
                case '':
                    return '';
                default:
                    return n1;
            }
        });
    }

    function htmlEntities(str) {
        return String(str).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');
    }

    function htmlFromTmsData(tms_data) {
        let html = '';
        $.each(tms_data, function (index, data) {
            html += '<div class="d-inline-block ml-2 mb-2" style="width:450px;">' +
                // '<div class="card sub-status-tm" style="width: 450px;"' +
                '<div class="card sub-status-tm shadow" style="width: 450px;"' +
                'data-dashboard-id="' + data.dashboard_id + '"' +
                'data-tmfsales-id="' + data.tmfsales_id + '"' +
                'data-tmoffer-login="' + data.tmoffer_login + '"' +
                'data-tmoffer-id="' + data.tmoffer_id + '"' +
                'data-addy-note="' + htmlEntities(stripslashes(data.addy_note)) + '"' +
                'data-trigger="' + data.trigger + '">' +
                '    <div class="card-body pb-0 pt-2">\n' +
                '        <h5 class="card-title text-left client-flag-block">\n' +
                '            <div class="d-inline-block client-caption">' + data.client + '</div>\n' +
                '            <div class="float-right">' + stripslashes(data.country_flag) + '</div>\n' +
                '        </h5>\n' +
                '        <div class="d-flex align-middle" style="height: 75px;">\n' +
                '        <h5 class="card-title tm-module line-clamp"><strong>' + stripslashes(data.mark) + '</strong></h5>\n' +
                '        </div>\n' +
                '    </div>\n' +
                '    <div class="card-text">\n' +
                '        <div class="d-table w-100">\n' +
                '            <div class="d-table-row">\n' +
                '                <div class="d-table-cell text-center border-right border-bottom p-2">NEXT DEADLINE: ' + data.hard_deadline + '</div>\n' +
                '                <div class="d-table-cell text-center border-bottom p-2" style="width:150px;">\n' +
                '                    <i class="fas fa-user ' + data.owner_text_color_class + '"></i> ' + data.owner_login + '\n' +
                '                </div>\n' +
                '            </div>\n' +
                '            <div class="d-table-row">\n' +
                '                <div class="d-table-cell border-right">\n' +
                '                    <div class="d-table w-100 text-center">\n' +
                '                        <div class="d-table-row">\n' +
                '                            <div class="d-table-cell border-right p-2" title="' + (data.boom_when_by.length ? data.boom_when_by : data.trigger) + '">' + stripslashes(data.time_since_caption_icon) + ' ' + data.time_since_formatted + '</div>\n' +
                '                            <div class="d-table-cell ' + data.flag_bg_class + ' p-2"><i class="far fa-clock"></i> ' + data.pending_in_this_status + '</div>\n' +
                '                        </div>\n' +
                '                    </div>\n' +
                '                </div>\n' +
                '                <div class="d-table-cell text-center p-2" style="width:150px;">\n' +
                '                    <i class="fas fa-user-clock"></i> ' + data.time_since_owner + '\n' +
                '                </div>\n' +
                '            </div>\n' +
                '        </div>\n' +
                '    </div>\n' +
                '</div>' +
                '</div>';
        });
        return html;
    }

    function getBadgeHtml(badge_val, badge_class) {
        if (badge_val)
            return '<span class="badge ' + badge_class + ' ml-1">' + badge_val + '</span>';
        return '';
    }

    function htmlFromClientsTmsData(clients_tms_data) {
        let html = '';
        let index = 0;
        $.each(clients_tms_data, function (client_name, client_data) {
            html += '<div class="accordion client-tms-block" id="ctb-' + index + '">' +
                '        <div class="card">' +
                '            <div class="card-header" id="client-tms-block-' + index + '">' +
                '                <h2 class="mb-0">' +
                '                    <button class="d-flex align-items-center btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#collapse-' + index + '" aria-expanded="false" aria-controls="collapse-' + index + '">' +
                '                        <div class="flex-grow-1 mr-2">' +
                '                            ' + client_name + ' [' + client_data.data.length + ']' +
                '                        </div>' +
                '                        <div class="flex-shrink-1">' +
                getBadgeHtml(client_data['badge-success'], 'badge-success') +
                getBadgeHtml(client_data['badge-warning'], 'badge-warning') +
                getBadgeHtml(client_data['badge-danger'], 'badge-danger') +
                '                        </div>\n' +
                '                    </button>\n' +
                '                </h2>\n' +
                '            </div>\n' +
                '            <div id="collapse-' + index + '" class="collapse" aria-labelledby="client-tms-block-' + index + '" data-parent="#ctb-' + index + '">\<n></n>' +
                '            <div class="card-body">' +
                htmlFromTmsData(client_data.data) +
                '</div></div></div></div>';
            index++;
        });
        return html;
    }

    function loadSubStatusTms(substatus_id) {
        let root_id = $('.sub-status[data-id="' + substatus_id + '"]').data('root-id');
        let group_by_client = (selected_dashboard_id ? 0 : ($('input[name="group-by-client"]').prop('checked') ? 1 : 0));
        if (!$('#tmfwaiting400_modal').is(':visible'))
            $('#tmfwaiting400_modal').modal('show');
        $.post(
            location.pathname + '/load-sub-status-tms/' + substatus_id,
            {
                days: ($('.days-select[data-root-id="' + root_id + '"]').length ? $('.days-select[data-root-id="' + root_id + '"]').val() : 0),
                group_by_client: group_by_client
            },
            function (msg) {
                setTimeout(function () {
                    $('#tmfwaiting400_modal').modal('hide');
                }, 1000);
                let html;
                if (Number(group_by_client)) {
                    // $('#tms-area').html(msg);
                    // $('#tms-area').show();
                    current_tms_data = msg;
                    html = htmlFromClientsTmsData(current_tms_data);
                } else {
                    current_tms_data = msg;
                    current_tms_data.sort(function (a, b) {
                        return (a.pending_in_this_status_delta > b.pending_in_this_status_delta ? -1 : 1)
                    });
                    html = htmlFromTmsData(current_tms_data);
                    // console.log(current_tms_data);
                }
                $('#tms-area').html(html);
                $('#tms-area').show();

                /*                datatables = [];
                                if (group_by_client == 0)
                                    $('.item-table').each(function () {
                                        datatables.push($(this).DataTable({
                                            'searching': false,
                                            "info": false,
                                            "scrollY": $(window).height() - $('.item-table:eq(0)').offset().top - 110,
                                            'scroller': true,
                                            "sScrollX": "100%",
                                            // 'bAutoWidth': true,
                                            "scrollCollapse": true,
                                            "order": [[6, "desc"]]
                                        }));
                                    });*/
                resizeTmsListHeight();
                if (selected_dashboard_id) {
                    $('.sub-status-tm[data-dashboard-id="' + selected_dashboard_id + '"]').css({
                        'animation-name': 'show_selected_row',
                        'animation-duration': '8s'
                    });
                    $('#tms-area').animate({
                        scrollTop: $('.sub-status-tm[data-dashboard-id="' + selected_dashboard_id + '"]').offset().top - 100
                    }, 2000);
                    selected_dashboard_id = 0;
                }
                imagePreview();
                /*                if (selected_dashboard_id) {
                                    datatables[0].scroller.toPosition(
                                        $('.sub-status-tm[data-dashboard-id="' + selected_dashboard_id + '"]').index()
                                    );
                                    $('.sub-status-tm[data-dashboard-id="' + selected_dashboard_id + '"]').css({
                                        'animation-name': 'show_selected_row',
                                        'animation-duration': '8s'
                                    });
                                    selected_dashboard_id = 0;
                                }*/
            }
        );
    }


    $('body').on('shown.bs.collapse', '#client-tms-block', function () {
        let t_id = $(this).find('.item-table').attr('id');
        if (datatables.indexOf(t_id) == -1) {
            $('#' + t_id).DataTable({
                'searching': false,
                "info": false,
                'scrollY': '450px',
                "sScrollX": "100%",
                // 'bAutoWidth': true,
                "scrollCollapse": true,
                "paging": false,
                "order": [[4, "desc"]]
            });
            datatables.push(t_id);
        }
    });

    function paintRootStatusNumbers(root_id) {
        var obj = {
            'badge-success': 0,
            'badge-warning': 0,
            'badge-danger': 0
        };

        $('button.sub-status[data-root-id="' + root_id + '"]').each(function () {
            var el = $(this);
            $.each(Object.keys(obj), function (i, val) {
                if (el.find('.badge.' + val).length) {
                    let b_val = $.trim(el.find('.badge.' + val).text());
                    obj[val] += Number(b_val);
                }
            });
        });

        let html = '';
        $.each(Object.keys(obj), function (i, val) {
            if (obj[val])
                html += '<span class="badge ' + val + ' ' + (i == 0 ? '' : 'ml-1') + '">' + obj[val] + '</span>';
        });
        $('.root-numbers-block[data-id="' + root_id + '"]').html(html);

        let total = 0;
        $('.total[data-root-id="' + root_id + '"]').each(function () {
            total += Number($.trim($(this).text()));
        });
        $('.root-total[data-id="' + root_id + '"]').text(total);
    }

    function loadSubStatusNumbers() {
        $('.numbers-block.empty').each(function () {
            let root_id = $(this).data('root-id');
            $.post(
                location.pathname + '/sub-status-numbers/' + $(this).data('id'),
                {days: ($('.days-select[data-root-id="' + root_id + '"]').length ? $('.days-select[data-root-id="' + root_id + '"]').val() : 0)},
                function (msg) {
                    $('.numbers-block.empty[data-id="' + msg.id + '"]').html(msg.html).removeClass('empty');
                    $('.total[data-id="' + msg.id + '"]').text(msg.total);
                    if (!$('.numbers-block.empty[data-root-id="' + msg.root_id + '"]').length)
                        paintRootStatusNumbers(msg.root_id);
                }
            );
        });
    }

    function resizeTmsListHeight() {
        if ($('#tms-area').is(':visible'))
            $('#tms-area').css('max-height', $(window).height() - $('#tms-area').offset().top - 35);
    }

    $('body').on('click', '.sub-status', function () {
        $('.sub-status.active').removeClass('active');
        $(this).addClass('active');
        loadSubStatusTms($(this).data('id'));
    });

    $('body').on('click', '.s-status', function () {
        $('.s-status.active').removeClass('active');
        $(this).addClass('active');
    });

    var $contextMenu = $("#context-menu");
    var cm_item = null;

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
        var d = setContextMenuPostion(e, el_menu);

        el_menu.css({
            display: "block",
            left: d.x,
            top: d.y
        });

    }

    function hideContextMenu() {
        $contextMenu.hide();
        cm_item = null;
    }

    function showContextMenuEvent(el, e) {
        cm_item = el;
        if (el.data('trigger') == 'BOOM')
            $('.view-in-aa-link').show();
        else
            $('.view-in-aa-link').hide();

        let tmfsales_id = Number(el.data('tmfsales-id'));
        if (tmfsales_id =={{\Illuminate\Support\Facades\Auth::user()->ID}}) {
            $('.claim-link').hide();
            $('.unclaim-link,.request-review-link').show();
        } else {
            $('.claim-link').show();
            $('.unclaim-link,.request-review-link').hide();
        }

        if (el.data('tmoffer-login').length) {
            $('.view-in-search-report-link,#print-shipping-link').show();
            $('.tmfentry-link').show();
        } else {
            $('.view-in-search-report-link,#print-shipping-link').hide();
            $('.tmfentry-link').hide();
        }
        showContextMenu($contextMenu, e);
    }

    $("body").on("contextmenu", ".sub-status-tm", function (e) {
        showContextMenuEvent($(this), e);
        return false;
    });

    $("body").on("click", ".sub-status-tm", function (e) {
        showContextMenuEvent($(this), e);
        return false;
    });

    $('body').on('click', '.view-in-dashboard-link', function () {
        let url = 'https://trademarkfactory.com/mlcclients/dashboard-trademarks-details.php?id=' + cm_item.data('dashboard-id');
        window.open(url, '_blank');
        hideContextMenu();
        return false;
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

    $('body').on('click', '#add-date', function () {
        addDateToEl('notes');
        return false;
    });

    $('body').on('click', '#add-date-alt', function () {
        addDateToEl('notes-alt');
        return false;
    });

    $('body').on('click', '.print-shipping-link', function () {
        let tmoffer_id = cm_item.data('tmoffer-id');
        let addy_note = cm_item.data('addy-note');
        $('input[name="tmoffer_id"]').val(tmoffer_id);
        $('input[name="addy"]').val(addy_note.addy);
        $('input[name="note"]').val(addy_note.note);
        $('#shipping-label-form').submit();
        return false;
    });


    $('body').on('click', '.dashboard-notes-link', function () {
        $('#tmfwaiting400_modal').modal('show');
        let dashboard_id = cm_item.data('dashboard-id');
        $.post(
            location.pathname + '/load-dashboard-notes',
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

    $('body').on('click', '.show-history-link', function () {
        $('#tmfwaiting400_modal').modal('show');
        let dashboard_id = cm_item.data('dashboard-id');
        $.post(
            location.pathname + '/load-history',
            {id: dashboard_id},
            function (msg) {
                setTimeout(function () {
                    $('#tmfwaiting400_modal').modal('hide');
                }, 1000);
                $('#history-modal .modal-body').html(msg);
                $('#history-modal').modal('show');
            }
        );
        hideContextMenu();
        return false;
    });

    $('#save-notes-data').click(function () {
        $('#notes-modal').modal('hide');
        $('#tmfwaiting400_modal').modal('show');
        $.post(
            location.pathname + '/save-dashboard-notes',
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


    $('body').on('click', '.view-in-search-report-link', function () {
        let url = 'https://trademarkfactory.com/searchreport/' + cm_item.data('tmoffer-login') + '&donttrack=donttrack';
        window.open(url, '_blank');
        hideContextMenu();
        return false;
    });

    $('body').on('click', '.view-in-aa-link', function () {
        let url = 'https://trademarkfactory.com/mlcclients/acceptedagreements.php?login=' + cm_item.data('tmoffer-login') + '&sbname=&sbphone=&sbtm=&sbemail=&sbnote=&date_from=&date_to=&affiliate_camefrom=&sort_by=new_logins_first&show=ALL&sbmt_btn=SEARCH&page=1';
        window.open(url, '_blank');
        hideContextMenu();
        return false;
    });

    $('body').on('click', '.tmfentry-link', function () {
        let url = 'https://trademarkfactory.com/mlcclients/tmfentry/' + cm_item.data('tmoffer-login') + '?show=searchresults';
        window.open(url, '_blank');
        hideContextMenu();
        return false;
    });

    $('body').on('click', '.request-review-link', function () {
        $('#request-review-yes-btn').data('dashboard-id', cm_item.data('dashboard-id'));
        $('#request-review-modal').modal('show');
        return false;
    });

    $('body').on('click', '.unclaim-link', function () {
        let dashboard_id = cm_item.data('dashboard-id');
        hideContextMenu();
        if (confirm('Unclaim?')) {
            $('#tmfwaiting400_modal').modal('show');
            let root_id = $('.sub-status.active').data('root-id');
            let id = $('.sub-status.active').data('id');
            $.post(
                location.pathname + '/unclaim',
                {
                    id: dashboard_id,
                    current_queue_status_id: id

                },
                function (msg) {
                    if (msg.length) {
                        reloadSubStatuses(root_id);
                        loadSubStatusTms(id);
                    } else {
                        setTimeout(function () {
                            $('#tmfwaiting400_modal').modal('hide');
                        }, 1000);
                        new Noty({
                            type: 'error',
                            layout: 'topRight',
                            text: 'Unknown error during unclaiming!',
                            timeout: 1500
                        }).show();
                    }
                }
            );

        }
        return false;
    });


    $('body').on('click', '.change-status-link', function () {
        $('#apply-status-btn').data('dashboard-id', cm_item.data('dashboard-id'));
        hideContextMenu();
        let root_id = $('.sub-status.active').data('root-id');
        let id = $('.sub-status.active').data('id');
        if (!$('#r-status-collapse-' + root_id).hasClass('show'))
            $('.r-status[data-id="' + root_id + '"]').trigger('click');
        $('.s-status[data-id="' + id + '"]').trigger('click');
        $('#change-status-modal').modal('show');
        return false;
    });

    $('#request-review-yes-btn').click(function () {
        $('#request-review-modal').modal('hide');
        $('#tmfwaiting400_modal').modal('show');
        let dashboard_id = $(this).data('dashboard-id');
        let root_id = $('.sub-status.active').data('root-id');
        let id = $('.sub-status.active').data('id');
        $.post(
            location.pathname + '/request-review',
            {
                id: dashboard_id,
                notification: ($('#notify-request-review-chbx').prop('checked') ? 1 : 0),
                current_queue_status_id: id

            },
            function (msg) {
                if (msg.length) {
                    reloadSubStatuses(root_id);
                    loadSubStatusTms(id);
                } else {
                    setTimeout(function () {
                        $('#tmfwaiting400_modal').modal('hide');
                        $('#request-review-modal').modal('show');
                    }, 1000);
                    new Noty({
                        type: 'error',
                        layout: 'topRight',
                        text: 'Owner not found!',
                        timeout: 1500
                    }).show();
                }
            }
        );
    });

    $('html').click(function (e) {
        hideContextMenu();
    });

    resizeTmsListHeight();

    $(window).resize(function () {
        resizeTmsListHeight();
    });

    $(document).ready(function () {
        loadSubStatusNumbers();
    });

    function reloadSubStatuses(root_id) {
        let active_id = 0;
        if ($('.sub-status[data-root-id="' + root_id + '"].active').length)
            active_id = $('.sub-status[data-root-id="' + root_id + '"].active').data('id');
        $.post(
            location.pathname + '/reload-sub-statuses/' + root_id,
            {},
            function (msg) {
                $('#root-status-collapse-' + root_id + ' .list-group').html(msg);
                if (active_id)
                    $('.sub-status[data-root-id="' + root_id + '"][data-id="' + active_id + '"]').trigger('click');
                loadSubStatusNumbers();
            }
        );
    }

    $('body').on('change', '.days-select', function () {
        reloadSubStatuses($(this).data('root-id'));
    });

    $('#apply-status-btn').click(function () {
        $('#change-status-modal').modal('hide');
        $('#tmfwaiting400_modal').modal('show');
        let new_status_root_id = $('.s-status.active').data('root-id');
        let current_status_root_id = $('.sub-status.active').data('root-id');
        $.post(
            location.pathname + '/apply-new-status',
            {
                dashboard_id: $(this).data('dashboard-id'),
                new_status_id: $('.s-status.active').data('id')
            },
            function (msg) {
                setTimeout(function () {
                    $('#tmfwaiting400_modal').modal('hide');
                }, 1000);

                reloadSubStatuses(current_status_root_id);
                reloadSubStatuses(new_status_root_id);
            }
        );
    });

    $('#search-link').click(function () {
        $('#search-results-block').html('');
        $('#client_fn,#tm').val('');
        $('#show-not-in-queue').prop('checked', false);
        $('#search-modal').modal('show');
        return false;
    });

    $('#search-btn').click(function () {
        $('#search-results-block').html('<img src="https://trademarkfactory.com/img/tmfwaiting400.gif"/>');
        $.post(
            location.pathname + '/search',
            {
                client_fn: $.trim($('#client_fn').val()),
                show_not_in_queue: ($('#show-not-in-queue').prop('checked') ? 1 : 0),
                done_status_days: $('#root-status-7 select:eq(0)').val(),
                tm: $.trim($('#tm').val())
            },
            function (msg) {
                $('#search-results-block').html(msg);
                imagePreview();
            }
        );
    });

    $('body').on('click', '.claim-link', function () {
        $('#tmfwaiting400_modal').modal('show');
        let dashboard_id = cm_item.data('dashboard-id');
        $.post(
            location.pathname + '/claim',
            {dashboard_id: dashboard_id},
            function (msg) {
                /*                setTimeout(function () {
                                    $('#tmfwaiting400_modal').modal('hide');
                                }, 1000);*/
                let id = $('.sub-status.active').data('id');
                loadSubStatusTms(id);
            }
        );
        hideContextMenu();
        return false;
    });

    $('body').on('click', '.search-open-btn', function () {
        $('#search-modal').modal('hide');
        let id = $(this).data('id');
        selected_dashboard_id = $(this).data('dashboard-id');
        let root_id = $(this).data('root-id');

        if ($('.root-status[data-id="' + root_id + '"]').attr('aria-expanded') != 'true')
            $('.root-status[data-id="' + root_id + '"]').trigger('click');
        $('.sub-status[data-id="' + id + '"]').trigger('click');
    });

    $('input[name="group-by-client"]').change(function () {
        $('.sub-status.active').trigger('click');
    });

    $('#claimed-by-me-only-chbx').change(function () {
        $.get(
            location.pathname+'/claimed-by-me-setting/'+($(this).prop('checked')?1:0),
            function (msg) {
                $('.numbers-block').addClass('empty');
                $('.root-total').text('');
                loadSubStatusNumbers();
                $('.sub-status.active').trigger('click');
            }
        );
    });
</script>