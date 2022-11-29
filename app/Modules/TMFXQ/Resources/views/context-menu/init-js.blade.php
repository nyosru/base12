<script>
    var $contextMenu = $("#context-menu");
    var cm_item = null;

    $('html').click(function (e) {
        hideContextMenu();
    });

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

    function hideContextMenu() {
        $contextMenu.hide();
        cm_item = null;
    }

    $("body").on("contextmenu", "{{$selector}}", function (e) {
        showContextMenu($contextMenu, e);
        return false;
    });

    $("body").on("click", "{{$selector}}", function (e) {
        showContextMenu($contextMenu, e);
        return false;
    });

</script>