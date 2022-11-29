<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    var fixHelper = function (e, ui) {
        ui.children().each(function () {
            $(this).width($(this).width());
        });
        return ui;
    };

    function setRootStatusesSortable() {
        $('#root-statuses-block').sortable({
            axis: "y",
            helper: fixHelper,
            cursor: "n-resize",
            change: function (event, ui) {
                ui.placeholder.css({visibility: 'visible', border: '5px solid yellow'});
            },
            start: function (event, ui) {
                $(this).data('preventBehaviour', true);
            },
            update: function (event, ui) {
                var arr=[];
                $('.root-status').each(function () {
                    arr.push($(this).data('id'));
                });
                $.post(location.pathname + '/reorder-root-statuses', {arr: JSON.stringify(arr)}, function (msg) {
                });
            }
        });
    }

    function setSubStatusesSortable() {
        $('#sub-statuses-block').sortable({
            axis: "y",
            helper: fixHelper,
            cursor: "n-resize",
            change: function (event, ui) {
                ui.placeholder.css({visibility: 'visible', border: '5px solid yellow'});
            },
            start: function (event, ui) {
                $(this).data('preventBehaviour', true);
            },
            update: function (event, ui) {
                var arr=[];
                $('.sub-status').each(function () {
                    arr.push($(this).data('id'));
                });
                $.post(location.pathname + '/reorder-sub-statuses', {arr: JSON.stringify(arr)}, function (msg) {
                });
            }
        });
    }


    function loadSubStatuses() {
        let root_block_id=$('.root-status.active').data('id');
        $.get(
            location.pathname+'/load-sub-statuses/'+root_block_id,
            function (msg) {
                if(msg.length){
                    $('#sub-statuses-block').html(msg);
                    $('.sub-status.active .edit-sub-status').removeClass('text-primary').addClass('text-white');
                    setSubStatusesSortable();
                }else
                    $('#sub-statuses-block').html('');
            }
        );
    }

    function loadRootStatuses(){
        $.get(
            location.pathname+'/load-root-statuses',
            function (msg) {
                if(msg.length){
                    let selected_block_id=0;
                    if($('.root-status.active').length)
                        selected_block_id=$('.root-status.active').data('id');
                    $('#root-statuses-block').html(msg);
                    if(selected_block_id) {
                        $('.root-status.active .edit-root-status').removeClass('text-white').addClass('text-primary');
                        $('.root-status.active').removeClass('active');
                        $('.root-status[data-id="'+selected_block_id+'"]').addClass('active');
                        $('.root-status.active .edit-root-status').removeClass('text-primary').addClass('text-white');
                    }
                    setRootStatusesSortable();
                    $('.root-status.active .edit-root-status').removeClass('text-primary').addClass('text-white');
                    loadSubStatuses();
                }else
                    new Noty({
                        type: 'error',
                        layout: 'topRight',
                        text: 'Unknown error during loading root statuses!',
                        timeout: 1500
                    }).show();
            }
        );
    }

    function loadRootStatusOptions(){
        $.get(
            location.pathname+'/load-root-status-options',
            function (msg) {
                if(msg.length){
                    $('#root-status').html(msg);
                    $('#root-status').val($('.root-status.active').data('id'));
                }else
                    new Noty({
                        type: 'error',
                        layout: 'topRight',
                        text: 'Unknown error during loading root statuses for options!',
                        timeout: 1500
                    }).show();
            }
        );
    }

    $('#new-root-status-btn').click(function () {
        $('#new-status').val('');
        $('#save-status-btn').data('action','root-status');
        $('#save-status-btn').data('id',0);
        $('#save-status-btn').data('parent-id',0);
        $('#new-status-modal .modal-title').text('New Root Status');
        $('#new-status-modal').modal('show');
    });

    $('body').on('click','.edit-root-status',function (e) {
        let parent_li=$(this).parents('.root-status');
        $('#new-status').val($.trim(parent_li.text()));
        $('#save-status-btn').data('action','root-status');
        $('#save-status-btn').data('id',parent_li.data('id'));
        $('#save-status-btn').data('parent-id',0);
        $('#new-status-modal .modal-title').text('Edit Root Status');
        $('#new-status-modal').modal('show');
        e.preventDefault();
        return false;
    });


    $('body').on('click','.edit-sub-status',function (e) {
        let parent_li=$(this).parents('.sub-status');
        $('#new-sub-status').val($.trim(parent_li.text()));
        $('#save-sub-status-btn').data('action', 'edit-sub-status');
        $('#save-sub-status-btn').data('id', $(this).data('id'));
        $('#queue-status-type').val(parent_li.data('queue-status-type-id')?parent_li.data('queue-status-type-id'):$('#queue-status-type option:eq(0)').val());
        $('#new-sub-status-modal .modal-title').text('Edit Sub-Status');
        $('#description').val(parent_li.data('description'));
        $('#dashboard-status').val(parent_li.data('cipostatus-status-formalized-id'));
        $('#global-status').val(parent_li.data('global-id'));
        loadRootStatusOptions();
        paintFlagSettings(parent_li.data('flag-settings'));
        $('#new-sub-status-modal').modal('show');
        e.preventDefault();
        return false;
    });

    $('#new-sub-status-btn').click(function () {
        if($('.root-status').length) {
            $('#new-sub-status,#description').val('');
            $('#queue-status-type').val($('#queue-status-type option:eq(0)').val());
            $('#save-sub-status-btn').data('action', 'new-sub-status');
            $('#save-sub-status-btn').data('id', 0);
            $('#new-sub-status-modal .modal-title').text('New Sub-Status');
            // loadDashboardTSSOptions(0);
            loadRootStatusOptions();
            $('#tss-status option:eq(0)').prop('selected',true);
            $('#global-status option:eq(0)').prop('selected',true);
            $('#new-sub-status-modal').modal('show');
        }else
            new Noty({
                type: 'error',
                layout: 'topRight',
                text: 'Add at least one root status!',
                timeout: 1500
            }).show();

    });

    $('#save-sub-status-btn').click(function () {
        $('#new-sub-status-modal').modal('hide');
        $('#tmfwaiting400_modal').modal('show');
        $.post(
            location.pathname+'/save-sub-status',
            {
                id:$(this).data('id'),
                parent_id:$('#root-status').val(),
                name:$.trim($('#new-sub-status').val()),
                cipostatus_status_formalized_id:$('#dashboard-status').val(),
                global_status_id:$('#global-status').val(),
                description:$.trim($('#description').val()),
                queue_status_type:$('#queue-status-type').val(),
                action:$(this).data('action'),
                flags_settings_data:JSON.stringify(getAllFlagSettingsData())
            },
            function (msg) {
                setTimeout(function () {
                    $('#tmfwaiting400_modal').modal('hide');
                }, 1000);
                if(msg.length){
                    loadSubStatuses();
                }else
                    new Noty({
                        type: 'error',
                        layout: 'topRight',
                        text: 'Unknown error during saving sub-status data!',
                        timeout: 1500
                    }).show();
            }
        );
    });

    $('#save-status-btn').click(function () {
        $('#new-status-modal').modal('hide');
        $('#tmfwaiting400_modal').modal('show');
        $.post(
            location.pathname+'/save-status',
            {
                id:$(this).data('id'),
                parent_id:$(this).data('parent-id'),
                name:$.trim($('#new-status').val()),
                action:$(this).data('action')
            },
            function (msg) {
                setTimeout(function () {
                    $('#tmfwaiting400_modal').modal('hide');
                }, 1000);
                if(msg.length){
                    loadRootStatuses();
                }else
                    new Noty({
                        type: 'error',
                        layout: 'topRight',
                        text: 'Unknown error during saving data!',
                        timeout: 1500
                    }).show();
            }
        );
    });

    $('body').on('click','.root-status',function () {
        $('.root-status.active .edit-root-status').removeClass('text-white').addClass('text-primary');
        $('.root-status.active').removeClass('active');
        $(this).addClass('active');
        $('.root-status.active .edit-root-status').removeClass('text-primary').addClass('text-white');
        loadSubStatuses();
    });

    $('body').on('click','.sub-status',function () {
        $('.sub-status.active .edit-sub-status').removeClass('text-white').addClass('text-primary');
        $('.sub-status.active').removeClass('active');
        $(this).addClass('active');
        $('.sub-status.active .edit-sub-status').removeClass('text-primary').addClass('text-white');
    });

    $('body').on('click','.del-root-status',function (e) {
        if(confirm('Remove Root Status?')){
            var block=$(this).parents('li:eq(0)');
            $.get(
                location.pathname+'/remove-root-status/'+$(this).data('id'),
                function (msg) {
                    if(msg.length){
                        block.remove();
                        if($('.root-status.active').length==0)
                            $('.root-status:eq(0)').trigger('click');
                    }else
                        new Noty({
                            type: 'error',
                            layout: 'topRight',
                            text: 'Unknown error during removing root block!',
                            timeout: 1500
                        }).show();
                }
            );
        }
        e.preventDefault();
        return false;
    });

    $('body').on('click','.del-sub-status',function (e) {
        if(confirm('Remove Sub Status?')){
            var block=$(this).parents('li:eq(0)');
            $.get(
                location.pathname+'/remove-sub-status/'+$(this).data('id'),
                function (msg) {
                    if(msg.length){
                        block.remove();
                        if($('.sub-status.active').length==0)
                            $('.sub-status:eq(0)').trigger('click');
                    }else
                        new Noty({
                            type: 'error',
                            layout: 'topRight',
                            text: 'Unknown error during removing sub status!',
                            timeout: 1500
                        }).show();
                }
            );
        }
        e.preventDefault();
        return false;
    });

    loadRootStatuses();

    $('body').on('click','.minus-btn',function () {
        let num=Number($(this).next('.pm-digit').text());
        if(num>0)
            $(this).next('.pm-digit').text(--num);
        else
            $(this).next('.pm-digit').text(0);
        return false;
    });

    $('body').on('click','.plus-btn',function () {
        let num=Number($(this).prev('.pm-digit').text());
        $(this).prev('.pm-digit').text(++num);
        return false;
    });
</script>
<?php echo $__env->make('common-queue.flag-settings-js', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/in.trademarkfactory.com/resources/views/tmf-filing-queue-status-maintainer/js.blade.php ENDPATH**/ ?>