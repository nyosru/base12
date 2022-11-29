    <!DOCTYPE html>
    <html lang="en">

    <head>

        <meta charset="UTF-8">
        <title>Магия в деталях</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">

        @if( 1 == 1 )
        {{-- <link rel="stylesheet" href="/vendor/didrive/base/design/design/font/iconsmind/style.css" /> --}}
        <link rel="stylesheet" href="{{ asset('module_buh/didrive/font/iconsmind/style.css') }}" />

        {{-- <link rel="stylesheet"
            href="/vendor/didrive/base/design/design/font/simple-line-icons/css/simple-line-icons.css" /> --}}
        <link rel="stylesheet" href="{{ asset('module_buh/didrive/font/simple-line-icons/css/simple-line-icons.css') }}" />

        {{-- <link rel="stylesheet" href="/vendor/didrive/base/design/design/css/vendor/bootstrap.min.css" /> --}}
        {{-- <link rel="stylesheet" href="{{ asset('module_buh/didrive/css/vendor/bootstrap.min.css' ) }}" /> --}}
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">

        {{-- <link rel="stylesheet" href="/vendor/didrive/base/design/design/css/vendor/bootstrap-float-label.min.css" /> --}}
        <link rel="stylesheet" href="{{ asset('module_buh/didrive/css/vendor/bootstrap-float-label.min.css') }}" />

        {{-- <link rel="stylesheet" href="/vendor/didrive/base/design/design/css/main.css" /> --}}
        <link rel="stylesheet" href="{{ asset('module_buh/didrive/font/iconsmind/css/main.css') }}" />

        {{-- <link rel="stylesheet" type="text/css" href="/vendor/didrive/base/design/design/css/dore.light.blue.min.css"> --}}
        <link rel="stylesheet" href="{{ asset('module_buh/didrive/css/dore.light.blue.min.css') }}" />
        @endif

        {{-- <link rel="stylesheet" href="{{ asset('didrive/all.css') }}" /> --}}
        <meta property="og:image" content="http://php-cat.com/sites/my2007phpcat/download/didrive-preview_for_fb.jpg" />
    </head>

    <body class="background xshow-spinner">

        <div class="fixed-background"></div>

        @section('content')
            привет :)
        @show

    </body>

    <script
			  src="https://code.jquery.com/jquery-3.6.0.min.js"
			  integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
			  crossorigin="anonymous"></script>
    {{-- <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script> --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>


    {{-- <script src="{{ asset('didrive/js/vendor/jquery-3.3.1.min.js') }}"></script> --}}
    <script type="text/javascript">
        $().ready(function() {
            // удаление загрузчика
            $('body').removeClass('show-spinner');
        });
        // document.write('<script src=' + '"//ulogin.ru/js/ulogin.' + 'js"><' + '/script>');
    </script>
    <script src="//ulogin.ru/js/ulogin.js"></script>

    </html>
