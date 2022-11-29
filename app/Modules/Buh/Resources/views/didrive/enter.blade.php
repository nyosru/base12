<!DOCTYPE html>
<html lang="en">
    <head>

        <meta charset="UTF-8">
        <title>Магия в деталях</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="stylesheet" href="{{ sdd }}font/iconsmind/style.css" />
        <link rel="stylesheet" href="{{ sdd }}font/simple-line-icons/css/simple-line-icons.css" />

        <link rel="stylesheet" href="{{ sdd }}css/vendor/bootstrap.min.css" />
        <link rel="stylesheet" href="{{ sdd }}css/vendor/bootstrap-float-label.min.css" />
        <link rel="stylesheet" href="{{ sdd }}css/main.css" />
        <link rel="stylesheet" type="text/css" href="{{ sdd }}css/dore.light.blue.min.css">
    </head>

    <body class="background xshow-spinner">
        <div class="fixed-background"></div>
        <main>
            <div class="container">
                <div class="row h-100">
                    <div class="col-12 col-md-10 mx-auto my-auto">
                        <div class="card auth-card">
                            <div class="position-relative image-side " {% if didrive_enter_img is defined %} style="background-image: url('{{ didrive_enter_img }}');" {% endif %} >

                                <p class=" text-white h2" style="text-transform: uppercase; text-shadow: 0 0 5px black; ">Магия в&nbsp;деталях</p>

                                <p class="white mb-0" style="text-shadow: 0 0 5px black;">
                                    Управляйте управляемым
                                    {#
                                    <br>If you are not a member, please
                                    <a href="#" class="white">register</a>.
                                    #}
                                </p>
                            </div>
                            <div class="form-side">


                                <center>

                                    {% if 1 == 2 %}
                                        <a href="/i.didrive.php" style="display: inline-block;margin-bottom:2rem;">
                                            {# <span class="logo-single"></span> #}
                                            <img src="{{ sdd }}../img/logo.svg" onerror="this.onerror=null; this.src='{{ sdd }}../img/logo.png'" class="logos" style="width:18rem;" />
                                        </a>
                                    {% endif %}

                                    {% if get.warn is defined and get.warn is not empty %}
                                        <div class='col-xs-12 col-md-12 text-center' >
                                            <div  style="background-color: yellow; color: red; padding:0.5em; display: inline-block; margin: 5px 2rem; width:80%; border-radius: 5px;">
                                                {{ get.warn|raw }}
                                            </div>
                                        </div>
                                    {% endif %}

                                    <h6>Войти с помощью:</h6>
                                    <br/>

                                    <table><tr>

                                            {% if vk_app_id is defined %}
                                                <td>
                                                    <a href="https://oauth.vk.com/authorize?client_id={{ id_app }}&redirect_uri={{ url_script }}&response_type=code" ><img src="/img/icon/vk04.png" style="max-width:40px;" /></a>
                                                    &nbsp;
                                                </td>
                                            {% endif %}
                                            <td>
                                                <div id="uLogin_didrive" data-ulogin="verify=1;display=panel;theme=classic;fields=first_name,last_name;providers={% if vk_app_id is not defined %}vkontakte,{% endif %}yandex,odnoklassniki,google,facebook;redirect_uri=%2F%2F{{ host }}%2Fi.didrive.php;mobilebuttons=0;"></div>
                                            </td>
                                        </tr>
                                    </table>

                                    <br/>
                                    <br/>

                                    <h6 class="mb-4">или</h6>

                                    <form action="" method="post" >
                                        <label class="form-group has-float-label mb-4">
                                            <input class="form-control" type="text" name="login2" value="" required="" />
                                            <span>Логин</span>
                                        </label>

                                        <label class="form-group has-float-label mb-4">
                                            <input class="form-control" type="password" name="pass2" value=""  required="" />
                                            <span>Пароль</span>
                                        </label>

                                        {# <a href="#">Forget password?</a> #}
                                        <button class="btn btn-primary btn-lg btn-shadow" type="submit" name="enter" value="Войти" >Войти</button>

                                    </form>

                                    <br/>
                                    <br/>
                                    <br/>

                                    <a href="http://php-cat.com" style="color:rgba(0,0,0,0.4);" target="_blank" >Создание сайта php-cat.com</a>

                                </center>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>

    </body>

    <script src="{{ sdd }}js/vendor/jquery-3.3.1.min.js"></script>
    <script type="text/javascript">
        $().ready(function () {
            // удаление загрузчика
            $('body').removeClass('show-spinner');
        });
        // document.write('<script src=' + '"//ulogin.ru/js/ulogin.' + 'js"><' + '/script>');
    </script>
    <script src="//ulogin.ru/js/ulogin.js"></script>

</html>
