<header id="header-wrap">
    {{-- <!-- Navbar Start --> --}}
    <nav class="navbar navbar-expand-lg fixed-top scrolling-navbar indigo">
        <div class="container">
            {{-- <!-- Brand and toggle get grouped for better mobile display --> --}}
            <div class="navbar-header">

                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#main-navbar"
                    aria-controls="main-navbar" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                    <span class="icon-menu"></span>
                    <span class="icon-menu"></span>
                    <span class="icon-menu"></span>
                </button>

                <a href="/index" class="navbar-brand">
                    {{-- <img src="{{ asset('/billiard/img/logo.png') }}" alt=""> --}}
                    <img src="{{ asset('/billiard/logo.png') }}" alt="">
                </a>
            </div>

            <div class="collapse navbar-collapse" id="main-navbar">
                <ul class="navbar-nav mr-auto w-100 justify-content-end clearfix">

                    {{-- <li class="nav-item active">
                        <a class="nav-link" href="#sliders">
                            Home
                        </a>
                    </li> --}}
                    <li class="nav-item">
                        <a class="nav-link" href="#about">
                            О салоне
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#services">
                            Услуги
                        </a>
                    </li>
                    {{-- <li class="nav-item">
                        <a class="nav-link" href="#portfolio">
                            Portfolio
                        </a>
                    </li> --}}
                    {{-- <li class="nav-item">
                        <a class="nav-link" href="#feature">
                            Features
                        </a>
                    </li> --}}
                    {{-- <li class="nav-item">
                        <a class="nav-link" href="#team">
                            Team
                        </a>
                    </li> --}}
                    {{-- <li class="nav-item">
                        <a class="nav-link" href="#pricing">
                            Pricing
                        </a>
                    </li> --}}
                    <li class="nav-item">
                        <a class="nav-link" href="#contact">
                            Контакты
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Mobile Menu Start -->
        <ul class="mobile-menu navbar-nav">
            <li>
                <a class="page-scroll" href="#sliders">
                    Home
                </a>
            </li>
            <li>
                <a class="page-scroll" href="#about">
                    О салоне
                </a>
            </li>
            <li>
                <a class="page-scroll" href="#services">
                    Услуги
                </a>
            </li>
            {{-- <li>
                <a class="page-scroll" href="#portfolio">
                    Portfolio
                </a>
            </li> --}}
            {{-- <li>
                <a class="page-scroll" href="#feature">
                    Features
                </a>
            </li> --}}
            {{-- <li>
                <a class="page-scroll" href="#team">
                    Team
                </a>
            </li> --}}
            {{-- <li>
                <a class="page-scroll" href="#pricing">
                    Pricing
                </a>
            </li> --}}
            <li>
                <a class="page-scroll" href="#contact">
                    Контакты
                </a>
            </li>
        </ul>
        {{-- <!-- Mobile Menu End --> --}}

    </nav>
    {{-- <!-- Navbar End --> --}}




    {{-- <!-- sliders --> --}}
    <div id="sliders bg_nice">
        <div class="full-width">
            {{-- <!-- light slider --> --}}
            <div id="light-slider" class="carousel slide">

                <div id="carousel-area2">
                    <div id="carousel-slider" class="carousel slide" data-ride="carousel">
                        <ol class="carousel-indicators">
                            @for ($e = 0; $e <= 5; $e++)
                            <li data-target="#carousel-slider" data-slide-to="{{ $e }}" class="@if( $e == 0 ) active @endif"></li>
                            {{-- <li data-target="#carousel-slider" data-slide-to="1"></li> --}}
                            {{-- <li data-target="#carousel-slider" data-slide-to="2"></li> --}}
                            @endfor
                        </ol>
                        <div class="carousel-inner" role="listbox">

                            {{-- <div class="carousel-item active"> --}}
                                {{-- <img src="{{ asset('/billiard/img/slider/bg-1.jpg') }}" alt=""> --}}
                                {{-- <img src="{{ asset('/billiard/adv/up1.jpg') }}" alt=""> --}}
                                {{-- <div class="carusel_item" style="background-image: url({{ asset('/billiard/adv/up1.jpg') }});" >&nbsp;</div> --}}
                                {{-- <div class="carousel-caption"> --}}
                                    {{-- <h3 class="slide-title animated fadeInDown"><span>Helium</span> - Bootstrap 4 UI
                                        Kit</h3>
                                    <h5 class="slide-text animated fadeIn">Lorem ipsum dolor sit amet, consectetuer
                                        adipiscing elit<br> Curabitur ultricies nisi Nam eget dui. Etiam rhoncus
                                    </h5>
                                    <a href="#" class="btn btn-lg btn-common animated fadeInUp">Get Started</a>
                                    <a href="#" class="btn btn-lg btn-border animated fadeInUp">Learn More</a> --}}
                                {{-- </div> --}}
                            {{-- </div> --}}

                            @for ($e = 1; $e <= 6; $e++)
                            <div class="carousel-item @if( $e == 1 ) active @endif">
                                {{-- <img src="{{ asset('/billiard/img/slider/bg-1.jpg') }}" alt=""> --}}
                                {{-- <img src="{{ asset('/billiard/adv/up'. $e .'.jpg') }}" alt=""> --}}
                                <div class="carusel_item" style="background-image: url({{ asset('/billiard/adv/up'. $e .'.jpg') }});" >&nbsp;</div>
                                {{-- <div class="carousel-caption"> --}}
                                    {{-- <h3 class="slide-title animated fadeInDown">&nbsp;</h3> --}}
                                    {{-- <h5 class="slide-text animated fadeIn">Lorem ipsum dolor sit amet, consectetuer
                                        adipiscing elit<br> Curabitur ultricies nisi Nam eget dui. Etiam rhoncus
                                    </h5>
                                    <a href="#" class="btn btn-lg btn-common animated fadeInUp">Get Started</a>
                                    <a href="#" class="btn btn-lg btn-border animated fadeInUp">Learn More</a> --}}
                                {{-- </div> --}}
                            </div>
                            @endfor

                            @if( 1 == 2 )
                            <div class="carousel-item">
                                <img src="{{ asset('/billiard/img/slider/bg-2.jpg') }}" alt="">
                                <div class="carousel-caption">
                                    <h3 class="slide-title animated fadeInDown"><span>Cutting-edge</span> Features
                                    </h3>
                                    <h5 class="slide-text animated fadeIn">Lorem ipsum dolor sit amet, consectetuer
                                        adipiscing elit<br> Curabitur ultricies nisi Nam eget dui. Etiam rhoncus
                                    </h5>
                                    <a href="#" class="btn btn-lg btn-common animated fadeInUp">Download Now</a>
                                </div>
                            </div>
                            <div class="carousel-item">
                                <img src="{{ asset('/billiard/img/slider/bg-3.jpg') }}" alt="">
                                <div class="carousel-caption">
                                    <h3 class="slide-title animated fadeInDown"><span>100+</span> UI Blocks &
                                        Components</h3>
                                    <h5 class="slide-text animated fadeIn">Lorem ipsum dolor sit amet, consectetuer
                                        adipiscing elit<br> Curabitur ultricies nisi Nam eget dui. Etiam rhoncus
                                    </h5>
                                    <a href="#" class="btn btn-lg btn-border animated fadeInUp">Get Started</a>
                                    <a href="#" class="btn btn-lg btn-common animated fadeInUp">Download</a>
                                </div>
                            </div>
                            @endif

                        </div>
                        <a class="carousel-control-prev" href="#carousel-slider" role="button" data-slide="prev">
                            <i class="fa fa-chevron-left"></i>
                        </a>
                        <a class="carousel-control-next" href="#carousel-slider" role="button" data-slide="next">
                            <i class="fa fa-chevron-right"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- <!-- End sliders --> --}}

</header>
