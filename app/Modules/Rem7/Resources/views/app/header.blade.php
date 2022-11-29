    {{-- @section('style')
        <style>
            .navbar .logo {
                max-height: 40px;
            }
            .navbar.top-nav-collapse .logo {
                max-height: 20px;
            }
        </style>
    @endsection --}}

    {{-- <!-- Header Area wrapper Starts --> --}}
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

                    <a href="/" class="navbar-brand"><img {{-- src="{{ asset('/module_rem7/img/logo.png') }}" --}} {{-- src="{{ asset('/module_rem7/img/logo1.png') }}" --}}
                            {{-- class="logo" --}} style="max-height: 46px;" src="{{ asset('/module_rem7/logo.svg') }}"
                            alt=""></a>
                </div>
                <div class="collapse navbar-collapse" id="main-navbar">
                    <ul class="navbar-nav mr-auto w-100 justify-content-left clearfix">
                        {{-- <li class="nav-item active">
                            <a class="nav-link" href="#hero-area">
                                Home
                            </a>
                        </li> --}}
                        <li class="nav-item active">
                            <a class="nav-link" href="#about">
                                Мастерская
                            </a>
                        </li>
                        {{-- <li class="nav-item">
                            <a class="nav-link" href="#services">
                                Services
                            </a>
                        </li> --}}
                        {{-- <li class="nav-item">
                            <a class="nav-link" href="#feature">
                                feature
                            </a>
                        </li> --}}

                        @if (1 == 2)
                            <li class="nav-item">
                                <a class="nav-link" href="#team">
                                    Team
                                </a>
                            </li>
                        @endif

                        {{-- <li class="nav-item">
                            <a class="nav-link" href="#testimonial">
                                Testimonial
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
                    <div class="btn-sing float-right">
                        <a class="btn btn-border" href="tel:+79963203608">8-996-320-36-08</a>
                    </div>
                </div>
            </div>

            {{-- <!-- Mobile Menu Start --> --}}
            <ul class="mobile-menu navbar-nav">
                <li>
                    <a class="page-scroll" href="#hero-area">
                        Home
                    </a>
                </li>
                <li>
                    <a class="page-scroll" href="#services">
                        Services
                    </a>
                </li>
                <li>
                    <a class="page-scroll" href="#feature">
                        feature
                    </a>
                </li>
                <li>
                    <a class="page-scroll" href="#team">
                        Team
                    </a>
                </li>
                <li>
                    <a class="page-scroll" href="#testimonial">
                        Testimonial
                    </a>
                </li>
                <li>
                    <a class="page-scroll" href="#pricing">
                        Pricing
                    </a>
                </li>
                <li>
                    <a class="page-scroll" href="#contact">
                        Contact
                    </a>
                </li>
            </ul>
            {{-- <!-- Mobile Menu End --> --}}

        </nav>
        {{-- <!-- Navbar End --> --}}

        {{-- <!-- Hero Area Start --> --}}
        <div id="hero-area" class="hero-area-bg">
            <div class="overlay"></div>
            <div class="container">
                <div class="row">
                    <div class="col-md-12 col-sm-12">

                        <div class="contents text-center">
                            @if (1 == 2)
                                <div class="contents text-center">
                                    {{-- <h2 class="head-title wow fadeInUp">Super Simple Bootstrap HTML5 Template<br> For Business, SaaS and Apps</h2> --}}
                                    <h2 class="head-title wow fadeInUp">Ремонт телефонов, ремонт телевизоров, ремонт
                                        планшетов,
                                        ремонт свч, ремонт проекторов.</h2>
                                    <div class="header-button wow fadeInUp" data-wow-delay="0.3s">
                                        <a href="#" class="btn btn-common">Записаться на ремонт</a>
                                    </div>
                                </div>
                            @endif

                            {{-- @section('style') --}}
                            {{-- @parent --}}
                            <style>
                                .remont_items {
                                    color: #585b60;
                                }

                                .remont_items button,
                                .remont_items a {
                                    margin-right: 5px;
                                    margin-bottom: 5px;
                                }

                            </style>
                            {{-- @endsection --}}

                            <div class="d-block d-lg-none remont_items img-thumb text-center wow fadeInUp"
                                data-wow-delay="0.6s">

                                <p><a href="tel:+79963203608" style="font-size: 2rem;">8-996-320-36-08</a></p>
                                <br />

                            </div>

                            <div id="about" class="remont_items img-thumb text-center wow fadeInUp"
                                data-wow-delay="0.6s">
                                <h3>Выберите что нужно ремонтировать<br />&nbsp;</h3>

                                <p>

                                    @foreach ($remont_items as $i)
                                        <a class="page-scroll btn btn-info btn-sm"
                                            href="#form12">{{ $i['name'] }}</a>
                                    @endforeach

                                    <a class="page-scroll btn btn-info btn-sm" href="#form1">Другое</a>
                                </p>
                            </div>

                            {{-- <div class="img-thumb text-center wow fadeInUp" data-wow-delay="0.6s">
                            <img class="img-fluid" src="{{ asset('/module_rem7/img/hero-1.png') }}" alt="">
                        </div> --}}

                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- <!-- Hero Area End --> --}}

    </header>
    {{-- <!-- Header Area wrapper End --> --}}
