<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    var jstree_json={!! json_encode($js_tree_data) !!};

    function initJSTree(){
        $('#jstree').jstree({
            'core' : {
                "themes" : {
                    "default" : "large",
                },
                'data' : [jstree_json]
            }
        }).on('click','.edit-category-link',function () {
            var name=prompt('New Name:',$(this).data('category'));
            $.post(
                '/money/save-new-category',
                {
                    id:$(this).data('id'),
                    category:name
                },
                function (msg) {
                    location.href=location.href;
                }
            );
            return false;
        });
    }

    initJSTree();

    // $('').click();
</script>