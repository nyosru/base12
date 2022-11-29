@extends('buh::didrive.app.app')

@section('content')

    <main>
        <div class="container">
            <div class="row h-100">
                <div class="col-12 col-md-10 mx-auto my-auto">
                    <div class="card auth-card">
                        <div class="position-relative image-side ">

                            <p class=" text-white h2" style="text-transform: uppercase; text-shadow: 0 0 5px black; ">
                                Магия в&nbsp;деталях
                            </p>
                            <p class="white mb-0" style="text-shadow: 0 0 5px black;">
                                Управляйте управляемым
                            </p>

                        </div>
                        <div class="form-side">
                            <center>

                                <h6>Войти с помощью:</h6>
                                <br />

                                <table>
                                    <tr>
                                        <td>

                                            Вход с помощью соц сетей
                                            <br/>

                                            <div class="text-center margin-bottom-20" id="uLogin" data-ulogin="display=panel;theme=flat;fields=first_name,last_name,email,nickname,photo,country;providers=facebook,vkontakte,odnoklassniki,mailru;hidden=other;redirect_uri={{ urlencode('http://' . $_SERVER['HTTP_HOST']) }}/ulogin;mobilebuttons=0;">

                                            {{-- <div id="uLogin_didrive"
                                                data-ulogin="verify=1;display=panel;theme=classic;fields=first_name,last_name;providers=vkontakte,yandex,odnoklassniki,google,facebook;redirect_uri=%2F%2Favto-as.ru%2Fi.didrive.php;mobilebuttons=0;">
                                            </div>

                                            <div class="text-center margin-bottom-20" id="uLogin"
                                            data-ulogin="display=panel;theme=flat;fields=first_name,last_name,email,nickname,photo,coun
                                            try;
                                            providers=facebook,vkontakte,odnoklassniki,mailru;hidden=other;
                                            redirect_uri={{ urlencode('http://' . $_SERVER['HTTP_HOST']) }}/ulo
                                            gin;mobilebuttons=0;">
                                            </div> --}}

                                            @section('js')
                                             <script src="//ulogin.ru/js/ulogin.js"></script>
                                            @endsection

                                        </td>
                                    </tr>
                                </table>

                                <br />
                                <br />

                                <h6 class="mb-4">или</h6>

                                <form action="" method="post">

                                    <label class="form-group has-float-label mb-4">
                                        <input class="form-control" type="text" name="login2" value="" required="" />
                                        <span>Логин</span>
                                    </label>

                                    <label class="form-group has-float-label mb-4">
                                        <input class="form-control" type="password" name="pass2" value="" required="" />
                                        <span>Пароль</span>
                                    </label>

                                    <button class="btn btn-primary btn-lg btn-shadow" type="submit" name="enter"
                                        value="Войти">Войти</button>

                                    </form>

                                <br />
                                <br />
                                <br />

                                <a href="http://php-cat.com" style="color:rgba(0,0,0,0.4);" target="_blank">
                                    Создание сайта php-cat.com
                                </a>

                            </center>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

@endsection
