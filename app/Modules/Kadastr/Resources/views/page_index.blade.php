@extends('kadastr::app.app')

@section('content')

    <div class="main-banner wow fadeIn" id="top" data-wow-duration="1s" data-wow-delay="0.5s">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-6 align-self-center">
                            <div class="left-content header-text wow fadeInLeft" data-wow-duration="1s" data-wow-delay="1s">

                                <h6>Добро пожаловать</h6>

                                <h2>Мы делаем <em>всё связанное</em> с&nbsp;<span>Земельным Кадастром</span> и&nbsp;всякими
                                    планами</h2>
                                <p>
                                    Быстро и понятно оказываем услуги по планированию, узаканиванию изменений и фиксированию
                                    текущих планов и будующих построек
                                    {{-- <a rel="nofollow" href="https://templatemo.com/page/1" target="_parent">TemplateMo</a>. --}}
                                </p>

                                <center>
                                    <a href="#contact" class="btn btn-success">Заказать обратный звонок</a>
                                    <a href="#contact" class="btn btn-info">Отправить заявку</a>
                                </center>

                                {{-- <form id="search" action="#" method="GET">
                  <fieldset>
                    <input type="address" name="address" class="email" placeholder="Your website URL..." autocomplete="on" required>
                  </fieldset>
                  <fieldset>
                    <button type="submit" class="main-button">Analyze Site</button>
                  </fieldset>
                </form> --}}
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="right-image wow fadeInRight" data-wow-duration="1s" data-wow-delay="0.5s">
                                <img src="{{ asset('/kadastr/SpaceDynamic/assets/images/banner-right-image.png') }}"
                                    alt="team meeting">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="about" class="about-us section">
        @include('kadastr::block-about')
    </div>

    <div id="services" class="our-services section">
        {{-- @include('kadastr::block-services') --}}
        @include('kadastr::block-services2', [ '$uslugi' => $uslugi ] )
    </div>

    @if( 1 == 2 )
    <div id="portfolio" class="our-portfolio section">
        @include('kadastr::block-portfolio')
    </div>
    @endif

    @if( 1 == 2 )
    <div id="blog" class="our-blog section">
        @include('kadastr::block-blog')
    </div>
    @endif

    <div id="contact" class="contact-us section">
        @include('kadastr::block-contact')
    </div>

@endsection
