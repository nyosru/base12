    {{-- <!-- Go to Top Link --> --}}
    <a href="#" class="back-to-top">
        <i class="lni-arrow-up"></i>
    </a>

    @section('script')
        @parent

        <script type="text/javascript">
            $(document).ready(function() {

                // console.log(4344444444);

                /* Back Top Link active
                ========================================================*/
                var offset = 200;
                var duration = 500;

                $(window).scroll(function() {
                    if ($(this).scrollTop() > offset) {
                        $('.back-to-top').fadeIn(400);
                    } else {
                        $('.back-to-top').fadeOut(400);
                    }
                });

                $('.back-to-top').on('click', function(event) {
                    event.preventDefault();
                    $('html, body').animate({
                        scrollTop: 0
                    }, 600);
                    return false;
                });

            });
        </script>

    @endsection
