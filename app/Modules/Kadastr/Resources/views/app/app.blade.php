<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">

    <title>Земельный Кадастр</title>

    {{-- <!-- Bootstrap core CSS --> --}}
    <link href="{{ asset('/kadastr/SpaceDynamic/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">

    {{-- <!-- Additional CSS Files --> --}}
    <link rel="stylesheet" href="{{ asset('/kadastr/SpaceDynamic/assets/css/fontawesome.css') }}">
    <link rel="stylesheet" href="{{ asset('/kadastr/SpaceDynamic/assets/css/templatemo-space-dynamic.css') }}">
    {{-- <link rel="stylesheet" href="{{ asset('/kadastr/assets/css/animated.css') }}"> --}}
    {{-- <link rel="stylesheet" href="{{ asset('/kadastr/assets/css/owl.css') }}"> --}}
    {{-- <link rel="stylesheet" href="{{ asset('/kadastr/css/kadastr123.css') }}"> --}}
    <link rel="stylesheet" href="{{ mix('/kadastr/css.css') }}">

    {{-- <!--
    TemplateMo 562 Space Dynamic
    https://templatemo.com/tm-562-space-dynamic
    --> --}}
</head>

<body>

    <!-- ***** Preloader Start ***** -->
    <div id="js-preloader" class="js-preloader">
        <div class="preloader-inner">
            <span class="dot"></span>
            <div class="dots">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </div>
    </div>
    <!-- ***** Preloader End ***** -->

    <!-- ***** Header Area Start ***** -->
    <header class="header-area header-sticky wow slideInDown" data-wow-duration="0.75s" data-wow-delay="0s">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <nav class="main-nav">
                        <!-- ***** Logo Start ***** -->
                        <a href="/index/" class="logo">
                            <h4>Земельный<span style="display:block;">Кадастр</span></h4>
                        </a>
                        <!-- ***** Logo End ***** -->
                        <!-- ***** Menu Start ***** -->
                        <ul class="nav">
                            <li class="scroll-to-section"><a href="#top" class="active">Старт</a></li>
                            <li class="scroll-to-section"><a href="#about">Наше дело</a></li>
                            <li class="scroll-to-section"><a href="#services">Услуги</a></li>
                            {{-- <li class="scroll-to-section"><a href="#portfolio">Portfolio</a></li> --}}
                            {{-- <li class="scroll-to-section"><a href="#blog">Blog</a></li> --}}
                            <li class="scroll-to-section"><a href="#contact">Обратный звонок</a></li>
                            <li class="scroll-to-section">
                                <div class="main-red-button"><a href="#contact">Отправить заявку</a></div>
                            </li>
                        </ul>
                        <a class='menu-trigger'>
                            <span>Menu</span>
                        </a>
                        <!-- ***** Menu End ***** -->
                    </nav>
                </div>
            </div>
        </div>
    </header>
    <!-- ***** Header Area End ***** -->

    @yield('content')


    <footer>
        <div class="container">
            <div class="row">
                <div class="col-lg-12 wow fadeIn" data-wow-duration="1s" data-wow-delay="0.25s">
                    <p>© Copyright 2021 Все права защищены

                        <br>Создание сайта: <a href="https://php-cat.com" target="_blank">php-cat.com</a> mew mew
                    </p>
                </div>
            </div>
        </div>
    </footer>
</body>


    <!-- Scripts -->
    <script src="{{ asset('/kadastr/SpaceDynamic/vendor/jquery/jquery.min.js') }}"></script>
    {{-- <script src="{{ asset('/kadastr/SpaceDynamic/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script> --}}
    <script src="{{ asset('/kadastr/SpaceDynamic/assets/js/owl-carousel.js') }}"></script>
    <script src="{{ asset('/kadastr/SpaceDynamic/assets/js/animation.js') }}"></script>
    {{-- <script src="{{ asset('/kadastr/SpaceDynamic/assets/js/imagesloaded.js') }}"></script> --}}
    {{-- <script src="{{ asset('/kadastr/assets/js/templatemo-custom.js') }}"></script> --}}
    <script src="{{ mix('/kadastr/js.js') }}"></script>

</html>
