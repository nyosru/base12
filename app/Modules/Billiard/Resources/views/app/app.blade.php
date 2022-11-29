{{-- <link rel="stylesheet" href="{{ asset('/billiard/css/bootstrap/css/bootstrap.min.css') }}"> --}}
{{-- @include('billiard::app.app-header') --}}
{{-- @section('breadcrumbs') --}}
{{-- @endsection --}}
{{-- @yield('content') --}}
{{-- <script type="text/javascript" src="{{ asset('/billiard/js/jquery-2.2.4.min.js') }}"></script> --}}
{{-- @yield('js') --}}
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>Салон-магазин "В мире бильярда"</title>

    {{-- <!-- Bootstrap CSS --> --}}
    <link rel="stylesheet" type="text/css" href="{{ asset('/billiard/css/bootstrap.min.css') }}">
    {{-- <!-- Font --> --}}
    <link rel="stylesheet" type="text/css" href="{{ asset('/billiard/css/font-awesome.min.css') }}">
    {{-- <!-- Slicknav --> --}}
    <link rel="stylesheet" type="text/css" href="{{ asset('/billiard/css/slicknav.css') }}">
    {{-- <!-- Owl carousel --> --}}
    <link rel="stylesheet" type="text/css" href="{{ asset('/billiard/css/owl.carousel.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('/billiard/css/owl.theme.css') }}">
    {{-- <!-- Animate --> --}}
    {{-- <link rel="stylesheet" type="text/css" href="{{ asset('/billiard/css/animate.css') }}"> --}}
    {{-- <!-- Main Style --> --}}
    {{-- <link rel="stylesheet" type="text/css" href="{{ asset('/billiard/css/main.css') }}"> --}}
    {{-- <!-- Extras Style --> --}}
    {{-- <link rel="stylesheet" type="text/css" href="{{ mix('/billiard/css/extras.css') }}"> --}}
    {{-- <!-- Responsive Style --> --}}
    {{-- <link rel="stylesheet" type="text/css" href="{{ mix('/billiard/css/responsive.css') }}"> --}}

    <link rel="stylesheet" type="text/css" href="{{ asset('/billiard/css.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('/billiard/scss.css') }}">
</head>

<body>
    {{-- <!-- Header Area wrapper Starts --> --}}
    @include('billiard::app.app-header')
    {{-- <!-- Header Area wrapper End --> --}}


    <span class="content">

        {{-- @section('content')
    @endsection --}}
        {{-- @yield('content') --}}

        @if (1 == 1)
            {{-- <!-- About Section Start --> --}}
            <div id="about" class="section-padding">

                @include('billiard::pages.index')

                @if (1 == 2)
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-3 col-md-6 col-xs-12">
                                <div class="about block text-center">
                                    <img src="{{ asset('/billiard/img/about/img1.png') }}" alt="">
                                    <h5><a href="#">About Title</a></h5>
                                    <p>Quisque sit amet libero purus. Nulla a dignissim quam. In hac habitasse platea
                                        dictumst.
                                    </p>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 col-xs-12">
                                <div class="about block text-center">
                                    <img src="{{ asset('/billiard/img/about/img2.png') }}" alt="">
                                    <h5><a href="#">About Title</a></h5>
                                    <p>Quisque sit amet libero purus. Nulla a dignissim quam. In hac habitasse platea
                                        dictumst.
                                    </p>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 col-xs-12">
                                <div class="about block text-center">
                                    <img src="{{ asset('/billiard/img/about/img3.png') }}" alt="">
                                    <h5><a href="#">About Title</a></h5>
                                    <p>Quisque sit amet libero purus. Nulla a dignissim quam. In hac habitasse platea
                                        dictumst.
                                    </p>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 col-xs-12">
                                <div class="about block text-center">
                                    <img src="{{ asset('/billiard/img/about/img4.png') }}" alt="">
                                    <h5><a href="#">About Title</a></h5>
                                    <p>Quisque sit amet libero purus. Nulla a dignissim quam. In hac habitasse platea
                                        dictumst.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

            </div>
            {{-- <!-- About Section End --> --}}
        @endif

        @if (1 == 1)
            {{-- <!-- Services Section Start --> --}}
            <section id="services" class="section-padding">

                @include('billiard::pages.uslugi')

                @if (1 == 2)
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12">
                                <h2 class="section-title wow fadeInDown animated" data-wow-delay="0.3s">Our Services
                                </h2>
                            </div>
                        </div>
                        <div class="row">
                            {{-- <!-- Start Service Icon 1 --> --}}
                            <div class="col-md-6 col-lg-4 col-xs-12">
                                <div class="service-box">
                                    <div class="service-icon">
                                        <i class="fa fa-cogs"></i>
                                    </div>
                                    <div class="service-content">
                                        <h4><a href="#">Easy to Customize</a></h4>
                                        <p>
                                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Recusandae
                                            architecto
                                            officiis
                                            consequuntur vero error excepturi.
                                        </p>
                                    </div>
                                </div>
                            </div>
                            {{-- <!-- End Service Icon 1 --> --}}

                            {{-- <!-- Start Service Icon 2 --> --}}
                            <div class="col-md-6 col-lg-4 col-xs-12">
                                <div class="service-box">
                                    <div class="service-icon">
                                        <i class="fa fa-cubes"></i>
                                    </div>
                                    <div class="service-content">
                                        <h4><a href="#">100+ Components</a></h4>
                                        <p>
                                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Recusandae
                                            architecto
                                            officiis
                                            consequuntur vero error excepturi.
                                        </p>
                                    </div>
                                </div>
                            </div>
                            {{-- <!-- End Service Icon 2 --> --}}

                            {{-- <!-- Start Service Icon 3 --> --}}
                            <div class="col-md-6 col-lg-4 col-xs-12">
                                <div class="service-box">
                                    <div class="service-icon">
                                        <i class="fa fa-tachometer"></i>
                                    </div>
                                    <div class="service-content">
                                        <h4><a href="#">Super Fast</a></h4>
                                        <p>
                                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Recusandae
                                            architecto
                                            officiis
                                            consequuntur vero error excepturi.
                                        </p>
                                    </div>
                                </div>
                            </div>
                            {{-- <!-- End Service Icon 3 --> --}}

                            {{-- <!-- Start Service Icon 4 --> --}}
                            <div class="col-md-6 col-lg-4 col-xs-12">
                                <div class="service-box">
                                    <div class="service-icon">
                                        <i class="fa fa-check"></i>
                                    </div>
                                    <div class="service-content">
                                        <h4><a href="#">Clean Design</a></h4>
                                        <p>
                                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Recusandae
                                            architecto
                                            officiis
                                            consequuntur vero error excepturi.
                                        </p>
                                    </div>
                                </div>
                            </div>
                            {{-- <!-- End Service Icon 4 --> --}}

                            {{-- <!-- Start Service Icon 5 --> --}}
                            <div class="col-md-6 col-lg-4 col-xs-12">
                                <div class="service-box">
                                    <div class="service-icon">
                                        <i class="fa fa-flash"></i>
                                    </div>
                                    <div class="service-content">
                                        <h4><a href="#">Bootstrap 4 UI Kit</a></h4>
                                        <p>
                                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Recusandae
                                            architecto
                                            officiis
                                            consequuntur vero error excepturi.
                                        </p>
                                    </div>
                                </div>
                            </div>
                            {{-- <!-- End Service Icon 5 --> --}}

                            {{-- <!-- Start Service Icon 6 --> --}}
                            <div class="col-md-6 col-lg-4 col-xs-12">
                                <div class="service-box">
                                    <div class="service-icon">
                                        <i class="fa fa-hand-pointer-o"></i>
                                    </div>
                                    <div class="service-content">
                                        <h4><a href="#">Advanced Features</a></h4>
                                        <p>
                                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Recusandae
                                            architecto
                                            officiis
                                            consequuntur vero error excepturi.
                                        </p>
                                    </div>
                                </div>
                            </div>
                            {{-- <!-- End Service Icon 6 --> --}}
                        </div>
                    </div>
                @endif
            </section>
            {{-- <!-- Services Section End --> --}}
        @endif

        @if (1 == 2)
            {{-- <!-- Portfolio Section --> --}}
            <section id="portfolio" class="section-padding">
                {{-- <!-- Container Starts --> --}}
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <h2 class="section-title wow fadeInDown animated" data-wow-delay="0.3s">Portfolio</h2>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-md-12">
                            {{-- <!-- Portfolio Controller/Buttons --> --}}
                            <div class="controls text-center wow fadeInUpQuick" data-wow-delay=".6s">
                                <a class="filter active btn btn-common" data-filter="all">
                                    All
                                </a>
                                <a class="filter btn btn-common" data-filter=".branding">
                                    Branding
                                </a>
                                <a class="filter btn btn-common" data-filter=".marketing">
                                    Marketing
                                </a>
                                <a class="filter btn btn-common" data-filter=".planning">
                                    Planning
                                </a>
                                <a class="filter btn btn-common" data-filter=".research">
                                    Research
                                </a>
                            </div>
                            {{-- <!-- Portfolio Controller/Buttons Ends--> --}}
                        </div>

                        {{-- <!-- Portfolio Recent Projects --> --}}
                        <div id="portfolio" class="row wow fadeInUpQuick" data-wow-delay="0.8s">
                            <div class="col-lg-4 col-md-6 col-xs-12 mix marketing planning">
                                <div class="portfolio-item">
                                    <div class="portfolio-img">
                                        <img src="{{ asset('/billiard/img/portfolio/img1.jpg') }}" alt="" />
                                    </div>
                                    <div class="portfoli-content">
                                        <div class="sup-desc-wrap">
                                            <div class="sup-desc-inner">
                                                <div class="sup-link">
                                                    <a class="left-link" href="#"><i class="fa fa-link"></i></a>
                                                    <a class="right-link" href="#"><i class="fa fa-heart"></i></a>
                                                </div>
                                                <div class="sup-meta-wrap">
                                                    <a class="sup-title" href="#">
                                                        <h4>TITLE HERE</h4>
                                                    </a>
                                                    <p class="sup-description">Lorem ipsum dolor sit amet, consectetur
                                                        adipisicing elit. Sapiente vel quisquam.</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6 col-xs-12 mix branding planning">
                                <div class="portfolio-item">
                                    <div class="portfolio-img">
                                        <img src="{{ asset('/billiard/img/portfolio/img2.jpg') }}" alt="" />
                                    </div>
                                    <div class="portfoli-content">
                                        <div class="sup-desc-wrap">
                                            <div class="sup-desc-inner">
                                                <div class="sup-link">
                                                    <a class="left-link" href="#"><i class="fa fa-link"></i></a>
                                                    <a class="right-link" href="#"><i class="fa fa-heart"></i></a>
                                                </div>
                                                <div class="sup-meta-wrap">
                                                    <a class="sup-title" href="#">
                                                        <h4>TITLE HERE</h4>
                                                    </a>
                                                    <p class="sup-description">Lorem ipsum dolor sit amet, consectetur
                                                        adipisicing elit. Sapiente vel quisquam.</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6 col-xs-12 mix branding research">
                                <div class="portfolio-item">
                                    <div class="portfolio-img">
                                        <img src="{{ asset('/billiard/img/portfolio/img3.jpg') }}" alt="" />
                                    </div>
                                    <div class="portfoli-content">
                                        <div class="sup-desc-wrap">
                                            <div class="sup-desc-inner">
                                                <div class="sup-link">
                                                    <a class="left-link" href="#"><i class="fa fa-link"></i></a>
                                                    <a class="right-link" href="#"><i class="fa fa-heart"></i></a>
                                                </div>
                                                <div class="sup-meta-wrap">
                                                    <a class="sup-title" href="#">
                                                        <h4>TITLE HERE</h4>
                                                    </a>
                                                    <p class="sup-description">Lorem ipsum dolor sit amet, consectetur
                                                        adipisicing elit. Sapiente vel quisquam.</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6 col-xs-12 mix marketing research">
                                <div class="portfolio-item">
                                    <div class="portfolio-img">
                                        <img src="{{ asset('/billiard/img/portfolio/img4.jpg') }}" alt="" />
                                    </div>
                                    <div class="portfoli-content">
                                        <div class="sup-desc-wrap">
                                            <div class="sup-desc-inner">
                                                <div class="sup-link">
                                                    <a class="left-link" href="#"><i class="fa fa-link"></i></a>
                                                    <a class="right-link" href="#"><i class="fa fa-heart"></i></a>
                                                </div>
                                                <div class="sup-meta-wrap">
                                                    <a class="sup-title" href="#">
                                                        <h4>TITLE HERE</h4>
                                                    </a>
                                                    <p class="sup-description">Lorem ipsum dolor sit amet, consectetur
                                                        adipisicing elit. Sapiente vel quisquam.</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6 col-xs-12 mix marketing planning">
                                <div class="portfolio-item">
                                    <div class="portfolio-img">
                                        <img src="{{ asset('/billiard/img/portfolio/img5.jpg') }}" alt="" />
                                    </div>
                                    <div class="portfoli-content">
                                        <div class="sup-desc-wrap">
                                            <div class="sup-desc-inner">
                                                <div class="sup-link">
                                                    <a class="left-link" href="#"><i class="fa fa-link"></i></a>
                                                    <a class="right-link" href="#"><i class="fa fa-heart"></i></a>
                                                </div>
                                                <div class="sup-meta-wrap">
                                                    <a class="sup-title" href="#">
                                                        <h4>TITLE HERE</h4>
                                                    </a>
                                                    <p class="sup-description">Lorem ipsum dolor sit amet, consectetur
                                                        adipisicing elit. Sapiente vel quisquam.</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6 col-xs-12 mix planning research">
                                <div class="portfolio-item">
                                    <div class="portfolio-img">
                                        <img src="{{ asset('/billiard/img/portfolio/img6.jpg') }}" alt="" />
                                    </div>
                                    <div class="portfoli-content">
                                        <div class="sup-desc-wrap">
                                            <div class="sup-desc-inner">
                                                <div class="sup-link">
                                                    <a class="left-link" href="#"><i class="fa fa-link"></i></a>
                                                    <a class="right-link" href="#"><i class="fa fa-heart"></i></a>
                                                </div>
                                                <div class="sup-meta-wrap">
                                                    <a class="sup-title" href="#">
                                                        <h4>TITLE HERE</h4>
                                                    </a>
                                                    <p class="sup-description">Lorem ipsum dolor sit amet, consectetur
                                                        adipisicing elit. Sapiente vel quisquam.</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- <!-- Container Ends --> --}}
            </section>
            {{-- <!-- Portfolio Section Ends --> --}}
        @endif

        @if (1 == 2)
            {{-- <!-- Feature Section Start --> --}}
            <div id="feature" class="section-padding">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <h2 class="section-title wow fadeInDown animated" data-wow-delay="0.3s">Features</h2>
                        </div>
                    </div>
                    <div class="row">
                        {{-- <!-- Start featured --> --}}
                        <div class="col-lg-4 col-md-6 col-xs-12">
                            <div class="featured-box-item">
                                <div class="featured-icon">
                                    <i class="fa fa-bolt"></i>
                                </div>
                                <div class="featured-content">
                                    <h4>Bootstrap 4</h4>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor
                                        incididunt ut labore et magna aliqua.</p>
                                </div>
                            </div>
                        </div>
                        {{-- <!-- End featured --> --}}

                        {{-- <!-- Start featured --> --}}
                        <div class="col-lg-4 col-md-6 col-xs-12">
                            <div class="featured-box-item">
                                <div class="featured-icon">
                                    <i class="fa fa-diamond"></i>
                                </div>
                                <div class="featured-content">
                                    <h4>Clean Design</h4>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor
                                        incididunt ut labore et magna aliqua.</p>
                                </div>
                            </div>
                        </div>
                        {{-- <!-- End featured --> --}}

                        {{-- <!-- Start featured --> --}}
                        <div class="col-lg-4 col-md-6 col-xs-12">
                            <div class="featured-box-item">
                                <div class="featured-icon">
                                    <i class="fa fa-cubes"></i>
                                </div>
                                <div class="featured-content">
                                    <h4>100+ Components</h4>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor
                                        incididunt ut labore et magna aliqua.</p>
                                </div>
                            </div>
                        </div>
                        <!-- End featured -->

                        <!-- Start featured -->
                        <div class="col-lg-4 col-md-6 col-xs-12">
                            <div class="featured-box-item">
                                <div class="featured-icon">
                                    <i class="fa fa-cogs"></i>
                                </div>
                                <div class="featured-content">
                                    <h4>Easy to Customize</h4>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor
                                        incididunt ut labore et magna aliqua.</p>
                                </div>
                            </div>
                        </div>
                        {{-- <!-- End featured --> --}}

                        {{-- <!-- Start featured --> --}}
                        <div class="col-lg-4 col-md-6 col-xs-12">
                            <div class="featured-box-item">
                                <div class="featured-icon">
                                    <i class="fa fa-check"></i>
                                </div>
                                <div class="featured-content">
                                    <h4>Pixel Perfect</h4>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor
                                        incididunt ut labore et magna aliqua.</p>
                                </div>
                            </div>
                        </div>
                        {{-- <!-- End featured --> --}}

                        {{-- <!-- Start featured --> --}}
                        <div class="col-lg-4 col-md-6 col-xs-12">
                            <div class="featured-box-item">
                                <div class="featured-icon">
                                    <i class="fa fa-cloud"></i>
                                </div>
                                <div class="featured-content">
                                    <h4>Cloud Backup</h4>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor
                                        incididunt ut labore et magna aliqua.</p>
                                </div>
                            </div>
                        </div>
                        {{-- <!-- End featured --> --}}
                    </div>
                </div>
            </div>
            {{-- <!-- Feature Section End --> --}}
        @endif

        @if (1 == 2)
            {{-- <!-- facts Section Start --> --}}
            <div id="counter">
                <div class="container">
                    <div class="row count-to-sec">
                        <div class="col-lg-3 col-md-6 col-xs-12 count-one">
                            <span class="icon"><i class="fa fa-download"> </i></span>
                            <h3 class="timer count-value" data-to="561" data-speed="1000">561</h3>
                            <hr class="width25-divider">
                            <small class="count-title">Downloads</small>
                        </div>

                        <div class="col-lg-3 col-md-6 col-xs-12 count-one">
                            <span class="icon"><i class="fa fa-user"> </i></span>
                            <h3 class="timer count-value" data-to="950" data-speed="1000">950</h3>
                            <hr class="width25-divider">
                            <small class="count-title">Developers</small>
                        </div>

                        <div class="col-lg-3 col-md-6 col-xs-12 count-one">
                            <span class="icon"><i class="fa fa-desktop"> </i></span>
                            <h3 class="timer count-value" data-to="978" data-speed="1000">978</h3>
                            <hr class="width25-divider">
                            <small class="count-title">Lines of code written</small>
                        </div>

                        <div class="col-lg-3 col-md-6 col-xs-12 count-one">
                            <span class="icon"><i class="fa fa-coffee"> </i></span>
                            <h3 class="timer count-value" data-to="1700" data-speed="1000">1700</h3>
                            <hr class="width25-divider">
                            <small class="count-title">Cups of coffee consumed</small>
                        </div>
                    </div>
                </div>
            </div>
            {{-- <!-- facts Section End --> --}}
        @endif

        @if (1 == 2)
            {{-- <!-- Team Section Start --> --}}
            <div id="team" class="team-members-tow section-padding">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <h2 class="section-title wow fadeInDown animated" data-wow-delay="0.3s">Our Team</h2>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4 col-md-6 col-xs-12">
                            {{-- <!-- Team Item Starts --> --}}
                            <figure>
                                <img src="{{ asset('/billiard/img/team/team-05.jpg') }}" alt="">
                                <div class="image-overlay">
                                    <div class="overlay-text text-center">
                                        <div class="info-text">
                                            <strong>Melody Clark</strong>
                                            <span>UX Specialist</span>
                                        </div>
                                        <hr class="small-divider">
                                        <ul class="social-icons">
                                            <li><a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
                                            <li><a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
                                            <li><a href="#"><i class="fa fa-instagram" aria-hidden="true"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                            </figure>
                            {{-- <!-- Team Item Ends --> --}}
                        </div>
                        <div class="col-lg-4 col-md-6 col-xs-12">
                            {{-- <!-- Team Item Starts --> --}}
                            <figure>
                                <img src="{{ asset('/billiard/img/team/team-06.jpg') }}" alt="">
                                <div class="image-overlay">
                                    <div class="overlay-text text-center">
                                        <div class="info-text">
                                            <strong>Danny Burton</strong>
                                            <span>Senior Designer</span>
                                        </div>
                                        <hr class="small-divider">
                                        <ul class="social-icons">
                                            <li><a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
                                            <li><a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
                                            <li><a href="#"><i class="fa fa-instagram" aria-hidden="true"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                            </figure>
                            {{-- <!-- Team Item Ends --> --}}
                        </div>

                        <div class="col-lg-4 col-md-6 col-xs-12">
                            {{-- <!-- Team Item Starts --> --}}
                            <figure>
                                <img src="{{ asset('/billiard/img/team/team-07.jpg') }}" alt="">
                                <div class="image-overlay">
                                    <div class="overlay-text text-center">
                                        <div class="info-text">
                                            <strong>Elizabeth Jones</strong>
                                            <span>Art Director</span>
                                        </div>
                                        <hr class="small-divider">
                                        <ul class="social-icons">
                                            <li><a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
                                            <li><a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
                                            <li><a href="#"><i class="fa fa-instagram" aria-hidden="true"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                            </figure>
                            {{-- <!-- Team Item Ends --> --}}
                        </div>
                    </div>
                </div>
            </div>
            {{-- <!-- Team Section End --> --}}
        @endif

        @if (1 == 2)
            {{-- <!-- Pricing section Start --> --}}
            <section id="pricing" class="section-padding">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <h2 class="section-title wow fadeInDown animated" data-wow-delay="0.3s">Pricing Table</h2>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4 col-md-6 col-xs-12">
                            <div class="pricing-table-item">
                                <div class="plan-name">
                                    <h3>Basic</h3>
                                </div>
                                <div class="plan-price">
                                    <div class="price-value">$ 10</div>
                                    <div class="interval">per month</div>
                                </div>
                                <div class="plan-list">
                                    <ul>
                                        <li><i class="fa fa-check"></i>2GB Disk Space</li>
                                        <li><i class="fa fa-check"></i>3 Sub Domains</li>
                                        <li><i class="fa fa-check"></i>12 Database</li>
                                        <li><i class="fa fa-check"></i>Unlimited Users</li>
                                    </ul>
                                </div>
                                <div class="plan-signup">
                                    <a href="#" class="btn btn-common">Get Started</a>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-6 col-xs-12">
                            <div class="pricing-table-item table-active">
                                <div class="plan-name">
                                    <h3>Premium</h3>
                                </div>
                                <div class="plan-price">
                                    <div class="price-value">$ 69 </div>
                                    <div class="interval">per month</div>
                                </div>
                                <div class="plan-list">
                                    <ul>
                                        <li><i class="fa fa-check"></i>10GB Disk Space</li>
                                        <li><i class="fa fa-check"></i>5 Sub Domains</li>
                                        <li><i class="fa fa-check"></i>12 Database</li>
                                        <li><i class="fa fa-check"></i>Unlimited Users</li>
                                    </ul>
                                </div>
                                <div class="plan-signup">
                                    <a href="#" class="btn btn-common">Get Started</a>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-6 col-xs-12">
                            <div class="pricing-table-item">
                                <div class="plan-name">
                                    <h3>Unltimate</h3>
                                </div>
                                <div class="plan-price">
                                    <div class="price-value">$ 79 </div>
                                    <div class="interval">per month</div>
                                </div>
                                <div class="plan-list">
                                    <ul>
                                        <li><i class="fa fa-check"></i>50GB Disk Space</li>
                                        <li><i class="fa fa-check"></i>20 Sub Domains</li>
                                        <li><i class="fa fa-check"></i>36 Database</li>
                                        <li><i class="fa fa-check"></i>Unlimited Users</li>
                                    </ul>
                                </div>
                                <div class="plan-signup">
                                    <a href="#" class="btn btn-common">Get Started</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            {{-- <!-- Pricing Table Section End --> --}}
        @endif

        @if (1 == 2)
            {{-- <!-- Single testimonial Start --> --}}
            <div class="single-testimonial-area">
                <div class="container">
                    <div id="single-testimonial-item" class="owl-carousel">
                        {{-- <!-- Single testimonial Item --> --}}
                        <div class="item">
                            <div class="row justify-content-md-center">
                                <div class="col-lg-8 col-md-12 col-xs-12 col-md-auto">
                                    <div class="testimonial-inner text-md-center">
                                        <blockquote>
                                            {{-- Lorem ipsum dolor sit amet, consectetur adipisicing elit. Id ipsam, non ut molestiae
                                    rerum praesentium repellat debitis iure reiciendis, eius culpa beatae commodi facere
                                    ad numquam. Quisquam dignissimos similique sunt iure fugit, omnis vel cupiditate
                                    repellendus magni nihil molestiae quam, delectus --}}
                                        </blockquote>
                                        <div class="testimonial-images">
                                            <img class="img-circle text-md-center"
                                                src="{{ asset('/billiard/adv/niz1.jpg') }}" alt="">
                                        </div>
                                        {{-- <div class="testimonial-footer">
                                    <i class="fa fa-user"></i> Arman
                                    <a href="#"> UIdeck</a>
                                </div> --}}
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- <!-- Single testimonial Item --> --}}
                        <div class="item">
                            <div class="row justify-content-md-center">
                                <div class="col-lg-8 col-md-12 col-xs-12 col-md-auto">
                                    <div class="testimonial-inner text-md-center">
                                        {{-- <blockquote>
                                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Id ipsam, non ut molestiae
                                    rerum praesentium repellat debitis iure reiciendis, eius culpa beatae commodi facere
                                    ad numquam. Quisquam dignissimos similique sunt iure fugit, omnis vel cupiditate
                                    repellendus magni nihil molestiae quam, delectus
                                </blockquote>
                                <div class="testimonial-images">
                                    <img class="img-circle text-md-center"
                                        src="{{ asset('/billiard/img/testimonial/img2.jpg') }}" alt="">
                                </div>
                                <div class="testimonial-footer">
                                    <i class="fa fa-user"></i> Jeniffer
                                    <a href="#"> GrayGrids</a>
                                </div> --}}
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- <!-- Single testimonial Item --> --}}
                        <div class="item">
                            <div class="row justify-content-md-center">
                                <div class="col-lg-8 col-md-12 col-xs-12 col-md-auto">
                                    <div class="testimonial-inner text-md-center">
                                        {{-- <blockquote>
                                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Id ipsam, non ut molestiae
                                    rerum praesentium repellat debitis iure reiciendis, eius culpa beatae commodi facere
                                    ad numquam. Quisquam dignissimos similique sunt iure fugit, omnis vel cupiditate
                                    repellendus magni nihil molestiae quam, delectus
                                </blockquote>
                                <div class="testimonial-images">
                                    <img class="img-circle text-md-center"
                                        src="{{ asset('/billiard/img/testimonial/img3.jpg') }}" alt="">
                                </div>
                                <div class="testimonial-footer">
                                    <i class="fa fa-user"></i> Elon Musk<a href="#"> Tesla</a>
                                </div> --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- <!-- end --> --}}
        @endif

        {{-- <!-- Contact Form Section Start --> --}}
        <section id="contact" class="contact-form section-padding">

            <div class="container">
                <div class="row">
                    <div class="col-12">
                        @include('billiard::pages.contact')
                    </div>
                </div>
            </div>

            @if (1 == 2)
                <hr>
                <hr>
                <hr>

                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <h2 class="section-title wow fadeInDown animated" data-wow-delay="0.3s">Contact Us</h2>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-8 col-md-6 col-xs-12">
                            <h3 class="title-head text-left">Get in touch</h3>
                            <form class="contact-form" data-toggle="validator">
                                <div class="row">
                                    <div class="col-lg-4 col-md-12 col-xs-12">
                                        <div class="form-group">
                                            <i class="contact-icon fa fa-user"></i>
                                            <input type="text" class="form-control" id="name" placeholder="Full Name"
                                                required data-error="Please enter your name">
                                            <div class="help-block with-errors"></div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-12 col-xs-12">
                                        <div class="form-group">
                                            <i class="contact-icon fa fa-envelope-o"></i>
                                            <input type="email" class="form-control" id="email" placeholder="Email"
                                                required data-error="Please enter your email">
                                            <div class="help-block with-errors"></div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-12 col-xs-12">
                                        <div class="form-group">
                                            <i class="contact-icon fa fa-pencil-square-o"></i>
                                            <input type="text" class="form-control" id="subject" placeholder="Subject"
                                                required data-error="Please enter your Subject">
                                            <div class="help-block with-errors"></div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-xs-12">
                                        <textarea class="form-control" id="message" rows="4" placeholder="Message"
                                            required data-error="Please enter your message"></textarea>
                                        <div class="help-block with-errors"></div>
                                        <button type="submit" id="form-submit"
                                            class="btn btn-common btn-form-submit">Send
                                            Message</button>
                                        <div id="msgSubmit" class="h3 text-center hidden"></div>
                                        <div class="clearfix"></div>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div class="col-lg-4 col-md-6 col-xs-12">
                            <h4 class="contact-info-title text-left">Contact Information</h4>
                            <div class="contact-info">
                                <address>
                                    <i class="lni-map-marker icons cyan-color contact-info-icon"></i>
                                    Level 13, 2 Elizabeth St, Melbourne,
                                </address>
                                <div class="tel-info">
                                    <a href="tel:1800452308"><i
                                            class="lni-mobile icons cyan-color contact-info-icon"></i>1800
                                        452 308</a>
                                    <a href="tel:+61(8)82343555"><i
                                            class="lni-phone icons cyan-color contact-info-icon"></i>+61
                                        (8) 8234 3555</a>
                                </div>
                                <a href="mailto:hello@spiritapp.com"><i
                                        class="lni-envelope icons cyan-color contact-info-icon"></i>admin@uideck.com</a>
                                <a href="#"><i class="lni-tab icons cyan-color contact-info-icon"></i>www.uideck.com</a>
                                <ul class="social-links">
                                    <li>
                                        <a href="#" class="fa fa-facebook"></a>
                                    </li>
                                    <li>
                                        <a href="#" class="fa fa-twitter"></a>
                                    </li>
                                    <li>
                                        <a href="#" class="fa fa-instagram"></a>
                                    </li>
                                    <li>
                                        <a href="#" class="fa fa-linkedin"></a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

        </section>
        <!-- Contact Form Section End -->

    </span>

    <!-- Footer Section -->
    <footer class="footer">

        {{-- @include('billiard::app.app-footer') --}}

        <!-- Copyright -->
        <div id="copyright">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-xs-12">
                        <p class="copyright-text">В мире бильярда © 2002-{{ date('Y') }}</p>
                    </div>
                    <div class="col-lg-6 col-md-6 col-xs-12">
                        <ul class="nav nav-inline  justify-content-end ">
                            {{-- <li class="nav-item">
                                <a class="nav-link active" href="#">Home</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">Sitemap</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">Privacy Policy</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">Terms of services</a>
                            </li> --}}
                            <li class="nav-item">
                                <a class="nav-link" href="https://php-cat.com" target="_blank">Создание сайта
                                    PHP-CAT.com</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- Copyright  End-->

    </footer>
    <!-- Footer Section End-->

    <!-- Go to Top Link -->
    <a href="#" class="back-to-top">
        <i class="fa fa-arrow-up"></i>
    </a>


    <!-- Preloader -->
    <div id="preloader">
        <div class="loader" id="loader-1"></div>
    </div>
    <!-- End Preloader -->

    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    {{-- <script src="{{ asset('/billiard/js/jquery-min.js') }}"></script> --}}
    <script src="https://yastatic.net/jquery/2.1.4/jquery.min.js"></script>
    {{-- <script src="{{ asset('/billiard/js/popper.min.js') }}"></script> --}}
    <script src="{{ asset('/billiard/js/bootstrap.min.js') }}"></script>
    {{-- <script src="{{ asset('/billiard/js/owl.carousel.min.js') }}"></script> --}}
    {{-- <script src="{{ asset('/billiard/js/jquery.mixitup.js') }}"></script> --}}
    {{-- <script src="{{ asset('/billiard/js/jquery.countTo.js') }}"></script> --}}
    <script src="{{ asset('/billiard/js/jquery.nav.js') }}"></script>
    {{-- <script src="{{ asset('/billiard/js/scrolling-nav.js') }}"></script> --}}
    {{-- <script src="{{ asset('/billiard/js/jquery.easing.min.js') }}"></script> --}}
    {{-- <script src="{{ asset('/billiard/js/jquery.slicknav.js') }}"></script> --}}
    {{-- <script src="{{ asset('/billiard/js/form-validator.min.js') }}"></script> --}}
    {{-- <script src="{{ asset('/billiard/js/contact-form-script.js') }}"></script> --}}
    <script src="{{ asset('/billiard/js/main.js') }}"></script>

</body>

</html>
