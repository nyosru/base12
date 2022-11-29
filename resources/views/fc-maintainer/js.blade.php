<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    function paintElCounter(el_counter,total_length){
        var max=Number(el_counter.data('max'));
        if(total_length>max)
            el_counter.addClass('text-danger');
        else
            el_counter.removeClass('text-danger');
        el_counter.text(total_length+' of '+max+' symbols');
    }

    $('#seo-title').keyup(function () {
        var el_counter=$(this).next('.el-counter');
        paintElCounter(el_counter,$.trim($(this).val()).length);
    });

    $('#seo-description').keyup(function () {
        var el_counter=$(this).next('.el-counter');
        paintElCounter(el_counter,$.trim($(this).val()).length);
    });

    $('#item-twitter').keyup(function () {
        var el_counter=$(this).next('.el-counter');
        paintElCounter(el_counter,$.trim($(this).val()).length);
    });

    $('body').on('click', '#add-new-section-btn', function () {
        $('#add-edit-section-modal .modal-title').text('Add New Section');
        $('#save-section-btn').data('href', location.pathname + '/save-section');
        $('#section-name').val('');
        $('#add-edit-section-modal').modal('show');
    });

    $('body').on('click', '.edit-section-btn', function () {
        $('#add-edit-item-modal .modal-title').text('Edit Section');
        $('#save-section-btn').data('href', location.pathname + '/edit-section/' + $(this).data('id'));
        var section_name = $.trim($('button[aria-controls="collapse-' + $(this).data('id') + '"]').text());
        $('#section-name').val(section_name);
        $('#add-edit-section-modal').modal('show');
        return false;
    });

    $('#save-section-btn').click(function () {
        $('#add-edit-section-modal').modal('hide');
        $.post(
            $('#save-section-btn').data('href'),
            {
                section: $.trim($('#section-name').val())
            },
            function (msg) {
                if (msg.length) {
                    new Noty({
                        type: 'success',
                        layout: 'topRight',
                        text: 'Saved',
                        timeout: 1500
                    }).show();
                    location.reload();
                } else {
                    new Noty({
                        type: 'error',
                        layout: 'topRight',
                        text: 'Unknown error during saving new section!',
                        timeout: 1500
                    }).show();
                    $('#add-edit-section-modal').modal('show');
                }
            }
        );
    });

    $('body').on('click', '.del-section-btn', function () {
        if (confirm('Delete Section?')) {
            $.post(
                location.pathname + '/delete-section/' + $(this).data('id'),
                {},
                function (msg) {
                    if (msg.length) {
                        new Noty({
                            type: 'success',
                            layout: 'topRight',
                            text: 'Done',
                            timeout: 1500
                        }).show();
                        location.reload();
                    } else {
                        new Noty({
                            type: 'error',
                            layout: 'topRight',
                            text: 'Unknown error during deleting section!',
                            timeout: 1500
                        }).show();
                    }
                }
            );
        }
        return false;
    });


    $('#root-block').sortable({
        change: function (event, ui) {
            ui.placeholder.css({visibility: 'visible', border: '5px solid yellow'});
        },
        handle: '.move-section-btn'
    }).bind('sortupdate', function (e, ui) {
        var arr = [];
        $('#root-block .card').each(function () {
            arr.push($(this).data('id'));
        });
        $.post(location.pathname + '/reorder-sections', {arr: JSON.stringify(arr)}, function (msg) {
        });

    });

    var fixHelper = function (e, ui) {
        ui.children().each(function () {
            $(this).width($(this).width());
        });
        return ui;
    };

    $('.item-table tbody').sortable({
        handle: '.move-item',
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
            var parent_tbody = ui.item.parents('tbody:eq(0)');
            var arr = [];
            parent_tbody.find('tr').each(function () {
                arr.push($(this).data('id'));
            });
            $.post(location.pathname + '/reorder-items', {arr: JSON.stringify(arr)}, function (msg) {
            });
            $(this).data('preventBehaviour', true);
        }
    });

    $(document).ready(function () {
        $('#item-description').summernote({
            height: 100,                 // set editor height
            minHeight: 100,             // set minimum height of editor
            maxHeight: null,             // set maximum height of editor
            // focus: true,                  // set focus to editable area after initializing summernote
            toolbar: [
                //[groupname, [button list]]
                ['text', ['bold', 'italic', 'underline', 'clear', 'color']],
                ['para', ['paragraph', 'ul', 'ol']],
                ['insert', ['table', 'link', 'picture', 'video']],
                ['misc', ['fullscreen', 'codeview', 'undo', 'redo']]
            ]
        });
        $('#item-transcription').summernote({
            height: 100,                 // set editor height
            minHeight: 100,             // set minimum height of editor
            maxHeight: null,             // set maximum height of editor
            // focus: true,                  // set focus to editable area after initializing summernote
            toolbar: [
                //[groupname, [button list]]
                ['text', ['bold', 'italic', 'underline', 'clear', 'color']],
                ['para', ['paragraph', 'ul', 'ol']],
                ['insert', ['table', 'link', 'picture', 'video']],
                ['misc', ['fullscreen', 'codeview', 'undo', 'redo']]
            ]
        });

    });

    $('body').on('click', '.add-new-item-btn', function () {
        $('#add-edit-item-modal .modal-title').text('Add New Item');
        $('#save-item-btn').data('href', location.pathname + '/save-item');
        $('#item-title,#item-title-html,' +
            '#item-url,#item-youtube-id,' +
            '#seo-title,#seo-description,' +
            '#item-sniply-url,#item-twitter').val('');
        $('#item-section').val($(this).parents('.card:eq(0)').data('id'));
        $('input[name="visibility-option"][value="visible"]').prop('checked', true);
        $('#item-description').summernote('code', '');
        $('#item-transcription').summernote('code', '');
        $('#delete-item-btn').hide();

        $('#seo-title').trigger('keyup');
        $('#seo-description').trigger('keyup');
        $('#item-twitter').trigger('keyup');

        $('#add-edit-item-modal').modal('show');

        return false;
    });

    $('body').on('dblclick', '.item-row', function () {
        $('#add-edit-item-modal .modal-title').text('Edit Item');
        $('#item-section').val($(this).data('section-id'));
        $('#delete-item-btn').show();
        $('#delete-item-btn').data('id', $(this).data('id'));
        $('#delete-item-btn').data('section-id', $(this).data('section-id'));
        $('#save-item-btn').data('href', location.pathname + '/edit-item/' + $(this).data('id'));
        $('#item-title').val($(this).data('title'));
        $('#item-title-html').val($(this).data('title-html'));
        $('#item-url').val($(this).data('url'));
        $('#item-youtube-id').val($(this).data('youtube-id'));
        $('#item-sniply-url').val($(this).data('sniply-url'));
        $('#item-twitter').val($(this).data('twitter'));

        $('#seo-title').val($(this).data('seo-title'));
        $('#seo-description').val($(this).data('seo-description'));
        $('#seo-title').trigger('keyup');
        $('#seo-description').trigger('keyup');
        $('#item-twitter').trigger('keyup');

        $('input[name="visibility-option"][value="' + $(this).data('visible') + '"]').prop('checked', true);
        $('#item-description').summernote('code', $(this).data('description'));
        $('#item-transcription').summernote('code', $(this).data('transcription'));
        $('#add-edit-item-modal').modal('show');

    });

    function initItemTableSortable(section_id) {
        $('.item-table[data-section-id="' + section_id + '"] tbody').sortable({
            handle: '.move-item',
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
                var parent_tbody = ui.item.parents('tbody:eq(0)');
                var arr = [];
                parent_tbody.find('tr').each(function () {
                    arr.push($(this).data('id'));
                });
                $.post(location.pathname + '/reorder-items', {arr: JSON.stringify(arr)}, function (msg) {
                });
                $(this).data('preventBehaviour', true);
            }
        });
    }

    $('#save-item-btn').click(function () {
        $('#add-edit-item-modal').modal('hide');
        var section_id = $('#item-section').val();
        $.post(
            $('#save-item-btn').data('href'),
            {
                section: section_id,
                title: $.trim($('#item-title').val()),
                title_html: $.trim($('#item-title-html').val()),
                url: $.trim($('#item-url').val()),
                youtube_id: $.trim($('#item-youtube-id').val()),
                sniply_url: $.trim($('#item-sniply-url').val()),
                twitter: $.trim($('#item-twitter').val()),
                visibility: $('input[name="visibility-option"]:checked').val(),
                description: $.trim($('#item-description').summernote('code')),
                transcription: $.trim($('#item-transcription').summernote('code')),
                seo_title:$.trim($('#seo-title').val()),
                seo_description:$.trim($('#seo-description').val())
            },
            function (msg) {
                if (msg.length) {
                    $('.card-body[data-section-id="' + section_id + '"]').html(msg);
                    initItemTableSortable(section_id);
                    new Noty({
                        type: 'success',
                        layout: 'topRight',
                        text: 'Done',
                        timeout: 1500
                    }).show();
                } else {
                    new Noty({
                        type: 'error',
                        layout: 'topRight',
                        text: 'Unknown error during saving item!',
                        timeout: 1500
                    }).show();
                    $('#add-edit-item-modal').modal('show');
                }
            }
        );
    });

    $('body').on('click', '#delete-item-btn', function () {
        if (confirm('Delete Item?')) {
            $('#add-edit-item-modal').modal('hide');
            var section_id = $(this).data('section-id');
            $.post(
                location.pathname + '/delete-item/' + $(this).data('id'),
                {},
                function (msg) {
                    if (msg.length) {
                        new Noty({
                            type: 'success',
                            layout: 'topRight',
                            text: 'Done',
                            timeout: 1500
                        }).show();
                        $('.card-body[data-section-id="' + section_id + '"]').html(msg);
                        initItemTableSortable(section_id);
                    } else {
                        new Noty({
                            type: 'error',
                            layout: 'topRight',
                            text: 'Unknown error during deleting item!',
                            timeout: 1500
                        }).show();
                        $('#add-edit-item-modal').modal('show');
                    }
                }
            );
        }
        return false;
    });

    function getUrl(str) {
        str = str.replace(/\s\s+/g, ' ');
        str = str.replace(/[àâäôéèëêïîçùûüÿæœÀÂÄÔÉÈËÊÏÎŸÇÙÛÜÆŒ]/g, '');
        str = str.replace(/[.,\/#!$%\^&?\*;:{}=—_’‘"'`~()”“<>]/g, '');
        str = str.replace(/ /g, '-');
        return str.toLowerCase();
    }

    function changeSniplyUrl() {
        $.get(
            '/sniply-link-creator',
            {url: '{{$url}}/' + $('#item-url').val()},
            function (msg) {
                if (msg.length)
                    $('#item-sniply-url').val(msg.replace(/https:\/\/snip.ly\//g, ''));
            }
        );
    }

    $('#item-title').change(function () {
        if ($.trim($('#item-title-html').val()).length == 0)
            $('#item-title-html').val($(this).val());

        if ($.trim($('#item-url').val()).length == 0)
            $('#item-url').val(getUrl($(this).val()));

        if ($.trim($('#item-sniply-url').val()).length == 0)
            changeSniplyUrl();
    });

    $('#change-title-link').click(function () {
        $('#item-title-html').val($('#item-title').val());
        return false;
    });

    $('#change-url-link').click(function () {
        $('#item-url').val(getUrl($('#item-title').val()));
        return false;
    });

    $('#change-underlines-link').click(function () {
        var url = $.trim($('#item-url').val());
        url = url.replace(/_/g, '-');
        $('#item-url').val(url);
        return false;
    });

    $('#change-sniply-url-link').click(function () {
        changeSniplyUrl();
        return false;
    });


    $('#export-for-social-pilot-btn').click(function () {
        $('#posts-per-day').trigger('change');
        $('#export-sp-modal').modal('show');
    });

    $("#first_day_campaign").datepicker({
        dateFormat: "yy-mm-dd"
    });

    $('#posts-per-day').change(function(){
        $('.post-area').hide();
        for(var i=1;i<=Number($(this).val());i++)
            $('#post-area-'+i).show();
    });

    function filterItemRows() {
        var yt_filter=$.trim($('#yt-filter').val());
        $('.item-row').show();
        if(yt_filter.length) {
            $('#root-block .collapse').removeClass('show');
            var func;
            var accordion_ids=[];
            if ($('input[name="yt-filter-radio"]:checked').val() == 'title') {
                func = function (el, filter) {
                    if (el.data('title').toLowerCase().indexOf(filter.toLowerCase()) == -1)
                        el.hide();
                    else {
                        var id=Number(el.parents('.card:eq(0)').data('id'));
                        if ($.inArray(id,accordion_ids)==-1)
                            accordion_ids.push(id);
                    }
                };
            }else {
                func = function (el, filter) {
                    if (el.data('youtube-id').toLowerCase().indexOf(filter.toLowerCase()) == -1)
                        el.hide();
                    else{
                        var id=Number(el.parents('.card:eq(0)').data('id'));
                        if ($.inArray(id,accordion_ids)==-1)
                            accordion_ids.push(id);
                    }
                };

            }

            $('.item-row').each(function () {
                func($(this),yt_filter);
            });

            if(accordion_ids.length)
                $.each(accordion_ids,function (i,val) {
                    $('.card[data-id="'+val+'"] .collapse').toggleClass('show');
                });
        }
    }

    $('input[name="yt-filter-radio"]').change(function () {
        if ($('input[name="yt-filter-radio"]:checked').val() == 'title')
            $('#yt-filter').attr('placeholder','Title Filter');
        else
            $('#yt-filter').attr('placeholder','Youtube Url Filter');
        filterItemRows();
    });

    $('#yt-filter').keyup(function () {
        filterItemRows();
    });

    $('#copy-yt-id').click(function () {
        prompt('Use Ctrl+C to copy:','https://youtu.be/'+$.trim($('#item-youtube-id').val()));
        return false;
    });

    $('.export-to-item').click(function () {
        $('#export-action').val($(this).data('to'));
        $('#export-csv-frm').submit();
        return false;
    });

</script>
