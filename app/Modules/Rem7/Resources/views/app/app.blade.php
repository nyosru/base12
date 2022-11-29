<!DOCTYPE html>
<html lang="en">

<head>

    {{-- <!-- Required meta tags --> --}}
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>Мастерская «7 РЕМЁСЕЛ»</title>

    <!-- Bootstrap CSS -->
    {{-- <link rel="stylesheet" type="text/css" href="{{ asset('/module_rem7/css/bootstrap.min.css') }}"> --}}
    <!-- Icon -->
    <link rel="stylesheet" type="text/css" href="{{ asset('/module_rem7/fonts/line-icons.css') }}">
    <!-- Slicknav -->
    {{-- <link rel="stylesheet" type="text/css" href="{{ asset('/module_rem7/css/slicknav.css') }}"> --}}
    <!-- Owl carousel -->
    {{-- <link rel="stylesheet" type="text/css" href="{{ asset('/module_rem7/css/owl.carousel.min.css') }}"> --}}
    {{-- <link rel="stylesheet" type="text/css" href="{{ asset('/module_rem7/css/owl.theme.css') }}"> --}}
    <!-- Slick Slider -->
    {{-- <link rel="stylesheet" type="text/css" href="{{ asset('/module_rem7/css/slick.css') }}"> --}}
    {{-- <link rel="stylesheet" type="text/css" href="{{ asset('/module_rem7/css/slick-theme.css') }}"> --}}
    <!-- Animate -->
    {{-- <link rel="stylesheet" type="text/css" href="{{ asset('/module_rem7/css/animate.css') }}"> --}}
    <!-- Main Style -->
    {{-- <link rel="stylesheet" type="text/css" href="{{ asset('/module_rem7/css/main.css') }}"> --}}
    <!-- Responsive Style -->
    {{-- <link rel="stylesheet" type="text/css" href="{{ asset('/module_rem7/css/responsive.css') }}"> --}}

    <link rel="stylesheet" type="text/css" href="{{ asset('/module_rem7/css/all.css') }}" />

    @section('style')
    @show

</head>

<body>

    {{-- preloader --}}
    @if (1 == 1)

        {{-- <!-- Preloader --> --}}
        <div id="preloader">
            <div class="loader" id="loader-1"></div>
        </div>
        {{-- <!-- End Preloader --> --}}

        @section('script')
            @parent
            <script type="text/javascript">
                $(document).ready(function() {
                    $(window).on('load', function() {
                        /* Page Loader active */
                        $('#preloader').fadeOut();
                    });
                });
            </script>
        @endsection

    @endif

    @include('rem7::app.header')

    @section('content')
    @show

    @include('rem7::block-map')

    @include('rem7::app.footer')

    <section id="copyright">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-xs-12">
                    <p>© 2020-{{ date('Y') }} Все права защищены</p>
                </div>
                <div class="col-md-6 col-xs-12">
                    <p>Создание сайта: <a href="https://php-cat.com" target="_blank">php-cat.com</a></p>
                </div>
            </div>
        </div>
    </section>

    @include('rem7::arrow-top')

    @include('rem7::widget-vk')

</body>

<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="{{ asset('/module_rem7/js/jquery-min.js') }}"></script>

<script src="{{ asset('/module_rem7/js/popper.min.js') }}"></script>
<script src="{{ asset('/module_rem7/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('/module_rem7/js/owl.carousel.min.js') }}"></script>
<script src="{{ asset('/module_rem7/js/wow.js') }}"></script>
<script src="{{ asset('/module_rem7/js/jquery.nav.js') }}"></script>
<script src="{{ asset('/module_rem7/js/scrolling-nav.js') }}"></script>
<script src="{{ asset('/module_rem7/js/jquery.easing.min.js') }}"></script>

{{-- block slider --}}
{{-- <script src="{{ asset('/module_rem7/js/slick.min.js') }}"></script> --}}
{{-- block otzuvu --}}
{{-- <script src="{{ asset('/module_rem7/js/jquery.slicknav.js') }}"></script> --}}

{{-- <script src="{{ asset('/module_rem7/js/all.js') }}"></script> --}}

{{-- <script src="{{ mix('/js/all.js') }}"></script> --}}




{{-- <script src="{{ asset('/module_rem7/js/main.js') }}"></script> --}}

{{-- <script src="{{ asset('/module_rem7/js/form-validator.min.js') }}"></script> --}}
{{-- <script src="{{ asset('/module_rem7/js/contact-form-script.min.js') }}"></script> --}}

{{-- <script src="{{ asset('/module_rem7/js/map.js') }}"></script> --}}
{{-- <script type="text/javascript" src="//maps.googleapis.com/maps/api/js?key=AIzaSyCsa2Mi2HqyEcEnM1urFSIGEpvualYjwwM"></script> --}}

@section('script')

    <script type="text/javascript">
        $(document).ready(function() {
            $(window).on('load', function() {

            // alert('123123');

                // Sticky Nav
                $(window).on('scroll', function() {
                    if ($(window).scrollTop() > 50) {
                        $('.scrolling-navbar').addClass('top-nav-collapse');
                    } else {
                        $('.scrolling-navbar').removeClass('top-nav-collapse');
                    }
                });

                // one page navigation
                $('.navbar-nav').onePageNav({
                    currentClass: 'active'
                });

                /* WOW Scroll Spy
                  ========================================================*/
                var wow = new WOW({
                    //disabled for mobile
                    mobile: false
                });
                wow.init();


                /* Map Form Toggle
                ========================================================*/
                $('.map-icon').on('click', function(e) {
                    $('#conatiner-map').toggleClass('panel-show');
                    e.preventDefault();
                });


            });

        });
    </script>

@show

</html>
