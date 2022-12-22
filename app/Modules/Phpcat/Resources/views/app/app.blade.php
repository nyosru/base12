<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta name="description" content="super developer site">
    <meta name="author" content="Sergey php-cat.com">

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">
    <title>PHP-cat create magic</title>

    <!-- Bootstrap core CSS -->
    {{-- <link href="/metrika/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet"> --}}

    <!-- Additional CSS Files -->
    {{-- <link rel="stylesheet" href="/metrika/assets/css/fontawesome.css"> --}}
    {{-- <link rel="stylesheet" href="/metrika/assets/css/templatemo-space-dynamic.css"> --}}
    {{-- <link rel="stylesheet" href="/metrika/assets/css/animated.css"> --}}
    {{-- <link rel="stylesheet" href="/metrika/assets/css/owl.css"> --}}
    {{-- <!--
TemplateMo 562 Space Dynamic
https://templatemo.com/tm-562-space-dynamic
--> --}}

    <meta property="vk:image" content="https://php-cat.com/phpcat/phpcat-preview_for_vk.jpg" />
    <meta property="og:image" content="https://php-cat.com/phpcat/phpcat-preview_for_fb.jpg" />

    <meta property="og:title" content="Сергей Бакланов php-cat Программирование в сети " />
    <meta property="og:site_name" content="PHP-CAT.com web developement" />
    <meta property="og:url" content="https://php-cat.com/" />
    <meta property="og:description" content="Программирование сайтов норм ( Laravel + VueJS 3 )" />

    <style>
        /* .services .item:HOVER h4{ text-decoration: underline; } */
        .ya {
            width: 90%;
            margin: 0 auto;
        }

        footer {
            padding-top: 3vh;
            background-color: #efefef;
        }

        .loader {
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            right: 0;
            background-color: rgb(255, 255, 255);
            text-align: center;
        }

        .loader h1 {
            padding-top: 20vh;
            font-family: Arial, Helvetica, sans-serif;
        }

        .loader h1 span {
            padding: 10px;
            background-color: yellow;
            border-radius: 10px;
        }

    </style>

</head>

<body>

    <div id="app">

        <div class="loader text-center" v-if="preloader == true">
            <h1><span>Норм программирование!!</span>
                <br /><br /><br />
                PHP-CAT
                <br />
                Сергей Бакланов
                <br />
                <br />
                <br />
                позвоните мне 89-222-6-222-89
            </h1>
        </div>

        <div class="container" style="min-height: 80vh;">

            <div class="row">
                <div class="col-12 text-center pt-3 pb-2">
                    <a href="/" style="color:black;text-decoration: none;">
                        <h1 class="p-0 mb-4">php-cat.com</h1>
                    </a>
                </div>
                <div class="col-12 text-center">
                    <app-menu class="p-o m-o xpt-5" />
                </div>
            </div>

            <div class="row" v-if="currentRouteName == 'index'">
                <div class="col-12 col-md-6">
                    <img v-if="1 == 2 " src="/phpcat/ya{{ rand(1, 7) }}.jpg" class="ya pb-5" alt="" />
                    <photos />
                </div>
                <div class="col-12 col-md-6">

<style>
                    @import url(https://fonts.googleapis.com/css?family=Roboto);

                    @import url(https://fonts.googleapis.com/css?family=Festive);
                    
                    body {
                      padding: 0;
                      margin: 0;
                      height: 50vh;
                      display: grid;
                      place-items: center;
                      overflow: hidden;
                      background-color: black;
                    }
                    
                    .conteiner {
                      display: flex;
                      justify-content: center;
                      align-items: center;
                      flex-direction: column;
                    }
                    
                    h1 {
                      font-size: 15rem;
                      font-family: "Roboto";
                      font-weight: 900;
                      background-image: url(https://c.tenor.com/7k2yASJxRuEAAAAM/stars-twinkling.gif);
                      -webkit-background-clip: text;
                      -webkit-text-fill-color: transparent;
                    
                    }
                    
                    h2 {
                      font-family: "Festive";
                      font-size: 3rem;
                      position: relative;
                      bottom: 230px;
                      background:linear-gradient(to right, #BF953F, #FCF6BA, #B38728, #FBF5B7, #AA771C);
                      -webkit-background-clip: text;
                      -webkit-text-fill-color: transparent;
                    }
                    
                    @media only screen and (max-width: 600px) {
                      h1 {
                        font-size: 11rem;
                      }
                      
                      h2 {
                        font-size: 2rem;
                        position: relative;
                        bottom: 160px;
                      }
                    }
                    
                    
                </style>                    

324234234

ghbdtn

5555

<div class="conteiner">
    <h1>2022</h1>
    <h2>HAPPY NEW YEAR</h2>
    </div>
    

    

                    <h2 class="alert alert-warning text-center">




                        {{ date('Y') }}&nbsp;год самое&nbsp;время реализовать вашу&nbsp;идею!
                    </h2>
                    <p class="text-center" >
                        Я&nbsp;Сергей&nbsp;Бакланов 
                        <br/>
                        <br/>
                        Програмист, IT архитектор
                        <br/>
                        <br/>
                        Набираюсь опыта и учусь быть норм тим/тех&nbsp;лидом, помогать вести группу(ы) IT специалистов (тестеров, программисты, дизайнеров, верстальщиков), контроль качества и&nbsp;защита от&nbsp;форс мажоров,                        
                        <br />
                        Команда 3-7 человек было бы самое то, буду признателен если поможете найти такой вид деятельности
                        <br />
                        <br />
                        Работаю удалённо, нахожусь&nbsp;в&nbsp;Тюмени
                    </p>
                    <h2 class="alert xalert-info text-center">
                        Позвоните и&nbsp;обсудим
                        <br clear="all" />
                        <small>(или напишите Телеграм/Viber/WA)</small>
                        <br clear="all" />
                        <a href="tel:+79222622289">
                            тел: <b>89-222-6-222-89</b>
                        </a>
                    </h2>
                </div>
            </div>

            <router-view name="content"></router-view>

        </div>

        <footer>
            <div class="container">
                <div class="row">
                    <div class="col-12 col-sm-6 text-center">
                        <p>© Copyright 2003-{{ date('Y') }} Все права защищены


                        </p>
                    </div>
                    <div class="col-12 col-sm-6 text-center">
                        Создание сайта: <a href="https://php-cat.com" target="_blank">PHP-cat.com</a>
                        </p>
                    </div>
                </div>
            </div>
        </footer>

    </div>

    {{-- <!-- Yandex.Metrika counter --> --}}
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

        ym(76358443, "init", {
            clickmap: true,
            trackLinks: true,
            accurateTrackBounce: true
        });
    </script>
    <noscript>
        <div><img src="https://mc.yandex.ru/watch/76358443" style="position:absolute; left:-9999px;" alt="" /></div>
    </noscript>
    {{-- <!-- /Yandex.Metrika counter --> --}}

</body>

<script>
    window.replainSettings = {
        id: 'b425c1ea-1e24-4a28-bd66-fb7a3ed2011d'
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

<script src="{{ asset('/phpcat/vue.js?' . date('U')) }}"></script>

@if (1 == 2)
    {{-- <script src="{{ asset('/metrika/metrika.js') }}"></script> --}}

    <!-- Scripts -->
    {{-- <script src="/metrika/vendor/jquery/jquery.min.js"></script> --}}
    {{-- <script src="/metrika/vendor/bootstrap/js/bootstrap.bundle.min.js"></script> --}}

    <script src="/metrika/assets/js/owl-carousel.js"></script>
    <script src="/metrika/assets/js/animation.js"></script>
    <script src="/metrika/assets/js/imagesloaded.js"></script>
    <script src="/metrika/assets/js/templatemo-custom.js"></script>
@endif

</html>
