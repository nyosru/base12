<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="{{ asset('img/magentatmf.png') }}">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title') | IN.TMF</title>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    @yield('css')
</head>
<body style="background: #eee">
        <header class="navbar navbar-light sticky-top bg-light flex-md-nowrap p-0 shadow">
            <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3" href="/home">
                <img class="img-fluid"  src="https://trademarkfactory.imgix.net/img/images/tmf-black.png?fm=webp&amp;lossless=true&amp;w=191&amp;h=40" alt="image">
            </a>
            <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            {{--<input class="form-control form-control-dark w-100" type="text" placeholder="Search" aria-label="Search">--}}
            <ul class="nav nav-pills">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false" title="3 Tasks"><i class="fas fa-tasks"></i> <span class="badge bg-warning">3</span></a>
                    <ul class="dropdown-menu">
                        <li><a href="#" class="dropdown-item">Task1</a></li>
                        <li><a href="#" class="dropdown-item">Task2</a></li>
                        <li><a href="#" class="dropdown-item">Task3</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false" title="5 Notifications"><i class="fas fa-bell"></i> <span class="badge bg-danger">5</span></a>
                    <ul class="dropdown-menu">
                        <li><a href="#" class="dropdown-item">Notification1</a></li>
                        <li><a href="#" class="dropdown-item">Notification2</a></li>
                        <li><a href="#" class="dropdown-item">Notification3</a></li>
                        <li><a href="#" class="dropdown-item">Notification4</a></li>
                        <li><a href="#" class="dropdown-item">Notification5</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false"><i class="fas fa-user"></i> {{$tmfsales->FirstName}} {{$tmfsales->LastName}}</a>
                    <ul class="dropdown-menu">
                        <li>
                            <a class="dropdown-item" href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>
        </header>
        <div class="container-fluid">
            <div class="row">
                @yield('sidebar')
                <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                    @yield('content')
                </main>
            </div>
        </div>
    <div class="modal fade" id="tmfwaiting400_modal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" style="text-align: center;padding: 0!important;">
        <div class="modal-dialog" role="document" style="display: inline-block;text-align: left;vertical-align: middle;width:auto">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <img src="https://trademarkfactory.com/img/tmfwaiting400.gif"/>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    @yield('modals')
    @yield('external-jscss')
</body>
</html>
