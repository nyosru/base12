<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    let selected_dashboard_id=0;
    let datatables=[];

    function loadSubStatusTms(substatus_id){
        let root_id=$('.sub-status[data-id="'+substatus_id+'"]').data('root-id');
        let group_by_client=(selected_dashboard_id?0:$('input[name="group-by-client"]:checked').val());
        $.post(
            '/tmf-filing-queue/load-sub-status-tms/'+substatus_id,
            {
                days:($('.days-select[data-root-id="'+root_id+'"]').length?$('.days-select[data-root-id="'+root_id+'"]').val():0),
                group_by_client:group_by_client
            },
            function (msg) {
                $('#tms-area').html(msg);
                $('#tms-area').show();
                datatables=[];
                if(group_by_client==0)
                    $('.item-table').each(function () {
                        datatables.push($(this).DataTable({
                            'searching': false,
                            "info":     false,
                            "scrollY":        $(window).height()-$('.item-table:eq(0)').offset().top-110,
                            'scroller':true,
                            'bAutoWidth':true,
                            "scrollCollapse": true,
                            "order": [[ 5, "desc" ]]
                        }));
                    });
                resizeTmsListHeight();
                if(selected_dashboard_id) {
                    datatables[0].scroller.toPosition(
                        $('.sub-status-tm[data-dashboard-id="'+selected_dashboard_id+'"]').index()
                    );
                    $('.sub-status-tm[data-dashboard-id="'+selected_dashboard_id+'"]').css({
                        'animation-name':'show_selected_row',
                        'animation-duration':'8s'
                    });
                    selected_dashboard_id = 0;
                }
            }
        );
    }


    $('body').on('shown.bs.collapse','#client-tms-block', function () {
        let t_id=$(this).find('.item-table').attr('id');
        if(datatables.indexOf(t_id)==-1) {
            $('#' + t_id).DataTable({
                'searching': false,
                "info": false,
                'scrollY':'450px',
                'bAutoWidth': true,
                "scrollCollapse": true,
                "paging": false,
                "order": [[4, "desc"]]
            });
            datatables.push(t_id);
        }
    });

    function paintRootStatusNumbers(root_id) {
        var obj={
            'badge-success':0,
            'badge-warning':0,
            'badge-danger':0
        };

        $('button.sub-status[data-root-id="'+root_id+'"]').each(function () {
            var el=$(this);
            $.each(Object.keys(obj),function (i,val) {
                if(el.find('.badge.'+val).length){
                    let b_val=$.trim(el.find('.badge.'+val).text());
                    obj[val]+=Number(b_val);
                }
            });
        });

        let html='';
        $.each(Object.keys(obj),function (i,val) {
            if(obj[val])
                html+='<span class="badge '+val+' '+(i==0?'':'ml-1')+'">'+obj[val]+'</span>';
        });
        $('.root-numbers-block[data-id="'+root_id+'"]').html(html);

        let total=0;
        $('.total[data-root-id="'+root_id+'"]').each(function () {
            total+=Number($.trim($(this).text()));
        });
        $('.root-total[data-id="'+root_id+'"]').text(total);
    }

    function loadSubStatusNumbers() {
        $('.numbers-block.empty').each(function () {
            let root_id=$(this).data('root-id');
            $.post(
                '/tmf-filing-queue/sub-status-numbers/'+$(this).data('id'),
                {days:($('.days-select[data-root-id="'+root_id+'"]').length?$('.days-select[data-root-id="'+root_id+'"]').val():0)},
                function (msg) {
                    $('.numbers-block.empty[data-id="'+msg.id+'"]').html(msg.html).removeClass('empty');
                    $('.total[data-id="'+msg.id+'"]').text(msg.total);
                    if(!$('.numbers-block.empty[data-root-id="'+msg.root_id+'"]').length)
                            paintRootStatusNumbers(msg.root_id);
                }
            );
        });
    }

    function resizeTmsListHeight(){
        if($('#tms-list').is(':visible'))
            $('#tms-list').css('max-height',$(window).height()-$('#tms-list').offset().top-35);
    }

    $('body').on('click','.sub-status',function () {
        $('.sub-status.active').removeClass('active');
        $(this).addClass('active');
        loadSubStatusTms($(this).data('id'));
    });

    $('body').on('click','.s-status',function () {
        $('.s-status.active').removeClass('active');
        $(this).addClass('active');
    });

    var $contextMenu = $("#context-menu");
    var cm_item=null;

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

    function hideContextMenu(){
        $contextMenu.hide();
        cm_item=null;
    }

    function showContextMenuEvent(el,e){
        cm_item=el;
        if(el.data('trigger')=='BOOM')
            $('.view-in-aa-link').show();
        else
            $('.view-in-aa-link').hide();
        if(el.data('tmoffer-login').length) {
            $('.view-in-search-report-link,#print-shipping-link').show();
            $('.tmfentry-link').show();
        }else {
            $('.view-in-search-report-link,#print-shipping-link').hide();
            $('.tmfentry-link').hide();
        }
        showContextMenu($contextMenu, e);
    }

    $("body").on("contextmenu", ".sub-status-tm", function (e) {
        showContextMenuEvent($(this),e);
        return false;
    });

    $("body").on("click", ".sub-status-tm", function (e) {
        showContextMenuEvent($(this),e);
        return false;
    });


    $('body').on('click','.view-in-dashboard-link',function () {
        let url='https://trademarkfactory.com/mlcclients/dashboard-trademarks-details.php?id='+cm_item.data('dashboard-id');
        window.open(url,'_blank');
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

    $('body').on('click','#add-date',function () {
        addDateToEl('notes');
        return false;
    });

    $('body').on('click','#add-date-alt',function () {
        addDateToEl('notes-alt');
        return false;
    });

    $('body').on('click','.print-shipping-link',function () {
        let tmoffer_id=cm_item.data('tmoffer-id');
        let addy_note=cm_item.data('addy-note');
        $('input[name="tmoffer_id"]').val(tmoffer_id);
        $('input[name="addy"]').val(addy_note.addy);
        $('input[name="note"]').val(addy_note.note);
        $('#shipping-label-form').submit();
        return false;
    });


    $('body').on('click','.dashboard-notes-link',function () {
        $('#tmfwaiting400_modal').modal('show');
        let dashboard_id=cm_item.data('dashboard-id');
        $.post(
            '/tmf-filing-queue/load-dashboard-notes',
            {id:dashboard_id},
            function (msg) {
                setTimeout(function () {
                    $('#tmfwaiting400_modal').modal('hide');
                }, 1000);
                $('#notes-alt').val(msg);
                $('#save-notes-data').data('dashboard-id',dashboard_id);
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
            '/tmf-filing-queue/save-dashboard-notes',
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


    $('body').on('click','.view-in-search-report-link',function () {
        let url='https://trademarkfactory.com/searchreport/'+cm_item.data('tmoffer-login')+'&donttrack=donttrack';
        window.open(url,'_blank');
        hideContextMenu();
        return false;
    });

    $('body').on('click','.view-in-aa-link',function () {
        let url='https://trademarkfactory.com/mlcclients/acceptedagreements.php?login='+cm_item.data('tmoffer-login')+'&sbname=&sbphone=&sbtm=&sbemail=&sbnote=&date_from=&date_to=&affiliate_camefrom=&sort_by=new_logins_first&show=ALL&sbmt_btn=SEARCH&page=1';
        window.open(url,'_blank');
        hideContextMenu();
        return false;
    });

    $('body').on('click','.tmfentry-link',function () {
        let url='https://trademarkfactory.com/mlcclients/tmfentry/'+cm_item.data('tmoffer-login')+'?show=searchresults';
        window.open(url,'_blank');
        hideContextMenu();
        return false;
    });

    $('body').on('click','.change-status-link',function () {
        $('#apply-status-btn').data('dashboard-id',cm_item.data('dashboard-id'));
        hideContextMenu();
        let root_id=$('.sub-status.active').data('root-id');
        let id=$('.sub-status.active').data('id');
        if(!$('#r-status-collapse-'+root_id).hasClass('show'))
            $('.r-status[data-id="'+root_id+'"]').trigger('click');
        $('.s-status[data-id="'+id+'"]').trigger('click');
        $('#change-status-modal').modal('show');
        return false;
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

    function reloadSubStatuses(root_id){
        let active_id=0;
        if($('.sub-status[data-root-id="'+root_id+'"].active').length)
            active_id=$('.sub-status[data-root-id="'+root_id+'"].active').data('id');
        $.post(
            '/tmf-filing-queue/reload-sub-statuses/'+root_id,
            {},
            function (msg) {
                $('#root-status-collapse-'+root_id+' .list-group').html(msg);
                if(active_id)
                    $('.sub-status[data-root-id="'+root_id+'"][data-id="'+active_id+'"]').trigger('click');
                loadSubStatusNumbers();
            }
        );
    }
    
    $('body').on('change','.days-select',function () {
        reloadSubStatuses($(this).data('root-id'));
    });

    $('#apply-status-btn').click(function () {
        $('#change-status-modal').modal('hide');
        $('#tmfwaiting400_modal').modal('show');
        let new_status_root_id=$('.s-status.active').data('root-id');
        let current_status_root_id=$('.sub-status.active').data('root-id');
        $.post(
            '/tmf-filing-queue/apply-new-status',
            {
                dashboard_id:$(this).data('dashboard-id'),
                new_status_id:$('.s-status.active').data('id')
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
        $('#show-not-in-queue').prop('checked',false);
        $('#search-modal').modal('show');
        return false;
    });

    $('#search-btn').click(function () {
        $('#search-results-block').html('<img src="https://trademarkfactory.com/img/tmfwaiting400.gif"/>');
        $.post(
            '/tmf-filing-queue/search',
            {
                client_fn:$.trim($('#client_fn').val()),
                show_not_in_queue:($('#show-not-in-queue').prop('checked')?1:0),
                done_status_days:$('#root-status-7 select:eq(0)').val(),
                tm:$.trim($('#tm').val())
            },
            function (msg) {
                $('#search-results-block').html(msg);
            }
        );
    });
    
    $('body').on('click','.search-open-btn',function () {
        $('#search-modal').modal('hide');
        let id=$(this).data('id');
        selected_dashboard_id=$(this).data('dashboard-id');
        let root_id=$(this).data('root-id');

        if($('.root-status[data-id="'+root_id+'"]').attr('aria-expanded')!='true')
            $('.root-status[data-id="'+root_id+'"]').trigger('click');
        $('.sub-status[data-id="'+id+'"]').trigger('click');
    });

    $('input[name="group-by-client"]').change(function () {
        $('.sub-status.active').trigger('click');
    });
</script>