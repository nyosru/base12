@extends('rem7::app.app')



@section('content')

    @include('rem7::block-sendmessage_top')

    {{-- <!-- Clients Section Start --> --}}
    {{-- <div id="xxclients" class="section-padding bg-white">
        <div class="container">
            <div class="section-header text-center">
                <h2 style="padding:0; margin: 0;" class="section-title wow fadeInDown" data-wow-delay="0.3s">Предварительная диагностика производится
                    непосредственно в&nbsp;период обращения.</h2>
            </div>
        </div>
    </div> --}}
    {{-- <!-- Clients Section End --> --}}



    <div class=""

    {{-- background:      repeating-linear-gradient(125deg, white, rgb(230,230,230), white 80px);  --}}
    style="background-color: rgb(240,240,240); padding-top:3rem; padding-bottom: 3rem;" >
      <div class="container">
          <div class="row align-items-center">
              <div class="col-12 col-sm-8 text-center align-self-center wow fadeInRight" data-wow-delay="0.3s">
                  <h4>Бесплатная консультация </h4>
              </div>
              <div class="col-12 col-sm-4 text-center wow fadeInLeft" data-wow-delay="0.3s">
                  <a class="page-scroll align-self-center btn btn-info btn-sm" href="#form1">Записаться</a>
              </div>
          </div>
      </div>
  </div>


<br/>
<br/>
<br/>

    @include('rem7::block-lovejob')

    {{-- <!-- Clients Section Start --> --}}
    <div id="xxclients" class="section-padding bg-white">
        <div class="container">
            <div class="section-header text-center">
                <h2 class="section-title wow fadeInDown" data-wow-delay="0.3s">Гарантия 30&nbsp;дней на&nbsp;работу
                    и&nbsp;запчасти.</h2>
            </div>
        </div>
    </div>
    {{-- <!-- Clients Section End --> --}}


    {{-- <!-- Services Section Start --> --}}
    <section id="services" class="section-padding">
        <div class="container">
            <div class="section-header text-center">
                {{-- <h2 class="section-title wow fadeInDown" data-wow-delay="0.3s">Our Services</h2> --}}
                <p class="wow fadeInDown" data-wow-delay="0.3s">Если Вам нужен недорогой ремонт аудио- или видеотехники
                    в&nbsp;Тюмени, мастер «7Ремёсел» будет рад Вам&nbsp;помочь. Позвоните и&nbsp;уточните марку возможную
                    причину поломки или
                    обстоятельства, при&nbsp;которых поломка произошла.</p>
                <br />
                <br />
            </div>
            <div class="row">

                {{-- <pre>{{ print_r($uslugi) }}</pre> --}}

                @foreach ($uslugi as $i)
                    <div class="col-md-6 col-lg-4 col-xs-12">
                        <div class="services-item wow fadeInRight" data-wow-delay="0.3s">
                            <div class="icon">
                                <i class="lni-cog"></i>
                            </div>
                            <div class="services-content">
                                <h3><a href="#">{{ $i['name'] }}</a></h3>
                                <p>{{ $i['opis'] }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach

                @if (1 == 2)
                    <!-- Services item -->
                    <div class="col-md-6 col-lg-4 col-xs-12">
                        <div class="services-item wow fadeInRight" data-wow-delay="0.3s">
                            <div class="icon">
                                <i class="lni-cog"></i>
                            </div>
                            <div class="services-content">
                                <h3><a href="#">Web Development</a></h3>
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Unde perspiciatis dicta labore
                                    nulla beatae quaerat quia incidunt laborum aspernatur...</p>
                            </div>
                        </div>
                    </div>
                    <!-- Services item -->
                    <div class="col-md-6 col-lg-4 col-xs-12">
                        <div class="services-item wow fadeInRight" data-wow-delay="0.6s">
                            <div class="icon">
                                <i class="lni-bar-chart"></i>
                            </div>
                            <div class="services-content">
                                <h3><a href="#">Graphic Design</a></h3>
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Unde perspiciatis dicta labore
                                    nulla beatae quaerat quia incidunt laborum aspernatur...</p>
                            </div>
                        </div>
                    </div>
                    <!-- Services item -->
                    <div class="col-md-6 col-lg-4 col-xs-12">
                        <div class="services-item wow fadeInRight" data-wow-delay="0.9s">
                            <div class="icon">
                                <i class="lni-briefcase"></i>
                            </div>
                            <div class="services-content">
                                <h3><a href="#">Business Branding</a></h3>
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Unde perspiciatis dicta labore
                                    nulla beatae quaerat quia incidunt laborum aspernatur...</p>
                            </div>
                        </div>
                    </div>
                    <!-- Services item -->
                    <div class="col-md-6 col-lg-4 col-xs-12">
                        <div class="services-item wow fadeInRight" data-wow-delay="1.2s">
                            <div class="icon">
                                <i class="lni-pencil-alt"></i>
                            </div>
                            <div class="services-content">
                                <h3><a href="#">Content Writing</a></h3>
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Unde perspiciatis dicta labore
                                    nulla beatae quaerat quia incidunt laborum aspernatur...</p>
                            </div>
                        </div>
                    </div>
                    <!-- Services item -->
                    <div class="col-md-6 col-lg-4 col-xs-12">
                        <div class="services-item wow fadeInRight" data-wow-delay="1.5s">
                            <div class="icon">
                                <i class="lni-mobile"></i>
                            </div>
                            <div class="services-content">
                                <h3><a href="#">App Development</a></h3>
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Unde perspiciatis dicta labore
                                    nulla beatae quaerat quia incidunt laborum aspernatur...</p>
                            </div>
                        </div>
                    </div>
                    <!-- Services item -->
                    <div class="col-md-6 col-lg-4 col-xs-12">
                        <div class="services-item wow fadeInRight" data-wow-delay="1.8s">
                            <div class="icon">
                                <i class="lni-layers"></i>
                            </div>
                            <div class="services-content">
                                <h3><a href="#">Digital Marketing</a></h3>
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Unde perspiciatis dicta labore
                                    nulla beatae quaerat quia incidunt laborum aspernatur...</p>
                            </div>
                        </div>
                    </div>
                @endif

            </div>
        </div>
    </section>
    {{-- <!-- Services Section End --> --}}




    @include('rem7::block-poryadokuslug')



    @if (1 == 2)
        {{-- <!-- Team Section Start --> --}}
        <section id="team" class="section-padding text-center">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="section-header text-center">
                            <h2 class="section-title wow fadeInDown" data-wow-delay="0.3s">Our Team</h2>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6 col-md-6 col-lg-4">
                        <!-- Team Item Starts -->
                        <div class="team-item text-center">
                            <div class="team-img">
                                <img class="img-fluid" src="{{ asset('/module_rem7/img/team/team-01.jpg') }}" alt="">
                                <div class="team-overlay">
                                    <div class="overlay-social-icon text-center">
                                        <ul class="social-icons">
                                            <li><a href="#"><i class="lni-facebook-filled" aria-hidden="true"></i></a></li>
                                            <li><a href="#"><i class="lni-twitter-filled" aria-hidden="true"></i></a></li>
                                            <li><a href="#"><i class="lni-instagram-filled" aria-hidden="true"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="info-text">
                                <h3><a href="#">Rafael Basilla</a></h3>
                                <p>Front-end Developer, Dropbox</p>
                            </div>
                        </div>
                        <!-- Team Item Ends -->
                    </div>
                    <div class="col-sm-6 col-md-6 col-lg-4">
                        <!-- Team Item Starts -->
                        <div class="team-item text-center">
                            <div class="team-img">
                                <img class="img-fluid" src="{{ asset('/module_rem7/img/team/team-02.jpg') }}" alt="">
                                <div class="team-overlay">
                                    <div class="overlay-social-icon text-center">
                                        <ul class="social-icons">
                                            <li><a href="#"><i class="lni-facebook-filled" aria-hidden="true"></i></a></li>
                                            <li><a href="#"><i class="lni-twitter-filled" aria-hidden="true"></i></a></li>
                                            <li><a href="#"><i class="lni-instagram-filled" aria-hidden="true"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="info-text">
                                <h3><a href="#">Renee Fleck</a></h3>
                                <p>Product Designer, Tesla</p>
                            </div>
                        </div>
                        <!-- Team Item Ends -->
                    </div>

                    <div class="col-sm-6 col-md-6 col-lg-4">
                        <!-- Team Item Starts -->
                        <div class="team-item text-center">
                            <div class="team-img">
                                <img class="img-fluid" src="{{ asset('/module_rem7/img/team/team-03.jpg') }}" alt="">
                                <div class="team-overlay">
                                    <div class="overlay-social-icon text-center">
                                        <ul class="social-icons">
                                            <li><a href="#"><i class="lni-facebook-filled" aria-hidden="true"></i></a></li>
                                            <li><a href="#"><i class="lni-twitter-filled" aria-hidden="true"></i></a></li>
                                            <li><a href="#"><i class="lni-instagram-filled" aria-hidden="true"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="info-text">
                                <h3><a href="#">Paul Kowalsy</a></h3>
                                <p>Lead Designer, TNW</p>
                            </div>
                        </div>
                        <!-- Team Item Ends -->
                    </div>

                </div>
            </div>
        </section>
        {{-- <!-- Team Section End --> --}}
    @endif


    @if (1 == 2)
        {{-- <!-- Clients Section Start --> --}}
        <div id="clients" class="section-padding">
            <div class="container">
                <div class="section-header text-center">
                    <h2 class="section-title wow fadeInDown" data-wow-delay="0.3s">As Seen On</h2>
                </div>
                <div class="row text-align-">
                    <div class="col-lg-3 col-md-3 col-xs-12 wow fadeInUp" data-wow-delay="0.3s">
                        <div class="client-item-wrapper">
                            <img class="img-fluid" src="{{ asset('/module_rem7/img/clients/img1.png') }}" alt="">
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3 col-xs-12 wow fadeInUp" data-wow-delay="0.6s">
                        <div class="client-item-wrapper">
                            <img class="img-fluid" src="{{ asset('/module_rem7/img/clients/img2.png') }}" alt="">
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3 col-xs-12 wow fadeInUp" data-wow-delay="0.9s">
                        <div class="client-item-wrapper">
                            <img class="img-fluid" src="{{ asset('/module_rem7/img/clients/img3.png') }}" alt="">
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3 col-xs-12 wow fadeInUp" data-wow-delay="1.2s">
                        <div class="client-item-wrapper">
                            <img class="img-fluid" src="{{ asset('/module_rem7/img/clients/img4.png') }}" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- <!-- Clients Section End --> --}}
    @endif

    @if (1 == 2)
        @include('rem7::block-otzuvu')
    @endif

    @if (1 == 2)
        {{-- <!-- Pricing section Start --> --}}
        <section id="pricing" class="section-padding">
            <div class="container">
                <div class="row">
                    <div class="col-lg-4 col-md-6 col-xs-12">
                        <div class="table wow fadeInLeft" data-wow-delay="1.2s">
                            <div class="title">
                                <h3>Basic</h3>
                            </div>
                            <div class="pricing-header">
                                <p class="price-value">$12.90<span>/ Month</span></p>
                            </div>
                            <ul class="description">
                                <li>Up to 5 projects </li>
                                <li>Up to 10 collabrators</li>
                                <li>2gb of storage</li>
                            </ul>
                            <button class="btn btn-common">Get It</button>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-xs-12 active">
                        <div class="table wow fadeInUp" id="active-tb" data-wow-delay="1.2s">
                            <div class="title">
                                <h3>Profesional</h3>
                            </div>
                            <div class="pricing-header">
                                <p class="price-value">$49.90<span>/ Month</span></p>
                            </div>
                            <ul class="description">
                                <li>Up to 10 projects</li>
                                <li>Up to 20 collabrators</li>
                                <li>10gb of storage</li>
                                <li>Real-time collabration</li>
                            </ul>
                            <button class="btn btn-common">Get It</button>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-xs-12">
                        <div class="table wow fadeInRight" data-wow-delay="1.2s">
                            <div class="title">
                                <h3>Expert</h3>
                            </div>
                            <div class="pricing-header">
                                <p class="price-value">$89.90<span>/ Month</span></p>
                            </div>
                            <ul class="description">
                                <li>unlimited projects </li>
                                <li>Unlimited collabrators</li>
                                <li>Unlimited of storage</li>
                                <li>Real-time collabration</li>
                                <li>24x7 Support</li>
                            </ul>
                            <button class="btn btn-common">Get It</button>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        {{-- <!-- Pricing Table Section End --> --}}
    @endif

    @if (1 == 2)
        @include('rem7::block-slider')
    @endif

    @include('rem7::block-sendmessage')

    @include('rem7::block-contact')


    @if (1 == 2)
        {{-- <!-- Contact Section Start --> --}}
        <section id="contact" class="section-padding">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="section-header text-center">
                            <h2 class="section-title wow fadeInDown" data-wow-delay="0.3s">Contact</h2>
                        </div>
                    </div>
                </div>
                <div class="row contact-form-area wow fadeInUp" data-wow-delay="0.4s">
                    <div class="col-md-6 col-lg-6 col-sm-12">
                        <div class="contact-block">
                            <h2>Контакты</h2>
                            @if (1 == 2)
                                <form id="contactForm">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <input type="text" class="form-control" id="name" name="name"
                                                    placeholder="Name" required data-error="Please enter your name">
                                                <div class="help-block with-errors"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <input type="text" placeholder="Email" id="email" class="form-control"
                                                    name="email" required data-error="Please enter your email">
                                                <div class="help-block with-errors"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <input type="text" placeholder="Subject" id="msg_subject"
                                                    class="form-control" required data-error="Please enter your subject">
                                                <div class="help-block with-errors"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <textarea class="form-control" id="message" placeholder="Your Message"
                                                    rows="5" data-error="Write your message" required></textarea>
                                                <div class="help-block with-errors"></div>
                                            </div>
                                            <div class="submit-button">
                                                <button class="btn btn-common" id="form-submit" type="submit">Send
                                                    Message</button>
                                                <div id="msgSubmit" class="h3 text-center hidden"></div>
                                                <div class="clearfix"></div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-6 col-sm-12">
                        <div class="contact-right-area wow fadeIn">
                            <h2>Приходите</h2>
                            <div class="contact-right">
                                <div class="single-contact">
                                    <div class="contact-icon">
                                        <i class="lni-map-marker"></i>
                                    </div>
                                    <p>г.Тюмень ул. Александра Логунова д. 12 </p>
                                </div>
                                <div class="single-contact">
                                    <div class="contact-icon">
                                        <i class="lni-envelope"></i>
                                    </div>
                                    <p><a href="mailto:remont@php-cat.com">remont@php-cat.com</a></p>
                                    {{-- <p><a href="#">tomsaulnier@gmail.com</a></p> --}}
                                </div>
                                <div class="single-contact">
                                    <div class="contact-icon">
                                        <i class="lni-phone-handset"></i>
                                    </div>
                                    <p><a href="tel:+79963217649">8-996-321-76-49</a></p>
                                    {{-- <p><a href="#">+99 123 5967</a></p> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        {{-- <!-- Contact Section End --> --}}
    @endif

@endsection

@section('style')
    @parent
    <style>
        .img-block {
            background-size: cover;
            background-position: center center;
            min-height: 200px;
        }

        .img-block-big {
            background-size: cover;
            background-position: center center;
            min-height: 500px;
        }

        @media (min-width: 750px) {

            .img-block-left {
                border-top-left-radius: 15%;
                border-bottom-left-radius: 15%;
                overflow: hidden;
            }

            .img-block-right {
                border-top-right-radius: 15%;
                border-bottom-right-radius: 15%;
                overflow: hidden;
            }

        }

    </style>
@endsection




