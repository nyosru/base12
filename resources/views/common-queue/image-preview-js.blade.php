<script>
    this.imagePreview = function () {
        /* CONFIG */

        xOffset = 10;
        yOffset = 30;

        // these 2 variable determine popup's distance from the cursor
        // you might want to adjust to get the right result

        /* END CONFIG */
        $("img.preview").hover(function (e) {
                this.t = this.title;
                this.title = "";

                var c = (this.t != "") ? "<br/>" + this.t : "";
                $("body").append("<p id='preview' style='z-index: 1000000'><img src='" + this.attributes.src.value + "' alt='Image preview' style='max-width:500px;max-height:500px;'>" + c + "</p>");
                var y = 0;
                var my_tooltip = $("#preview");

                var border_top = $(window).scrollTop();
                var border_right = $(window).width();
                var left_pos;
                var top_pos;
                var offset = 15;
                if (border_right - (offset * 2) >= my_tooltip.width() + e.pageX) {
                    left_pos = e.pageX + offset;
                } else {
                    left_pos = border_right - my_tooltip.width() - offset;
                }

                if (border_top + (offset * 2) >= e.pageY - my_tooltip.height()) {
                    top_pos = border_top + offset;
                } else {
                    top_pos = e.pageY - my_tooltip.height() - offset;
                }

                //$("#tst").html("y:"+y+" x:"+e.pageX);
                $("#preview")
                    .css("top", top_pos + "px")
                    .css("left", left_pos + "px")
                    .fadeIn("fast");
            },
            function () {
                this.title = this.t;
                $("#preview").remove();
            });
        $("a.preview").mousemove(function (e) {
            my_tooltip = $("#preview");
            var y = 0;
            /*if((window.innerHeight- e.pageY)<500)
             y=window.innerHeight-500;
             else*/
            var border_top = $(window).scrollTop();
            var border_right = $(window).width();
            var left_pos;
            var top_pos;
            var offset = 15;
            if (border_right - (offset * 2) >= my_tooltip.width() + e.pageX) {
                left_pos = e.pageX + offset;
            } else {
                left_pos = border_right - my_tooltip.width() - offset;
            }

            if (border_top + (offset * 2) >= e.pageY - my_tooltip.height()) {
                top_pos = border_top + offset;
            } else {
                top_pos = e.pageY - my_tooltip.height() - offset;
            }

            //$("#tst").html("y:"+y+" x:"+e.pageX);
            $("#preview")
                .css("top", top_pos + "px")
                .css("left", left_pos + "px");
        });
    };
</script>