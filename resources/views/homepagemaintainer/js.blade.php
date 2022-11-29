<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    
    function recalculateUrlsInEachCategory() {
        $('.card-body .card').each(function () {
            let count=$(this).find('.item-table tr').length;
            $(this).find('.url-count').text(count+' URL'+(count>1?'s':''));
        });
    }

    recalculateUrlsInEachCategory();

    function initItemTableSortable(category_id) {
        $('.item-table[data-category-id="' + category_id + '"] tbody').sortable({
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
                let parent_tbody = ui.item.parents('tbody:eq(0)');
                let arr = [];
                parent_tbody.find('tr').each(function () {
                    arr.push($(this).data('id'));
                });
                $.post(location.pathname + '/reorder-items', {arr: JSON.stringify(arr)}, function (msg) {
                });
                $(this).data('preventBehaviour', true);
            }
        });
    }

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



    $('.add-new-item-btn').click(function () {
        $('#add-edit-category-item-modal .modal-title').text('Add New Category Item');
        $('#category-item-name,#category-item-url').val('');
        $('#save-category-item-btn').data('category-id',$(this).data('id'));
        $('#save-category-item-btn').data('id',0);
        $('#add-edit-category-item-modal').modal('show');
        return false;
    });

    function editCategoryItem(el_item_row){
        $('#add-edit-category-item-modal .modal-title').text('Edit Category Item');
        $('#category-item-name').val(el_item_row.data('name'));
        $('#category-item-url').val(el_item_row.data('url'));
        $('#save-category-item-btn').data('category-id',el_item_row.data('category-id'));
        $('#save-category-item-btn').data('id',el_item_row.data('id'));
        $('#add-edit-category-item-modal').modal('show');
    }

    $('body').on('dblclick', '.item-row', function () {
        editCategoryItem($(this));
    });

    $('body').on('click','.edit-category-item',function () {
        editCategoryItem($(this).parents('.item-row:eq(0)'));
        return false;
    });

    $('#save-category-item-btn').click(function () {
        $('#add-edit-category-item-modal').modal('hide');
        $('#tmfwaiting400_modal').modal('show');
        let category_id=$(this).data('category-id');
        $.post(
            '/tmfportal-maintainer/add-edit-category-item',
            {
                id:$(this).data('id'),
                category_id:$(this).data('category-id'),
                name:$.trim($('#category-item-name').val()),
                url:$.trim($('#category-item-url').val())
            },
            function (msg) {
                setTimeout(function () {
                    $('#tmfwaiting400_modal').modal('hide');
                }, 1000);
                if(msg.length){
                    $('.sys-message .toast-body').text('Saved');
                    $('.sys-message').toast('show');
                    $('.card-body[data-category-id="' + category_id + '"]').html(msg);
                    recalculateUrlsInEachCategory();
                    initItemTableSortable(category_id);
                }else{
                    $('.sys-message .toast-body').text('Error during saving category item!');
                    $('.sys-message').toast('show');
                    $('#add-edit-category-item-modal').modal('show');
                }
            }
        );
    });

    $('body').on('click','.delete-category-item',function () {
        if(confirm('Delete Category Item?')){
            $('#tmfwaiting400_modal').modal('show');
            let category_id=$(this).data('category-id');
            $.post(
                '/tmfportal-maintainer/delete-category-item',
                {
                    id:$(this).data('id')
                },
                function (msg) {
                    setTimeout(function () {
                        $('#tmfwaiting400_modal').modal('hide');
                    }, 1000);
                    if(msg.length){
                        $('.sys-message .toast-body').text('Category Item Removed');
                        $('.sys-message').toast('show');
                        $('.card-body[data-category-id="' + category_id + '"]').html(msg);
                        recalculateUrlsInEachCategory();
                        initItemTableSortable(category_id);
                    }else{
                        $('.sys-message .toast-body').text('Error during deleting category item!');
                        $('.sys-message').toast('show');
                    }
                }
            );
        }
        return false;
    });
</script>