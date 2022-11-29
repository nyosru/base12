<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    let current_queue_status_id={{$queue_status_data->id}};
    let current_queue_root_status_id={{$queue_status_data->queueRootStatus->id}};
    let current_dashboard_id={{$dashboard_id}};

    var pusher = new Pusher('{{config('broadcasting.connections.pusher.key')}}', {
        cluster: '{{config('broadcasting.connections.pusher.options.cluster')}}'
    });

    var channel = pusher.subscribe('queue-script-channel');


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

    function htmlFromTmsData(data) {
        let index = 0;
        let html = '';

        html += '<div class="d-inline-block ml-2 mb-2" style="width:450px;">' +
            // '<div class="card sub-status-tm" style="width: 450px;"' +
            '<div class="card sub-status-tm shadow" style="width: 450px;background:' + data['card-background'] + '"' +
            'data-dashboard-id="' + data.dashboard_id + '"' +
            'data-warning-at="' + data.warning_at + '"' +
            'data-danger-at="' + data.danger_at + '"' +
            'data-tmfsales-id="' + data.tmfsales_id + '"' +
            'data-agency-url="' + data.agency_url + '"' +
            'data-tmoffer-login="' + data.tmoffer_login + '"' +
            'data-tmoffer-id="' + data.tmoffer_id + '"' +
            'data-addy-note="' + htmlEntities(stripslashes(data.addy_note)) + '"' +
            'data-review-requested="' + data.review_requested + '"' +
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
            '                <div class="d-table-cell text-center border-right border-bottom p-2" style="font-size:16px;"><span class="badge badge-pill badge-' +
            data.hard_deadline_text_class + '">NEXT DEADLINE: ' + data.hard_deadline + '</span>' +
            '<sup class="text-' + data.hard_deadline_text_class + ' font-weight-bold">' +
            data.hard_deadline_text +
            '</sup>' +
            '</div>\n' +
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
        return html;
    }

    let tm_data={!! $tm_data !!};
    $('#tm-block').html(htmlFromTmsData(tm_data));
    imagePreview();

    function reloadTm(dashboard_id){
        $.get(
            '/queue-random-check/reload-tm/'+dashboard_id,
            function (msg) {
                if(Object.keys(msg).length){
                    $('#tm-block').html(htmlFromTmsData(msg));
                }else{
                    new Noty({
                        type: 'error',
                        layout: 'topRight',
                        text: 'Unknown error during reloading tm data!',
                        timeout: 1500
                    }).show();
                }
            }
        );
    }

    function reloadQueueStatus(dashboard_id){
        $.get(
            '/queue-random-check/reload-queue-status/'+dashboard_id,
            function (msg) {
                if (Object.keys(msg).length) {
                    current_queue_status_id=msg.current_queue_status_id;
                    current_queue_root_status_id=msg.current_queue_root_status_id;
                    $('#status-block').html(msg.html);
                } else {
                    new Noty({
                        type: 'error',
                        layout: 'topRight',
                        text: 'Unknown error during reloading queue status!',
                        timeout: 1500
                    }).show();
                }
            }
        );
    }

    function reloadContextMenu(dashboard_id){
        $('#context-menu').remove();
        $.get(
            '/queue-random-check/reload-context-menu/'+dashboard_id,
            function (msg) {
                if (msg.length) {
                    $('main').prepend(msg);
                    $contextMenu = $("#context-menu");
                } else {
                    new Noty({
                        type: 'error',
                        layout: 'topRight',
                        text: 'Unknown error during reloading context menu!',
                        timeout: 1500
                    }).show();
                }
            }
        );
    }

    channel.bind('reload-tm', function(data) {
        if(data.dashboard_id==current_dashboard_id) {
            reloadTm(data.dashboard_id);
            reloadQueueStatus(data.dashboard_id);
            reloadContextMenu(data.dashboard_id);
        }
    });

    $('#refresh-tss-link').click(function () {
        $.get(
            '/queue-random-check/reload-tss/'+current_dashboard_id,
            function (msg) {
                $('#tss-description-block').html(msg);
            }
        );

        return false;
    });

    $('#all-good-btn').click(function () {
        $.post(
            '/queue-random-check/all-good/'+current_dashboard_id,
            {
                status:$.trim($('#status-block').text()),
                queue_status_id:current_queue_status_id
            },
            function (msg) {
                if(msg.length){
                    new Noty({
                        type: 'success',
                        layout: 'topRight',
                        text: 'Done, reloading...',
                        timeout: 1500
                    }).show();
                    location.reload();
                }else{
                    new Noty({
                        type: 'error',
                        layout: 'topRight',
                        text: 'Unknown error during handling "ALL IS GOOD" click!',
                        timeout: 1500
                    }).show();
                }
            }
        );
    });

    $('#rebucket-btn').click(function () {
        changeStatusStart(current_dashboard_id,current_queue_root_status_id,current_queue_status_id);
    });

    let waiting_loading_popup=0;

    $('#change-status-modal').on('shown.bs.modal', function (event) {
        waiting_loading_popup=1;
    });

    $('#change-status-modal .btn-secondary').click(function () {
        waiting_loading_popup=0;
    });

    $('#tmfwaiting400_modal').on('hidden.bs.modal', function (event) {
        if(waiting_loading_popup){
            $.post(
                '/queue-random-check/new-status-note/'+current_dashboard_id,
                {
                    queue_type_id:$('.queue-type-list').val(),
                    queue_root_status_id:$('.s-status.active').data('root-id'),
                    queue_status_id:$('.s-status.active').data('id'),
                    current_queue_status_id:current_queue_status_id
                },
                function (msg) {
                    if(msg.length){
                        new Noty({
                            type: 'success',
                            layout: 'topRight',
                            text: 'Done, reloading...',
                            timeout: 1500
                        }).show();
                        location.reload();
                    }else{
                        new Noty({
                            type: 'error',
                            layout: 'topRight',
                            text: 'Unknown error during handling "REBUCKET" click!',
                            timeout: 1500
                        }).show();
                    }
                    waiting_loading_popup=0;
                }
            );
        }
    });
</script>