<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#add-new-category-btn').click(function () {
        $('#add-edit-category-modal .modal-title').text('Add New Category');
        $('#category-name').val('');
        $('#save-category-btn').data('id',0);
        $('#add-edit-category-modal').modal('show');
    });

    $('.edit-category-btn').click(function () {
        $('#add-edit-category-modal .modal-title').text('Edit Category');
        $('#category-name').val($(this).data('name'));
        $('#save-category-btn').data('id',$(this).data('id'));
        $('#add-edit-category-modal').modal('show');
        return false;
    });


    $('#save-category-btn').click(function () {
        $('#add-edit-category-modal').modal('hide');
        $('#tmfwaiting400_modal').modal('show');
        $.post(
            '/tmfportal/add-edit-category',
            {
                id:$('#save-category-btn').data('id'),
                name:$.trim($('#category-name').val()),
            },
            function (msg) {
                setTimeout(function () {
                    $('#tmfwaiting400_modal').modal('hide');
                }, 1000);
                if(msg.length){
                    $('.sys-message .toast-body').text('Saved');
                    $('.sys-message').toast('show');
                    location.href='/tmfportal';
                }else{
                    $('.sys-message .toast-body').text('Error during saving category!');
                    $('.sys-message').toast('show');
                    $('#add-edit-category-modal').modal('show');
                }
            }
        );
    });

    $('.del-category-btn').click(function () {
        if(confirm('Delete Category?')){
            $('#tmfwaiting400_modal').modal('show');
            $.post(
                '/tmfportal-maintainer/delete-category',
                {
                    id:$(this).data('id')
                },
                function (msg) {
                    setTimeout(function () {
                        $('#tmfwaiting400_modal').modal('hide');
                    }, 1000);
                    if(msg.length){
                        $('.sys-message .toast-body').text('Category Removed');
                        $('.sys-message').toast('show');
                        location.href='/tmfportal';
                    }else{
                        $('.sys-message .toast-body').text('Error during deleting category!');
                        $('.sys-message').toast('show');
                        $('#add-edit-category-modal').modal('show');
                    }
                }
            );
        }
        return false;
    });

    $('.add-new-item-btn').click(function () {
        $('#add-edit-category-item-modal .modal-title').text('Add New Category Item');
        $('#category-item-name,#category-item-url').val('');
        $('#save-category-item-btn').data('category-id',$(this).data('id'));
        $('#save-category-item-btn').data('id',0);
        $('#add-edit-category-item-modal').modal('show');
        return false;
    });

    $('body').on('click', '.edit-category-item', function () {
        $('#add-edit-category-item-modal .modal-title').text('Edit Category Item');
        $('#category-item-name').val($(this).data('name'));
        $('#category-item-url').val($(this).data('url'));
        $('#save-category-item-btn').data('category-id',$(this).data('category-id'));
        $('#save-category-item-btn').data('id',$(this).data('id'));
        $('#category-item-name').focus();
        $('#add-edit-category-item-modal').modal('show');
        return false;
    });

    $('#save-category-item-btn').click(function () {
        $('#add-edit-category-item-modal').modal('hide');
        $('#tmfwaiting400_modal').modal('show');
        // let category_id=$(this).data('category-id');
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
                    location.href='/tmfportal';
                }else{
                    $('.sys-message .toast-body').text('Error during saving category item!');
                    $('.sys-message').toast('show');
                    $('#add-edit-category-item-modal').modal('show');
                }
            }
        );
    });

    $('.delete-category-item').click(function () {
        if(confirm('Delete Category Item?')){
            $('#tmfwaiting400_modal').modal('show');
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
                        location.href='/tmfportal';
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