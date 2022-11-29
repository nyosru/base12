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
                $.post(
                    location.pathname + '/reorder-root-statuses',
                    {arr: JSON.stringify(arr)},
                    function (msg) {}
                );
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


    function loadSubStatuses(current_id) {
        let root_block_id=$('.root-status.active').data('id');
        $.get(
            location.pathname+'/load-sub-statuses/'+root_block_id,
            function (msg) {
                if(msg.length){
                    $('#sub-statuses-block').html(msg);
                    $('.sub-status.active .edit-sub-status').removeClass('text-primary').addClass('text-white');
                    setSubStatusesSortable();
                    if(current_id) {
                        let active_el=$('.sub-status.active');
                        active_el.removeClass('active');
                        active_el.find('.edit-sub-status').removeClass('text-white').addClass('text-primary');
                        let new_active_el=$('.sub-status[data-id="' + current_id + '"]');
                        new_active_el.addClass('active');
                        new_active_el.find('.edit-sub-status').removeClass('text-primary').addClass('text-white');
                    }
                }else
                    $('#sub-statuses-block').html('');
            }
        );
    }

    $('#queue-type').change(function () {
        loadRootStatuses(0);
    });

    function loadRootStatuses(restore_selected_block){
        $.get(
            location.pathname+'/load-root-statuses/'+$('#queue-type').val(),
            function (msg) {
                if(msg.length){
                    let selected_block_id=0;
                    if($('.root-status.active').length)
                        selected_block_id=$('.root-status.active').data('id');
                    $('#root-statuses-block').html(msg);
                    $('.root-status:eq(0)').addClass('active');
                    if(selected_block_id && restore_selected_block) {
                        $('.root-status.active .edit-root-status').removeClass('text-white').addClass('text-primary');
                        $('.root-status.active').removeClass('active');
                        $('.root-status[data-id="'+selected_block_id+'"]').addClass('active');
                        $('.root-status.active .edit-root-status').removeClass('text-primary').addClass('text-white');
                    }
                    setRootStatusesSortable();
                    $('.root-status.active .edit-root-status').removeClass('text-primary').addClass('text-white');
                    loadSubStatuses(0);
                }else {
                    /*                    new Noty({
                                            type: 'error',
                                            layout: 'topRight',
                                            text: 'Unknown error during loading root statuses!',
                                            timeout: 1500
                                        }).show();*/
                    $('#root-statuses-block').html('');
                    $('#sub-statuses-block').html('');
                }
            }
        );
    }

    function loadRootStatusOptions(){
        $.get(
            location.pathname+'/load-root-status-options/'+$('#queue-type').val(),
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
        let current_id=$(this).data('id');
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
                    loadSubStatuses(current_id);
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
            location.pathname+'/save-status/'+$('#queue-type').val(),
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
                    loadRootStatuses(1);
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
        loadSubStatuses(0);
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

    loadRootStatuses(1);

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

    function addNewCustomMenuItem(){
        let template='<div class="row mb-3 custom-menu-item">' +
            '<div class="col-md-3">' +
            '<input type="text" class="form-control menu-item-icon" placeholder="Icon"/>'+
            '</div>'+
            '<div class="col-md-3">' +
            '<input type="text" class="form-control menu-item-name" placeholder="Caption"/>'+
            '</div>'+
            '<div class="col-md-6">' +
            '<div class="row">' +
            '<div class="col-md-11">' +
            '<input type="text" class="form-control menu-item-url" placeholder="Url"/>' +
            '</div>'+
            '<div class="col-md-1 text-lg-center" style="margin-top:7px">' +
            '<a href="#" class="remove-custom-menu-item text-danger position-relative" style="right:13px;">' +
            '<i class="fas fa-times align-content-center"></i>' +
            '</a>'+
            '</div>'+
            '</div>'+
            '</div>';
        $('.custom-menu-items-block').append(template);
    }

    $('body').on('click','#new-custom-menu-item',function () {
        addNewCustomMenuItem();
    });

    $('body').on('click','.remove-custom-menu-item',function () {
        if(confirm('Remove menu item?')) {
            let parent_div = $(this).parents('.custom-menu-item:eq(0)');
            parent_div.remove();
        }
        return false;
    });

    $('body').on('click','.edit-sub-status-context-menu',function (e) {
        $('#save-menu-items-btn').data('id',$(this).data('id'));
        $.post(
            location.pathname+'/load-context-menu-data',
            {queue_status_id:$(this).data('id')},
            function (msg) {
                $('.standart-menu-item').each(function () {
                    $(this).prop('checked',false);
                });
                $('.custom-menu-items-block').html('');
                if(Object.keys(msg).length){
                    $.each(msg.standart_menu_items,function (i,val) {
                        $('.standart-menu-item[value="'+val+'"]').prop('checked',true);
                    });

                    $.each(msg.custom_menu_items,function (i,val) {
                        addNewCustomMenuItem();
                        $('.menu-item-icon:last').val(val.icon);
                        $('.menu-item-name:last').val(val.name);
                        $('.menu-item-url:last').val(val.url);
                    });
                }
            }
        );
        $('#custom-context-menu-modal').modal('show');
        e.preventDefault();
        return false;
    });

    function getCustomContextMenuData(){
        let data=[];
        $('.custom-menu-item').each(function () {
            let icon=$.trim($(this).find('.menu-item-icon').val());
            let name=$.trim($(this).find('.menu-item-name').val());
            let url=$.trim($(this).find('.menu-item-url').val());
            if(icon.length && name.length && url.length)
                data.push({icon:icon,name:name,url:url});
        });
        return data;
    }

    $('#save-menu-items-btn').click(function () {
        $('#custom-context-menu-modal').modal('hide');
        $('#tmfwaiting400_modal').modal('show');
        let standart_context_menu_ids=[];
        let custom_context_menu_data=getCustomContextMenuData();
        $('.standart-menu-item').each(function () {
            standart_context_menu_ids.push($(this).val());
        });
        $.post(
            location.pathname+'/save-custom-context-menu',
            {
                id:$(this).data('id'),
                standart_context_menu_ids:JSON.stringify(standart_context_menu_ids),
                custom_context_menu_data:JSON.stringify(custom_context_menu_data)
            },
            function (msg) {
                setTimeout(function () {
                    $('#tmfwaiting400_modal').modal('hide');
                }, 1000);
                if(Object.keys(msg).length){
                    new Noty({
                        type: 'success',
                        layout: 'topRight',
                        text: 'Saved',
                        timeout: 1500
                    }).show();
                    $('.edit-sub-status-context-menu[data-id="'+msg.id+'"]').removeClass('text-success');
                    $('.edit-sub-status-context-menu[data-id="'+msg.id+'"]').addClass(msg.class);
                }else {
                    $('#custom-context-menu-modal').modal('show');
                    new Noty({
                        type: 'error',
                        layout: 'topRight',
                        text: 'Unknown error during saving context menu data!',
                        timeout: 1500
                    }).show();
                }
            }
        );
    });
</script>
@include('common-queue.flag-settings-js')