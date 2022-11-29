<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">

    <title>Бюро Метрологии - точнее точного всегда</title>

    <!-- Bootstrap core CSS -->
    <link href="/metrika/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Additional CSS Files -->
    <link rel="stylesheet" href="/metrika/assets/css/fontawesome.css">
    <link rel="stylesheet" href="/metrika/assets/css/templatemo-space-dynamic.css">
    <link rel="stylesheet" href="/metrika/assets/css/animated.css">
    <link rel="stylesheet" href="/metrika/assets/css/owl.css">
    {{-- <!--
TemplateMo 562 Space Dynamic
https://templatemo.com/tm-562-space-dynamic
--> --}}

    <meta property="vk:image" content="https://{{ $HTTP_HOST }}/metrika/img/preview_for_vk.jpg" />
    <meta property="og:image" content="https://{{ $HTTP_HOST }}/metrika/img/preview_for_fb.jpg" />

    <style>
        .services .item:HOVER h4{ text-decoration: underline; }
    </style>
</head>

<body>
    <div id="app">

        {{-- host {{ $HTTP_HOST }} --}}

        {{-- <!-- ***** Preloader Start ***** --> --}}
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
        {{-- <!-- ***** Preloader End ***** --> --}}

        {{-- <!-- ***** Header Area Start ***** --> --}}
        <header class="header-area header-sticky wow slideInDown" data-wow-duration="0.75s" data-wow-delay="0s">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <nav class="main-nav">
                            <!-- ***** Logo Start ***** -->
                            <a href="index.html" class="logo">
                                <h4>Бюро <span>Метрологии</span></h4>
                            </a>
                            {{-- <!-- ***** Logo End ***** --> --}}
                            {{-- <!-- ***** Menu Start ***** --> --}}
                            <ul class="nav">
                                <li class="scroll-to-section"><a href="#top" class="active">Метрология</a></li>
                                {{-- <li class="scroll-to-section"><a href="#about">О нашем бюро</a></li> --}}
                                <li class="scroll-to-section"><a href="#about">Услуги</a></li>
                                {{-- <li class="scroll-to-section"><a href="#services">Услуги</a></li> --}}

                                <li class="scroll-to-section"><a href="#contact">Отправьте заявку</a></li>
                                <li class="scroll-to-section"><a href="#contact">Контакты</a></li>

                                {{-- <li class="xscroll-to-section"><a href="mailto:b-metrology@inbox.ru">b-metrology@inbox.ru</a></li> --}}


                                {{-- <li class="scroll-to-section"><a href="#portfolio">Портфолио</a></li> --}}
                                {{-- <li class="scroll-to-section"><a href="#blog">Новости</a></li> --}}
                                {{-- <li class="scroll-to-section"><a href="#contact">Напишите нам</a></li> --}}

                                <li class="scroll-to-section">
                                    <div class="main-red-button"><a href="tel:+79630692692">8-963-0-692-692</a></div>
                                    {{-- <div class="main-red-button"><a href="#contact">8-963-069-269-2</a></div> --}}
                                </li>

                            </ul>
                            <a class='menu-trigger'>
                                <span>Меню</span>
                            </a>
                            <!-- ***** Menu End ***** -->
                        </nav>
                    </div>
                </div>
            </div>
        </header>
        <!-- ***** Header Area End ***** -->

        <div class="main-banner wow fadeIn" id="top" data-wow-duration="1s" data-wow-delay="0.5s">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="row">
                            <div class="col-lg-6 align-self-center">
                                <div class="left-content header-text wow fadeInLeft" data-wow-duration="1s"
                                    data-wow-delay="1s">
                                    <h6>Добро пожаловать, метрология здесь</h6>

                                    <h2>Полный <em>спектр</em> <span>метрологического</span> консалтинга</h2>
                                    <p>
                                    Если Ваш вопрос связан с&nbsp;метрологией, выбором метрологического оборудования,
                                    подготовкой документации и&nbsp;подбором специалистов –
                                    Вы&nbsp;попали в&nbsp;нужное место! Мы&nbsp;обязательно Вам&nbsp;поможем!
                                    </p>

                                    {{-- <p>Space Dynamic is a professional looking HTML template using a Bootstrap 5 (beta
                                        2). This CSS template is free for you provided by <a rel="nofollow"
                                            href="https://templatemo.com/page/1" target="_parent">TemplateMo</a>.</p> --}}

                                    <br />
                                    <br />

                                    <backword-mini title-from="верхняя мини форма" />
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="right-image wow fadeInRight" data-wow-duration="1s" data-wow-delay="0.5s">
                                    <img src="/metrika/assets/images/banner-right-image.png" alt="team meeting">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>






        <div id="about" class="about-us section">
            <div class="container">
                <div class="row">
                    <div class="col-lg-4">
                        <div class="left-image wow fadeIn" data-wow-duration="1s" data-wow-delay="0.2s">
                            <img src="/metrika/assets/images/about-left-image.png" alt="person graphic">
                        </div>
                    </div>
                    <div class="col-lg-8 align-self-center">
                        <div class="services">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="item wow fadeIn" data-wow-duration="1s" data-wow-delay="0.5s">
                                        <a href="#us_doc">
                                            <div class="icon">
                                                <img src="/metrika/assets/images/service-icon-01.png" alt="reporting">
                                            </div>
                                            <div class="right-text">
                                                <h4>Документация</h4>
                                                {{-- <h2>Полный <em>спектр</em> <span>метрологического</span> консалтинга</h2> --}}
                                                {{-- <p>Lorem ipsum dolor sit amet, ctetur aoi adipiscing eliter</p> --}}
                                                <p>Подготовка, продажа, адаптация документов СМК</p>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <a href="#us_obor">
                                        <div class="item wow fadeIn" data-wow-duration="1s" data-wow-delay="0.7s">
                                            <div class="icon">
                                                <img src="/metrika/assets/images/service-icon-02.png" alt="">
                                            </div>
                                            <div class="right-text">
                                                <h4>Оборудование</h4>
                                                {{-- <p>Lorem ipsum dolor sit amet, ctetur aoi adipiscing eliter</p> --}}
                                                <p>Подбор, проверка, обучение</p>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-lg-6">
                                    <a href="#us_otd">
                                        <div class="item wow fadeIn" data-wow-duration="1s" data-wow-delay="0.9s">
                                            <div class="icon">
                                                <img src="/metrika/assets/images/service-icon-03.png" alt="">
                                            </div>
                                            <div class="right-text">
                                                <h4>Ваш отдел</h4>
                                                {{-- <p>Lorem ipsum dolor sit amet, ctetur aoi adipiscing eliter</p> --}}
                                                <p>Подбор персонала, оборудования, документация</p>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-lg-6">
                                    <div class="item wow fadeIn" data-wow-duration="1s" data-wow-delay="1.1s">
                                        <a href="#us_spec">
                                            <div class="icon">
                                                <img src="/metrika/assets/images/service-icon-04.png" alt="">
                                            </div>
                                            <div class="right-text">
                                                <h4>Специалисты</h4>
                                                {{-- <p>Lorem ipsum dolor sit amet, ctetur aoi adipiscing eliter</p> --}}
                                                <p>Подбор, план стажировок, обучение</p>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-lg-6">

                                </div>
                                <div class="col-lg-6">
                                    <div class="item wow fadeIn" data-wow-duration="1s" data-wow-delay="0.9s">
                                        <a href="#us_akk">
                                            <div class="icon">
                                                <img src="/metrika/assets/images/service-icon-03.png" alt="">
                                            </div>
                                            <div class="right-text">
                                                <h4>Аккредитация</h4>
                                                {{-- <p>Lorem ipsum dolor sit amet, ctetur aoi adipiscing eliter</p> --}}
                                                <p>Подготовка, проверка готовности лаборатории, сопровождение, ПК,
                                                    расширение</p>
                                            </div>
                                        </a>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>



        <span id="services">

            <div id="us_doc"></div>
            <div class="xour-services section">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-6 wow fadeInLeft" data-wow-duration="1s" data-wow-delay="0.2s">
                            <h2><em>Документация</em></h2>

                            <p> Подготовка документов СМК</p>
                            <p> Продажа готовой документации СМК</p>
                            <p> Адаптация ваших СМК</p>
                            {{-- <p>Продажа подготовленной документации СМК</p> --}}
                            {{-- <p>Как итог – заказчик получает на руки готовую документацию, где конкретно прослеживаются
                                аккредитационные критерии, предназначенные для переделывания под свою специфику работ.
                            </p>
                            <p>Процесс правки документации в лабораторных условиях СМК
                            </p>
                            <p>Документы дополняются сведениями, которые должны соответствовать установленным требования
                                аккредитации. Фиксируются особенности процесса. Процедура редакции проводится один раз.
                                Если
                                в будущем понадобиться снова внести правки – это делается за отдельную плату.</p> --}}
                            <div class="btn-goto text-center mt-3">
                                <a href="#contact" class="btn btn-info xbtn-danger">Отправить заявку</a>
                            </div>

                        </div>
                        <div class="col-lg-6  wow fadeInRight" data-wow-duration="1s" data-wow-delay="0.2s">
                            <img src="/metrika/img/documentation.jpg" />
                        </div>
                    </div>
                </div>
            </div>

            <div id="us_spec"></div>

            <div class="xour-services section">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320" style="width: 100%; xheight: 50px;">
                    <path fill="#ff3d28" fill-opacity="1"
                        d="M0,256L80,250.7C160,245,320,235,480,202.7C640,171,800,117,960,101.3C1120,85,1280,107,1360,117.3L1440,128L1440,320L1360,320C1280,320,1120,320,960,320C800,320,640,320,480,320C320,320,160,320,80,320L0,320Z">
                    </path>
                </svg>
                <div
                    style=" background: #ff3d28; /* Для старых браузров */ xbackground: linear-gradient(to top, #ff3d28, #ff2f60);">
                    <div class="container">
                        <div class="row">




                            <div class="col-lg-6 wow fadeInLeft" data-wow-duration="1s" data-wow-delay="0.2s">
                                <img src="/metrika/img/specs.png" />
                            </div>
                            <div class="col-lg-6 wow fadeInRight color-white" data-wow-duration="1s"
                                data-wow-delay="0.2s">
                                <h2 style="color:white;">Специалисты</h2>
                                <p style="color:white;">Помощь в подборе квалифицированного персонала отвечающего
                                    критериям аккредитации</p>
                                <p style="color:white;">Помощь в оформлении Плана стажерства.</p>
                                <div class="btn-goto text-center mt-3">
                                    <a href="#contact" class="btn xbtn-info btn-light xbtn-danger">Отправить заявку</a>
                                </div>

                            </div>




                        </div>
                    </div>
                </div>
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320" style="width: 100%; xheight: 50px;">
                    <path fill="#ff3d28" fill-opacity="1"
                        d="M0,256L80,250.7C160,245,320,235,480,202.7C640,171,800,117,960,101.3C1120,85,1280,107,1360,117.3L1440,128L1440,0L1360,0C1280,0,1120,0,960,0C800,0,640,0,480,0C320,0,160,0,80,0L0,0Z">
                    </path>
                </svg>
            </div>

            <div id="us_otd"></div>

            <div class="xour-services section">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-6 wow fadeInLeft" data-wow-duration="1s" data-wow-delay="0.2s">
                            <h2><em>Организация Вашего&nbsp;отдела метрологии</em></h2>
                            <div class="btn-goto text-center mt-3">
                                <a href="#contact" class="btn btn-info xbtn-danger">Отправить заявку</a>
                            </div>
                        </div>
                        <div class="col-lg-6 wow fadeInRight" data-wow-duration="1s" data-wow-delay="0.2s">
                            <img src="/metrika/img/brigada.jpg" />
                        </div>
                    </div>
                </div>
            </div>




            <div id="us_obor"></div>

            <div class="xour-services section">
                <div class="container">
                    <div class="row">



                        <div class="col-lg-6 wow fadeInLeft" data-wow-duration="1s" data-wow-delay="0.2s">
                            <img src="/metrika/img/oborud.gif" />
                        </div>
                        <div class="col-lg-6 wow fadeInRight" data-wow-duration="1s" data-wow-delay="0.2s">
                            <h2><span>Оборудование</span></h2>
                            <p>Помощь в выборе измерительного оборудования</p>
                            <p>Подбор эталонного оборудования, вспомогательного и испытательного оборудования.</p>
                            <div class="btn-goto text-center mt-3">
                                <a href="#contact" class="btn xbtn-info btn-danger">Отправить заявку</a>
                            </div>
                        </div>




                    </div>
                </div>
            </div>
            <div id="us_akk"></div>
            <div class="xour-services section">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-6 wow fadeInLeft" data-wow-duration="1s" data-wow-delay="0.2s">
                            <h2><em>Аккредитация</em></h2>
                            {{-- <p>Помощь в&nbsp;формировании области аккредитации, подготовка форм для&nbsp;аккредитации
                            </p>
                            <p>Консалтинг: помощь по подготовке документов к&nbsp;аккредитации, подтверждению
                                компетентности
                                и&nbsp;расширению области аккредитации метрологических лабораторий в&nbsp;области
                                обеспечения
                                единства измерений и&nbsp;сопровождение данных процедур</p> --}}

<p>Помощь в формировании области аккредитации, Подготовка к аккредитации, Проверка готовности лаборатории, Сопровождение аккредитации, Подтверждение компетентности, Расширение области аккредитации
</p>
                            <div class="btn-goto text-center mt-3">
                                <a href="#contact" class="btn btn-info xbtn-danger">Отправить заявку</a>
                            </div>
                        </div>
                        <div class="col-lg-6 wow fadeInRight" data-wow-duration="1s" data-wow-delay="0.2s">
                            <img src="/metrika/img/akred.jpg" />
                        </div>
                    </div>
                </div>
            </div>
        </span>

        <div class="mb-5"></div>




        {{-- <div id="xservices" class="xour-services section">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6">
                    </div>
                    <div class="col-lg-6">
                        <pre>
1.
2.
3.
4. Метрологический аутсорсинг направлен:
5.
6.
                    </pre>
                    </div>
                </div>
            </div>
        </div> --}}

        @if (1 == 2)
            <div id="services" class="our-services section">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-6 align-self-center  wow fadeInLeft" data-wow-duration="1s"
                            data-wow-delay="0.2s">
                            <div class="left-image">
                                <img src="/metrika/assets/images/services-left-image.png" alt="">
                            </div>
                        </div>
                        <div class="col-lg-6 wow fadeInRight" data-wow-duration="1s" data-wow-delay="0.2s">
                            <div class="section-heading">
                                <h2>Grow your website with our <em>SEO</em> service &amp; <span>Project</span> Ideas
                                </h2>
                                <p>Space Dynamic HTML5 template is free to use for your website projects. However, you
                                    are
                                    not permitted to redistribute the template ZIP file on any CSS template collection
                                    websites. Please contact us for more information. Thank you for your kind
                                    cooperation.
                                </p>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="first-bar progress-skill-bar">
                                        <h4>Website Analysis</h4>
                                        <span>84%</span>
                                        <div class="filled-bar"></div>
                                        <div class="full-bar"></div>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="second-bar progress-skill-bar">
                                        <h4>SEO Reports</h4>
                                        <span>88%</span>
                                        <div class="filled-bar"></div>
                                        <div class="full-bar"></div>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="third-bar progress-skill-bar">
                                        <h4>Page Optimizations</h4>
                                        <span>94%</span>
                                        <div class="filled-bar"></div>
                                        <div class="full-bar"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        @if (1 == 2)
            <div id="portfolio" class="our-portfolio section">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-6 offset-lg-3">
                            <div class="section-heading  wow bounceIn" data-wow-duration="1s" data-wow-delay="0.2s">
                                <h2>See What Our Agency <em>Offers</em> &amp; What We <span>Provide</span></h2>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-3 col-sm-6">
                            <a href="#">
                                <div class="item wow bounceInUp" data-wow-duration="1s" data-wow-delay="0.3s">
                                    <div class="hidden-content">
                                        <h4>SEO Analysis</h4>
                                        <p>Lorem ipsum dolor sit ameti ctetur aoi adipiscing eto.</p>
                                    </div>
                                    <div class="showed-content">
                                        <img src="/metrika/assets/images/portfolio-image.png" alt="">
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-lg-3 col-sm-6">
                            <a href="#">
                                <div class="item wow bounceInUp" data-wow-duration="1s" data-wow-delay="0.4s">
                                    <div class="hidden-content">
                                        <h4>Website Reporting</h4>
                                        <p>Lorem ipsum dolor sit ameti ctetur aoi adipiscing eto.</p>
                                    </div>
                                    <div class="showed-content">
                                        <img src="/metrika/assets/images/portfolio-image.png" alt="">
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-lg-3 col-sm-6">
                            <a href="#">
                                <div class="item wow bounceInUp" data-wow-duration="1s" data-wow-delay="0.5s">
                                    <div class="hidden-content">
                                        <h4>Performance Tests</h4>
                                        <p>Lorem ipsum dolor sit ameti ctetur aoi adipiscing eto.</p>
                                    </div>
                                    <div class="showed-content">
                                        <img src="/metrika/assets/images/portfolio-image.png" alt="">
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-lg-3 col-sm-6">
                            <a href="#">
                                <div class="item wow bounceInUp" data-wow-duration="1s" data-wow-delay="0.6s">
                                    <div class="hidden-content">
                                        <h4>Data Analysis</h4>
                                        <p>Lorem ipsum dolor sit ameti ctetur aoi adipiscing eto.</p>
                                    </div>
                                    <div class="showed-content">
                                        <img src="/metrika/assets/images/portfolio-image.png" alt="">
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        @if (1 == 2)
            <div id="blog" class="our-blog section">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-6 wow fadeInDown" data-wow-duration="1s" data-wow-delay="0.25s">
                            <div class="section-heading">
                                <h2>Check Out What Is <em>Trending</em> In Our Latest <span>News</span></h2>
                            </div>
                        </div>
                        <div class="col-lg-6 wow fadeInDown" data-wow-duration="1s" data-wow-delay="0.25s">
                            <div class="top-dec">
                                <img src="/metrika/assets/images/blog-dec.png" alt="">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 wow fadeInUp" data-wow-duration="1s" data-wow-delay="0.25s">
                            <div class="left-image">
                                <a href="#"><img src="/metrika/assets/images/big-blog-thumb.jpg"
                                        alt="Workspace Desktop"></a>
                                <div class="info">
                                    <div class="inner-content">
                                        <ul>
                                            <li><i class="fa fa-calendar"></i> 24 Mar 2021</li>
                                            <li><i class="fa fa-users"></i> TemplateMo</li>
                                            <li><i class="fa fa-folder"></i> Branding</li>
                                        </ul>
                                        <a href="#">
                                            <h4>SEO Agency &amp; Digital Marketing</h4>
                                        </a>
                                        <p>Lorem ipsum dolor sit amet, consectetur and sed doer ket eismod tempor
                                            incididunt
                                            ut labore et dolore magna...</p>
                                        <div class="main-blue-button">
                                            <a href="#">Discover More</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 wow fadeInUp" data-wow-duration="1s" data-wow-delay="0.25s">
                            <div class="right-list">
                                <ul>
                                    <li>
                                        <div class="left-content align-self-center">
                                            <span><i class="fa fa-calendar"></i> 18 Mar 2021</span>
                                            <a href="#">
                                                <h4>New Websites &amp; Backlinks</h4>
                                            </a>
                                            <p>Lorem ipsum dolor sit amsecteturii and sed doer ket eismod...</p>
                                        </div>
                                        <div class="right-image">
                                            <a href="#"><img src="/metrika/assets/images/blog-thumb-01.jpg" alt=""></a>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="left-content align-self-center">
                                            <span><i class="fa fa-calendar"></i> 14 Mar 2021</span>
                                            <a href="#">
                                                <h4>SEO Analysis &amp; Content Ideas</h4>
                                            </a>
                                            <p>Lorem ipsum dolor sit amsecteturii and sed doer ket eismod...</p>
                                        </div>
                                        <div class="right-image">
                                            <a href="#"><img src="/metrika/assets/images/blog-thumb-01.jpg" alt=""></a>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="left-content align-self-center">
                                            <span><i class="fa fa-calendar"></i> 06 Mar 2021</span>
                                            <a href="#">
                                                <h4>SEO Tips &amp; Digital Marketing</h4>
                                            </a>
                                            <p>Lorem ipsum dolor sit amsecteturii and sed doer ket eismod...</p>
                                        </div>
                                        <div class="right-image">
                                            <a href="#"><img src="/metrika/assets/images/blog-thumb-01.jpg" alt=""></a>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <div id="contact" class="contact-us section">
            <backword title-from="нижняя форма на сайте" />
        </div>

        @if (1 == 2)
            <div id="contact" class="contact-us section">

                <div class="container">
                    <div class="row">
                        <div class="col-lg-6 align-self-center wow fadeInLeft" data-wow-duration="0.5s"
                            data-wow-delay="0.25s">
                            <div class="section-heading">
                                <h2>Feel Free To Send Us a Message About Your Website Needs</h2>
                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed doer ket eismod tempor
                                    incididunt ut labore et dolores</p>
                                <div class="phone-info">
                                    <h4>For any enquiry, Call Us: <span><i class="fa fa-phone"></i> <a
                                                href="#">010-020-0340</a></span></h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 wow fadeInRight" data-wow-duration="0.5s" data-wow-delay="0.25s">
                            <form id="contact" action="" method="post">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <fieldset>
                                            <input type="name" name="name" id="name" placeholder="Name"
                                                autocomplete="on" required>
                                        </fieldset>
                                    </div>
                                    <div class="col-lg-6">
                                        <fieldset>
                                            <input type="surname" name="surname" id="surname" placeholder="Surname"
                                                autocomplete="on" required>
                                        </fieldset>
                                    </div>
                                    <div class="col-lg-12">
                                        <fieldset>
                                            <input type="text" name="email" id="email" pattern="[^ @]*@[^ @]*"
                                                placeholder="Your Email" required="">
                                        </fieldset>
                                    </div>
                                    <div class="col-lg-12">
                                        <fieldset>
                                            <textarea name="message" type="text" class="form-control" id="message"
                                                placeholder="Message" required=""></textarea>
                                        </fieldset>
                                    </div>
                                    <div class="col-lg-12">
                                        <fieldset>
                                            <button type="submit" id="form-submit" class="main-button ">Send
                                                Message</button>
                                        </fieldset>
                                    </div>
                                </div>
                                <div class="contact-dec">
                                    <img src="/metrika/assets/images/contact-decoration.png" alt="">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        @endif

        <footer>
            <div class="container">
                <div class="row">
                    <div class="col-12 wow fadeIn" data-wow-duration="1s" data-wow-delay="0.25s">
                        <p>© Copyright 2015-{{ date('Y') }} Все права защищены
                            <br>
                            Создание сайта: <a href="https://php-cat.com" target="_blank">PHP-cat.com</a>
                        </p>
                    </div>
                </div>
            </div>
        </footer>
    </div>

    <script>
        window.replainSettings = {
            id: '6e09bed6-daaf-4d3a-9794-771c24df7fc9'
        };
        (function(u) {
            var s = document.createElement('script');
            s.type = 'text/javascript';
            s.async = true;
            s.src = u;
            var x = document.getElementsByTagName('script')[0];
            x.parentNode.insertBefore(s, x);
        })('https://widget.replain.cc/dist/client.js');
    </script>

    <!-- Yandex.Metrika counter -->
    <script type="text/javascript">
        (function(m, e, t, r, i, k, a) {
            m[i] = m[i] || function() {
                (m[i].a = m[i].a || []).push(arguments)
            };
            m[i].l = 1 * new Date();
            k = e.createElement(t), a = e.getElementsByTagName(t)[0], k.async = 1, k.src = r, a.parentNode.insertBefore(
                k, a)
        })
        (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");

        ym(85951046, "init", {
            clickmap: true,
            trackLinks: true,
            accurateTrackBounce: true
        });
    </script>
    <noscript>
        <div><img src="https://mc.yandex.ru/watch/85951046" style="position:absolute; left:-9999px;" alt="" /></div>
    </noscript>
    <!-- /Yandex.Metrika counter -->

</body>

<script src="{{ asset('/metrika/vue.js?' . date('U')) }}"></script>
{{-- <script src="{{ asset('/metrika/metrika.js') }}"></script> --}}

<!-- Scripts -->
{{-- <script src="/metrika/vendor/jquery/jquery.min.js"></script> --}}
{{-- <script src="/metrika/vendor/bootstrap/js/bootstrap.bundle.min.js"></script> --}}

<script src="/metrika/assets/js/owl-carousel.js"></script>
<script src="/metrika/assets/js/animation.js"></script>
<script src="/metrika/assets/js/imagesloaded.js"></script>
<script src="/metrika/assets/js/templatemo-custom.js"></script>

</html>
