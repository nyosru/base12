{{--
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
--}}
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    {{-- <!-- css -->
        <link href="{{ sd }}css/bootstrap.min.css" rel="stylesheet" />
        <link href="{{ sd }}css/fancybox/jquery.fancybox.css" rel="stylesheet">
        <link href="{{ sd }}css/flexslider.css" rel="stylesheet" />
        <link href="{{ sd }}et-line-font/style.css" rel="stylesheet" />
        <link href="{{ sd }}css/style.css" rel="stylesheet" /> --}}

    <link href="{{ asset('module_buh/et-line-font/style.css') }}" rel="stylesheet" />
    <link href="{{ asset('module_buh/all.css') }}" rel="stylesheet" />


    {{-- <meta name="description" content="{{ head.descr }}"> --}}
    <meta name="author" content="php-cat.com">

    {{-- <link rel="icon" href="{{ sd }}favicon.ico"> --}}
    {{-- <title>{{ head.title }}</title> --}}
    <!-- Custom styles for this template -->
    {{-- <link href="{{ sd }}css.css" rel="stylesheet" /> --}}

    {{-- <!-- HTML5 shim, for IE6-8 support of HTML5 elements --> --}}
    <!--[if lt IE 9]>
              <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
            <![endif]-->

</head>

<body>
    <div id="toptop" style="
             z-index: 5000;
             display: none;
             padding:10px;
             width: 100%;
             position: fixed;
             background-color: #272727;
             color: white;
             font-family: arial;
             font-size: 1.5em;
             top: 0;">
        <center><b>БухУчёт<font style="color: #f3494c;">72</font>.рф</b> &nbsp; &nbsp; &nbsp; Позвоните/напишите нам
            <nobr><u>+7 (912) 077-80-23</u></nobr>
            <nobr>или <a href="/080.order/"><u style="color: #f3494c;">отправьте заявку</u></a></nobr>
        </center>
    </div>

    {{-- {#11111
    {$dibody.start}
    {{ dibody.start }}
    22222#} --}}

    <div id="wrapper" class="home-page">

        {{-- <!-- start header --> --}}
        <header>
            <div class="navbar navbar-default navbar-static-top">
                <div class="container">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse"
                            data-target=".navbar-collapse">
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <a class="navbar-brand" href="/"><img src="{{ asset('module_buh/logo.png') }}"
                                alt="logo" /></a>
                    </div>
                    <div class="navbar-collapse collapse ">


                        {{--  include t_menu1  --}}

                        {{--
                            <ul class="nav navbar-nav">
                                <li class="active"><a href="index.html">Home</a></li>
                                <li><a href="about.html">About Us</a></li>
                                <li><a href="services.html">Services</a></li>
                                <li><a href="portfolio.html">Portfolio</a></li>
                                <li><a href="pricing.html">Pricing</a></li>
                                <li><a href="contact.html">Contact</a></li>
                            </ul>
                             --}}

                    </div>
                </div>
            </div>
        </header>
        <div style="min-height: 600px;">

            {{-- if $tpl_0body|strlen > 1 }
                include file="$tpl_0body"}
                 --}}
            {{-- <br clear="all" />
                ------{{ tpl_body_in }}
                ------{{ tpl_0body }}
                ------{{ tpl_body }}
                <br clear="all" />
                <br clear="all" /> --}}
            {{--  tpl_body ?? 'tpl_body' --}}
            {{--  include tpl_body  --}}

            @section('content')
            @show

        </div>

        <footer>
            <div class="container">
                <div class="row">
                    <div class="col-sm-4 col-lg-3 col-lg-offset-1">
                        <div class="widget">
                            <h5 class="widgetheading">Контакты</h5>
                            <p>
                                Ваш Ведущий Бухгалтер
                                <br>
                                <strong>Нина&nbsp;Витальевна Мазунина</strong>
                                <br />
                                <br />
                                Тел: <a href="tel:+79120778023">8 (912) 077-80-23</a>
                                <br>
                                Тел: <a href="tel:+79673827222">8 (967) 382-72-22</a>
                                <br>
                                E-mail: <a href="mailto:bizyspex@mail.ru">bizyspex@mail.ru</a>
                            </p>
                        </div>
                    </div>
                    <div class="col-sm-4 col-lg-4">
                        <div class="widget">
                            <h5 class="widgetheading">БухУчет в Тюмени на раз два</h5>
                            <ul class="link-list">
                                {{--  for kk,vv in usl if vv.nn == 1 %}
                                    {{ kk }} - {{ pa(vv) }}#}
                                    <li><a href="/010.uslugi/{{ kk }}/">{{ vv.name }}</a></li>
                                     endfor %} --}}
                                {{-- @foreach(  ) --}}
                                {{-- <li><a href="/010.uslugi/{{ kk }}/">{{ vv.name }}</a></li> --}}
                                {{-- @endforeach --}}
                            </ul>
                        </div>
                    </div>
                    <div class="col-sm-4 col-lg-4">
                        <div class="widget">
                            <h5 class="widgetheading">&nbsp;</h5>
                            <ul class="link-list">
                                {{-- {% for kk,vv in usl if vv.nn == 2 %}
                                    {#{{ kk }} - {{ pa(vv) }}#}
                                    <li><a href="/010.uslugi/{{ kk }}/">{{ vv.name }}</a></li>
                                    {% endfor %} --}}
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div id="sub-footer">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12 text-center">
                            <p>
                                <span>&copy; Все права защищены 2015-{{ date('Y') }}
                                    Создание сайта </span><a href="http://uralweb.info" target="_blank">uralweb.info</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
    </div>

    {{-- {{ dibody.end ?? '' }} --}}
    {{-- <!-- счётчик --> --}}
    {{-- <!-- Yandex.Metrika counter --> --}}
    <script type="text/javascript">
        (function(d, w, c) {
            (w[c] = w[c] || []).push(function() {
                try {
                    w.yaCounter39171445 = new Ya.Metrika({
                        id: 39171445,
                        clickmap: true,
                        trackLinks: true,
                        accurateTrackBounce: true
                    });
                } catch (e) {}
            });
            var n = d.getElementsByTagName("script")[0],
                s = d.createElement("script"),
                f = function() {
                    n.parentNode.insertBefore(s, n);
                };
            s.type = "text/javascript";
            s.async = true;
            s.src = "https://mc.yandex.ru/metrika/watch.js";
            if (w.opera == "[object Opera]") {
                d.addEventListener("DOMContentLoaded", f, false);
            } else {
                f();
            }
        })(document, window, "yandex_metrika_callbacks");
    </script>
    <noscript>
        <div><img src="https://mc.yandex.ru/watch/39171445" style="position:absolute; left:-9999px;" alt="" /></div>
    </noscript>
    {{-- <!-- /Yandex.Metrika counter --> --}}

    {{-- <a href="#" class="scrollup"><i class="fa fa-angle-up active"></i></a> --}}
    <a href="#" class="scrollup"><i class="lnr lnr917"></i></a>

    {{-- <!-- javascript --> --}}
    {{-- {{ mix('/public/module_buh/all.js') }} --}}
    {{-- {{ asset('module_buh/all.js') }} --}}
    {{-- <script src="{{ mix('module_buh/all') }}"></script> --}}
    {{-- <script src="{{ asset('module_buh/all.js') }}"></script> --}}
    <script src="{{ mix('module_buh/js.js') }}"></script>
    {{-- <script src="{{ asset('js/jquery.js"></script>
        <script src="{{ sd }}js/jquery.easing.1.3.js"></script>
        <script src="{{ sd }}js/bootstrap.min.js"></script>
        <script src="{{ sd }}js/jquery.fancybox.pack.js"></script>
        <script src="{{ sd }}js/jquery.fancybox-media.js"></script>
        <script src="{{ sd }}js/portfolio/jquery.quicksand.js"></script>
        <script src="{{ sd }}js/portfolio/setting.js"></script>
        <script src="{{ sd }}js/jquery.flexslider.js"></script>
        <script src="{{ sd }}js/animate.js"></script>
        <script src="{{ sd }}js/custom.js"></script> --}}

</body>

</html>
