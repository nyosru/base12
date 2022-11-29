<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('.item-table').each(function () {
        $(this).DataTable({
            'searching': false,
            "paging":   false,
            "info":     false,
            "scrollY":        "450px",
            'bAutoWidth':true,
            "scrollCollapse": true,
            "order": [[ 4, "desc" ]]
        });
    });

    $('.collapse').on('shown.bs.collapse',function(){
        $($.fn.dataTable.tables(true)).DataTable()
            .columns.adjust();
        $($.fn.dataTable.tables(true)).DataTable()
            .columns.adjust();
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
            $('.view-in-search-report-link').show();
            $('.tmfentry-link').show();
        }else {
            $('.view-in-search-report-link').hide();
            $('.tmfentry-link').hide();
        }
        showContextMenu($contextMenu, e);
    }

    $("body").on("contextmenu", ".item-row", function (e) {
        showContextMenuEvent($(this),e);
        return false;
    });

    $("body").on("click", ".item-row", function (e) {
        showContextMenuEvent($(this),e);
        return false;
    });

    $('html').click(function (e) {
        hideContextMenu();
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
        $('#' + el_str).val(printDate() + ' <?php echo e(Auth::user()->LongID); ?>:');
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


    $('body').on('click','.dashboard-notes-link',function () {
        $('#tmfwaiting400_modal').modal('show');
        let dashboard_id=cm_item.data('dashboard-id');
        $.post(
            location.pathname+'/load-dashboard-notes',
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
            location.pathname+'/save-dashboard-notes',
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

    function showDelays(){
        $('#root-block .collapse').each(function () {
            let normal=0;
            let warning=0;
            let problem=0;
            let ad_from=$(this).find('.item-row:eq(0)').data('ad-from');
            let ad_to=$(this).find('.item-row:eq(0)').data('ad-to');
            $(this).find('.item-row').each(function () {
                normal+=Number($(this).data('normal'));
                warning+=Number($(this).data('warning'));
                problem+=Number($(this).data('problem'));
            });
            let b_div=$(this).prev().find('.badges');
            b_div.find('.badge-success').text(normal);
            b_div.find('.badge-warning').text(warning);
            b_div.find('.badge-danger').text(problem);
            if(normal==0)
                b_div.find('.badge-success').parents('h2:eq(0)').removeClass('d-inline-block').addClass('d-none');
            else
                b_div.find('.badge-success').parents('h2:eq(0)').removeClass('d-none').addClass('d-inline-block').attr('title','Pending for less than '+ad_from+' hours');
            if(warning==0)
                b_div.find('.badge-warning').parents('h2:eq(0)').removeClass('d-inline-block').addClass('d-none');
            else
                b_div.find('.badge-warning').parents('h2:eq(0)').removeClass('d-none').addClass('d-inline-block').attr('title','Pending for more than '+ad_from+' and less than '+ad_to+' hours');
            if(problem==0)
                b_div.find('.badge-danger').parents('h2:eq(0)').removeClass('d-inline-block').addClass('d-none');
            else
                b_div.find('.badge-danger').parents('h2:eq(0)').removeClass('d-none').addClass('d-inline-block').attr('title','Pending for more than '+ad_to+' hours');
        });
    }

    $(document).ready(function () {
        showDelays();
    });
</script><?php /**PATH /var/www/html/in.trademarkfactory.com/resources/views/tm-filing-queue/js.blade.php ENDPATH**/ ?>