<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    {{-- <meta name="description" content="{if isset($head.descr)}{$head.descr}{/if}" /> --}}
    {{-- <meta name="author" content="nyos.ru" /> --}}
    <link rel="apple-touch-icon" sizes="180x180" href="/narod/img/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/narod/img/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/narod/img/favicon-16x16.png">
    <link rel="manifest" href="/narod/img/site.webmanifest">
    {{-- <link rel="mask-icon" href="/narod/img/safari-pinned-tab.svg" color="#5bbad5"> --}}
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="theme-color" content="#ffffff">
    <title>Народная Экономика</title>

    {{-- <script src="https://yastatic.net/jquery/3.3.1/jquery.min.js"></script> --}}
    {{-- <link href="{{ sd }}bootstrap-3.3.7/css/bootstrap.min.css" rel="stylesheet" /> --}}
    {{-- <link href="{{ sd }}bootstrap-3.3.7/css/bootstrap-theme.min.css" rel="stylesheet" /> --}}
    {{-- <link href="{{ sd }}css.css" rel="stylesheet" /> --}}
    {{-- <link href="https://fonts.googleapis.com/css?family=Roboto:700" rel="stylesheet"> --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @if (!empty($user0))
    <meta name="user" content="{{ $user0->id }}">
    @endif

    <meta name="referrer" content="strict-origin-when-cross-origin" />

    <style>
        body {
            margin: 0;
        }

    </style>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>


</head>

<body>
    <div id="app">

        <div class="loader text-center" v-if="1 == 2">
            <h1><span>Народная экономика !!!</span>
            </h1>
        </div>

        {{-- <br clear="all" />
        <br clear="all" />
        $user0: {{ print_r($user0) }}
        <br clear="all" />
        $dd: {{ $dd }}
        <br clear="all" />
        <br clear="all" /> --}}

        {{-- <header1></header1> --}}

        <header>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-xs-12 col-sm-6">
                        <a href="/"><img src="/narod/img/logo.png"
                                style="padding-top: 1em; max-height: 120px; margin-left: 10%"
                                alt="Народная экономика" /></a>
                    </div>

                    <div class="col-xs-12 col-sm-6" style="padding-right: 15px; padding-top: 15px;">

                        <center>
                            @if (!empty($user0))

                                <div
                                    style="display: inline-block; background-color:cornsilk; padding: 10px; margin-top: 20px; border-radius: 7px;">
                                    {{ $user0->name }}
                                    <br />
                                    <a href="/ulogout">выйти</a>
                                </div>
                            @else
                                <br />
                                Войти в личный кабинет:
                                <br />
                                <br />
                                <div id="uLogin"
                                    data-ulogin="display=panel;theme=classic;fields=nickname,photo,first_name,last_name;providers=vkontakte,odnoklassniki,mailru,facebook;hidden=other;redirect_uri=https%3A%2F%2F{{ Request::server('SERVER_NAME') }}%2Fulogin;mobilebuttons=0;">
                                </div>
                            @endif
                        </center>

                    </div>

                </div>
            </div>
        </header>

        <header-menu></header-menu>

        {{-- <div class="main"> --}}
        <router-view name="bodyContent"></router-view>
        {{-- </div> --}}

        <footer1></footer1>

    </div>

</body>

<script src="{{ asset('/narod/vue.js?' . date('U')) }}"></script>
@if (empty($user0))
    <script src="//ulogin.ru/js/ulogin.js"></script>
@endif

</html>
