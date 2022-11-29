<script type="text/javascript">
    $('#add-new-category-btn').click(function () {
        $('#add-edit-category-modal .modal-title').text('Add New Category');
        $('.view-access-filter-chbx').prop('checked',false);
        $('.view-access-all-filter-chbx').prop('checked',false);
        $('.admin-access-filter-chbx').prop('checked',false);
        $('.admin-access-filter-chbx[value="1"]').prop('checked',true);
        $('.admin-access-filter-chbx[value="53"]').prop('checked',true);
        $('.all-btn').data('all',1);
        $('#category-name').val('');
        $('#bg-color').val('#F7F7F7');
        $('#save-category-btn').data('id',0);
        $('#add-edit-category-modal').modal('show');
    });


    $('.view-access-filter-chbx').click(function () {
        if($(this).hasClass('eos-group')){
            let eos_group_checked=$(this).prop('checked');
            let eos_group_id=Number($(this).val());
            $('.tmfsales').each(function () {
                let groups=$(this).data('groups');
                if($.inArray(eos_group_id,groups)!=-1) {
                    if(eos_group_checked)
                        $(this).prop('checked', eos_group_checked);
                    else{
                        let checked=false;
                        $.each(groups,function (i,val) {
                            if($('.eos-group[value="'+val+'"]').prop('checked'))
                                checked=true;
                        });
                        $(this).prop('checked', checked);
                    }
                }
            });
        }else
            if($(this).hasClass('tmfsales') && $(this).prop('checked')==false){
                let groups=$(this).data('groups');
                $.each(groups,function (i,val) {
                    if($('.eos-group[value="'+val+'"]').prop('checked'))
                        $('.eos-group[value="'+val+'"]').prop('checked',false);
                });
            }
        if($(this).prop('checked')==false)
            $('.view-access-all-filter-chbx').prop('checked',false);
    });

    $('.all-btn').click(function () {
        let all=Number($(this).data('all'));
        $('.'+$(this).data('class')).prop('checked',all);
        $(this).data('all',(all?0:1));

    });

    $('#save-category-btn').click(function () {
        $('#add-edit-category-modal').modal('hide');
        $('#tmfwaiting400_modal').modal('show');
        let view_access_arr=[];
        $('.view-access-filter-chbx.tmfsales:checked').each(function () {
            view_access_arr.push($(this).val());
        });
        let view_access_group_arr=[];
        $('.view-access-filter-chbx.eos-group:checked').each(function () {
            view_access_group_arr.push($(this).val());
        });

        let admin_access_arr=[];
        $('.admin-access-filter-chbx:checked').each(function () {
            admin_access_arr.push($(this).val());
        });

        $.post(
            '/tmfportal-maintainer/add-edit-category',
            {
                id:$('#save-category-btn').data('id'),
                name:$.trim($('#category-name').val()),
                bg_color:$.trim($('#bg-color').val()),
                view_access:JSON.stringify(view_access_arr),
                view_access_group:JSON.stringify(view_access_group_arr),
                admin_access:JSON.stringify(admin_access_arr),
                view_access_all:($('.view-access-all-filter-chbx').prop('checked')?1:0)
            },
            function (msg) {
                setTimeout(function () {
                    $('#tmfwaiting400_modal').modal('hide');
                }, 1000);
                if(msg.length){
//                    $('#root-block').html(msg);
                    $('.sys-message .toast-body').text('Saved');
                    $('.sys-message').toast('show');
                    location.href='/tmfportal-maintainer';
                }else{
                    $('.sys-message .toast-body').text('Error during saving category!');
                    $('.sys-message').toast('show');
                    $('#add-edit-category-modal').modal('show');
                }
            }
        );
    });

    $('.edit-category-btn').click(function () {
        $('#add-edit-category-modal .modal-title').text('Edit Category');
        $('#category-name').val($(this).data('name'));
        $('#bg-color').val($(this).data('bg-color'));
        $('.view-access-all-filter-chbx').prop('checked',Number($(this).data('view-access-all')));
        $('#save-category-btn').data('id',$(this).data('id'));
        let view_access=$(this).data('view-access');
        let view_access_group=$(this).data('view-access-group');
        $('.view-access-filter-chbx').prop('checked',false);
        $('.admin-access-filter-chbx').prop('checked',false);
        $.each(view_access,function (i,val) {
            $('.view-access-filter-chbx.tmfsales[value="'+val+'"]').prop('checked',true);
        });
        $.each(view_access_group,function (i,val) {
            $('.view-access-filter-chbx.eos-group[value="'+val+'"]').prop('checked',true);
        });
        let admin_access=$(this).data('admin-access');
        $.each(admin_access,function (i,val) {
            $('.admin-access-filter-chbx[value="'+val+'"]').prop('checked',true);
        });
        $('#add-edit-category-modal').modal('show');
        return false;
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
                        location.href='/tmfportal-maintainer';
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
        $.post(location.pathname + '/reorder-categories', {arr: JSON.stringify(arr)}, function (msg) {});

    });

</script>