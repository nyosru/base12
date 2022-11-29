<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <meta name="description" content="super developer site">
    <meta name="author" content="Sergey php-cat.com">

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">
    <title>PHP-cat create magic</title>

    <!-- Bootstrap core CSS -->
    

    <!-- Additional CSS Files -->
    
    
    
    
    

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
                    <img v-if="1 == 2 " src="/phpcat/ya<?php echo e(rand(1, 7)); ?>.jpg" class="ya pb-5" alt="" />
                    <photos />
                </div>
                <div class="col-12 col-md-6">
                    <h2 class="alert alert-warning text-center">
                        <?php echo e(date('Y')); ?>&nbsp;год самое&nbsp;время реализовать вашу&nbsp;идею!
                    </h2>
                    <p class="text-center" >
                        Я&nbsp;Сергей&nbsp;Бакланов 
                        <br/>
                        <br/>
                        IT архитектор, тим/тех&nbsp;лид, помогаю управлять и&nbsp;вести группу(ы) программистов (тестеров, дизайнеров, верстальщиков), 
                        выстраивание командной работы, контроль качества и&nbsp;защита от&nbsp;форс мажоров,                        
                        <br />
                        <br />
                        Цель работы: выстраивание саморазвивающейся и&nbsp;обоюдно заинтересованной команды разработки/поддержки
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
                        <p>© Copyright 2003-<?php echo e(date('Y')); ?> Все права защищены


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

<script src="<?php echo e(asset('/phpcat/vue.js?' . date('U'))); ?>"></script>

<?php if(1 == 2): ?>
    

    <!-- Scripts -->
    
    

    <script src="/metrika/assets/js/owl-carousel.js"></script>
    <script src="/metrika/assets/js/animation.js"></script>
    <script src="/metrika/assets/js/imagesloaded.js"></script>
    <script src="/metrika/assets/js/templatemo-custom.js"></script>
<?php endif; ?>

</html>
<?php /**PATH /var/www/base12/data/www/site/app/Modules/Phpcat/Resources/views/app/app.blade.php ENDPATH**/ ?>